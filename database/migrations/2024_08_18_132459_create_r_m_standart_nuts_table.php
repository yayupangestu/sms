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
        Schema::create('rm_standart_nuts', function (Blueprint $table) {
            $table->id();
            $table->string('part_nut');
            $table->string('name_nut');
            $table->string('supplier_id');
            $table->string('packing_box');
            $table->string('packing_kantong');
            $table->string('line');
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
        Schema::dropIfExists('rm_standart_nuts');
    }
};
