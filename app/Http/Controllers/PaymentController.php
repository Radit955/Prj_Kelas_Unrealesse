<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = filter_var(config('services.midtrans.is_production'), FILTER_VALIDATE_BOOLEAN);
        Config::$isSanitized  = filter_var(config('services.midtrans.is_sanitized'), FILTER_VALIDATE_BOOLEAN);
        Config::$is3ds        = filter_var(config('services.midtrans.is_3ds'), FILTER_VALIDATE_BOOLEAN);
    }

    public function createTransaction(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1000',
            'note'   => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        $orderId = 'KAS-' . $user->id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $request->amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email'      => $user->email,
                'phone'      => $user->phone ?? '',
            ],
            'item_details' => [[
                'id'       => 'KAS-001',
                'price'    => (int) $request->amount,
                'quantity' => 1,
                'name'     => 'Kas Kelas XI TEKKES — ' . ($request->note ?? now()->format('M Y')),
            ]],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken, 'order_id' => $orderId]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashedKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashedKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        if (in_array($request->transaction_status, ['capture', 'settlement'])) {
            try {
                \App\Models\KasTransaction::create([
                    'user_id'    => auth()->id() ?? null,
                    'type'       => 'credit',
                    'amount'     => $request->gross_amount,
                    'note'       => 'Pembayaran via ' . $request->payment_type,
                    'order_id'   => $request->order_id,
                    'status'     => 'paid',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (\Exception $e) {
                // Ignore write failure, callback should still return OK.
            }
        }

        return response()->json(['message' => 'OK']);
    }
}
