<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('ticket_notes', function (Blueprint $table) {
            $table->boolean('view_notification')->default(false)->after('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('ticket_notes', function (Blueprint $table) {
            $table->dropColumn('view_notification');
        });
    }
};
