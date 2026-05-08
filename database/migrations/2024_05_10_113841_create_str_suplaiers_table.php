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
        Schema::create('str_suplaiers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('alamat')->nullable();
            $table->string('pt')->nullable();
            $table->string('hp')->nullable();
            $table->string('pic')->nullable();
            $table->text('description')->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('updatedby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('str_suplaiers');
    }
};
