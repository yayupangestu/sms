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
        Schema::create('rm_in_nuts', function (Blueprint $table) {
            $table->id('id')->nullable('');
            $table->string('suplai_id');
            $table->string('category_id');
            $table->string('material_id');
            $table->integer('qty_in');
            $table->string('keterangan')->nullable('');
            $table->date('date_plan');
            $table->integer('createdby')->nullable('');
            $table->integer('updateby')->nullable('');
            $table->timestamps();
        });
      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rm_in_nuts');
    }
};
