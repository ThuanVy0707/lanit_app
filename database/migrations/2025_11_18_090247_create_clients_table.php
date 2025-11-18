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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('owner_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('companyname')->nullable();
            $table->string('email')->unique();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();
            $table->string('countrycode', 2)->nullable();
            $table->string('phonenumber')->nullable();
            $table->string('tax_id')->nullable();
            $table->json('email_preferences')->nullable();
            $table->unsignedBigInteger('currency_id')->default(1);
            $table->string('defaultgateway')->nullable();
            $table->unsignedBigInteger('groupid')->default(0);
            $table->string('status')->default('Active');
            $table->decimal('credit', 10, 2)->default(0);
            $table->boolean('taxexempt')->default(false);
            $table->boolean('latefeeoveride')->default(false);
            $table->boolean('overideduenotices')->default(false);
            $table->boolean('separateinvoices')->default(false);
            $table->boolean('disableautocc')->default(false);
            $table->boolean('emailoptout')->default(false);
            $table->boolean('marketing_emails_opt_in')->default(true);
            $table->boolean('overrideautoclose')->default(false);
            $table->boolean('allowSingleSignOn')->default(true);
            $table->boolean('email_verified')->default(false);
            $table->string('language')->nullable();
            $table->text('lastlogin')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('email');
            $table->index('status');
            $table->index('owner_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
