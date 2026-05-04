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
        Schema::create('tabel_transit_pc_stores', function (Blueprint $table) {
            $table->id();
            $table->string('uniqNo')->nullable();
            $table->string('part_no')->nullable();
            $table->string('part_no2')->nullable();
            $table->string('model')->nullable();
            $table->string('job_no')->nullable();
            $table->string('qty_act')->nullable();
            $table->string('qty_ng')->nullable();
            $table->string('count')->nullable();
            $table->string('id_data')->nullable();
            $table->string('date')->nullable();
            $table->string('kodeMaterial')->nullable();
            $table->string('createdby')->nullable();
            $table->string('sts')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_transit_pc_stores');
    }
};
