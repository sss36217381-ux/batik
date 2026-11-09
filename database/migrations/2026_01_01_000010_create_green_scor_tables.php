<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('green_scor_metrics', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g. PL-01, SO-01, MK-01, DL-01, RT-01
            $table->enum('dimension', ['PLAN', 'SOURCE', 'MAKE', 'DELIVER', 'RETURN']);
            $table->string('metric_name');
            $table->text('description')->nullable();
            $table->string('unit'); // %, Liter, Hari, Skor (1-100)
            $table->decimal('target_value', 8, 2);
            $table->decimal('actual_value', 8, 2)->default(0);
            $table->decimal('weight', 5, 4)->default(0.2000)->comment('Bobot ANP dinamis yang dapat disesuaikan UMKM');
            $table->decimal('normalized_score', 8, 2)->default(0); // Snorm De Boer (0 - 100)
            $table->decimal('final_score', 8, 2)->default(0); // weight * normalized_score
            $table->timestamps();
        });

        Schema::create('green_scor_results', function (Blueprint $table) {
            $table->id();
            $table->string('evaluation_period'); // e.g., '2026-Q1', 'Januari 2026'
            $table->date('evaluation_date');
            $table->decimal('plan_score', 8, 4)->default(0);
            $table->decimal('source_score', 8, 4)->default(0);
            $table->decimal('make_score', 8, 4)->default(0);
            $table->decimal('deliver_score', 8, 4)->default(0);
            $table->decimal('return_score', 8, 4)->default(0);
            $table->decimal('total_index', 8, 4)->default(0);
            $table->enum('category', [
                'Poor',        // < 40
                'Marginal',    // 40 - 50
                'Average',     // 50 - 70 (Ref artikel: 65.52)
                'Good',        // 70 - 90
                'Excellent'    // > 90
            ])->default('Average');
            $table->text('notes')->nullable();
            $table->string('evaluated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('green_scor_results');
        Schema::dropIfExists('green_scor_metrics');
    }
};

