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
        Schema::create('pilihans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kriteria_id')->unsigned()->nullable();
            $table->foreign('kriteria_id')->references('id')->on('kriterias');
            $table->bigInteger('kriteria_minat_id')->unsigned()->nullable();
            $table->foreign('kriteria_minat_id')->references('id')->on('kriteria_minats');
            $table->string('nama');
            $table->integer('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilihans');
    }
};
