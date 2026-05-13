<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class PayPalService
{
    private string $clientId;

    private string $secret;

    private string $baseUrl;

    public function __construct()
    {
        $this->clientId = (string) config('payments.paypal.client_id', '');
        $this->secret = (string) config('payments.paypal.secret', '');
        $this->baseUrl = (string) config('payments.paypal.base_url', 'https://api-m.sandbox.paypal.com');
    }

    public function createOrder(Order $order, Collection $items): array
    {
        $accessToken = $this->fetchAccessToken();

        $payload = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'reference_id' => (string) $order->id,
                    'custom_id' => (string) $order->id,
                    'amount' => [
                        'currency_code' => 'ARS',
                        'value' => number_format((float) $order->total, 2, '.', ''),
                        'breakdown' => [
                            'item_total' => [
                                'currency_code' => 'ARS',
                                'value' => number_format((float) $order->subtotal, 2, '.', ''),
                            ],
                        ],
                    ],
                    'items' => $items->map(function (CartItem $item): array {
                        return [
                            'name' => $item->product->title,
                            'quantity' => (string) $item->quantity,
                            'unit_amount' => [
                                'currency_code' => 'ARS',
                                'value' => number_format((float) $item->product->price, 2, '.', ''),
                            ],
                        ];
                    })->values()->all(),
                ],
            ],
            'application_context' => [
                'return_url' => route('checkout.return.paypal', ['order_id' => $order->id]),
                'cancel_url' => route('checkout.return.paypal', ['order_id' => $order->id]),
            ],
        ];

        $response = Http::withToken($accessToken)
            ->post($this->baseUrl.'/v2/checkout/orders', $payload)
            ->throw()
            ->json();

        $approvalUrl = collect($response['links'] ?? [])
            ->firstWhere('rel', 'approve')['href'] ?? null;

        if (! is_string($approvalUrl) || $approvalUrl === '') {
            throw new RuntimeException('PayPal no devolvió una URL de aprobación válida.');
        }

        return [
            'checkout_url' => $approvalUrl,
            'transaction_id' => (string) ($response['id'] ?? ''),
        ];
    }

    public function captureOrder(string $paypalOrderId): array
    {
        $accessToken = $this->fetchAccessToken();

        return Http::withToken($accessToken)
            ->post($this->baseUrl."/v2/checkout/orders/{$paypalOrderId}/capture")
            ->throw()
            ->json();
    }

    public function handleWebhook(array $payload): void
    {
        $resource = $payload['resource'] ?? [];
        $eventType = (string) ($payload['event_type'] ?? '');
        $orderId = (int) ($resource['custom_id'] ?? ($resource['purchase_units'][0]['custom_id'] ?? 0));

        if ($orderId === 0) {
            Log::warning('Webhook PayPal sin custom_id/order_id.', ['payload' => $payload]);

            return;
        }

        $order = Order::query()->find($orderId);
        if (! $order) {
            Log::warning('Order no encontrada para webhook PayPal.', ['order_id' => $orderId]);

            return;
        }

        $status = match ($eventType) {
            'PAYMENT.CAPTURE.COMPLETED' => 'paid',
            'PAYMENT.CAPTURE.DENIED', 'PAYMENT.CAPTURE.DECLINED' => 'failed',
            default => 'pending',
        };

        $transactionId = (string) (
            $resource['id']
            ?? $resource['supplementary_data']['related_ids']['order_id']
            ?? $order->transaction_id
        );

        $order->update([
            'status' => $status,
            'payment_provider' => 'paypal',
            'transaction_id' => $transactionId,
        ]);
    }

    private function fetchAccessToken(): string
    {
        if ($this->clientId === '' || $this->secret === '') {
            throw new RuntimeException('Credenciales de PayPal no configuradas.');
        }

        $token = Http::asForm()
            ->withBasicAuth($this->clientId, $this->secret)
            ->post($this->baseUrl.'/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ])
            ->throw()
            ->json('access_token');

        if (! is_string($token) || $token === '') {
            throw new RuntimeException('No se pudo obtener access token de PayPal.');
        }

        return $token;
    }
}
