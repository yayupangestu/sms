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
        Schema::create('data_part_names', function (Blueprint $table) {
            $table->id();
            $table->string('job_no');
            $table->string('part_name');
            $table->string('model');
            $table->string('customer');
            $table->integer('createdby')->nullable();
            $table->integer('updatedby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_part_names');
    }
};
