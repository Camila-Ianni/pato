<?php

namespace App\Http\Controllers;

use App\Services\MercadoPagoService;
use App\Services\PayPalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function mercadoPago(Request $request, MercadoPagoService $mercadoPagoService): JsonResponse
    {
        $mercadoPagoService->handleWebhook($request->all());

        return response()->json(['received' => true]);
    }

    public function payPal(Request $request, PayPalService $payPalService): JsonResponse
    {
        $payPalService->handleWebhook($request->all());

        return response()->json(['received' => true]);
    }
}
