<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_media', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('uuid')->unique();

            $table->integer('profile_id')->nullable();
            $table->foreign('profile_id')->references('id')->on('profiles')->onUpdate('cascade')->onDelete('cascade');

            $table->string('type')->nullable(); // model type
            $table->integer('ref_id')->nullable(); // model id if not profile

            $table->string('name')->nullable();
            $table->string('path');
            $table->string('media_type')->nullable();
            $table->string('media_format')->nullable();
            $table->string('media_size')->nullable();
            $table->string('media_ratio')->nullable();
            $table->string('media_thumbnail')->nullable();

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
        Schema::dropIfExists('upload_media');
    }
}
