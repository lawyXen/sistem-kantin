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
        Schema::create('points', function (Blueprint $table) {
            $table->string('id', 16)->primary();
            $table->string('user_id');
            $table->date('tanggal');
            $table->string('waktu_makan');
            $table->string('dibuat');
            $table->string('points');
            $table->string('point_pelanggaran');
            $table->text('keterangan'); 
            $table->foreign('user_id')->references('id')->on('mahasiswas')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points');
    }
};
