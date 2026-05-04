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
        Schema::create('dn_inputs', function (Blueprint $table) {
            $table->id();
            $table->string('part_no')->nullable();
            $table->string('doc_po')->nullable();
            $table->string('doc_dn')->nullable();
            $table->string('spec')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dn_inputs');
    }
};
