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
            $table->integer('available_quantity');

            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('material')->nullable();
            $table->string('year_of_production')->nullable();
            $table->string('condition')->nullable();
            $table->string('scope_of_delivery')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('size')->nullable();
            $table->string('dial')->nullable();
            $table->string('make')->nullable(); 
            $table->string('year')->nullable();
            $table->string('vin')->nullable();
            $table->string('exterior')->nullable();
            $table->string('transmission')->nullable();
            $table->string('fuel')->nullable();
            $table->string('keys')->nullable();
            $table->string('doors')->nullable();
            $table->string('seats')->nullable();
            $table->string('odometer')->nullable();
            $table->string('body_type')->nullable(); 
            $table->string('country_of_made')->nullable();
            $table->string('city')->nullable();
            $table->string('code')->nullable();
            $table->string('number')->nullable();
            $table->string('color')->nullable();
            $table->string('weight')->nullable();
            $table->string('age')->nullable();
            $table->string('type')->nullable();
            $table->string('location')->nullable();
            $table->string('total_area')->nullable();
            $table->string('inspection_report_document')->nullable(); //(pdf)
            $table->string('affection_plan_document')->nullable(); //(pdf)
            
            $table->double('min_bid')->default(0.0);
            $table->double('max_bid')->default(0.0);
            $table->double('start_bid')->default(0.0);
            $table->double('target_price')->default(0.0);

            $table->boolean('is_sell_out')->default(false);
            $table->boolean('is_added_in_auction')->default(false);

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
