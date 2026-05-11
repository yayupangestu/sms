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
        Schema::create('str_out3s', function (Blueprint $table) {
            $table->id();
            $table->integer('doc_no');
            $table->integer('line_id');
            $table->integer('item_id');
            $table->integer('qty_request');
            $table->integer('qty_out');
            $table->integer('satuan');
            $table->string('keterangan')->nullable();
            $table->date('date_plan');
            $table->integer('createdby')->nullable();
            $table->integer('updateby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('str_out3s');
    }
};
