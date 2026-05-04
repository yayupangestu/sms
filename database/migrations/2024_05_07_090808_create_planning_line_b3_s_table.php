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
        Schema::create('planning_line_b3_s', function (Blueprint $table) {
            $table->id();
            $table->integer('line_id');
            $table->integer('product_id');
            $table->integer('qty_plan');
            $table->integer('qty_act')->nullable();
            $table->integer('qty_ng')->nullable();
            $table->integer('qty_gsph')->nullable();
            $table->string('qty_mesin')->nullable();
            $table->string('qty_dies')->nullable();
            $table->string('qty_dandori')->nullable();
            $table->string('ket_remark')->nullable();
            $table->string('ket_remark2')->nullable();
            $table->string('ket_pengambil')->nullable();
            $table->string('material_id')->nullable();
            $table->integer('start')->nullable();
            $table->date('date_plan');
            $table->string('createdby')->nullable();
            $table->string('updateby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planning_line_b3_s');
    }
};
