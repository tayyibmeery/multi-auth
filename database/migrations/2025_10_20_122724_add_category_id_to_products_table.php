<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add category_id if it doesn't exist
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            }

            // Add min_stock if it doesn't exist
            if (!Schema::hasColumn('products', 'min_stock')) {
                $table->decimal('min_stock', 10, 2)->default(0);
            }

            // Add unit if it doesn't exist
            if (!Schema::hasColumn('products', 'unit')) {
                $table->string('unit')->default('pcs');
            }

            // Add image if it doesn't exist
            if (!Schema::hasColumn('products', 'image')) {
                $table->string('image')->nullable();
            }

            // Add is_active if it doesn't exist
            if (!Schema::hasColumn('products', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'min_stock', 'unit', 'image', 'is_active']);
        });
    }
};