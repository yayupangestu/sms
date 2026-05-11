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
        Schema::create('str_out2s', function (Blueprint $table) {
            $table->id();
            $table->integer('doc_no');
            $table->integer('line_id');
            $table->integer('item_id');
            $table->integer('qty_request');
            $table->integer('qty_standing');
            $table->integer('qty_out');
            $table->integer('satuan');
            $table->string('keterangan2')->nullable();
            $table->string('keterangan')->nullable();
            $table->date('date_plan');
            $table->date('sts');
            $table->integer('createdby')->nullable();
            $table->integer('updateby')->nullable();
            $table->timestamps();
            $table->timestamps('w_dibuat')->nullable();
            $table->timestamps('w_diberi')->nullable();
            $table->integer('status')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('str_out2s');
    }
};
