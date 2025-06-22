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
        Schema::create('ticket_ownerships', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ticket_id');
            $table->integer('owner_id');
            $table->bigInteger('duration')->nullable()->comment('owner\'s ticket time of this ticket in seconds');
            $table->integer('created_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_ownerships');
    }
};
