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
        Schema::create('line_store_scan_ins', function (Blueprint $table) {
            $table->id();
            $table->string('uniqNo')->nullable();
            $table->string('job_no')->nullable();
            $table->string('part_no')->nullable();
            $table->string('model')->nullable();
            $table->string('qty')->nullable();
            $table->date('date')->nullable();
            $table->string('kodeMaterial')->nullable();
            $table->string('part_no_rm')->nullable();
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
        Schema::dropIfExists('line_store_scan_ins');
    }
};
