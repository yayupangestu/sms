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
        Schema::create('tabel_list_dies', function (Blueprint $table) {
             $table->id();
            $table->string('part_name')->nullable();
            $table->string('part_no')->nullable();
            $table->string('job_no')->nullable();
            $table->string('model_id')->nullable();
            $table->string('line_id')->nullable();
            $table->integer('std_stroke')->nullable();
            $table->integer('jml_stroke')->nullable();
            $table->integer('jml_prev')->nullable();
            $table->integer('proses')->nullable();
            $table->string('customer')->nullable();
            $table->string('createdby')->nullable();
            $table->string('updateby')->nullable();
            $table->datetime('date_prev')->nullable();
            $table->string('cycle_Prev')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_list_dies');
    }
};
