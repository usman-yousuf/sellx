<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('uuid')->nullable();

            $table->integer('profile_id')->nullable();
            $table->foreign('profile_id')->references('id')->on('profiles')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('cat_id')->nullable();
            $table->foreign('cat_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('sub_cat_id')->nullable();
            $table->foreign('sub_cat_id')->references('id')->on('sub_categories')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('sub_cat_level_3_id')->nullable();
            $table->foreign('sub_cat_level_3_id')->references('id')->on('sub_categories_level_3')->onUpdate('cascade')->onDelete('cascade');

            $table->string('title');
            $table->string('description');

            $table->double('min_bid')->default(0.0);
            $table->double('max_bid')->default(0.0);
            $table->double('start_bid')->default(0.0);
            $table->double('target_price')->default(0.0);

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
        Schema::dropIfExists('products');
    }
}
