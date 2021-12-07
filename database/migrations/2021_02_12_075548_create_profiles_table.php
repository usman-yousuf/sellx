<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('uuid')->unique();

            $table->integer('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('auction_house_name')->nullable();

            $table->string('username')->unique()->nullable();
            $table->text('profile_image')->nullable();
            $table->text('auction_house_logo')->nullable();
            $table->longText('bio')->nullable();
            $table->longText('description')->nullable();

            $table->date('dob')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();

            $table->string('country')->nullable();

            $table->boolean('is_online')->default(false);
            $table->enum('profile_type', ['buyer', 'auctioneer'])->default('buyer');
            $table->boolean('is_approved')->default(false);

            $table->decimal('deposit')->nullable();
            // $table->decimal('max_bid_limit')->default(15000);
            $table->string('max_bid_limit')->default('1000')->nullable();

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
        Schema::dropIfExists('profiles');
    }
}
