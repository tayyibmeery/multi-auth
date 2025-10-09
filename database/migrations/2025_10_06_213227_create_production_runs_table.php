<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('production_runs', function (Blueprint $table) {
            $table->id();
            $table->string('batch_number')->unique();
            $table->foreignId('bom_id')->constrained('bill_of_materials')->onDelete('cascade');
            $table->integer('quantity_to_produce');
            $table->integer('actual_quantity')->nullable();
            $table->string('status')->default('pending'); // pending, in_progress, completed, cancelled
            $table->date('production_date');
            $table->date('completion_date')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('production_runs');
    }
};