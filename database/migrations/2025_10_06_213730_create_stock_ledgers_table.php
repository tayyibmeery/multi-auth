<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stock_ledgers', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('type'); // purchase, production_usage, production_output, adjustment, sale
            $table->morphs('reference'); // Polymorphic relation
            $table->foreignId('item_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('quantity_in')->default(0);
            $table->integer('quantity_out')->default(0);
            $table->decimal('unit_cost', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->integer('stock_after_transaction');
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_ledgers');
    }
};