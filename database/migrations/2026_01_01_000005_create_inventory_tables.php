<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->enum('item_type', ['product', 'raw_material']);
            $table->unsignedBigInteger('item_id');
            $table->decimal('current_stock', 12, 2)->default(0);
            $table->decimal('safety_stock', 12, 2)->default(0);
            $table->string('warehouse_location')->default('Gudang Utama Bangkalan');
            $table->timestamp('last_counted_at')->nullable();
            $table->timestamps();

            $table->index(['item_type', 'item_id']);
        });

        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->enum('item_type', ['product', 'raw_material']);
            $table->unsignedBigInteger('item_id');
            $table->enum('movement_type', ['in', 'out', 'adjustment', 'waste']);
            $table->decimal('quantity', 12, 2);
            $table->string('reference_type')->nullable(); // Purchase, Production, Sale, Return
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['item_type', 'item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
        Schema::dropIfExists('inventories');
    }
};
