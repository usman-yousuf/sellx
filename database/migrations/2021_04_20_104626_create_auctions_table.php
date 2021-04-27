<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->uuid('uuid')->nullable();

            $table->integer('auctioneer_id');
            $table->foreign('auctioneer_id')->references('id')->on('profiles')->onUpdate('cascade')->onDelete('cascade');

            $table->string('title');
            $table->enum('status', ['completed', 'in-progress', 'pending', 'cancelled', 'aborted'])->default('pending');

            $table->boolean('is_scheduled')->default(false);
            $table->dateTime('scheduled_date_time')->nullable();

            $table->boolean('is_live')->default(false);

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
        Schema::dropIfExists('auctions');
    }
}
