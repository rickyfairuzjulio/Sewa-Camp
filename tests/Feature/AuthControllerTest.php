<?php

namespace Tests\Feature;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

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

        Schema::create('pembayaran', function (Blueprint $table): void {
            $table->increments('id_bayar');
            $table->unsignedInteger('id_sewa');
            $table->date('tgl_bayar')->nullable();
            $table->decimal('jumlah_bayar', 12, 0)->default(0);
            $table->string('metode')->nullable();
            $table->timestamps();
        });

        Schema::create('petugas', function (Blueprint $table): void {
            $table->increments('id_petugas');
            $table->timestamps();
        });

        Schema::create('alat', function (Blueprint $table): void {
            $table->increments('id_alat');
            $table->unsignedInteger('id_kategori')->nullable();
            $table->string('nama_alat');
            $table->decimal('harga_sewa_per_hari', 12, 0);
            $table->integer('stok')->default(0);
            $table->string('kondisi')->nullable();
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
    }

    public function test_admin_login_redirects_to_admin_dashboard_instead_of_intended_customer_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $response = $this->from(route('pelanggan.dashboard'))
            ->post(route('login.post'), [
                'email' => strtoupper($user->email),
                'password' => 'password',
            ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_petugas_login_redirects_to_petugas_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'petugas@example.test',
            'password' => 'password',
            'role' => 'petugas',
        ]);

        $response = $this->post(route('login.post'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('petugas.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_does_not_switch_an_already_authenticated_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create([
            'email' => 'another-customer@example.test',
            'password' => 'password',
            'role' => 'pelanggan',
        ]);

        $response = $this->actingAs($admin)->post(route('login.post'), [
            'email' => $customer->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_pelanggan_login_can_open_dashboard_while_verification_is_pending(): void
    {
        $user = User::factory()->create([
            'email' => 'pelanggan@example.test',
            'password' => 'password',
            'role' => 'pelanggan',
        ]);

        Pelanggan::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            'no_hp' => '081234567890',
            'no_identitas' => 'ID-PELANGGAN-1',
            'status_verifikasi' => 'belum_verifikasi',
        ]);

        $loginResponse = $this->post(route('login.post'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $loginResponse->assertRedirect(route('pelanggan.dashboard'));

        $this->get(route('pelanggan.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Pelanggan')
            ->assertSee('Belum Verifikasi')
            ->assertDontSee('Data Pelanggan')
            ->assertDontSee('Transaksi Sewa')
            ->assertDontSee('Ringkasan Laporan');

        $this->get(route('public.cara_sewa'))
            ->assertOk()
            ->assertSee(route('pelanggan.dashboard'), false)
            ->assertDontSee(route('petugas.dashboard'), false);
    }

    public function test_customer_registration_page_is_available_from_login(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee(route('register'), false);

        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Buat akun CampSewa');
    }

    public function test_registration_creates_a_pending_customer_and_authenticates_the_account(): void
    {
        $response = $this->post(route('register.post'), [
            'nama' => 'Rani Pratama',
            'email' => 'RANI@EXAMPLE.TEST',
            'no_hp' => '081234567890',
            'alamat' => 'Semarang',
            'no_identitas' => 'ID-REG-001',
            'password' => 'campsewa-password',
            'password_confirmation' => 'campsewa-password',
            'role' => 'admin',
        ]);

        $response->assertRedirect(route('pelanggan.dashboard'));
        $this->assertDatabaseHas('users', [
            'name' => 'Rani Pratama',
            'email' => 'rani@example.test',
            'role' => 'pelanggan',
            'no_hp' => '081234567890',
        ]);
        $this->assertDatabaseHas('pelanggan', [
            'nama' => 'Rani Pratama',
            'no_identitas' => 'ID-REG-001',
            'status_verifikasi' => 'belum_verifikasi',
        ]);

        $user = User::where('email', 'rani@example.test')->firstOrFail();
        $this->assertAuthenticatedAs($user);

        $this->get(route('pelanggan.dashboard'))
            ->assertOk()
            ->assertSee('Belum Verifikasi');
    }

    public function test_registration_claims_an_unlinked_profile_only_when_identity_and_phone_match(): void
    {
        $pelanggan = Pelanggan::create([
            'nama' => 'Pelanggan Lama',
            'no_hp' => '081234567890',
            'alamat' => 'Semarang',
            'no_identitas' => 'ID-LAMA-001',
            'status_verifikasi' => 'terverifikasi',
        ]);
        DB::table('penyewaan')->insert([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'tgl_sewa' => now()->toDateString(),
            'tgl_kembali_rencana' => now()->addDay()->toDateString(),
            'status' => 'Selesai',
            'total_biaya' => 50000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->post(route('register.post'), [
            'nama' => 'Nama yang dikirim pengguna',
            'email' => 'pelanggan.lama@example.test',
            'no_hp' => '081234567890',
            'no_identitas' => 'ID-LAMA-001',
            'password' => 'campsewa-password',
            'password_confirmation' => 'campsewa-password',
        ]);

        $response->assertRedirect(route('pelanggan.dashboard'));
        $this->assertDatabaseHas('pelanggan', [
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'user_id' => User::where('email', 'pelanggan.lama@example.test')->value('id'),
            'status_verifikasi' => 'belum_verifikasi',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'pelanggan.lama@example.test',
            'name' => 'Pelanggan Lama',
        ]);

        $this->get(route('pelanggan.dashboard'))
            ->assertOk()
            ->assertSee('Belum Verifikasi')
            ->assertSee('Riwayat transaksi akan tampil')
            ->assertDontSee('Selesai');
    }

    public function test_registration_does_not_claim_an_existing_profile_with_a_different_phone(): void
    {
        $pelanggan = Pelanggan::create([
            'nama' => 'Pelanggan Lama',
            'no_hp' => '081234567890',
            'no_identitas' => 'ID-LAMA-002',
            'status_verifikasi' => 'terverifikasi',
        ]);

        $response = $this->from(route('register'))
            ->post(route('register.post'), [
                'nama' => 'Pengguna Tidak Cocok',
                'email' => 'claim-fail@example.test',
                'no_hp' => '089999999999',
                'no_identitas' => 'ID-LAMA-002',
                'password' => 'campsewa-password',
                'password_confirmation' => 'campsewa-password',
            ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors('no_identitas');
        $this->assertDatabaseMissing('users', ['email' => 'claim-fail@example.test']);
        $this->assertDatabaseHas('pelanggan', [
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'user_id' => null,
            'status_verifikasi' => 'terverifikasi',
        ]);
        $this->assertGuest();
    }

    public function test_admin_can_verify_a_customer_before_their_history_is_shown(): void
    {
        $customer = User::factory()->create(['role' => 'pelanggan']);
        $pelanggan = Pelanggan::create([
            'user_id' => $customer->id,
            'nama' => $customer->name,
            'no_hp' => '081234567890',
            'no_identitas' => 'ID-VERIFY-001',
            'status_verifikasi' => 'belum_verifikasi',
        ]);
        DB::table('penyewaan')->insert([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'tgl_sewa' => now()->toDateString(),
            'tgl_kembali_rencana' => now()->addDay()->toDateString(),
            'status' => 'Selesai',
            'total_biaya' => 50000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.pelanggan.show', $pelanggan))
            ->assertOk()
            ->assertSee('Verifikasi akun');

        $this->actingAs($admin)
            ->post(route('admin.pelanggan.verify', $pelanggan))
            ->assertRedirect(route('admin.pelanggan.show', $pelanggan));

        $this->assertDatabaseHas('pelanggan', [
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'status_verifikasi' => 'terverifikasi',
        ]);

        $this->actingAs($customer)
            ->get(route('pelanggan.dashboard'))
            ->assertOk()
            ->assertSee('Selesai')
            ->assertDontSee('Riwayat transaksi akan tampil');
    }

    public function test_petugas_cannot_verify_a_customer_account(): void
    {
        $customer = User::factory()->create(['role' => 'pelanggan']);
        $pelanggan = Pelanggan::create([
            'user_id' => $customer->id,
            'nama' => $customer->name,
            'no_hp' => '081234567890',
            'no_identitas' => 'ID-VERIFY-002',
            'status_verifikasi' => 'belum_verifikasi',
        ]);
        $petugas = User::factory()->create(['role' => 'petugas']);

        $this->actingAs($petugas)
            ->post(route('admin.pelanggan.verify', $pelanggan))
            ->assertForbidden();

        $this->assertDatabaseHas('pelanggan', [
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'status_verifikasi' => 'belum_verifikasi',
        ]);
    }

    public function test_authenticated_customer_rental_is_saved_to_the_dashboard_profile(): void
    {
        $user = User::factory()->create(['role' => 'pelanggan']);
        $pelanggan = Pelanggan::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            'no_hp' => '081234567890',
            'no_identitas' => 'ID-PELANGGAN-2',
            'status_verifikasi' => 'belum_verifikasi',
        ]);
        $equipmentId = \Illuminate\Support\Facades\DB::table('alat')->insertGetId([
            'nama_alat' => 'Tenda Dome',
            'harga_sewa_per_hari' => 25000,
            'stok' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $startDate = now()->addDay();

        $response = $this->actingAs($user)->post(route('public.sewa.simpan'), [
            'nama' => 'Nama yang tidak boleh menimpa profil',
            'no_hp' => '089999999999',
            'no_identitas' => 'ID-PELANGGAN-2',
            'tgl_sewa' => $startDate->toDateString(),
            'tgl_kembali_rencana' => $startDate->copy()->addDay()->toDateString(),
            'items' => [
                ['id_alat' => $equipmentId, 'jumlah' => 1],
            ],
        ]);

        $response->assertRedirect(route('public.sewa.sukses', 1));
        $this->assertDatabaseHas('penyewaan', [
            'id_sewa' => 1,
            'id_pelanggan' => $pelanggan->id_pelanggan,
        ]);
        $this->assertDatabaseHas('pelanggan', [
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'nama' => $user->name,
            'no_hp' => '081234567890',
        ]);

        $this->get(route('pelanggan.dashboard'))
            ->assertOk()
            ->assertSee('Transaksi 1');
    }

    public function test_registration_rejects_a_password_confirmation_mismatch(): void
    {
        $response = $this->from(route('register'))
            ->post(route('register.post'), [
                'nama' => 'Rani Pratama',
                'email' => 'rani@example.test',
                'no_hp' => '081234567890',
                'no_identitas' => 'ID-REG-002',
                'password' => 'campsewa-password',
                'password_confirmation' => 'different-password',
            ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', ['email' => 'rani@example.test']);
        $this->assertGuest();
    }

    public function test_invalid_login_returns_an_error_without_authenticating(): void
    {
        $response = $this->post(route('login.post'), [
            'email' => 'unknown@example.test',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_is_rate_limited_after_five_invalid_attempts(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post(route('login.post'), [
                'email' => 'unknown@example.test',
                'password' => 'wrong-password',
            ])->assertSessionHasErrors('email');
        }

        $this->post(route('login.post'), [
            'email' => 'unknown@example.test',
            'password' => 'wrong-password',
        ])->assertStatus(429);
    }

    public function test_customer_cannot_open_an_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'pelanggan']);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }
}
