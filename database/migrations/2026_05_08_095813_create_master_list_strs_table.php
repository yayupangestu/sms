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
        Schema::create('master_list_strs', function (Blueprint $table) {
            $table->id();
            $table->string('item_code');
            $table->string('name');
            $table->string('category');
            $table->string('description');
            $table->string('price');
            $table->integer('createdby');
            $table->integer('updatedby');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_list_strs');
    }
};
