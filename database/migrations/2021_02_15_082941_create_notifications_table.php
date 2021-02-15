<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);

            $table->integer('sender_id');
            $table->foreign('sender_id')->references('id')->on('profiles')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('receiver_id');
            $table->foreign('receiver_id')->references('id')->on('profiles')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('type_id');
            $table->string('noti_type');
            $table->text('noti_text');
            $table->boolean('is_read')->default(false);

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
        Schema::dropIfExists('notifications');
    }
}
