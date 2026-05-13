<?php

use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/webhooks/mercadopago', [WebhookController::class, 'mercadoPago'])
    ->name('webhooks.mercadopago');

Route::post('/webhooks/paypal', [WebhookController::class, 'payPal'])
    ->name('webhooks.paypal');
