<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnonymityColumnToLocalisationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('localisation_settings', function (Blueprint $table) {
            $table->boolean('is_anonymity')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('localisation_settings', function (Blueprint $table) {
            $table->dropColumn('is_anonymity');
        });
    }
}
