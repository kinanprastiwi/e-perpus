<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('log_aktivitas', function (Blueprint $table) {
        $table->id('id_log');
        $table->unsignedBigInteger('id_user');
        $table->string('aktivitas', 255);
        $table->string('tabel_terkait', 50);
        $table->ipAddress('ip_address');
        $table->string('user_agent');
        $table->timestamps();
        
        // Foreign key constraint
        $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
    }
};
