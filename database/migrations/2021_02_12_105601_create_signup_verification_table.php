<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignupVerificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signup_verification', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->enum('type', ['email', 'phone'])->nullable();
            $table->string('email')->index()->nullable();
            $table->string('phone')->index()->nullable();
            $table->string('token');
            
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signup_verification');
    }
}
