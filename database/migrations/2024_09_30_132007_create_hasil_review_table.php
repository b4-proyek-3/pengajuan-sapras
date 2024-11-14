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
        Schema::create('reviews', function (Blueprint $table) {
            $table->string('id_pengajuan', 6); // Foreign key ke tabel pengajuan
            $table->foreign('id_pengajuan')->references('id_pengajuan')->on('pengajuan')->onDelete('cascade');
            $table->char('id_reviewer', 18); // Foreign key ke tabel reviewer
            $table->foreign('id_reviewer')->references('id_reviewer')->on('reviewers')->onDelete('cascade');
            $table->text('review');
            $table->string('status', 255);
            $table->timestamp('tanggal_review');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_review');
    }
};
