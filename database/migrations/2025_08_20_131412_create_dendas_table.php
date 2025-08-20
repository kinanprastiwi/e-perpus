<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('denda', function (Blueprint $table) {
        $table->id('id_denda');
        $table->decimal('tarif_denda_per_hari', 10, 2);
        $table->integer('maksimal_hari_peminjaman');
        $table->integer('maksimal_peminjaman_buku');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};
