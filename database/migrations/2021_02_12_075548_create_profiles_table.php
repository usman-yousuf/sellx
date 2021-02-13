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
            $table->string('username')->nullable();
            $table->text('profile_image')->nullable();
            $table->longText('bio')->nullable();

            $table->date('dob')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();

            $table->boolean('is_online')->default(FALSE);
            $table->enum('profile_type', ['buyer', 'auctioner'])->default('buyer');
            $table->boolean('is_approved')->default(false);

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
