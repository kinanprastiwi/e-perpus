<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBukus extends Migration
{
    public function up()
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id('id_buku');
            $table->string('judul_buku', 125);
            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_penerbit');
            $table->string('pengarang', 125);
            $table->year('tahun_terbit');
            $table->string('isbn', 50)->unique();
            $table->integer('j_buku_baik')->default(0);
            $table->integer('j_buku_rusak')->default(0);
            $table->text('deskripsi')->nullable();
            $table->string('cover_buku')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bukus');
    }
}