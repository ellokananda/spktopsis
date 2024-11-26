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
        Schema::create('penggunas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_identitas')->unique();  // Nomor identitas unik (misal NIS atau NIK)
            $table->string('nama');
            $table->string('username')->unique();  // Username unik
            $table->string('password');  // Password yang terenkripsi
            $table->enum('role', ['admin', 'koordinator', 'siswa']);  // Menentukan role pengguna
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggunas');
    }
};
