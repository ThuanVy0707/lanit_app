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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('domain_name');
            $table->string('status')->default('Active');
            $table->date('registration_date');
            $table->date('expiry_date');
            $table->decimal('registration_price', 10, 2)->default(0);
            $table->decimal('renewal_price', 10, 2)->default(0);
            $table->string('registrar')->nullable();
            $table->timestamps();

            $table->index('client_id');
            $table->index('status');
            $table->index('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
