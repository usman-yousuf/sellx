<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('uuid')->nullable();

            $table->integer('sender_profile_id')->nullable();
            $table->foreign('sender_profile_id')->references('id')->on('profiles')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('auction_product_id')->nullable();
            $table->foreign('auction_product_id')->references('id')->on('auction_products')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('receiver_profile_id')->nullable();
            $table->foreign('receiver_profile_id')->references('id')->on('profiles')->onUpdate('cascade')->onDelete('cascade');

            $table->text('message');
            $table->string('rating')->default('0');

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
        Schema::dropIfExists('reviews');
    }
}
