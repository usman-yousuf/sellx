<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auction_products', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->uuid('uuid')->nullable();

            $table->integer('auction_id')->nullable();
            $table->foreign('auction_id')->references('id')->on('auctions')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('sort_order')->default(1);
            $table->integer('lot_no')->default(1);

            $table->integer('last_extended_time')->default(false)->nullable()->comment('Time extended in minutes');
            $table->dateTime('closure_time')->nullable()->comment('Closing time when the lot is done being in Auction');

            $table->boolean('lot_for_auction')->default(false);
            $table->boolean('is_fixed_price')->default(false);
            $table->double('fixed_price')->default(0.0);

            $table->enum('status', ['completed', 'pending', 'aborted'])->default('pending');

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
        Schema::dropIfExists('auction_products');
    }
}
