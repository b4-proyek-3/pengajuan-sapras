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
        Schema::create('reviewers', function (Blueprint $table) {
            $table->string('nip')->primary();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            //$table->unsignedBigInteger('id_role'); // Foreign key ke tabel roles
            //$table->foreign('id_role')->references('id_role')->on('roles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviewer');
    }
};
