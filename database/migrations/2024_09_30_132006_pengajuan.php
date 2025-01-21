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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->string('id_pengajuan', length: 6)->primary();
            $table->char('nim', 9)->nullable();
            $table->foreign('nim')->references('nim')->on('pengaju')->onDelete('cascade');
            $table->dateTime('tanggal_pengajuan');
            $table->string('nama_kegiatan');
            $table->string('nama_ketuplak');
            $table->string('notelp', length: 15);
            $table->integer('jumlah_peserta');
            $table->enum('jenis_kegiatan', ['proker', 'pergerakan', 'latihan_rutin']);
            $table->enum('status', ['diedit', 'direview', 'direvisi', 'ditolak', 'selesai', 'diajukan'])->default('diajukan');
            $table->string('link_drive');
            $table->boolean('edited')->default(false);
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->char('nim', 9)->nullable()->change();
        });
    }
};