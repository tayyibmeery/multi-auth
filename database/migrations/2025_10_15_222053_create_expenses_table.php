<?php
// database/migrations/2024_01_07_create_expenses_table.php
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
            $table->dateTime('expense_date');
            $table->foreignId('account_id')->constrained();
            $table->decimal('amount', 10, 2);
            $table->text('description');
            $table->string('category');
            $table->enum('payment_method', ['cash', 'bank_transfer', 'card', 'cheque']);
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};