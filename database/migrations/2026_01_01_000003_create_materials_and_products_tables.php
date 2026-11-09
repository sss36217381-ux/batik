<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raw_materials', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->enum('category', [
                'kain',                  // Kain Mori Prima, Primissima, Sutra, dll
                'malam',                 // Malam tawon, malam klowong, lilin batik
                'pewarna_alami',         // Kulit tingi, jolawe, tegeran, indigofera
                'pewarna_sintetis',      // Remazol, Naptol, Indigosol
                'bahan_pendukung'        // Soda abu, waterglass, tawas, kapur
            ]);
            $table->string('unit');       // meter, kg, gram, liter, bks
            $table->decimal('stock', 12, 2)->default(0);
            $table->decimal('min_stock', 12, 2)->default(5);
            $table->decimal('unit_price', 14, 2)->default(0);
            $table->boolean('is_eco_friendly')->default(false)->comment('Apakah tergolong bahan ramah lingkungan');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('motif_type'); // Gentongan, Aromanis, Sekar Jagat, Labasto, Lancor, Tarik Sis, dll
            $table->string('size')->default('200 x 115 cm');
            $table->decimal('cost_price', 14, 2)->default(0)->comment('Harga Pokok Produksi (HPP)');
            $table->decimal('selling_price', 14, 2)->default(0)->comment('Harga Jual');
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(2);
            $table->string('image_path')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('raw_materials');
    }
};

