<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaju', function (Blueprint $table) {
            $table->char('nim', length: 8)->primary();
            $table->id('id_user');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_ormawa'); // Foreign key ke tabel ormawa
            $table->foreign('id_ormawa')->references('id_ormawa')->on('ormawa')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaju');
    }
};
