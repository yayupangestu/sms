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
        Schema::create('scan_in_line_stores', function (Blueprint $table) {
            $table->id();
            $table->string('uniqNo')->nullable();
            $table->string('job_no')->nullable();
            $table->string('part_no')->nullable();
            $table->string('part_no2')->nullable();
            $table->string('model')->nullable();
            $table->string('qty_act')->nullable();
            $table->string('qty_ng')->nullable();
            $table->date('date')->nullable();
            $table->time('date_scan')->nullable();
            $table->integer('id_data')->nullable();
            $table->string('kode_material')->nullable();
            $table->string('status')->nullable();
            $table->string('status_2')->nullable();
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
        Schema::dropIfExists('scan_in_line_stores');
    }
};
