<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cartItems = $this->cartQuery($request)
            ->with('product.categories')
            ->get();

        $subtotal = $cartItems->sum(fn (CartItem $item): float => (float) $item->product->price * $item->quantity);

        return view('cart.index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'items' => $cartItems,
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        abort_unless($product->is_active, 404);

        $requestedQuantity = (int) ($validated['quantity'] ?? 1);
        $existingItem = $this->cartQuery($request)
            ->where('product_id', $product->id)
            ->first();

        $newQuantity = $requestedQuantity + ($existingItem?->quantity ?? 0);
        if ($newQuantity > $product->stock) {
            throw ValidationException::withMessages([
                'quantity' => 'No hay stock suficiente para la cantidad solicitada.',
            ]);
        }

        if ($existingItem) {
            $existingItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::query()->create([
                'user_id' => $request->user()?->id,
                'session_id' => $request->user() ? null : $this->sessionCartId($request),
                'product_id' => $product->id,
                'quantity' => $requestedQuantity,
            ]);
        }

        return back()->with('status', 'Producto agregado al carrito.');
    }

    public function increment(Request $request, CartItem $cartItem): RedirectResponse
    {
        $this->assertOwnership($request, $cartItem);

        if ($cartItem->quantity + 1 > $cartItem->product->stock) {
            throw ValidationException::withMessages([
                'quantity' => 'No hay stock suficiente para sumar una unidad más.',
            ]);
        }

        $cartItem->increment('quantity');

        return back()->with('status', 'Cantidad actualizada.');
    }

    public function decrement(Request $request, CartItem $cartItem): RedirectResponse
    {
        $this->assertOwnership($request, $cartItem);

        if ($cartItem->quantity <= 1) {
            $cartItem->delete();

            return back()->with('status', 'Producto eliminado del carrito.');
        }

        $cartItem->decrement('quantity');

        return back()->with('status', 'Cantidad actualizada.');
    }

    public function remove(Request $request, CartItem $cartItem): RedirectResponse
    {
        $this->assertOwnership($request, $cartItem);
        $cartItem->delete();

        return back()->with('status', 'Producto eliminado del carrito.');
    }

    public function clear(Request $request): RedirectResponse
    {
        $this->cartQuery($request)->delete();

        return back()->with('status', 'Carrito vaciado.');
    }

    private function cartQuery(Request $request): Builder
    {
        if ($request->user()) {
            return CartItem::query()->where('user_id', $request->user()->id);
        }

        return CartItem::query()
            ->whereNull('user_id')
            ->where('session_id', $this->sessionCartId($request));
    }

    private function sessionCartId(Request $request): string
    {
        $session = $request->session();

        if (! $session->has('cart_session_id')) {
            $session->put('cart_session_id', (string) Str::uuid());
        }

        return (string) $session->get('cart_session_id');
    }

    private function assertOwnership(Request $request, CartItem $cartItem): void
    {
        $isOwner = $request->user()
            ? $cartItem->user_id === $request->user()->id
            : $cartItem->user_id === null && $cartItem->session_id === $this->sessionCartId($request);

        abort_unless($isOwner, 403);
    }
}
