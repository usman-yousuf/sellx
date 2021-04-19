<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoriesLevel3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories_level_3', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('uuid')->nullable();

            $table->integer('sub_cat_id')->nullable();
            $table->foreign('sub_cat_id')->references('id')->on('sub_categories')->onUpdate('cascade')->onDelete('cascade');

            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('status')->default(true);

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
        Schema::dropIfExists('sub_categories_level_3');
    }
}
