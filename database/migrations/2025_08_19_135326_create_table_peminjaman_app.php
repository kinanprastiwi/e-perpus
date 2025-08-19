<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePeminjamanApp extends Migration
{
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_buku');
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian')->nullable();
            $table->date('tanggal_harus_kembali');
            $table->enum('kondisi_buku_saat_dipinjam', ['Baik', 'Rusak Ringan', 'Rusak Berat']);
            $table->enum('kondisi_buku_saat_dikembalikan', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->nullable();
            $table->decimal('denda', 10, 2)->default(0);
            $table->enum('status', ['Dipinjam', 'Dikembalikan', 'Terlambat'])->default('Dipinjam');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peminjaman');
    }
}