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
        Schema::create('bahan_mentah_produksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_bahan_mentah')->constrained('bahan_mentahs', 'id');
            $table->foreignId('id_hasil_produksi')->constrained('hasil_produksis', 'id');
            $table->integer('kuantitas');
            $table->integer('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_mentah_produksis');
    }
};