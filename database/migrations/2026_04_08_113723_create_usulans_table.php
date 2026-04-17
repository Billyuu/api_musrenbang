<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usulans', function (Blueprint $table) {
            $table->id();

            // 1. Relasi ke user (siapa yang mengusulkan)
            $table->unsignedBigInteger('user_id');

            // 2. Data Dropdown Dusun
            $table->string('dusun'); // Suko, Duyo, Rujak Sente

            // 3. Judul Usulan
            $table->string('judul_usulan');

            // 4. Masukan Permasalahan
            $table->text('permasalahan');

            // 5. Urgensi (Dropdown 5 pilihan)
            $table->string('urgensi');

            // 6. Masyarakat Terdampak (Dropdown 5 pilihan)
            $table->string('masyarakat_terdampak');

            // 7. Tingkat Kerusakan (Dropdown 5 pilihan)
            $table->string('tingkat_kerusakan');

            // 8. Biaya (Gunakan bigInteger atau decimal agar aman untuk angka besar)
            $table->bigInteger('biaya');

            // 9. Lokasi (Alamat detail/patokan)
            $table->string('lokasi_detail');

            // 10. Titik Koordinat (Latitude, Longitude)
            $table->string('koordinat')->nullable();

            // 11. Upload Foto (Kita simpan nama filenya saja)
            $table->string('foto_usulan')->nullable();

            // Tambahan: Status untuk diproses Admin
            $table->string('status')->default('pending');

            $table->timestamps();

            // Foreign key ke tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usulans');
    }
};
