<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddForeignKeysToTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Fungsi untuk menghapus foreign key jika sudah ada
        $dropForeignKeyIfExists = function ($tableName, $columnName) {
            $constraintName = "{$tableName}_{$columnName}_foreign";
            
            // Cek apakah constraint sudah ada
            $exists = DB::select("
                SELECT COUNT(*) as count 
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                WHERE CONSTRAINT_NAME = ? 
                AND TABLE_SCHEMA = ?
                AND TABLE_NAME = ?
            ", [$constraintName, config('database.connections.mysql.database'), $tableName]);
            
            if ($exists[0]->count > 0) {
                Schema::table($tableName, function (Blueprint $table) use ($columnName, $constraintName) {
                    $table->dropForeign([$columnName]);
                });
            }
        };

        // Pastikan tabel-tabel utama sudah ada sebelum menambahkan foreign key
        if (Schema::hasTable('kategoris') && Schema::hasTable('bukus')) {
            $dropForeignKeyIfExists('bukus', 'id_kategori');
            Schema::table('bukus', function (Blueprint $table) {
                $table->foreign('id_kategori')
                      ->references('id_kategori')
                      ->on('kategoris')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');
            });
        }

        if (Schema::hasTable('penerbits') && Schema::hasTable('bukus')) {
            $dropForeignKeyIfExists('bukus', 'id_penerbit');
            Schema::table('bukus', function (Blueprint $table) {
                $table->foreign('id_penerbit')
                      ->references('id_penerbit')
                      ->on('penerbits')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');
            });
        }

        if (Schema::hasTable('users') && Schema::hasTable('peminjaman')) {
            $dropForeignKeyIfExists('peminjaman', 'id_user');
            Schema::table('peminjaman', function (Blueprint $table) {
                $table->foreign('id_user')
                      ->references('id_user')
                      ->on('users')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');
            });
        }

        if (Schema::hasTable('bukus') && Schema::hasTable('peminjaman')) {
            $dropForeignKeyIfExists('peminjaman', 'id_buku');
            Schema::table('peminjaman', function (Blueprint $table) {
                $table->foreign('id_buku')
                      ->references('id_buku')
                      ->on('bukus')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');
            });
        }

        if (Schema::hasTable('users') && Schema::hasTable('pesan')) {
            $dropForeignKeyIfExists('pesan', 'penerima');
            Schema::table('pesan', function (Blueprint $table) {
                $table->foreign('penerima')
                      ->references('id_user')
                      ->on('users')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');
            });
        }

        if (Schema::hasTable('users') && Schema::hasTable('pesan')) {
            $dropForeignKeyIfExists('pesan', 'pengirim');
            Schema::table('pesan', function (Blueprint $table) {
                $table->foreign('pengirim')
                      ->references('id_user')
                      ->on('users')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');
            });
        }

        if (Schema::hasTable('users') && Schema::hasTable('log_aktivitas')) {
            $dropForeignKeyIfExists('log_aktivitas', 'id_user');
            Schema::table('log_aktivitas', function (Blueprint $table) {
                $table->foreign('id_user')
                      ->references('id_user')
                      ->on('users')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
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

        Schema::table('pesan', function (Blueprint $table) {
            $table->dropForeign(['penerima']);
            $table->dropForeign(['pengirim']);
        });

        Schema::table('log_aktivitas', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
        });
    }
}