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
        Schema::create('rm_in_materials', function (Blueprint $table) {
            $table->id();
            $table->date('date_plan')->nullable();
            $table->string('line_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('part_no')->nullable();
            $table->string('model_id')->nullable();
            $table->string('spek')->nullable();
            $table->string('spek_t')->nullable();
            $table->string('spek_w')->nullable();
            $table->string('spek_l')->nullable();
            $table->integer('qty_act')->nullable();
            $table->integer('uniqNo')->nullable();
            $table->string('createdby')->nullable();
            $table->string('updateby')->nullable();
            // $table->integer('sts')->nullable();
            $table->integer('sts_scan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rm_in_materials');
    }
};
