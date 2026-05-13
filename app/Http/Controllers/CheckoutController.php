<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\MercadoPagoService;
use App\Services\PayPalService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class CheckoutController extends Controller
{
    public function show(Request $request): View
    {
        $items = $this->cartQuery($request)
            ->with('product')
            ->get();

        if ($items->isEmpty()) {
            throw ValidationException::withMessages([
                'cart' => 'Tu carrito está vacío.',
            ]);
        }

        $subtotal = $items->sum(fn (CartItem $item): float => (float) $item->product->price * $item->quantity);
        $items = $items->map(function (CartItem $item): CartItem {
            $item->setAttribute('total_price', (float) $item->product->price * $item->quantity);

            return $item;
        });

        $order = new Order([
            'total' => $subtotal,
        ]);
        $order->setRelation('items', $items);

        return view('checkout.show', [
            'order' => $order,
        ]);
    }

    public function process(
        Request $request,
        MercadoPagoService $mercadoPagoService
    ): RedirectResponse {
        $validated = $request->validate([
            'payment_method' => ['required', 'in:mercadopago,transferencia'],
        ]);

        $paymentProvider = (string) $validated['payment_method'];

        $user = $request->user();
        $cartItems = collect();

        $order = DB::transaction(function () use ($request, $user, &$cartItems): Order {
            $cartItems = $this->cartQuery($request)
                ->with('product')
                ->lockForUpdate()
                ->get();

            if ($cartItems->isEmpty()) {
                throw ValidationException::withMessages([
                    'cart' => 'Tu carrito está vacío.',
                ]);
            }

            foreach ($cartItems as $item) {
                if (! $item->product->is_active || $item->quantity > $item->product->stock) {
                    throw ValidationException::withMessages([
                        'cart' => "No hay stock suficiente para {$item->product->title}.",
                    ]);
                }
            }

            $subtotal = $cartItems->sum(fn (CartItem $item): float => (float) $item->product->price * $item->quantity);
            $total = $subtotal;

            $order = Order::query()->create([
                'user_id' => $user->id,
                'customer_email' => (string) $request->input('customer_email', $user->email),
                'customer_phone' => (string) $request->input('customer_phone', ''),
                'status' => 'pending',
                'payment_provider' => null,
                'transaction_id' => null,
                'subtotal' => $subtotal,
                'total' => $total,
                'currency' => 'ARS',
            ]);

            $orderItems = $cartItems->map(function (CartItem $item) use ($order): array {
                $unitPrice = (float) $item->product->price;
                $quantity = (int) $item->quantity;

                $item->product->decrement('stock', $quantity);

                return [
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $unitPrice * $quantity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->all();

            OrderItem::query()->insert($orderItems);

            return $order;
        });

        if ($paymentProvider === 'transferencia') {
            $order->update([
                'payment_provider' => 'transferencia',
                'transaction_id' => null,
                'status' => 'pending',
            ]);

            $this->cartQuery($request)->delete();

            return redirect()->route('checkout.transfer.instructions', $order);
        }

        try {
            $checkout = $mercadoPagoService->createCheckoutPreference($order, $cartItems);

            $order->update([
                'payment_provider' => $paymentProvider,
                'transaction_id' => $checkout['transaction_id'],
            ]);

            $this->cartQuery($request)->delete();

            return redirect()->away($checkout['checkout_url']);
        } catch (Throwable $exception) {
            return back()->with('error', 'Error conectando con Mercado Pago. Por favor, elige Transferencia.');
        }
    }

    public function mercadoPagoReturn(Request $request): View
    {
        $order = Order::query()->findOrFail((int) $request->query('order_id'));
        abort_unless($order->user_id === $request->user()->id, 403);

        $status = $request->query('status');
        if ($status === 'approved') {
            $order->update(['status' => 'paid']);
        } elseif (in_array($status, ['rejected', 'cancelled'], true)) {
            $order->update(['status' => 'failed']);
        }

        return view('checkout.result', ['order' => $order->fresh('items.product')]);
    }

    public function payPalReturn(Request $request, PayPalService $payPalService): View
    {
        $order = Order::query()->findOrFail((int) $request->query('order_id'));
        abort_unless($order->user_id === $request->user()->id, 403);

        $paypalOrderId = (string) $request->query('token');
        if ($paypalOrderId !== '') {
            $capture = $payPalService->captureOrder($paypalOrderId);

            $order->update([
                'transaction_id' => $paypalOrderId,
                'status' => $capture['status'] === 'COMPLETED' ? 'paid' : 'pending',
            ]);
        }

        return view('checkout.result', ['order' => $order->fresh('items.product')]);
    }

    public function transferInstructions(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        return view('checkout.thanks', [
            'order' => $order->fresh('items.product'),
            'transferCbu' => (string) config('payments.transferencia.cbu'),
            'transferAlias' => (string) config('payments.transferencia.alias'),
            'transferReceiptEmail' => (string) config('payments.transferencia.receipt_email'),
        ]);
    }

    private function cartQuery(Request $request): Builder
    {
        return CartItem::query()->where('user_id', $request->user()->id);
    }
}
