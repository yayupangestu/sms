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
        Schema::create('trace_proses2s', function (Blueprint $table) {
            $table->id();
            $table->date('date_plan')->nullable();
            $table->string('uniqNo')->nullable();
            $table->string('plan_mesin')->nullable();
            $table->string('plan_jobNo')->nullable();
            $table->string('plan_partNo')->nullable();
            $table->string('plan_model')->nullable();
            $table->string('plan_qty')->nullable();
            $table->string('plan_user')->nullable();


            $table->string('rm_uniqNo')->nullable();
            $table->string('rm_partNo')->nullable();
            $table->string('rm_spek')->nullable();
            $table->string('rm_supplier')->nullable();
            $table->string('rm_qty')->nullable();
            $table->timestamp('rm_time')->nullable();
            $table->string('rm_user')->nullable();

            $table->string('rm_uniqNo2')->nullable();
            $table->string('rm_partNo2')->nullable();
            $table->string('rm_spek2')->nullable();
            $table->string('rm_supplier2')->nullable();
            $table->string('rm_qty2')->nullable();
            $table->timestamp('rm_time2')->nullable();
            $table->string('rm_user2')->nullable();
            
            $table->string('rm_uniqNo3')->nullable();
            $table->string('rm_partNo3')->nullable();
            $table->string('rm_spek3')->nullable();
            $table->string('rm_supplier3')->nullable();
            $table->string('rm_qty3')->nullable();
            $table->timestamp('rm_time3')->nullable();
            $table->string('rm_user3')->nullable();

            $table->string('stmp_in_uniqNo')->nullable();
            $table->string('stmp_in_user')->nullable();
            $table->timestamp('stmp_in_time')->nullable();
            $table->string('stmp_in_partNo')->nullable();
            $table->string('stmp_in_spek')->nullable();
            $table->string('stmp_in_qty')->nullable();
            $table->string('stmp_in_supplier')->nullable();

            $table->string('stmp_in_uniqNo2')->nullable();
            $table->string('stmp_in_user2')->nullable();
            $table->timestamp('stmp_in_time2')->nullable();
            $table->string('stmp_in_partNo2')->nullable();
            $table->string('stmp_in_spek2')->nullable();
            $table->string('stmp_in_qty2')->nullable();
            $table->string('stmp_in_supplier2')->nullable();

            $table->string('stmp_in_uniqNo3')->nullable();
            $table->string('stmp_in_user3')->nullable();
            $table->timestamp('stmp_in_time3')->nullable();
            $table->string('stmp_in_partNo3')->nullable();
            $table->string('stmp_in_spek3')->nullable();
            $table->string('stmp_in_qty3')->nullable();
            $table->string('stmp_in_supplier3')->nullable();

            $table->string('stmp_out_uniqNo')->nullable();
            $table->string('stmp_out_user')->nullable();
            $table->string('stmp_out_name')->nullable();
            $table->string('stmp_out_jobNo')->nullable();
            $table->string('stmp_out_partNo')->nullable();
            $table->string('stmp_out_model')->nullable();
            $table->string('stmp_out_qty')->nullable();
            $table->string('stmp_out_start')->nullable();
            $table->timestamp('stmp_out_time')->nullable();

            $table->string('stmp_out_uniqNo2')->nullable();
            $table->string('stmp_out_user2')->nullable();
            $table->string('stmp_out_name2')->nullable();
            $table->string('stmp_out_jobNo2')->nullable();
            $table->string('stmp_out_partNo2')->nullable();
            $table->string('stmp_out_model2')->nullable();
            $table->string('stmp_out_qty2')->nullable();
            $table->string('stmp_out_start2')->nullable();
            $table->timestamp('stmp_out_time2')->nullable();

            $table->string('stmp_out_uniqNo3')->nullable();
            $table->string('stmp_out_user3')->nullable();
            $table->string('stmp_out_name3')->nullable();
            $table->string('stmp_out_jobNo3')->nullable();
            $table->string('stmp_out_partNo3')->nullable();
        










            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trace_proses2s');
    }
};
