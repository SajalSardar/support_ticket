<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('team_id')->nullable()->index();
            $table->integer('category_id')->nullable()->index();
            $table->integer('ticket_status_id')->nullable()->index();
            $table->integer('source_id')->nullable()->index();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('attachment')->nullable();
            $table->string('priority')->nullable()->comment('low,medium,high');
            $table->string('ticket_type')->default('customer')->comment('internal,customer');
            $table->date('due_date')->nullable();
            $table->date('resolved_at')->nullable();
            $table->integer('resolved_by')->nullable();
            $table->string('resolution_time')->nullable()->comment('calculate the time ticket resolution');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('tickets');
    }
};
