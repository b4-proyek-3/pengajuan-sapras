<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuansTable extends Migration
{
    public function up()
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->string('ormawa');
            $table->string('nama_pengaju');
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_berakhir');
            $table->string('waktu');
            $table->string('nama_kegiatan');
            $table->string('tempat_peminjaman');
            $table->string('dokumen1');
            $table->string('dokumen2')->nullable();
            $table->string('dokumen3')->nullable();
            $table->string('dokumen4')->nullable();
            $table->string('dokumen5')->nullable();
            $table->string('dokumen6')->nullable();
            $table->string('dokumen7')->nullable();
            $table->string('link_gdrive')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengajuans');
    }
}