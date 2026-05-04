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
        Schema::create('tag_label_blanks', function (Blueprint $table) {
            $table->id('id')->nullable('');
            $table->string('uniqNo')->nullable();
            $table->string('product_id')->nullable();
            $table->string('line_id')->nullable();
            $table->string('part_name')->nullable();
            $table->string('job_no')->nullable();
            $table->string('part_no')->nullable();
            $table->string('model')->nullable();
            $table->string('spec')->nullable();
            $table->integer('qty_act')->nullable();
            $table->integer('qty_ng')->nullable();
            $table->integer('kode_material')->nullable();
            $table->date('date_plan');
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('sts_scan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_label_blanks');
    }
};
