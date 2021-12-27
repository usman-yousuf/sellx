<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('uuid')->unique();

            $table->integer('sold_id')->nullable();
            $table->foreign('sold_id')->references('id')->on('solds')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('auction_id')->nullable();
            $table->foreign('auction_id')->references('id')->on('auctions')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('auction_product_id')->nullable();
            $table->foreign('auction_product_id')->references('id')->on('auction_products')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('profile_id')->nullable();
            $table->foreign('profile_id')->references('id')->on('profiles')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('auctioneer_id')->nullable();
            $table->foreign('auctioneer_id')->references('id')->on('profiles')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('address_id')->nullable();
            $table->foreign('address_id')->references('id')->on('addresses')->onUpdate('cascade')->onDelete('cascade');

            $table->double('price')->default(0.0);
            $table->double('shipping_fee')->default(0.0);
            $table->double('total_price')->default(0.0);
            $table->string('currency')->default(0.0);

            $table->string('payment_type')->nullable();
            $table->integer('payment_type_id')->nullable();
            
            $table->string('delivery_type')->nullable();
            $table->integer('delivery_type_id')->nullable();

            $table->string('string_charge_id')->nullable();

            $table->enum('status', ['paid','delivered','pickeup','pending','shipped'])->nullable();


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
        Schema::dropIfExists('deliveries');
    }
}
