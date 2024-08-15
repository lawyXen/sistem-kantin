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
        Schema::create('detail_pikets', function (Blueprint $table) {
            $table->string('id', 16)->primary();
            $table->string('piket_id', 16);
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('mahasiswas')->onDelete('cascade');
            $table->foreign('piket_id')->references('id')->on('pikets')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pikets');
    }
};
