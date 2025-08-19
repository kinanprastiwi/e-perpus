<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUsersApp extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('kode_user', 25)->unique();
            $table->char('nis', 20)->nullable();
            $table->string('fullname', 125);
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->string('kelas', 50)->nullable();
            $table->text('alamat')->nullable();
            $table->string('verif', 50)->default('Belum Terverifikasi');
            $table->enum('role', ['admin', 'petugas', 'anggota'])->default('anggota');
            $table->date('join_date');
            $table->timestamp('terakhir_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}