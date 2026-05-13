<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/nuestra-historia', 'pages.history')->name('pages.history');
Route::view('/contacto', 'pages.contact')->name('pages.contact');

Route::middleware('guest')->group(function (): void {
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', function (Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:120', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => false,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    })->name('register.store');

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Las credenciales no son válidas.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    })->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    })->name('logout');

    Route::get('/dashboard', function (Request $request) {
        if ($request->user()?->is_admin) {
            return redirect()->route('admin.orders.index');
        }

        return redirect()->route('home');
    })->name('dashboard');
});

Route::prefix('catalog')->name('catalog.')->group(function (): void {
    Route::get('/', [CatalogController::class, 'index'])->name('index');
    Route::get('/{product:slug}', [CatalogController::class, 'show'])->name('show');
});

Route::prefix('cart')->name('cart.')->group(function (): void {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/items/{cartItem}/increment', [CartController::class, 'increment'])->name('increment');
    Route::patch('/items/{cartItem}/decrement', [CartController::class, 'decrement'])->name('decrement');
    Route::delete('/items/{cartItem}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

Route::middleware('auth')->prefix('checkout')->name('checkout.')->group(function (): void {
    Route::get('/', [CheckoutController::class, 'show'])->name('show');
    Route::post('/', [CheckoutController::class, 'process'])->name('process');
    Route::get('/thanks/{order}', [CheckoutController::class, 'transferInstructions'])->name('thanks');
    Route::get('/transfer/{order}', [CheckoutController::class, 'transferInstructions'])->name('transfer.instructions');
    Route::get('/return/mercadopago', [CheckoutController::class, 'mercadoPagoReturn'])->name('return.mercadopago');
    Route::get('/return/paypal', [CheckoutController::class, 'payPalReturn'])->name('return.paypal');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::resource('products', AdminProductController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
});
