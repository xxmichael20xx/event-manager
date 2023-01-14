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
        Schema::table('events', function (Blueprint $table) {
            $table->string( 'payment_status' )->after( 'status' )->default( 'no_payment' )->nullable();
            $table->float( 'payment' )->after( 'status' )->default( 0 )->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn( 'payment_status' );
            $table->dropColumn( 'payment' );
        });
    }
};
