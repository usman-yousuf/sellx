<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solds', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->uuid('uuid')->nullable();

            $table->integer('bidding_id')->nullable();
            $table->foreign('bidding_id')->references('id')->on('biddings')->onUpdate('cascade')->onDelete('cascade');

            $table->double('price')->default(0.0);
            $table->double('discount')->default(0.0);
            $table->double('total_price')->default(0.0);
            $table->enum('type', ['bid_won', 'purchased'])->nullable();
            $table->enum('status', ['pending', 'paid','on_hold','reversed','shipped'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solds');
    }
}
