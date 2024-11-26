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
        Schema::create('penilaian_minats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pengguna_id')->unsigned();
            $table->foreign('pengguna_id')->references('id')->on('penggunas')->onDelete('cascade');
            $table->bigInteger('pertanyaan_minat_id')->unsigned();
            $table->foreign('pertanyaan_minat_id')->references('id')->on('pertanyaan_minats')->onDelete('cascade');
            // $table->bigInteger('pilihan_id')->unsigned();
            // $table->foreign('pilihan_id')->references('id')->on('pilihans');
            // $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->float('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_minats');
    }
};
