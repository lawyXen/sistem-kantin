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
        Schema::create('detail_mejas', function (Blueprint $table) {
            $table->string('id', 16)->primary();
            $table->string('kantin_id', 16);
            $table->string('user_id');
            $table->string('meja_id', 16); 
            
            $table->foreign('meja_id')->references('id')->on('meja_makans')->onDelete('cascade'); 
            $table->foreign('kantin_id')->references('id')->on('kantins')->onDelete('cascade'); 
            $table->foreign('user_id')->references('id')->on('mahasiswas')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_mejas');
    }
};