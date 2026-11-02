<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('target_product_id')->constrained('products')->cascadeOnDelete();
            $table->integer('planned_quantity');
            $table->integer('actual_quantity')->default(0);
            $table->date('start_date');
            $table->date('estimated_completion_date')->nullable();
            $table->date('actual_completion_date')->nullable();
            $table->enum('stage', [
                'pola_desain',       // Menggambar pola pada kain
                'canting_malam',     // Mencanting dengan malam/lilin
                'pewarnaan',         // Pewarnaan (alami/sintetis)
                'pelorotan',         // Merebus untuk meluruhkan malam (water intensive)
                'penjemuran',        // Pengeringan alami
                'finishing'          // Quality check & packing
            ])->default('pola_desain');
            $table->enum('status', ['draft', 'in_progress', 'completed', 'cancelled'])->default('draft');
            // Green SCOR Make Indicators:
            $table->decimal('water_usage_liters', 12, 2)->default(0)->comment('Volume air yang digunakan selama proses produksi (L)');
            $table->decimal('waste_generated_kg', 12, 2)->default(0)->comment('Estimasi limbah padat/malam yang dihasilkan (kg)');
            $table->decimal('recycled_wax_kg', 12, 2)->default(0)->comment('Malam yang berhasil didaur ulang kembali (kg)');
            $table->decimal('total_production_cost', 14, 2)->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('production_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_order_id')->constrained('production_orders')->cascadeOnDelete();
            $table->foreignId('raw_material_id')->constrained('raw_materials')->cascadeOnDelete();
            $table->decimal('planned_qty', 12, 2);
            $table->decimal('actual_qty', 12, 2)->default(0);
            $table->decimal('unit_cost', 14, 2)->default(0);
            $table->decimal('subtotal_cost', 14, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_details');
        Schema::dropIfExists('production_orders');
    }
};
