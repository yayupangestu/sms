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
        Schema::create('line_store_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('part_name')->nullable();
            $table->string('job_no')->nullable();
            $table->string('part_no')->nullable();
            $table->string('model')->nullable();
            $table->integer('order_part')->nullable();
            $table->integer('balance_order')->nullable();
            $table->string('no_dn')->nullable();
            $table->string('no_po')->nullable();
            $table->date('tgl_delivery')->nullable();
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
        Schema::dropIfExists('line_store_uploads');
    }
};
