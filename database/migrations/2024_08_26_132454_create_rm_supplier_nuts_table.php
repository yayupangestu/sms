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
        Schema::create('rm_supplier_nuts', function (Blueprint $table) {
            $table->id();
            $table->string('name_suplai');
            $table->string('pt');
            $table->string('alamat');
            $table->string('hp')->nullable();
            $table->string('pic')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('rm_supplier_nuts');
    }
};
