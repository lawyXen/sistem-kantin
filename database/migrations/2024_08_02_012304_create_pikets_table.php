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
        Schema::create('pikets', function (Blueprint $table) {
            $table->string('id', 16)->primary();
            $table->string('kantin_id', 16);
            $table->string('nama_piket');
            $table->boolean('active')->default(0);
            $table->foreign('kantin_id')->references('id')->on('kantins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pikets');
    }
};
