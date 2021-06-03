<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);

            $table->integer('chat_id');
            $table->foreign('chat_id')->references('id')->on('chats')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('sender_id');
            $table->foreign('sender_id')->references('id')->on('profiles')->onUpdate('cascade')->onDelete('cascade');

            $table->text('message')->nullable();
            $table->string('file_type')->nullable();
            $table->text('file_path')->nullable();
            $table->text('file_ratio')->nullable();
            $table->text('thumbnail')->nullable();
            $table->boolean('is_deleted')->default(FALSE);

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
        Schema::dropIfExists('chat_messages');
    }
}
