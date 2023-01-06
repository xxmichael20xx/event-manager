<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId( 'user_id' )->constrained( 'users' )->onDelete( 'cascade' );
            $table->string( 'name' )->nullable();
            $table->string( 'occasion' );
            $table->string( 'venue' );
            $table->date( 'date' );
            $table->time( 'time' );
            $table->string( 'status' )->default( 'pending' )->nullable();
            $table->json( 'metadata' )->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
