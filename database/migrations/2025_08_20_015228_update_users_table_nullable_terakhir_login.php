<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateUsersTableNullableTerakhirLogin extends Migration
{
    public function up()
    {
        // Untuk MySQL
        DB::statement('ALTER TABLE users MODIFY terakhir_login TIMESTAMP NULL');
        
        // atau untuk database lain
        // Schema::table('users', function (Blueprint $table) {
        //     $table->timestamp('terakhir_login')->nullable()->change();
        // });
    }

    public function down()
    {
        DB::statement('ALTER TABLE users MODIFY terakhir_login TIMESTAMP');
        
        // atau untuk database lain
        // Schema::table('users', function (Blueprint $table) {
        //     $table->timestamp('terakhir_login')->change();
        // });
    }
}