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
        Schema::create('line_store_incoming_parts', function (Blueprint $table) {
            $table->id();
            $table->string('no_po')->nullable();
            $table->string('no_dn')->nullable();
            $table->integer('part_no')->nullable();
            $table->integer('supplier')->nullable();
            $table->integer('actual_order')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_store_incoming_parts');
    }
};
