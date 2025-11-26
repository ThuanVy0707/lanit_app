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
        Schema::create('order_line_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('type'); // product, domain, addon, etc.
            $table->unsignedBigInteger('relid')->nullable(); // Related product/domain/addon ID
            $table->string('product_type')->nullable();
            $table->string('product')->nullable();
            $table->string('domain')->nullable();
            $table->string('billing_cycle')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('status')->default('Pending');
            $table->timestamps();

            $table->index('order_id');
            $table->index('type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_line_items');
    }
};
