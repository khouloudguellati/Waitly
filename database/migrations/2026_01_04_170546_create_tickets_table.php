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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()->cascadeOnDelete();
            $table->foreignId('institution_id')
                ->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')
                ->constrained()->cascadeOnDelete();
            $table->integer('ticket_number');
            $table->enum('status', ['waiting', 'called', 'completed', 'cancelled'])
                ->default('waiting');
            $table->timestamp('called_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['service_id', 'ticket_number', 'created_at']);
            $table->index(['service_id', 'status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
