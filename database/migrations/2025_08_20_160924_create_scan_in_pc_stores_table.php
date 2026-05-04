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
        Schema::create('scan_in_pc_stores', function (Blueprint $table) {
            $table->id();
            $table->string('part_no2')->nullable();
            $table->string('part_no')->nullable();
            $table->string('job_no')->nullable();
            $table->string('model')->nullable();
            $table->string('qty_act')->nullable();
            $table->string('date')->nullable();
            $table->string('kodeMaterial')->nullable();
            $table->string('uniqNo')->nullable();
            $table->string('sts')->nullable();
            $table->string('id_data')->nullable();
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->integer('count')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_in_pc_stores');
    }
};
