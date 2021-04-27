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
            $table->string('uuid')->nullable();

            $table->integer('auction_id')->nullable();
            $table->foreign('auction_id')->references('id')->on('auctions')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('auction_products');
    }
}