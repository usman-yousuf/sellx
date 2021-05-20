<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiddingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biddings', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->uuid('uuid')->nullable();

            $table->integer('auction_id')->nullable();
            $table->foreign('auction_id')->references('id')->on('auctions')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('auction_product_id')->nullable();
            $table->foreign('auction_product_id')->references('id')->on('auction_products')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->double('bid_price')->default(0.0);

            //to be updated after Sold
            //if is_fixed_price is true bid_price will be null
            //quantity avlaible only if is_fixed_price is true 
            $table->boolean('is_fixed_price')->default(false);
            $table->double('single_unit_price')->default(0.0);
            $table->integer('quantity')->default(1);
            $table->double('total_price')->default(0.0);
            $table->enum('status', ['bid_won', 'purchased'])->nullable();

            $table->dateTime('sold_date_time')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('biddings');
    }
}
