<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function show()
    {
        $cartItems = CartItem::where('user_id', Auth::id())
                        ->orWhere('session_id', session()->getId())
                        ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('catalog.index')->with('error', 'Tu carrito está vacío.');
        }

        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'subtotal' => $total,
            'total' => $total,
            'currency' => 'ARS'
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->product->price,
                'total_price' => $item->quantity * $item->product->price
            ]);
        }

        return view('checkout.show', compact('order'));
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
            CartItem::where('user_id', Auth::id())->orWhere('session_id', session()->getId())->delete();
            return redirect()->route('checkout.thanks', $order->id);
        }

        if ($request->payment_method === 'mercadopago') {
            try {
                $mpService = new \App\Services\MercadoPagoService();
                $preference = $mpService->createPreference($order);
                CartItem::where('user_id', Auth::id())->orWhere('session_id', session()->getId())->delete();
                return redirect($preference->init_point);
            } catch (\Exception $e) {
                return back()->with('error', 'Error conectando con Mercado Pago. Por favor, elegí Transferencia.');
            }
        }
    }

    public function transferInstructions(Order $order)
    {
        return view('checkout.thanks', compact('order'));
    }
}
