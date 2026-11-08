<?php

namespace App\Services;

use App\Models\Penyewaan;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class MidtransService
{
    /**
     * Membuat transaksi Snap Midtrans untuk penyewaan.
     *
     * @return array{token: string, redirect_url: string, order_id: string, simulation?: bool, is_production?: bool, error_message?: string}
     */
    public function createSnapTransaction(Penyewaan $penyewaan, int $grossAmount): array
    {
        $serverKey = trim((string) config('services.midtrans.server_key'));
        $snapUrl = (string) config('services.midtrans.snap_url');
        $isProduction = (bool) config('services.midtrans.is_production', false);

        if ($serverKey === '') {
            throw new RuntimeException('Konfigurasi Midtrans Server Key belum diatur.');
        }

        $orderId = 'CAMPSEWA-'.$penyewaan->id_sewa.'-'.now()->timestamp;

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $penyewaan->pelanggan?->nama ?? 'Pelanggan CampSewa',
                'phone' => $penyewaan->pelanggan?->no_hp ?? '',
            ],
            'item_details' => [
                [
                    'id' => 'SEWA-'.$penyewaan->id_sewa,
                    'price' => $grossAmount,
                    'quantity' => 1,
                    'name' => 'Pembayaran Sewa Alat Camping #'.$penyewaan->id_sewa,
                ],
            ],
            'enabled_payments' => [
                'other_qris',
                'dana',
            ],
        ];

        $lastError = '';
        $urlsToTry = [
            ['url' => $snapUrl, 'is_prod' => $isProduction],
        ];

        $sandboxUrl = 'https://app.sandbox.midtrans.com/snap/v1/transactions';
        $prodUrl = 'https://app.midtrans.com/snap/v1/transactions';
        if (! app()->runningUnitTests()) {
            if ($snapUrl === $sandboxUrl) {
                $urlsToTry[] = ['url' => $prodUrl, 'is_prod' => true];
            } elseif ($snapUrl === $prodUrl) {
                $urlsToTry[] = ['url' => $sandboxUrl, 'is_prod' => false];
            }
        }

        foreach ($urlsToTry as $attempt) {
            try {
                $request = Http::connectTimeout(4)
                    ->timeout(8)
                    ->withBasicAuth($serverKey, '')
                    ->acceptJson()
                    ->asJson()
                    ->withoutVerifying();

                $response = $request->post($attempt['url'], $payload);

                if ($response->successful()) {
                    $token = (string) $response->json('token', '');
                    $redirectUrl = (string) $response->json('redirect_url', '');

                    if ($token !== '') {
                        return [
                            'token' => $token,
                            'redirect_url' => $redirectUrl,
                            'order_id' => $orderId,
                            'simulation' => false,
                            'is_production' => $attempt['is_prod'],
                        ];
                    }
                } else {
                    $errMsgs = $response->json('error_messages');
                    $lastError = is_array($errMsgs) ? implode(', ', $errMsgs) : 'HTTP '.$response->status();
                }
            } catch (\Throwable $e) {
                $lastError = $e->getMessage();
            }
        }

        // Fallback Snap Sandbox lokal apabila Server Key belum diganti dari Merchant ID atau jaringan terblokir
        $simToken = 'SNAP-SIM-'.$penyewaan->id_sewa.'-'.substr(md5($orderId), 0, 12);

        return [
            'token' => $simToken,
            'redirect_url' => '',
            'order_id' => $orderId,
            'simulation' => true,
            'is_production' => false,
            'error_message' => $lastError,
        ];
    }

    /**
     * Memverifikasi signature key notifikasi webhook Midtrans.
     */
    public function verifySignature(string $orderId, string $statusCode, string $grossAmount, string $signatureKey): bool
    {
        $serverKey = (string) config('services.midtrans.server_key');

        if ($serverKey === '' || $signatureKey === '') {
            return false;
        }

        $expectedSignature = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        return hash_equals($expectedSignature, $signatureKey);
    }

    /**
     * Mengekstrak ID penyewaan dari format order_id CAMPSEWA-{id_sewa}-{timestamp}.
     */
    public function extractSewaId(string $orderId): ?int
    {
        if (preg_match('/^CAMPSEWA-(\d+)(?:-\d+)?$/', $orderId, $matches) === 1) {
            return (int) $matches[1];
        }

        return null;
    }
}
