<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->uuid('uuid')->nullable();

            $table->integer('profile_id')->nullable();
            $table->foreign('profile_id')->references('id')->on('profiles')->onUpdate('cascade')->onDelete('cascade');

            $table->enum('ref_type', ['user','story','auction','product'])->nullable();
            $table->integer('ref_id')->nullable();

            $table->enum('type', ['block','report','both'])->nullable();;

            $table->text('report_type')->nullable();
            $table->text('description')->nullable();

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
        Schema::dropIfExists('blocks');
    }
}
