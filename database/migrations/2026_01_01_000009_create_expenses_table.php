<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expense_number')->unique();
            $table->enum('category', [
                'operasional',
                'utilitas_listrik_air',
                'gaji_pengrajin',
                'pengolahan_limbah_ipal',
                'pemeliharaan_alat',
                'lain_lain'
            ]);
            $table->decimal('amount', 14, 2);
            $table->date('expense_date');
            $table->text('description');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};

