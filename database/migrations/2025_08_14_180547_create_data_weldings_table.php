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
        Schema::create('data_weldings', function (Blueprint $table) {
            $table->id();
            $table->string('part_name')->nullable();
            $table->string('part_no')->nullable();
            $table->string('part_no2')->nullable();
            $table->string('job_no')->nullable();
            $table->string('model')->nullable();
            $table->string('qty_kanban')->nullable();
            $table->string('customer')->nullable();
            $table->string('description')->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('updateby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_weldings');
    }
};
