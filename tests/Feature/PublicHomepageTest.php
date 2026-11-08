<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PublicHomepageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createPublicHomepageSchema();
    }

    public function test_homepage_displays_live_categories_equipment_and_catalog_search(): void
    {
        $categoryId = $this->createCategory('Tenda');
        $this->createEquipment($categoryId, 'Tenda Dome Dua Orang', 25000);

        $response = $this->get(route('public.beranda'));

        $response->assertOk();
        $response->assertSee('Sewa Gear Outdoor');
        $response->assertSee('Kini Lebih Mudah!');
        $response->assertSee('Tenda');
        $response->assertSee('Tenda Dome Dua Orang');
        $response->assertSee(route('public.katalog'), false);
        $response->assertSee('name="q"', false);
        $response->assertSee('name="kategori"', false);
        $response->assertSee('name="sort"', false);
    }

    public function test_catalog_search_filters_equipment_from_the_homepage_search_fields(): void
    {
        $categoryId = $this->createCategory('Perlengkapan');
        $this->createEquipment($categoryId, 'Tenda Dome Dua Orang', 25000);
        $this->createEquipment($categoryId, 'Carrier 45 Liter', 35000);

        $response = $this->get(route('public.katalog', [
            'q' => 'Tenda',
            'kategori' => $categoryId,
            'stok' => 'tersedia',
            'sort' => 'terbaru',
        ]));

        $response->assertOk();
        $response->assertSee('Tenda Dome Dua Orang');
        $response->assertDontSee('Carrier 45 Liter');
    }

    public function test_equipment_detail_and_rental_form_render_for_available_equipment(): void
    {
        $categoryId = $this->createCategory('Tenda');
        $equipmentId = $this->createEquipment($categoryId, 'Tenda Dome Dua Orang', 25000);

        $detailResponse = $this->get(route('public.detail', $equipmentId));
        $guestRentalResponse = $this->get(route('public.sewa', ['alat_id' => $equipmentId]));
        $guestRentalResponse->assertRedirect(route('login'));

        $user = \App\Models\User::factory()->create(['role' => 'pelanggan']);
        $rentalResponse = $this->actingAs($user)->get(route('public.sewa', ['alat_id' => $equipmentId]));

        $detailResponse->assertOk();
        $detailResponse->assertSee('Tenda Dome Dua Orang');
        $detailResponse->assertSee(route('public.sewa', ['alat_id' => $equipmentId]), false);
        $rentalResponse->assertOk();
        $rentalResponse->assertSee('Formulir penyewaan');
        $rentalResponse->assertSee('name="items[0][id_alat]"', false);
        $rentalResponse->assertSee('name="tgl_sewa"', false);
        $rentalResponse->assertSee('name="tgl_kembali_rencana"', false);
    }

    public function test_rental_request_validates_and_stores_equipment_booking(): void
    {
        $categoryId = $this->createCategory('Tenda');
        $equipmentId = $this->createEquipment($categoryId, 'Tenda Dome Dua Orang', 25000);
        $startDate = now()->addDay();
        $user = \App\Models\User::factory()->create(['role' => 'pelanggan']);

        $response = $this->actingAs($user)->post(route('public.sewa.simpan'), [
            'nama' => 'Rani Pratama',
            'no_hp' => '081234567890',
            'alamat' => 'Semarang',
            'no_identitas' => 'ID-CAMP-001',
            'tgl_sewa' => $startDate->toDateString(),
            'tgl_kembali_rencana' => $startDate->copy()->addDays(2)->toDateString(),
            'items' => [
                ['id_alat' => $equipmentId, 'jumlah' => 2],
            ],
        ]);

        $response->assertRedirect(route('public.sewa.sukses', 1));
        $this->assertDatabaseHas('pelanggan', ['no_identitas' => 'ID-CAMP-001']);
        $this->assertDatabaseHas('penyewaan', ['id_sewa' => 1, 'total_biaya' => 100000]);
        $this->assertDatabaseHas('detail_penyewaan', ['id_sewa' => 1, 'id_alat' => $equipmentId, 'jumlah' => 2]);
        $this->assertDatabaseHas('alat', ['id_alat' => $equipmentId, 'stok' => 0]);

        $successResponse = $this->actingAs($user)->get(route('public.sewa.sukses', 1));

        $successResponse->assertOk();
        $successResponse->assertSee('Pengajuan sewa berhasil');
        $successResponse->assertSee('Tenda Dome Dua Orang');
        $successResponse->assertSee('Rp 100.000');
    }

    public function test_rental_request_returns_validation_errors_for_missing_required_fields(): void
    {
        $user = \App\Models\User::factory()->create(['role' => 'pelanggan']);

        $response = $this->actingAs($user)->from(route('public.sewa'))
            ->post(route('public.sewa.simpan'), []);

        $response->assertRedirect(route('public.sewa'));
        $response->assertSessionHasErrors([
            'nama',
            'no_hp',
            'no_identitas',
            'tgl_sewa',
            'tgl_kembali_rencana',
            'items',
        ]);
    }

    public function test_public_guide_and_contact_pages_render(): void
    {
        $guideResponse = $this->get(route('public.cara_sewa'));
        $contactResponse = $this->get(route('public.kontak'));

        $guideResponse->assertOk();
        $guideResponse->assertSee('Cara sewa perlengkapan');
        $contactResponse->assertOk();
        $contactResponse->assertSee('Kontak CampSewa');
        $contactResponse->assertSee('0812-3456-7890');
    }

    private function createCategory(string $name): int
    {
        return DB::table('kategori_alat')->insertGetId([
            'nama_kategori' => $name,
            'created_at' => now(),
            'updated_at' => now(),
        ], 'id_kategori');
    }

    private function createEquipment(int $categoryId, string $name, int $dailyPrice): int
    {
        return DB::table('alat')->insertGetId([
            'id_kategori' => $categoryId,
            'nama_alat' => $name,
            'harga_sewa_per_hari' => $dailyPrice,
            'stok' => 2,
            'kondisi' => 'Baik',
            'created_at' => now(),
            'updated_at' => now(),
        ], 'id_alat');
    }
}
