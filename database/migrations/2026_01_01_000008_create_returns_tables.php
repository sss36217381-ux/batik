<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->string('return_number')->unique();
            $table->enum('return_type', ['purchase_return', 'sale_return']);
            $table->unsignedBigInteger('reference_id')->comment('ID dari purchase atau sale terkait');
            $table->string('party_name')->comment('Nama supplier atau customer');
            $table->date('return_date');
            $table->decimal('total_amount', 14, 2)->default(0);
            $table->text('reason'); // Cacat lilin, warna luntur, kain robek, dsb.
            $table->enum('handling_action', ['replace', 'repair', 'refund', 'dispose'])->default('replace');
            $table->enum('status', ['requested', 'approved', 'processed', 'rejected'])->default('requested');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('return_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('return_id')->constrained('returns')->cascadeOnDelete();
            $table->enum('item_type', ['product', 'raw_material']);
            $table->unsignedBigInteger('item_id');
            $table->decimal('quantity', 12, 2);
            $table->enum('condition', ['damaged', 'defect', 'wrong_item', 'other'])->default('defect');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('return_details');
        Schema::dropIfExists('returns');
    }
};

