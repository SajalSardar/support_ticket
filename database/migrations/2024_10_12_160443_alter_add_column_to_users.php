<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('requester_type_id')->nullable()->after('password');
            $table->string('requester_id', 50)->nullable()->index()->after('requester_type_id')->comment('student id, employee id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('requester_type_id');
            $table->dropColumn('requester_id');
        });
    }
};
