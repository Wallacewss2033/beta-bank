<?php

use App\Enums\TransactionStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('sender');
            $table->foreignUuid('receiver');
            $table->decimal('value')->nullable(false);
            $table->date('date')->nullable();
            $table->enum('status', array_column(TransactionStatusEnum::cases(), 'value'));
            $table->timestamps();

            $table->foreign('sender')
                ->references('id')
                ->on('accounts');

            $table->foreign('receiver')
                ->references('id')
                ->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
