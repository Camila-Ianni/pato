<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class MercadoPagoService
{
    private string $accessToken;

    private string $baseUrl;

    public function __construct()
    {
        $this->accessToken = (string) config('payments.mercadopago.access_token', '');
        $this->baseUrl = (string) config('payments.mercadopago.base_url', 'https://api.mercadopago.com');
    }

    public function createCheckoutPreference(Order $order, Collection $items): array
    {
        if ($this->accessToken === '') {
            throw new RuntimeException('MercadoPago access token no configurado.');
        }

        $payload = [
            'items' => $items->map(function (CartItem $item): array {
                return [
                    'title' => $item->product->title,
                    'quantity' => (int) $item->quantity,
                    'currency_id' => 'ARS',
                    'unit_price' => (float) $item->product->price,
                ];
            })->values()->all(),
            'external_reference' => (string) $order->id,
            'back_urls' => [
                'success' => route('checkout.return.mercadopago', ['order_id' => $order->id, 'status' => 'approved']),
                'failure' => route('checkout.return.mercadopago', ['order_id' => $order->id, 'status' => 'rejected']),
                'pending' => route('checkout.return.mercadopago', ['order_id' => $order->id, 'status' => 'pending']),
            ],
            'auto_return' => 'approved',
        ];

        $response = Http::withToken($this->accessToken)
            ->post($this->baseUrl.'/checkout/preferences', $payload)
            ->throw()
            ->json();

        $checkoutUrl = $response['init_point'] ?? $response['sandbox_init_point'] ?? null;
        if (! is_string($checkoutUrl) || $checkoutUrl === '') {
            throw new RuntimeException('MercadoPago no devolvió una URL de checkout válida.');
        }

        return [
            'checkout_url' => $checkoutUrl,
            'transaction_id' => (string) ($response['id'] ?? ''),
        ];
    }

    public function fetchPayment(string $paymentId): array
    {
        if ($this->accessToken === '') {
            throw new RuntimeException('MercadoPago access token no configurado.');
        }

        return Http::withToken($this->accessToken)
            ->get($this->baseUrl."/v1/payments/{$paymentId}")
            ->throw()
            ->json();
    }

    public function handleWebhook(array $payload): void
    {
        $topic = $payload['type'] ?? $payload['topic'] ?? null;
        if (! in_array($topic, ['payment'], true)) {
            Log::info('Webhook MercadoPago ignorado por tipo no relevante.', ['topic' => $topic]);

            return;
        }

        $paymentId = (string) ($payload['data']['id'] ?? '');
        if ($paymentId === '') {
            Log::warning('Webhook MercadoPago sin payment id.', ['payload' => $payload]);

            return;
        }

        $payment = $this->fetchPayment($paymentId);
        $orderId = (int) ($payment['external_reference'] ?? 0);
        if ($orderId === 0) {
            Log::warning('Pago MercadoPago sin external_reference.', ['payment_id' => $paymentId]);

            return;
        }

        $order = Order::query()->find($orderId);
        if (! $order) {
            Log::warning('Order no encontrada para webhook MercadoPago.', ['order_id' => $orderId]);

            return;
        }

        $status = match ($payment['status'] ?? null) {
            'approved' => 'paid',
            'rejected', 'cancelled' => 'failed',
            default => 'pending',
        };

        $order->update([
            'status' => $status,
            'payment_provider' => 'mercadopago',
            'transaction_id' => $paymentId,
        ]);
    }
}
