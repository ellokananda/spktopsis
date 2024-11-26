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
        Schema::create('pertanyaans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kriteria_id')->unsigned();
            $table->foreign('kriteria_id')->references('id')->on('kriterias')->onDelete('cascade');
            $table->bigInteger('alternatif_id')->unsigned();
            $table->foreign('alternatif_id')->references('id')->on('alternatifs')->onDelete('cascade');
            $table->text('pertanyaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaans');
    }
};
