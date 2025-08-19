<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePesanApp extends Migration
{
    public function up()
    {
        Schema::create('pesan', function (Blueprint $table) {
            $table->id('id_pesan');
            $table->unsignedBigInteger('penerima');
            $table->unsignedBigInteger('pengirim');
            $table->string('judul_pesan', 50);
            $table->text('isi_pesan');
            $table->enum('status', ['terkirim', 'dibaca'])->default('terkirim');
            $table->timestamp('tanggal_kirim');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesan');
    }
}