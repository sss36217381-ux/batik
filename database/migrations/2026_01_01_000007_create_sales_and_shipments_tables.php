<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('sale_date');
            $table->decimal('total_amount', 14, 2)->default(0);
            $table->decimal('discount_amount', 14, 2)->default(0);
            $table->decimal('grand_total', 14, 2)->default(0);
            $table->enum('payment_method', ['cash', 'transfer_bank', 'qris'])->default('cash');
            $table->enum('payment_status', ['unpaid', 'paid'])->default('paid');
            $table->enum('status', ['draft', 'confirmed', 'shipped', 'completed', 'cancelled'])->default('completed');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('unit_price', 14, 2);
            $table->decimal('subtotal', 14, 2);
            $table->timestamps();
        });

        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->cascadeOnDelete();
            $table->string('tracking_number')->nullable();
            $table->string('courier_name')->default('Kurir Internal / J&T');
            $table->text('shipping_address');
            $table->date('shipping_date');
            $table->date('estimated_arrival')->nullable();
            $table->date('actual_arrival')->nullable();
            $table->enum('status', ['pending', 'shipped', 'in_transit', 'delivered', 'failed'])->default('pending');
            $table->boolean('is_on_time')->default(true)->comment('Indikator Green SCOR Deliver (Ketepatan waktu pengiriman)');
            $table->text('delivery_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
        Schema::dropIfExists('sale_details');
        Schema::dropIfExists('sales');
    }
};
