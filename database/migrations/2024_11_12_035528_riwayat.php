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
        Schema::create('riwayat', function (Blueprint $table) {
            $table->id('id_riwayat')->primary();
            $table->string('id_pengajuan', length: 6);
            $table->foreign('id_pengajuan')->references('id_pengajuan')->on('pengajuan')->onDelete('cascade');
            $table->enum('perubahan_status', ['diterima', 'direvisi', 'ditolak', 'selesai', 'diajukan']);
            $table->dateTime('tanggal_perubahan');
            $table->id('id_reviewer'); // Foreign key ke tabel reviewer
            $table->foreign('id_reviewer')->references('id_reviewer')->on('reviewers')->onDelete('cascade');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat');
    }
};
