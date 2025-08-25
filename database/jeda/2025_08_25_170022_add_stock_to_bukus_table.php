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
            // Cek dulu jika kolom stock belum ada, baru tambahkan
            if (!Schema::hasColumn('bukus', 'stock')) {
                $table->integer('stock')->default(0)->after('judul');
            }
        });
    }

    public function down()
    {
        Schema::table('bukus', function (Blueprint $table) {
            if (Schema::hasColumn('bukus', 'stock')) {
                $table->dropColumn('stock');
            }
        });
    }
};
