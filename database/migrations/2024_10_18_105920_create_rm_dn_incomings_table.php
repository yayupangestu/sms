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
        Schema::create('rm_dn_incomings', function (Blueprint $table) {
            $table->id();
            $table->string('part_no');
            $table->string('spec_material');
            $table->string('model');
            $table->string('tinggi');
            $table->string('panjang');
            $table->string('lebar');
            $table->string('supplier');
            $table->integer('no_rak')->nullable();
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
        Schema::dropIfExists('rm_dn_incomings');
    }
};
