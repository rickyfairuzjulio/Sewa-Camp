<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Penyewaan;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class MidtransController extends Controller
{
    public function __construct(public MidtransService $midtrans) {}

    /**
     * Membuat Snap Token Midtrans untuk transaksi penyewaan.
     */
    public function createSnapToken(Request $request, Penyewaan $penyewaan): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        if ($user->isPelanggan()) {
            $pelanggan = $user->pelanggan;

            if (
                ! $pelanggan
                || (int) $pelanggan->id_pelanggan !== (int) $penyewaan->id_pelanggan
                || $pelanggan->isBlocked()
            ) {
                abort(403, 'Anda tidak memiliki akses untuk membayar transaksi ini.');
            }
        } elseif (! $user->isAdmin() && ! $user->isPetugas()) {
            abort(403);
        }

        $penyewaan->loadMissing(['pelanggan', 'pembayaran']);

        if ($penyewaan->status === Penyewaan::STATUS_DIBATALKAN) {
            return $this->respondError($request, 'Transaksi yang dibatalkan tidak dapat dibayar.', 422);
        }

        $sisaTagihan = (int) round($penyewaan->sisa_tagihan);

        if ($sisaTagihan <= 0) {
            return $this->respondError($request, 'Tagihan transaksi ini sudah lunas.', 422);
        }

        $validated = $request->validate([
            'tipe_bayar' => ['nullable', 'string', 'in:dp,penuh'],
            'jumlah_bayar' => ['nullable', 'integer', 'min:1000', 'max:'.$sisaTagihan],
        ], [
            'jumlah_bayar.min' => 'Nominal pembayaran minimal Rp 1.000.',
            'jumlah_bayar.max' => 'Nominal pembayaran tidak boleh melebihi sisa tagihan.',
        ]);

        $tipeBayar = $validated['tipe_bayar'] ?? 'penuh';
        if (isset($validated['jumlah_bayar'])) {
            $grossAmount = (int) $validated['jumlah_bayar'];
        } elseif ($tipeBayar === 'dp' && (float) $penyewaan->total_dibayar <= 0) {
            $grossAmount = max(1000, (int) ceil($sisaTagihan * 0.5));
        } else {
            $grossAmount = $sisaTagihan;
        }

        try {
            $snap = $this->midtrans->createSnapTransaction($penyewaan, $grossAmount);
        } catch (RuntimeException $exception) {
            return $this->respondError($request, $exception->getMessage(), 502);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'token' => $snap['token'],
                'snap_token' => $snap['token'],
                'redirect_url' => $snap['redirect_url'],
                'order_id' => $snap['order_id'],
                'gross_amount' => $grossAmount,
                'tipe_bayar' => $tipeBayar,
                'simulation' => (bool) ($snap['simulation'] ?? false),
                'error_message' => $snap['error_message'] ?? null,
                'client_key' => config('services.midtrans.client_key'),
            ]);
        }

        if ($snap['redirect_url'] !== '') {
            return redirect()->away($snap['redirect_url']);
        }

        return back()->with('midtrans_snap_token', $snap['token']);
    }

    /**
     * Membuat Snap Token Midtrans dari halaman publik bukti booking (/sewa/sukses/{id}).
     */
    public function createPublicSnapToken(Request $request, Penyewaan $penyewaan): JsonResponse|RedirectResponse
    {
        $user = $request->user();
        if ($user && $user->isPelanggan() && $user->pelanggan) {
            if ((int) $user->pelanggan->id_pelanggan !== (int) $penyewaan->id_pelanggan) {
                abort(403, 'Anda tidak memiliki akses untuk membayar transaksi ini.');
            }
        }

        $penyewaan->loadMissing(['pelanggan', 'pembayaran']);

        if ($penyewaan->status === Penyewaan::STATUS_DIBATALKAN) {
            return $this->respondError($request, 'Transaksi yang dibatalkan tidak dapat dibayar.', 422);
        }

        $sisaTagihan = (int) round($penyewaan->sisa_tagihan);
        if ($sisaTagihan <= 0) {
            return $this->respondError($request, 'Tagihan transaksi ini sudah lunas.', 422);
        }

        $validated = $request->validate([
            'tipe_bayar' => ['nullable', 'string', 'in:dp,penuh'],
            'jumlah_bayar' => ['nullable', 'integer', 'min:1000', 'max:'.$sisaTagihan],
        ]);

        $tipeBayar = $validated['tipe_bayar'] ?? 'penuh';
        if (isset($validated['jumlah_bayar'])) {
            $grossAmount = (int) $validated['jumlah_bayar'];
        } elseif ($tipeBayar === 'dp' && (float) $penyewaan->total_dibayar <= 0) {
            $grossAmount = max(1000, (int) ceil($sisaTagihan * 0.5));
        } else {
            $grossAmount = $sisaTagihan;
        }

        try {
            $snap = $this->midtrans->createSnapTransaction($penyewaan, $grossAmount);
        } catch (RuntimeException $exception) {
            return $this->respondError($request, $exception->getMessage(), 502);
        }

        return response()->json([
            'token' => $snap['token'],
            'snap_token' => $snap['token'],
            'redirect_url' => $snap['redirect_url'],
            'order_id' => $snap['order_id'],
            'gross_amount' => $grossAmount,
            'tipe_bayar' => $tipeBayar,
            'simulation' => (bool) ($snap['simulation'] ?? false),
            'error_message' => $snap['error_message'] ?? null,
            'client_key' => config('services.midtrans.client_key'),
        ]);
    }

    /**
     * Menyimpan Server Key & Client Key Midtrans ke file .env dan memverifikasi koneksi API Midtrans.
     */
    public function saveKeys(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'server_key' => ['required', 'string', 'min:10'],
            'client_key' => ['nullable', 'string'],
        ]);

        $serverKey = trim($validated['server_key']);
        $clientKey = trim((string) ($validated['client_key'] ?? config('services.midtrans.client_key')));

        if (str_contains($serverKey, 'DEFAULT-PAYMENT-CLIENT')) {
            return response()->json([
                'success' => false,
                'message' => 'Kode "'.$serverKey.'" adalah ID Merchant/Client, BUKAN Server Key. Server Key Midtrans selalu diawali dengan "SB-Mid-server-..." atau "Mid-server-...".',
            ], 422);
        }

        $envPath = base_path('.env');
        if (is_file($envPath) && is_writable($envPath)) {
            $envContent = (string) file_get_contents($envPath);

            if (preg_match('/^MIDTRANS_SERVER_KEY=.*$/m', $envContent)) {
                $envContent = (string) preg_replace('/^MIDTRANS_SERVER_KEY=.*$/m', 'MIDTRANS_SERVER_KEY='.$serverKey, $envContent);
            } else {
                $envContent .= "\nMIDTRANS_SERVER_KEY=".$serverKey;
            }

            if ($clientKey !== '') {
                if (preg_match('/^MIDTRANS_CLIENT_KEY=.*$/m', $envContent)) {
                    $envContent = (string) preg_replace('/^MIDTRANS_CLIENT_KEY=.*$/m', 'MIDTRANS_CLIENT_KEY='.$clientKey, $envContent);
                } else {
                    $envContent .= "\nMIDTRANS_CLIENT_KEY=".$clientKey;
                }
            }

            file_put_contents($envPath, $envContent);
        }

        config([
            'services.midtrans.server_key' => $serverKey,
            'services.midtrans.client_key' => $clientKey,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Server Key Midtrans berhasil disimpan! Membuka ulang sesi Midtrans...',
        ]);
    }

    /**
     * Mencatat pembayaran setelah callback sukses Snap pada sisi klien (mendukung DP maupun Bayar Penuh).
     */
    public function confirmClientPayment(Request $request, Penyewaan $penyewaan): JsonResponse
    {
        $user = $request->user();
        if ($user && $user->isPelanggan() && $user->pelanggan) {
            if ((int) $user->pelanggan->id_pelanggan !== (int) $penyewaan->id_pelanggan) {
                abort(403);
            }
        }

        $validated = $request->validate([
            'order_id' => ['required', 'string'],
            'gross_amount' => ['required', 'numeric', 'min:1000'],
            'tipe_bayar' => ['nullable', 'string', 'in:dp,penuh'],
        ]);

        $paidAmount = (int) round((float) $validated['gross_amount']);
        $metodeLabel = ($validated['tipe_bayar'] ?? 'penuh') === 'dp' ? 'Midtrans (DP 50%)' : 'Midtrans';

        DB::transaction(function () use ($penyewaan, $paidAmount, $validated, $metodeLabel): void {
            $sewa = Penyewaan::lockForUpdate()->find($penyewaan->id_sewa);
            if (! $sewa || $sewa->status === Penyewaan::STATUS_DIBATALKAN) {
                return;
            }

            $cacheKey = 'midtrans_order_settled:'.$validated['order_id'];
            if (! Cache::add($cacheKey, true, now()->addDays(7))) {
                return;
            }

            $sisaTagihan = (int) round($sewa->sisa_tagihan);
            if ($sisaTagihan <= 0) {
                return;
            }

            Pembayaran::create([
                'id_sewa' => $sewa->id_sewa,
                'tgl_bayar' => now()->toDateString(),
                'jumlah_bayar' => min($paidAmount, $sisaTagihan),
                'metode' => $metodeLabel,
            ]);
        });

        return response()->json(['message' => 'Pembayaran berhasil dicatat.']);
    }

    /**
     * Menerima notifikasi webhook dari Midtrans.
     */
    public function notification(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order_id' => ['required', 'string'],
            'status_code' => ['required', 'string'],
            'gross_amount' => ['required', 'string'],
            'signature_key' => ['required', 'string'],
            'transaction_status' => ['required', 'string'],
            'fraud_status' => ['nullable', 'string'],
        ]);

        $isValidSignature = $this->midtrans->verifySignature(
            $validated['order_id'],
            $validated['status_code'],
            $validated['gross_amount'],
            $validated['signature_key']
        );

        if (! $isValidSignature) {
            return response()->json(['message' => 'Signature tidak valid.'], 403);
        }

        $idSewa = $this->midtrans->extractSewaId($validated['order_id']);

        if ($idSewa === null) {
            return response()->json(['message' => 'Order ID tidak dikenali.'], 404);
        }

        $transactionStatus = $validated['transaction_status'];
        $fraudStatus = $validated['fraud_status'] ?? null;

        $isPaid = $transactionStatus === 'settlement'
            || ($transactionStatus === 'capture' && in_array($fraudStatus, [null, '', 'accept'], true));

        if (! $isPaid) {
            return response()->json(['message' => 'Status transaksi dicatat tanpa pembayaran.']);
        }

        $paidAmount = (int) round((float) $validated['gross_amount']);

        if ($paidAmount <= 0) {
            return response()->json(['message' => 'Nominal pembayaran tidak valid.'], 422);
        }

        DB::transaction(function () use ($idSewa, $paidAmount, $validated): void {
            $sewa = Penyewaan::lockForUpdate()->find($idSewa);

            if (! $sewa || $sewa->status === Penyewaan::STATUS_DIBATALKAN) {
                return;
            }

            $cacheKey = 'midtrans_order_settled:'.$validated['order_id'];
            if (! Cache::add($cacheKey, true, now()->addDays(7))) {
                return;
            }

            $sisaTagihan = (int) round($sewa->sisa_tagihan);
            if ($sisaTagihan <= 0) {
                return;
            }

            Pembayaran::create([
                'id_sewa' => $sewa->id_sewa,
                'tgl_bayar' => now()->toDateString(),
                'jumlah_bayar' => min($paidAmount, $sisaTagihan),
                'metode' => 'Midtrans',
            ]);
        });

        return response()->json(['message' => 'Pembayaran Midtrans berhasil dicatat.']);
    }

    private function respondError(Request $request, string $message, int $status): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message], $status);
        }

        return back()->with('error', $message);
    }
}
