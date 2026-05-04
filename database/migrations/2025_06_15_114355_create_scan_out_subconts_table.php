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
        Schema::create('scan_out_subconts', function (Blueprint $table) {
            $table->id();
            $table->string('uniqNo');
            $table->string('spec');
            $table->string('part_no');
            $table->string('qty_out_sheet');
            $table->string('qty_out_kg');
            $table->string('supplier');
            $table->integer('id_data');
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
        Schema::dropIfExists('scan_out_subconts');
    }
};
