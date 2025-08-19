<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePenerbits extends Migration
{
    public function up()
    {
        Schema::create('penerbits', function (Blueprint $table) {
            $table->id('id_penerbit');
            $table->string('kode_penerbit', 125)->unique();
            $table->string('nama_penerbit', 50);
            $table->string('verif_penerbit', 25)->default('Belum Terverifikasi');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penerbits');
    }
}