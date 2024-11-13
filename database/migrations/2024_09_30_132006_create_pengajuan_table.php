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
            $table->string('id_pengajuan', length: 6)->primary(); // id_pengajuan sebagai primary key
            $table->char('nim', 8); // nim sebagai foreign key dari tabel pengajus
            $table->foreign('nim')->references('nim')->on('pengaju')->onDelete('cascade');
            $table->dateTimeTz('tanggal_pengajuan', precision: 0); // otomatis mengisi tanggal saat pengajuan dibuat
            $table->id('id_tempat');
            $table->foreign('id_tempat')->references('id_tempat')->on('tempat')->onDelete('cascade');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_akhir');
            $table->time('waktu_pengajuan');
            $table->string('nama_kegiatan');
            $table->boolean('edited')->default(false);
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
