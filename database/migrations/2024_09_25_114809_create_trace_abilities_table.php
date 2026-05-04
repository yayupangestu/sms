<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trace_abilities', function (Blueprint $table) {
            $table->id();
            $table->string('name_material'); // Kolom 1
            $table->string('spek'); // Kolom 2
            $table->string('suplier'); // Kolom 3
            $table->string('qty_out'); // Kolom 4
            $table->string('name_material_in_stmp')->nullable(''); // Kolom 1
            $table->string('spek_in_stmp')->nullable(''); // Kolom 2
            $table->string('suplier_in_stmp')->nullable(''); // Kolom 3
            $table->string('qty_out_in_stmp')->nullable(''); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trace_abilities');
    }
};
