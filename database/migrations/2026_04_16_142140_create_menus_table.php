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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('n');         // Nama menu (Contoh: Ayam)
            $table->string('h');         // Harga (Contoh: 22.000)
            $table->string('img');       // Nama file gambar (Contoh: AYAM.png)
            $table->string('category');  // Kategori (tanpa-nasi, paket-komplit, ala-carte)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
