<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dies_transactions', function (Blueprint $table) {
            $table->id();

            // Data Dies
            $table->string('dies_qr')->unique(); // hasil scan QR
            $table->string('dies_code')->nullable(); // optional jika ada kode dies manual
            $table->string('dies_name')->nullable();

            // Jenis transaksi
            $table->enum('transaction_type', ['SCAN_OUT', 'SCAN_ACC', 'SCAN_HISTORY'])->default('SCAN_OUT');

            // Lokasi tujuan (dipilih dari map)
            $table->text('destination_address')->nullable();
            $table->decimal('destination_lat', 10, 7)->nullable();
            $table->decimal('destination_lng', 10, 7)->nullable();

            // Lokasi scan (GPS realtime saat scan dilakukan)
            $table->text('scan_address')->nullable();
            $table->decimal('scan_lat', 10, 7)->nullable();
            $table->decimal('scan_lng', 10, 7)->nullable();

            // Informasi tambahan
            $table->string('pic')->nullable(); // siapa yang membawa / PIC
            $table->string('line')->nullable(); // line tujuan / departemen
            $table->text('note')->nullable();

            // Status dies sekarang
            $table->enum('status', ['IN', 'OUT', 'ACC'])->default('IN');

            // user yang scan (jika pakai login laravel)
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dies_transactions');
    }
};