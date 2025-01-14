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
        Schema::create('menggunakan_ruangan', function (Blueprint $table) {
            $table->id('id_menggunakan_ruangan');
            $table->string('id_pengajuan', length: 6);
            $table->foreign('id_pengajuan')->references('id_pengajuan')->on('pengajuan')->onDelete('cascade');
            $table->unsignedBigInteger('id_ruangan');
            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangan')->onDelete('cascade');
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->time('waktu_mulai');
            $table->time('waktu_akhir');
            $table->timestamps();

            $table->unique(['id_pengajuan', 'id_ruangan', 'tanggal_mulai', 'waktu_mulai'], 'unique_penggunaan_ruangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};