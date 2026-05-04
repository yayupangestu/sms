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
        Schema::create('scan_part_bps', function (Blueprint $table) {
            $table->id();
            $table->string('uniqNo')->nullable();
            $table->string('job_no')->nullable();
            $table->string('part_no2')->nullable();
            $table->string('model')->nullable();
            $table->string('qty')->nullable();
            $table->date('date_plan')->nullable();
            $table->datetimes('date_scan')->nullable();
            $table->integer('additional_qty')->nullable();
            $table->string('kode_material')->nullable();
            $table->string('createdby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_part_weldings');
    }
};
