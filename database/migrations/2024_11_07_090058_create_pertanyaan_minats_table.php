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
        Schema::create('pertanyaan_minats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kriteria_minat_id')->unsigned();
            $table->foreign('kriteria_minat_id')->references('id')->on('kriteria_minats')->onDelete('cascade');
            $table->bigInteger('sub_alternatif_id')->unsigned();
            $table->foreign('sub_alternatif_id')->references('id')->on('sub_alternatifs')->onDelete('cascade');
            $table->text('pertanyaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_minats');
    }
};
