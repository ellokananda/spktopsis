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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pengguna_id')->unsigned();
            $table->foreign('pengguna_id')->references('id')->on('penggunas')->onDelete('cascade');
            $table->bigInteger('pertanyaan_id')->unsigned();
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaans')->onDelete('cascade');
            $table->float('nilai');
            $table->integer('rata');
            $table->float('prestasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
