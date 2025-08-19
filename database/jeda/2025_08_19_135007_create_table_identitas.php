<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdentitasTable extends Migration
{
    public function up()
    {
        Schema::create('identitas', function (Blueprint $table) {
            $table->id('id_identitas');
            $table->string('nama_app', 50);
            $table->text('alamat_app');
            $table->string('email_app', 125);
            $table->string('nomor_hp', 50);
            $table->text('foto_app')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('identitas');
    }
}