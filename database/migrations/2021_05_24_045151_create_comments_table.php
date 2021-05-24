<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->uuid('uuid')->nullable();

            $table->integer('auction_id')->nullable();
            $table->foreign('auction_id')->references('id')->on('auctions')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('auction_product_id')->nullable();
            $table->foreign('auction_product_id')->references('id')->on('auction_products')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('profile_id')->nullable();
            $table->foreign('profile_id')->references('id')->on('profiles')->onUpdate('cascade')->onDelete('cascade');

            $table->text('comment')->nullable();

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
        Schema::dropIfExists('comments');
    }
}
