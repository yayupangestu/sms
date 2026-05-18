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
        Schema::create('str2_out3s', function (Blueprint $table) {
            $table->id();
            $table->string('doc_no');
            $table->string('line_id');
            $table->integer('item_id');
            $table->integer('qty_return')->nullable();
            $table->integer('qty_standing')->nullable();
            $table->integer('qty_request');
            $table->integer('qty_out')->nullable();
            $table->integer('satuan')->nullable();
            $table->decimal('price_item', 10,3)->nullable();
            $table->string('keterangan2')->nullable();
            $table->string('keterangan')->nullable();
            $table->date('date_plan');
            $table->string('sts')->nullable();
            $table->integer('createdby')->nullable();
            $table->integer('updateby')->nullable();
            $table->timestamps();
            $table->string('status')->nullable();
            $table->string('update_checklist')->nullable();
            $table->string('status_checklist')->nullable();
            $table->string('total_outstanding')->nullable();
            $table->string('outstanding')->nullable();
            $table->timestamp('w_dibuat')->nullable();
            $table->timestamp('w_diberi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('str2_out3s');
    }
};
