<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Perbarui tabel users: update enum role dan tambahkan kolom profil jika belum ada
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'petugas', 'pelanggan') NOT NULL DEFAULT 'pelanggan'");

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'no_hp')) {
                $table->string('no_hp', 20)->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar', 255)->nullable()->after('no_hp');
            }
        });

        // 2. Perluas tabel pelanggan
        Schema::table('pelanggan', function (Blueprint $table) {
            if (!Schema::hasColumn('pelanggan', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id_pelanggan')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('pelanggan', 'poin_loyalitas')) {
                $table->integer('poin_loyalitas')->default(0)->after('no_identitas');
            }
            if (!Schema::hasColumn('pelanggan', 'total_transaksi_selesai')) {
                $table->integer('total_transaksi_selesai')->default(0)->after('poin_loyalitas');
            }
        });

        // 3. Perluas tabel petugas
        Schema::table('petugas', function (Blueprint $table) {
            if (!Schema::hasColumn('petugas', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id_petugas')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('petugas', 'role_jabatan')) {
                $table->string('role_jabatan', 50)->default('Petugas Operasional')->after('username');
            }
        });

        // 4. Perluas tabel kategori_alat
        Schema::table('kategori_alat', function (Blueprint $table) {
            if (!Schema::hasColumn('kategori_alat', 'slug')) {
                $table->string('slug', 60)->nullable()->after('nama_kategori');
            }
            if (!Schema::hasColumn('kategori_alat', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('kategori_alat', 'icon')) {
                $table->string('icon', 50)->nullable()->after('deskripsi');
            }
        });

        // 5. Perluas tabel alat
        Schema::table('alat', function (Blueprint $table) {
            if (!Schema::hasColumn('alat', 'kode_alat')) {
                $table->string('kode_alat', 30)->nullable()->after('id_kategori');
            }
            if (!Schema::hasColumn('alat', 'slug')) {
                $table->string('slug', 120)->nullable()->after('nama_alat');
            }
            if (!Schema::hasColumn('alat', 'spesifikasi')) {
                $table->text('spesifikasi')->nullable()->after('deskripsi');
            }
            if (!Schema::hasColumn('alat', 'ambang_minimum')) {
                $table->integer('ambang_minimum')->default(2)->after('stok');
            }
            if (!Schema::hasColumn('alat', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('gambar');
            }
        });

        // 6. Unit Inventaris individual
        if (!Schema::hasTable('unit_inventaris')) {
            Schema::create('unit_inventaris', function (Blueprint $table) {
                $table->increments('id_unit');
                $table->unsignedInteger('id_alat');
                $table->string('kode_unit', 50)->unique();
                $table->string('kondisi', 30)->default('Tersedia'); // Tersedia, Dipesan, Sedang Disewa, Perlu Dibersihkan, Dalam Perawatan, Rusak, Hilang
                $table->text('catatan')->nullable();
                $table->timestamps();

                $table->foreign('id_alat')->references('id_alat')->on('alat')->onDelete('cascade');
            });
        }

        // 7. Paket Camping
        if (!Schema::hasTable('paket_camping')) {
            Schema::create('paket_camping', function (Blueprint $table) {
                $table->increments('id_paket');
                $table->string('nama_paket', 100);
                $table->string('slug', 120)->unique();
                $table->text('deskripsi')->nullable();
                $table->decimal('harga_harian_normal', 12, 0);
                $table->decimal('harga_harian_paket', 12, 0);
                $table->decimal('hemat_per_hari', 12, 0)->default(0);
                $table->string('gambar', 255)->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 8. Detail Paket
        if (!Schema::hasTable('detail_paket')) {
            Schema::create('detail_paket', function (Blueprint $table) {
                $table->increments('id_detail_paket');
                $table->unsignedInteger('id_paket');
                $table->unsignedInteger('id_alat');
                $table->integer('jumlah')->default(1);
                $table->timestamps();

                $table->foreign('id_paket')->references('id_paket')->on('paket_camping')->onDelete('cascade');
                $table->foreign('id_alat')->references('id_alat')->on('alat')->onDelete('cascade');
            });
        }

        // 9. Promo & Kupon
        if (!Schema::hasTable('promo')) {
            Schema::create('promo', function (Blueprint $table) {
                $table->increments('id_promo');
                $table->string('kode_promo', 30)->unique();
                $table->string('judul', 100);
                $table->text('deskripsi')->nullable();
                $table->string('tipe_diskon', 20)->default('persen'); // persen, nominal
                $table->decimal('nilai_diskon', 12, 0);
                $table->decimal('minimal_transaksi', 12, 0)->default(0);
                $table->decimal('maksimal_diskon', 12, 0)->nullable();
                $table->integer('kuota_total')->default(100);
                $table->integer('kuota_terpakai')->default(0);
                $table->date('tanggal_mulai');
                $table->date('tanggal_selesai');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 10. Perluas tabel penyewaan
        Schema::table('penyewaan', function (Blueprint $table) {
            if (!Schema::hasColumn('penyewaan', 'kode_transaksi')) {
                $table->string('kode_transaksi', 50)->nullable()->unique()->after('id_sewa');
            }
            if (!Schema::hasColumn('penyewaan', 'id_paket')) {
                $table->unsignedInteger('id_paket')->nullable()->after('id_petugas');
                $table->foreign('id_paket')->references('id_paket')->on('paket_camping')->nullOnDelete();
            }
            if (!Schema::hasColumn('penyewaan', 'durasi_hari')) {
                $table->integer('durasi_hari')->default(1)->after('tgl_kembali_aktual');
            }
            if (!Schema::hasColumn('penyewaan', 'biaya_sewa')) {
                $table->decimal('biaya_sewa', 12, 0)->default(0)->after('durasi_hari');
            }
            if (!Schema::hasColumn('penyewaan', 'biaya_tambahan')) {
                $table->decimal('biaya_tambahan', 12, 0)->default(0)->after('biaya_sewa');
            }
            if (!Schema::hasColumn('penyewaan', 'diskon')) {
                $table->decimal('diskon', 12, 0)->default(0)->after('biaya_tambahan');
            }
            if (!Schema::hasColumn('penyewaan', 'kode_promo')) {
                $table->string('kode_promo', 30)->nullable()->after('diskon');
            }
            if (!Schema::hasColumn('penyewaan', 'deposit')) {
                $table->decimal('deposit', 12, 0)->default(0)->after('kode_promo');
            }
            if (!Schema::hasColumn('penyewaan', 'total_tagihan')) {
                $table->decimal('total_tagihan', 12, 0)->default(0)->after('deposit');
            }
            if (!Schema::hasColumn('penyewaan', 'total_dibayar')) {
                $table->decimal('total_dibayar', 12, 0)->default(0)->after('total_tagihan');
            }
            if (!Schema::hasColumn('penyewaan', 'sisa_tagihan')) {
                $table->decimal('sisa_tagihan', 12, 0)->default(0)->after('total_dibayar');
            }
            if (!Schema::hasColumn('penyewaan', 'status_pembayaran')) {
                $table->string('status_pembayaran', 30)->default('belum_dibayar')->after('sisa_tagihan');
            }
            if (!Schema::hasColumn('penyewaan', 'status_penyewaan')) {
                $table->string('status_penyewaan', 30)->default('menunggu_pembayaran')->after('status_pembayaran');
            }
            if (!Schema::hasColumn('penyewaan', 'jaminan_identitas')) {
                $table->string('jaminan_identitas', 100)->nullable()->after('status_penyewaan');
            }
            if (!Schema::hasColumn('penyewaan', 'catatan_pelanggan')) {
                $table->text('catatan_pelanggan')->nullable()->after('jaminan_identitas');
            }
            if (!Schema::hasColumn('penyewaan', 'catatan_petugas')) {
                $table->text('catatan_petugas')->nullable()->after('catatan_pelanggan');
            }
            if (!Schema::hasColumn('penyewaan', 'expired_at')) {
                $table->timestamp('expired_at')->nullable()->after('catatan_petugas');
            }
        });

        // 11. Perluas tabel detail_penyewaan
        Schema::table('detail_penyewaan', function (Blueprint $table) {
            if (!Schema::hasColumn('detail_penyewaan', 'id_paket')) {
                $table->unsignedInteger('id_paket')->nullable()->after('id_alat');
                $table->foreign('id_paket')->references('id_paket')->on('paket_camping')->nullOnDelete();
            }
            if (!Schema::hasColumn('detail_penyewaan', 'nama_item')) {
                $table->string('nama_item', 100)->nullable()->after('id_paket');
            }
        });

        // 12. Perluas tabel pembayaran
        Schema::table('pembayaran', function (Blueprint $table) {
            if (!Schema::hasColumn('pembayaran', 'kode_pembayaran')) {
                $table->string('kode_pembayaran', 50)->nullable()->unique()->after('id_bayar');
            }
            if (!Schema::hasColumn('pembayaran', 'jenis_pembayaran')) {
                $table->string('jenis_pembayaran', 30)->default('pembayaran_penuh')->after('metode'); // dp, pelunasan, pembayaran_penuh, denda
            }
            if (!Schema::hasColumn('pembayaran', 'bukti_pembayaran')) {
                $table->string('bukti_pembayaran', 255)->nullable()->after('jenis_pembayaran');
            }
            if (!Schema::hasColumn('pembayaran', 'status')) {
                $table->string('status', 30)->default('pending')->after('bukti_pembayaran'); // pending, diverifikasi, ditolak
            }
            if (!Schema::hasColumn('pembayaran', 'catatan')) {
                $table->text('catatan')->nullable()->after('status');
            }
            if (!Schema::hasColumn('pembayaran', 'diverifikasi_oleh')) {
                $table->unsignedInteger('diverifikasi_oleh')->nullable()->after('catatan');
                $table->foreign('diverifikasi_oleh')->references('id_petugas')->on('petugas')->nullOnDelete();
            }
            if (!Schema::hasColumn('pembayaran', 'diverifikasi_pada')) {
                $table->timestamp('diverifikasi_pada')->nullable()->after('diverifikasi_oleh');
            }
        });

        // 13. Pengembalian
        if (!Schema::hasTable('pengembalian')) {
            Schema::create('pengembalian', function (Blueprint $table) {
                $table->increments('id_pengembalian');
                $table->unsignedInteger('id_sewa');
                $table->unsignedInteger('id_petugas');
                $table->date('tanggal_rencana_kembali');
                $table->dateTime('tanggal_aktual_kembali');
                $table->integer('terlambat_hari')->default(0);
                $table->decimal('denda_keterlambatan', 12, 0)->default(0);
                $table->decimal('denda_kerusakan_kehilangan', 12, 0)->default(0);
                $table->decimal('total_denda', 12, 0)->default(0);
                $table->string('status_denda', 30)->default('tidak_ada'); // tidak_ada, belum_lunas, lunas
                $table->string('kondisi_umum', 50)->default('Baik');
                $table->text('catatan_pemeriksaan')->nullable();
                $table->string('foto_pemeriksaan', 255)->nullable();
                $table->timestamps();

                $table->foreign('id_sewa')->references('id_sewa')->on('penyewaan')->onDelete('cascade');
                $table->foreign('id_petugas')->references('id_petugas')->on('petugas')->onDelete('restrict');
            });
        }

        // 14. Detail Pengembalian
        if (!Schema::hasTable('detail_pengembalian')) {
            Schema::create('detail_pengembalian', function (Blueprint $table) {
                $table->increments('id_detail_pengembalian');
                $table->unsignedInteger('id_pengembalian');
                $table->unsignedInteger('id_alat');
                $table->integer('jumlah_sewa');
                $table->integer('jumlah_kembali_baik');
                $table->integer('jumlah_rusak')->default(0);
                $table->integer('jumlah_hilang')->default(0);
                $table->decimal('biaya_ganti_rugi', 12, 0)->default(0);
                $table->text('keterangan')->nullable();
                $table->timestamps();

                $table->foreign('id_pengembalian')->references('id_pengembalian')->on('pengembalian')->onDelete('cascade');
                $table->foreign('id_alat')->references('id_alat')->on('alat')->onDelete('restrict');
            });
        }

        // 15. Perawatan Alat
        if (!Schema::hasTable('perawatan_alat')) {
            Schema::create('perawatan_alat', function (Blueprint $table) {
                $table->increments('id_perawatan');
                $table->unsignedInteger('id_alat');
                $table->unsignedInteger('id_unit')->nullable();
                $table->date('tanggal_masuk');
                $table->date('tanggal_selesai')->nullable();
                $table->string('jenis_perawatan', 100);
                $table->decimal('biaya', 12, 0)->default(0);
                $table->text('keterangan')->nullable();
                $table->string('status', 30)->default('proses'); // proses, selesai
                $table->timestamps();

                $table->foreign('id_alat')->references('id_alat')->on('alat')->onDelete('cascade');
                $table->foreign('id_unit')->references('id_unit')->on('unit_inventaris')->nullOnDelete();
            });
        }

        // 16. Ulasan & Rating
        if (!Schema::hasTable('ulasan')) {
            Schema::create('ulasan', function (Blueprint $table) {
                $table->increments('id_ulasan');
                $table->unsignedInteger('id_sewa');
                $table->unsignedInteger('id_pelanggan');
                $table->unsignedInteger('id_alat')->nullable();
                $table->tinyInteger('rating')->default(5);
                $table->text('komentar')->nullable();
                $table->boolean('is_published')->default(true);
                $table->timestamps();

                $table->foreign('id_sewa')->references('id_sewa')->on('penyewaan')->onDelete('cascade');
                $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan')->onDelete('cascade');
                $table->foreign('id_alat')->references('id_alat')->on('alat')->nullOnDelete();
            });
        }

        // 17. Audit Logs
        if (!Schema::hasTable('audit_logs')) {
            Schema::create('audit_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('aksi', 50);
                $table->string('entitas', 50);
                $table->unsignedBigInteger('entitas_id')->nullable();
                $table->json('data_lama')->nullable();
                $table->json('data_baru')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamp('created_at')->useCurrent();
            });
        }

        // 18. Notifikasi Sistem
        if (!Schema::hasTable('notifikasi_sistem')) {
            Schema::create('notifikasi_sistem', function (Blueprint $table) {
                $table->increments('id_notif');
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('judul', 100);
                $table->text('pesan');
                $table->string('tipe', 20)->default('info'); // info, sukses, peringatan, bahaya
                $table->string('link', 255)->nullable();
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi_sistem');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('ulasan');
        Schema::dropIfExists('perawatan_alat');
        Schema::dropIfExists('detail_pengembalian');
        Schema::dropIfExists('pengembalian');

        Schema::table('pembayaran', function (Blueprint $table) {
            if (Schema::hasColumn('pembayaran', 'diverifikasi_oleh')) {
                $table->dropForeign(['diverifikasi_oleh']);
            }
            $table->dropColumn(['kode_pembayaran', 'jenis_pembayaran', 'bukti_pembayaran', 'status', 'catatan', 'diverifikasi_oleh', 'diverifikasi_pada']);
        });

        Schema::table('detail_penyewaan', function (Blueprint $table) {
            if (Schema::hasColumn('detail_penyewaan', 'id_paket')) {
                $table->dropForeign(['id_paket']);
            }
            $table->dropColumn(['id_paket', 'nama_item']);
        });

        Schema::table('penyewaan', function (Blueprint $table) {
            if (Schema::hasColumn('penyewaan', 'id_paket')) {
                $table->dropForeign(['id_paket']);
            }
            $table->dropColumn([
                'kode_transaksi', 'id_paket', 'durasi_hari', 'biaya_sewa', 'biaya_tambahan',
                'diskon', 'kode_promo', 'deposit', 'total_tagihan', 'total_dibayar',
                'sisa_tagihan', 'status_pembayaran', 'status_penyewaan', 'jaminan_identitas',
                'catatan_pelanggan', 'catatan_petugas', 'expired_at'
            ]);
        });

        Schema::dropIfExists('promo');
        Schema::dropIfExists('detail_paket');
        Schema::dropIfExists('paket_camping');
        Schema::dropIfExists('unit_inventaris');

        Schema::table('alat', function (Blueprint $table) {
            $table->dropColumn(['kode_alat', 'slug', 'spesifikasi', 'ambang_minimum', 'is_active']);
        });

        Schema::table('kategori_alat', function (Blueprint $table) {
            $table->dropColumn(['slug', 'deskripsi', 'icon']);
        });

        Schema::table('petugas', function (Blueprint $table) {
            if (Schema::hasColumn('petugas', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn(['user_id', 'role_jabatan']);
            }
        });

        Schema::table('pelanggan', function (Blueprint $table) {
            if (Schema::hasColumn('pelanggan', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn(['user_id', 'poin_loyalitas', 'total_transaksi_selesai']);
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['no_hp', 'avatar']);
        });
    }
};
