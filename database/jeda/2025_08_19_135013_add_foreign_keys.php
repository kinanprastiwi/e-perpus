<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysApp extends Migration
{
    public function up()
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->foreign('id_kategori')->references('id_kategori')->on('kategoris')->onDelete('cascade');
            $table->foreign('id_penerbit')->references('id_penerbit')->on('penerbits')->onDelete('cascade');
        });

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_buku')->references('id_buku')->on('bukus')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
            $table->dropForeign(['id_penerbit']);
        });

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropForeign(['id_buku']);
        });
    }
}