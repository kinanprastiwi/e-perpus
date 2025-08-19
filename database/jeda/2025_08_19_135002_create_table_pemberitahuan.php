<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemberitahuanTable extends Migration
{
    public function up()
    {
        Schema::create('pemberitahuan', function (Blueprint $table) {
            $table->id('id_pemberitahuan');
            $table->text('isi_pemberitahuan');
            $table->enum('level_user', ['semua', 'admin', 'petugas', 'anggota'])->default('semua');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemberitahuan');
    }
}