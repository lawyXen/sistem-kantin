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
        Schema::create('detail_barangs', function (Blueprint $table) {
            $table->string('id', 16)->primary();
            $table->string('barang_id', 16);
            $table->string('user_id');
            $table->integer('stock');
            $table->integer('quantity'); 
            $table->string('satuan');
            $table->date('date');
            $table->enum('status', ['Masuk', 'Keluar']);
            $table->text('detail');
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade'); 
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_barangs');
    }
};
