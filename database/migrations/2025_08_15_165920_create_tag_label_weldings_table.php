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
        Schema::create('tag_label_weldings', function (Blueprint $table) {
            $table->id();
            $table->string('part_name')->nullable();
            $table->string('part_no')->nullable();
            $table->string('part_no2')->nullable();
            $table->string('job_no')->nullable();
            $table->string('model')->nullable();
            $table->string('category_id')->nullable();
            $table->string('qty_act')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('createdby')->nullable();
            $table->string('uniqNo')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('sts')->nullable();
            $table->string('line')->nullable();
            $table->integer('count')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_label_weldings');
    }
};
