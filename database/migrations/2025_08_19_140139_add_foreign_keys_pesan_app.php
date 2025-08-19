<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysPesanApp extends Migration
{
    public function up()
    {
        Schema::table('pesan', function (Blueprint $table) {
            $table->foreign('penerima')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('pengirim')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('pesan', function (Blueprint $table) {
            $table->dropForeign(['penerima']);
            $table->dropForeign(['pengirim']);
        });
    }
}