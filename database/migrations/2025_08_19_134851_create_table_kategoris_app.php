<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKategorisApp extends Migration
{
    public function up()
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('kode_kategori', 50)->unique();
            $table->string('nama_kategori', 125);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kategoris');
    }
}