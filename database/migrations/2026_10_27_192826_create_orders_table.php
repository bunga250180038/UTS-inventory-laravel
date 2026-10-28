<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Akun pembeli yang membuat pesanan.
            $table->foreignId('buyer_id')
                ->constrained('users')
                ->restrictOnDelete();

            // Nomor pesanan unik.
            $table->string('order_number', 100)->unique();

            // Informasi kontak dan pengiriman pembeli.
            $table->string('customer_phone', 30)->nullable();
            $table->text('shipping_address')->nullable();
            $table->text('notes')->nullable();

            // Total pesanan berdasarkan harga saat dipesan.
            $table->decimal('total', 12, 2)->default(0);

            // pending, confirmed, rejected, atau cancelled.
            $table->string('status', 30)->default('pending');

            // Terhubung ke transaksi penjualan setelah disetujui.
            $table->foreignId('sale_id')
                ->nullable()
                ->unique()
                ->constrained('sales')
                ->nullOnDelete();

            $table->timestamp('confirmed_at')->nullable();

            $table->timestamps();

            $table->index(['buyer_id', 'status']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
