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

        $order = Order::query()->firstOrCreate(
            [
                'user_id' => $request->user()->id,
                'status' => 'pending',
                'payment_provider' => null,
                'transaction_id' => null,
            ],
            [
                'customer_email' => (string) $request->user()->email,
                'customer_phone' => '',
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'currency' => 'ARS',
            ]
        );

        $order->update([
            'customer_email' => (string) $request->user()->email,
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'currency' => 'ARS',
        ]);

        $order->items()->delete();

        OrderItem::query()->insert($items->map(function (CartItem $item) use ($order): array {
            $unitPrice = (float) $item->product->price;
            $quantity = (int) $item->quantity;

            return [
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_price' => $unitPrice * $quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->all());

        return view('checkout.show', [
            'order' => $order->fresh('items.product'),
        ]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:mercadopago,transferencia',
            'order_id' => 'required|exists:orders,id'
        ]);

        $order = Order::findOrFail($request->order_id);
        $order->update(['payment_provider' => $request->payment_method]);

        if ($request->payment_method === 'transferencia') {
            // Redirigir a pantalla de gracias con datos de CBU
            return redirect()->route('checkout.thanks', $order->id);
        }

        if ($request->payment_method === 'mercadopago') {
            try {
                $mpService = new \App\Services\MercadoPagoService();
                $preference = $mpService->createPreference($order);
                return redirect($preference->init_point);
            } catch (\Exception $e) {
                return back()->with('error', 'Ocurrió un error al conectar con Mercado Pago. Por favor, intenta usar Transferencia Bancaria.');
            }
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
