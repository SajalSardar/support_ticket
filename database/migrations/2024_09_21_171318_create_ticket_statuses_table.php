<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'ticket_statuses', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'name' )->comment( 'open,progress,pending,resolved,hold,closed' );
            $table->boolean( 'status' )->default( true );
            $table->softDeletes();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'ticket_statuses' );
    }
};
