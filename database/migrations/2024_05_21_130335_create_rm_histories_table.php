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
        Schema::create('rm_histories', function (Blueprint $table) {
            $table->id();
            $table->string('material_id');
            $table->string('category_id');
            $table->string('qty_in');
            $table->string('suplai_id');
            $table->string('line_id');
            $table->string('description');
            $table->integer('sts');
            $table->integer('updatedby')->nullable();
            $table->integer('createdby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rm_histories');
    }
};
