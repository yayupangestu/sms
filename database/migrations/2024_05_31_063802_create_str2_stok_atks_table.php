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
        Schema::create('str2_stok_atks', function (Blueprint $table) {
            $table->id();
            $table->string('item_id');
            $table->string('category');
            $table->integer('minimal');
            $table->integer('actual');
            $table->string('satuan');
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('str2_stok_atks');
    }
};
