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
        Schema::create('upload_forcasts', function (Blueprint $table) {
           $table->id();
            $table->string('job_no')->nullable();
            $table->string('uniqNo')->nullable();
            $table->string('part_name')->nullable();
            $table->string('part_no')->nullable();
            $table->string('part_no2')->nullable();
            $table->string('model')->nullable();
            $table->string('qty_kanban')->nullable();
            $table->string('customer')->nullable();
            $table->year('tahun')->nullable();
            $table->string('jan')->nullable();
            $table->string('jan_month')->nullable();
            $table->string('feb')->nullable();
            $table->string('feb_month')->nullable();
            $table->string('mar')->nullable();
            $table->string('mar_month')->nullable();
            $table->string('apr')->nullable();
            $table->string('apr_month')->nullable();
            $table->string('may')->nullable();
            $table->string('may_month')->nullable();
            $table->string('jun')->nullable();
            $table->string('jun_month')->nullable();
            $table->string('jul')->nullable();
            $table->string('jul_month')->nullable();
            $table->string('aug')->nullable();
            $table->string('aug_month')->nullable();
            $table->string('sep')->nullable();
            $table->string('sep_month')->nullable();
            $table->string('oct')->nullable();
            $table->string('oct_month')->nullable();
            $table->string('nov')->nullable();
            $table->string('nov_month')->nullable();
            $table->string('dec')->nullable();
            $table->string('dec_month')->nullable();
            $table->string('createdby')->nullable();
            $table->string('sts')->nullable();
            $table->datetime('sts_close')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upload_forcasts');
    }
};
