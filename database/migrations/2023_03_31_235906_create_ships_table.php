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
        Schema::create('ships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('kode_kapal')->unique();
            $table->string('nama_kapal');
            $table->string('nama_pemilik');
            $table->string('alamat_pemilik');
            $table->string('ukuran_kapal');
            $table->string('kapten');
            $table->unsignedInteger('jumlah_anggota');
            $table->string('foto_kapal');
            $table->string('nomor_izin');
            $table->string('dokumen_perizinan');
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ships');
    }
};
