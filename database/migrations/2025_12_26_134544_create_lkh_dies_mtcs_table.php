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
        Schema::create('lkh_dies_mtcs', function (Blueprint $table) {
           $table->id();
            $table->string('doc_job')->nullable();
            $table->date('date_plan')->nullable();
            $table->string('part_name')->nullable();
            $table->string('part_no')->nullable();
            $table->string('job_no')->nullable();
            $table->string('model_id')->nullable();
            $table->string('line_id')->nullable();
            $table->string('problem')->nullable();
            $table->string('category')->nullable();
            $table->string('proses')->nullable();
            $table->string('tindakan')->nullable();
            $table->string('dt_start')->nullable();
            $table->string('dt_finish')->nullable();
            $table->string('pic')->nullable();
            $table->string('remarks')->nullable();
            $table->datetime('date_prev')->nullable();
            $table->integer('cycle_prev')->nullable();
            $table->string('updateby')->nullable();
            $table->string('createdby')->nullable();
            $table->string('foto_awal')->nullable();
            $table->string('foto_akhir')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lkh_dies_mtcs');
    }
};
