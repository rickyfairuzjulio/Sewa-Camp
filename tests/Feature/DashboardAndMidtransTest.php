<?php

namespace Tests\Feature;

use App\Models\Alat;
use App\Models\DetailPenyewaan;
use App\Models\KategoriAlat;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Penyewaan;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Client\Request as HttpClientRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DashboardAndMidtransTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.midtrans.client_key' => 'Mid-client-roCCiiGNO8ITcCJv',
            'services.midtrans.server_key' => 'M145570215-DEFAULT-PAYMENT-CLIENT',
            'services.midtrans.is_production' => false,
            'services.midtrans.snap_url' => 'https://app.sandbox.midtrans.com/snap/v1/transactions',
            'services.midtrans.snap_js_url' => 'https://app.sandbox.midtrans.com/snap/snap.js',
        ]);

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('pelanggan');
            $table->string('no_hp', 20)->nullable();
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('kategori_alat', function (Blueprint $table): void {
            $table->increments('id_kategori');
            $table->string('nama_kategori');
            $table->timestamps();
        });

        Schema::create('alat', function (Blueprint $table): void {
            $table->increments('id_alat');
            $table->unsignedInteger('id_kategori')->nullable();
            $table->string('nama_alat');
            $table->decimal('harga_sewa_per_hari', 12, 0);
            $table->integer('stok')->default(0);
            $table->string('kondisi')->default('Baik');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });

        Schema::create('pelanggan', function (Blueprint $table): void {
            $table->increments('id_pelanggan');
            $table->foreignId('user_id')->nullable();
            $table->string('nama', 100);
            $table->string('no_hp', 15);
            $table->string('alamat', 200)->nullable();
            $table->string('no_identitas', 20)->unique();
            $table->string('status_verifikasi', 20)->default('belum_verifikasi');
            $table->unsignedInteger('jumlah_terlambat')->default(0);
            $table->integer('poin_loyalitas')->default(0);
            $table->integer('total_transaksi_selesai')->default(0);
            $table->timestamps();
        });

        Schema::create('petugas', function (Blueprint $table): void {
            $table->increments('id_petugas');
            $table->string('nama_petugas')->default('Petugas Uji');
            $table->string('no_hp')->nullable();
            $table->string('username')->default('petugas_uji');
            $table->timestamps();
        });

        Schema::create('penyewaan', function (Blueprint $table): void {
            $table->increments('id_sewa');
            $table->unsignedInteger('id_pelanggan');
            $table->unsignedInteger('id_petugas')->nullable();
            $table->date('tgl_sewa');
            $table->date('tgl_kembali_rencana');
            $table->date('tgl_kembali_aktual')->nullable();
            $table->string('status');
            $table->decimal('total_biaya', 12, 0)->default(0);
            $table->timestamps();
        });

        Schema::create('detail_penyewaan', function (Blueprint $table): void {
            $table->increments('id_detail');
            $table->unsignedInteger('id_sewa');
            $table->unsignedInteger('id_alat');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 12, 0);
            $table->decimal('subtotal', 12, 0);
            $table->timestamps();
        });

        Schema::create('pembayaran', function (Blueprint $table): void {
            $table->increments('id_bayar');
            $table->unsignedInteger('id_sewa');
            $table->date('tgl_bayar')->nullable();
            $table->decimal('jumlah_bayar', 12, 0)->default(0);
            $table->string('metode')->nullable();
            $table->timestamps();
        });
    }

    public function test_admin_and_petugas_dashboards_render_operational_metrics(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'name' => 'Admin Utama']);
        $petugasUser = User::factory()->create(['role' => 'petugas', 'name' => 'Budi Santoso']);

        $kategori = KategoriAlat::create(['nama_kategori' => 'Tenda']);
        $alat = Alat::create([
            'id_kategori' => $kategori->id_kategori,
            'nama_alat' => 'Tenda Dome 4P',
            'harga_sewa_per_hari' => 50000,
            'stok' => 4,
            'kondisi' => 'Baik',
        ]);
        $pelanggan = Pelanggan::create([
            'nama' => 'Dimas Arya',
            'no_hp' => '081234567890',
            'no_identitas' => '3374010101990001',
            'status_verifikasi' => 'terverifikasi',
        ]);
        $petugas = Petugas::create([
            'nama_petugas' => 'Budi Santoso',
            'no_hp' => '081122334455',
            'username' => 'budi',
        ]);

        $sewa = Penyewaan::create([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'id_petugas' => $petugas->id_petugas,
            'tgl_sewa' => today()->subDays(2)->toDateString(),
            'tgl_kembali_rencana' => today()->toDateString(),
            'status' => 'Berjalan',
            'total_biaya' => 100000,
        ]);

        DetailPenyewaan::create([
            'id_sewa' => $sewa->id_sewa,
            'id_alat' => $alat->id_alat,
            'jumlah' => 1,
            'harga_satuan' => 50000,
            'subtotal' => 100000,
        ]);

        Pembayaran::create([
            'id_sewa' => $sewa->id_sewa,
            'tgl_bayar' => today()->toDateString(),
            'jumlah_bayar' => 50000,
            'metode' => 'Midtrans',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Admin')
            ->assertSee('Dimas Arya')
            ->assertSee('Tenda Dome 4P')
            ->assertSee('Rp 50.000');

        $this->actingAs($petugasUser)
            ->get(route('petugas.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Petugas')
            ->assertSee('Dimas Arya')
            ->assertSee(route('admin.pengembalian.proses', $sewa->id_sewa), false);
    }

    public function test_verified_customer_can_create_midtrans_snap_token_for_unpaid_rental(): void
    {
        $this->freezeTime();
        Http::preventStrayRequests();

        Http::fake([
            'https://app.sandbox.midtrans.com/snap/v1/transactions' => Http::response([
                'token' => 'snap-token-12345',
                'redirect_url' => 'https://app.sandbox.midtrans.com/snap/v2/vtweb/snap-token-12345',
            ], 201),
        ]);

        $user = User::factory()->create(['role' => 'pelanggan', 'name' => 'Dimas Arya']);
        $pelanggan = Pelanggan::create([
            'user_id' => $user->id,
            'nama' => 'Dimas Arya',
            'no_hp' => '081234567890',
            'no_identitas' => '3374010101990001',
            'status_verifikasi' => 'terverifikasi',
        ]);

        $sewa = Penyewaan::create([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'tgl_sewa' => today()->toDateString(),
            'tgl_kembali_rencana' => today()->addDays(2)->toDateString(),
            'status' => 'Berjalan',
            'total_biaya' => 150000,
        ]);

        $this->actingAs($user)
            ->get(route('pelanggan.dashboard'))
            ->assertOk()
            ->assertSee('Bayar Midtrans')
            ->assertSee(route('pelanggan.pembayaran.midtrans.token', $sewa->id_sewa), false);

        $response = $this->actingAs($user)
            ->postJson(route('pelanggan.pembayaran.midtrans.token', $sewa->id_sewa));

        $expectedOrderId = 'CAMPSEWA-'.$sewa->id_sewa.'-'.now()->timestamp;

        $response->assertOk()
            ->assertJson([
                'token' => 'snap-token-12345',
                'order_id' => $expectedOrderId,
                'gross_amount' => 150000,
                'client_key' => 'Mid-client-roCCiiGNO8ITcCJv',
            ]);

        Http::assertSent(function (HttpClientRequest $request) use ($expectedOrderId): bool {
            return $request->url() === 'https://app.sandbox.midtrans.com/snap/v1/transactions'
                && $request['transaction_details']['order_id'] === $expectedOrderId
                && $request['transaction_details']['gross_amount'] === 150000;
        });
    }

    public function test_customer_cannot_create_midtrans_snap_token_for_another_customers_rental(): void
    {
        Http::preventStrayRequests();

        $user = User::factory()->create(['role' => 'pelanggan']);
        Pelanggan::create([
            'user_id' => $user->id,
            'nama' => 'Pelanggan A',
            'no_hp' => '081111111111',
            'no_identitas' => 'ID-A',
            'status_verifikasi' => 'terverifikasi',
        ]);

        $otherPelanggan = Pelanggan::create([
            'nama' => 'Pelanggan B',
            'no_hp' => '082222222222',
            'no_identitas' => 'ID-B',
            'status_verifikasi' => 'terverifikasi',
        ]);

        $otherSewa = Penyewaan::create([
            'id_pelanggan' => $otherPelanggan->id_pelanggan,
            'tgl_sewa' => today()->toDateString(),
            'tgl_kembali_rencana' => today()->addDay()->toDateString(),
            'status' => 'Berjalan',
            'total_biaya' => 80000,
        ]);

        $this->actingAs($user)
            ->postJson(route('pelanggan.pembayaran.midtrans.token', $otherSewa->id_sewa))
            ->assertForbidden();

        Http::assertNothingSent();
    }

    public function test_midtrans_webhook_verifies_signature_and_records_payment_idempotently(): void
    {
        $pelanggan = Pelanggan::create([
            'nama' => 'Dimas Arya',
            'no_hp' => '081234567890',
            'no_identitas' => '3374010101990001',
            'status_verifikasi' => 'terverifikasi',
        ]);

        $sewa = Penyewaan::create([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'tgl_sewa' => today()->toDateString(),
            'tgl_kembali_rencana' => today()->addDays(2)->toDateString(),
            'status' => 'Berjalan',
            'total_biaya' => 184000,
        ]);

        $orderId = 'CAMPSEWA-'.$sewa->id_sewa.'-1730000000';
        $statusCode = '200';
        $grossAmount = '184000.00';
        $serverKey = (string) config('services.midtrans.server_key');
        $validSignature = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        $payload = [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $validSignature,
            'transaction_status' => 'settlement',
            'fraud_status' => 'accept',
        ];

        $this->postJson(route('midtrans.notification'), $payload)
            ->assertOk()
            ->assertJson(['message' => 'Pembayaran Midtrans berhasil dicatat.']);

        $this->assertDatabaseHas('pembayaran', [
            'id_sewa' => $sewa->id_sewa,
            'jumlah_bayar' => 184000,
            'metode' => 'Midtrans',
        ]);

        // Pengiriman ulang webhook yang sama tidak boleh mencatat pembayaran ganda
        $this->postJson(route('midtrans.notification'), $payload)
            ->assertOk();

        $this->assertSame(1, Pembayaran::where('id_sewa', $sewa->id_sewa)->count());
    }

    public function test_midtrans_webhook_rejects_invalid_signature(): void
    {
        $pelanggan = Pelanggan::create([
            'nama' => 'Dimas Arya',
            'no_hp' => '081234567890',
            'no_identitas' => '3374010101990001',
            'status_verifikasi' => 'terverifikasi',
        ]);

        $sewa = Penyewaan::create([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'tgl_sewa' => today()->toDateString(),
            'tgl_kembali_rencana' => today()->addDays(2)->toDateString(),
            'status' => 'Berjalan',
            'total_biaya' => 100000,
        ]);

        $this->postJson(route('midtrans.notification'), [
            'order_id' => 'CAMPSEWA-'.$sewa->id_sewa.'-1730000000',
            'status_code' => '200',
            'gross_amount' => '100000.00',
            'signature_key' => 'invalid-signature',
            'transaction_status' => 'settlement',
        ])->assertForbidden();

        $this->assertDatabaseMissing('pembayaran', [
            'id_sewa' => $sewa->id_sewa,
        ]);
    }

    public function test_staff_can_process_return_and_open_invoices_and_reports(): void
    {
        $petugasUser = User::factory()->create(['role' => 'petugas']);
        $kategori = KategoriAlat::create(['nama_kategori' => 'Tenda']);
        $alat = Alat::create([
            'id_kategori' => $kategori->id_kategori,
            'nama_alat' => 'Tenda Dome 2P',
            'harga_sewa_per_hari' => 35000,
            'stok' => 5,
            'kondisi' => 'Baik',
        ]);
        $pelanggan = Pelanggan::create([
            'nama' => 'Rina Astuti',
            'no_hp' => '085678901234',
            'no_identitas' => '3374020202980002',
            'status_verifikasi' => 'terverifikasi',
        ]);

        $sewa = Penyewaan::create([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'tgl_sewa' => today()->subDays(4)->toDateString(),
            'tgl_kembali_rencana' => today()->subDays(2)->toDateString(),
            'status' => 'Berjalan',
            'total_biaya' => 70000,
        ]);

        DetailPenyewaan::create([
            'id_sewa' => $sewa->id_sewa,
            'id_alat' => $alat->id_alat,
            'jumlah' => 2,
            'harga_satuan' => 35000,
            'subtotal' => 70000,
        ]);

        $bayar = Pembayaran::create([
            'id_sewa' => $sewa->id_sewa,
            'tgl_bayar' => today()->toDateString(),
            'jumlah_bayar' => 70000,
            'metode' => 'Midtrans',
        ]);

        $this->actingAs($petugasUser)
            ->get(route('admin.penyewaan.cetak', $sewa->id_sewa))
            ->assertOk()
            ->assertSee('NOTA-'.str_pad($sewa->id_sewa, 5, '0', STR_PAD_LEFT));

        $this->actingAs($petugasUser)
            ->get(route('admin.pembayaran.kuitansi', $bayar->id_bayar))
            ->assertOk()
            ->assertSee('KW-'.str_pad($bayar->id_bayar, 5, '0', STR_PAD_LEFT))
            ->assertSee('Midtrans');

        $this->actingAs($petugasUser)
            ->get(route('admin.laporan.belum_kembali'))
            ->assertOk()
            ->assertSee('Rina Astuti');

        $this->actingAs($petugasUser)
            ->post(route('admin.pengembalian.simpan', $sewa->id_sewa), [
                'tgl_kembali_aktual' => today()->toDateString(),
                'denda' => 20000,
                'kondisi_alat' => [$alat->id_alat => 'Baik'],
            ])
            ->assertRedirect(route('admin.penyewaan.show', $sewa->id_sewa));

        $this->assertDatabaseHas('penyewaan', [
            'id_sewa' => $sewa->id_sewa,
            'status' => 'Selesai',
            'total_biaya' => 90000,
        ]);
        $this->assertDatabaseHas('alat', [
            'id_alat' => $alat->id_alat,
            'stok' => 7,
        ]);
        $this->assertDatabaseHas('pelanggan', [
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'total_transaksi_selesai' => 1,
            'jumlah_terlambat' => 1,
        ]);
    }

    public function test_customer_can_choose_dp_or_full_payment_and_view_item_status_in_transaksi(): void
    {
        Http::preventStrayRequests();

        Http::fake([
            'https://app.sandbox.midtrans.com/snap/v1/transactions' => Http::response([
                'token' => 'snap-dp-token-999',
                'redirect_url' => 'https://app.sandbox.midtrans.com/snap/v2/vtweb/snap-dp-token-999',
            ], 201),
        ]);

        $user = User::factory()->create(['role' => 'pelanggan', 'name' => 'Jack Outdoor']);
        $pelanggan = Pelanggan::create([
            'user_id' => $user->id,
            'nama' => 'Jack Outdoor',
            'no_hp' => '081234567890',
            'no_identitas' => '3374010101990099',
            'status_verifikasi' => 'terverifikasi',
        ]);

        $kategori = KategoriAlat::create(['nama_kategori' => 'Tenda']);
        $alat = Alat::create([
            'id_kategori' => $kategori->id_kategori,
            'nama_alat' => 'Tenda Dome 4 Orang Family',
            'harga_sewa_per_hari' => 50000,
            'stok' => 4,
            'kondisi' => 'Baik',
        ]);

        $sewa = Penyewaan::create([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'tgl_sewa' => today()->toDateString(),
            'tgl_kembali_rencana' => today()->addDays(2)->toDateString(),
            'status' => 'Berjalan',
            'total_biaya' => 100000,
        ]);

        DetailPenyewaan::create([
            'id_sewa' => $sewa->id_sewa,
            'id_alat' => $alat->id_alat,
            'jumlah' => 1,
            'harga_satuan' => 50000,
            'subtotal' => 100000,
        ]);

        // Halaman Transaksi menampilkan dropdown user (UPGRADE MEMBER, Transaksi, Pengaturan, Logout),
        // status barang, serta pilihan Bayar DP 50% dan Bayar Penuh 100%
        $this->actingAs($user)
            ->get(route('pelanggan.dashboard'))
            ->assertOk()
            ->assertSee('UPGRADE MEMBER')
            ->assertSee('Transaksi')
            ->assertSee('Pengaturan')
            ->assertSee('Logout')
            ->assertSee('Tenda Dome 4 Orang Family')
            ->assertSee('Menunggu Pembayaran DP / Penuh')
            ->assertSee('Bayar DP 50%')
            ->assertSee('Bayar Penuh 100%');

        // Pilih Bayar DP 50% (Rp 50.000 dari Rp 100.000)
        $dpResponse = $this->actingAs($user)
            ->postJson(route('pelanggan.pembayaran.midtrans.token', $sewa->id_sewa), [
                'tipe_bayar' => 'dp',
            ]);

        $dpResponse->assertOk()
            ->assertJson([
                'token' => 'snap-dp-token-999',
                'gross_amount' => 50000,
                'tipe_bayar' => 'dp',
            ]);

        // Konfirmasi pembayaran DP dari sisi klien
        $this->actingAs($user)
            ->postJson(route('public.sewa.midtrans.confirm', $sewa->id_sewa), [
                'order_id' => $dpResponse->json('order_id'),
                'gross_amount' => 50000,
                'tipe_bayar' => 'dp',
            ])
            ->assertOk();

        $this->assertDatabaseHas('pembayaran', [
            'id_sewa' => $sewa->id_sewa,
            'jumlah_bayar' => 50000,
            'metode' => 'Midtrans (DP 50%)',
        ]);

        // Setelah DP masuk, status barang berubah menjadi "Barang Sedang Disewa / Siap Diambil"
        $this->actingAs($user)
            ->get(route('pelanggan.dashboard'))
            ->assertOk()
            ->assertSee('Sudah DP: Rp 50.000')
            ->assertSee('Barang Sedang Disewa / Siap Diambil');
    }
}
