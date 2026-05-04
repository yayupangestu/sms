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
        Schema::create('scan_out_blanks', function (Blueprint $table) {
            $table->id();
            $table->string('part_no')->nullable();
            $table->string('part_no2')->nullable();
            $table->string('uniqNo')->nullable();
            $table->string('spec')->nullable();
            $table->string('kode_material')->nullable();
            $table->string('line_id')->nullable();
            $table->string('qty_act')->nullable();
            $table->string('qty_stamping')->nullable();
            $table->integer('id_data')->nullable();
            $table->string('createdby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_out_blanks');
    }
};
