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
        Schema::create('jadwal_ujian', function (Blueprint $table) {
            $table->id('id_ujian');
            $table->enum('tipe_ujian', ['ets', 'eas']);
            $table->date('mulai_ujian');
            $table->date('akhir_ujian');
            $table->timestamps();
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
