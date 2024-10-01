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
            $table->string('nim')->primary();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            //$table->unsignedBigInteger('id_ormawa'); // Foreign key ke tabel ormawa
            //$table->foreign('id_ormawa')->references('id_ormawa')->on('ormawa')->onDelete('cascade');
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
