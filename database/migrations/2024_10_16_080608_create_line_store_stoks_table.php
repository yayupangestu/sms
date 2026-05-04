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
        Schema::create('line_store_stoks', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('part_name')->nullable();
            $table->string('job_no')->nullable();
            $table->string('part_no')->nullable();
            $table->string('model')->nullable();
            $table->string('customer')->nullable();
            $table->string('qty_min')->nullable();
            $table->string('qty_actual')->nullable();
            $table->string('qty_kanban')->nullable();
            $table->string('home_line')->nullable();
            $table->string('category')->nullable();
            $table->string('line_proses')->nullable();
            $table->string('updateby')->nullable(); 
            $table->string('createdby')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_store_stoks');
    }
};
