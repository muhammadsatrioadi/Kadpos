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
        Schema::create('posyandu_data', function (Blueprint $table) {
            $table->id();
            $table->string('dusun', 100);
            $table->string('nama', 100);
            $table->enum('kategori', ['Balita', 'Ibu Hamil', 'Ibu Menyusui', 'Lansia']);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_lahir');
            $table->integer('umur');
            $table->text('alamat');
            $table->string('nomor_ktp', 16)->nullable();
            $table->string('nomor_bpjs', 20)->nullable();
            $table->decimal('berat_badan', 5, 1);
            $table->decimal('tinggi_badan', 5, 1);
            $table->decimal('imt', 4, 1)->nullable();
            $table->decimal('lingkar_perut', 5, 1)->nullable();
            $table->decimal('lingkar_kepala', 5, 1)->nullable();
            $table->decimal('lila', 5, 1)->nullable();
            $table->string('tekanan_darah', 20)->nullable();
            $table->text('mental_dan_emosional')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes untuk performa
            $table->index(['nama', 'kategori']);
            $table->index('dusun');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posyandu_data');
    }
};
