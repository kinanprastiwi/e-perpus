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
    Schema::table('bukus', function (Blueprint $table) {
        $table->renameColumn('stok', 'stock'); // Jika ingin rename
        // atau
        $table->integer('stock')->default(0); // Jika ingin tambah kolom baru
    });
}

public function down()
{
    Schema::table('bukus', function (Blueprint $table) {
        $table->renameColumn('stock', 'stok'); // Untuk rollback
        // atau
        $table->dropColumn('stock');
    });
}
};
