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
        Schema::create('siswahs', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique();
            $table->string('tahun_akademik')->nullable();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->integer('rata')->nullable();
            $table->string('prestasi')->nullable();
            $table->string('rekomendasi_jenjang')->nullable();
            $table->string('rekomendasi_peminatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswahs');
    }
};
