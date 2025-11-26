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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('type')->default('other');
            $table->string('status')->default('Active');
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('billing_cycle')->nullable();
            $table->date('next_due_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('client_id');
            $table->index('status');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
