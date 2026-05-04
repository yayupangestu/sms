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
        Schema::create('rm_material_nuts', function (Blueprint $table) {
            $table->id();
            $table->string('part_no');
            $table->string('job_no');
            $table->string('model_id');
            $table->string('type_id');
            $table->string('spec_nut');
            $table->string('warna_nut');
            $table->string('supplier');
            $table->integer('sts')->nullable();
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rm_material_nuts');
    }
};
