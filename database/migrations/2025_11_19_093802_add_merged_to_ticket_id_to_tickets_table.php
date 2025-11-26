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
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('merged_to_ticket_id')->nullable()->after('message')->constrained('tickets')->onDelete('set null');
            $table->index('merged_to_ticket_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['merged_to_ticket_id']);
            $table->dropIndex(['merged_to_ticket_id']);
            $table->dropColumn('merged_to_ticket_id');
        });
    }
};
