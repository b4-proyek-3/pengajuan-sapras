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
            $table->string('id_pengajuan')->primary(); // id_pengajuan sebagai primary key
            $table->string('nim'); // nim sebagai foreign key dari tabel pengajus
            $table->foreign('nim')->references('nim')->on('pengaju')->onDelete('cascade');
            $table->timestamp('tanggal_pengajuan'); // otomatis mengisi tanggal saat pengajuan dibuat
            $table->date('tanggal_pinjam');
            $table->date('tanggal_akhir');
            $table->time('waktu_pengajuan');
            $table->string('nama_kegiatan');
            $table->string('dokumen')->nullable(); // Menyimpan path dokumen (nullable)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
