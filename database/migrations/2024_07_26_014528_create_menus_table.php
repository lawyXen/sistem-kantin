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
        Schema::create('menus', function (Blueprint $table) {
            $table->string('id', 16)->primary();
            $table->date('tanggal');
            $table->text('menu_sarapan')->nullable();
            $table->text('menu_siang')->nullable();
            $table->text('menu_malam')->nullable();
            $table->text('status_sarapan')->nullable();
            $table->text('status_siang')->nullable();
            $table->text('status_malam')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
