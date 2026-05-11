<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('str_ins', function (Blueprint $table) {
            $table->id();
            $table->string('category_id');
            $table->string('item_id');
            $table->string('suplai_id');
            $table->integer('qty_in');
            $table->string('satuan');
            $table->string('keterangan')->nullable('');
            $table->date('date_plan');
            $table->integer('createdby')->nullable('');
            $table->integer('updateby')->nullable('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('str_ins');
    }
};
