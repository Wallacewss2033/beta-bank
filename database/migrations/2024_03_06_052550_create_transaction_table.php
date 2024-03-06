<?php

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
            $table->tinyInteger('isScheduled')->default(0);
            $table->date('date')->nullable();
            $table->enum('status', [1, 2]);
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
