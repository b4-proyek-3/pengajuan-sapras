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
            $table->dateTime('tanggal_pengajuan', precision: 0); 
            $table->id('id_tempat');
            $table->foreign('id_tempat')->references('id_tempat')->on('tempat')->onDelete('cascade');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_akhir');
            $table->time('waktu_pinjam');
            $table->string('nama_kegiatan');
            $table->enum('jenis_kegiatan', ['proker', 'pergerakan']);
            $table->enum('status', ['diedit', 'direview', 'direvisi', 'ditolak', 'selesai', 'diajukan'])->default('diajukan');
            $table->string('link_drive');
            $table->boolean('edited')->default(false);
            $table->dateTime('updated_at', precision: 0);
            $table->foreign('foreign_key_column')->references('id')->on('related_table')->onDelete('cascade');
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