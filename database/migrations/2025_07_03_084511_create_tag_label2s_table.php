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
        Schema::create('tag_label2s', function (Blueprint $table) {
            $table->id();
        
            $table->string('part_name')->nullable();
            $table->string('part_no')->nullable();
            $table->string('job_no')->nullable();
            $table->string('model_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('qty_act')->nullable();
            $table->string('spek')->nullable();
            $table->string('spek_t')->nullable();
            $table->string('spek_w')->nullable();
            $table->string('spek_l')->nullable();
            $table->string('spek_bq')->nullable();
            $table->string('spek_kg')->nullable();
            $table->string('packing')->nullable();
            $table->string('supplier')->nullable();
            $table->string('minimal')->nullable();
            $table->string('minimal_kg')->nullable();
            $table->string('actual_sheet')->nullable();
            $table->string('actual_kg')->nullable();
            $table->string('no_rak')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('createdby')->nullable();
            $table->string('uniqNo')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('sts')->nullable();
            $table->string('category')->nullable();
            $table->integer('count')->nullable();
            $table->string('doc_po')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_label2s');
    }
};
