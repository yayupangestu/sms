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
        Schema::create('scan_in_labels', function (Blueprint $table) {
            $table->id();
            $table->string('uniqNo');
            $table->string('spec');
            $table->string('part_no');
            $table->string('qty_in');
            $table->string('supplier');
            $table->string('createdby')->nullable();
            $table->string('updateby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_in_labels');
    }
};
