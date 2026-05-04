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
        Schema::create('rm_materials', function (Blueprint $table) {
            $table->id();
            $table->string('name_material');
            $table->string('spek');
            $table->string('model');
            $table->string('spek_t');
            $table->string('spek_p');
            $table->string('spek_l');
            $table->string('category');
            $table->string('supplier');
            $table->integer('sts')->nullable();
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
        Schema::dropIfExists('rm_materials');
    }
};
