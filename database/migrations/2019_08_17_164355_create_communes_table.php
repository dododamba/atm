<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Migration class   CreateCommunesTable
|
|
|
|*/


class CreateCommunesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('communes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code_commune')->nullable();
            $table->string('nom_commune')->nullable();
            $table->string('contact')->nullable();
            $table->string('adresse')->nullable();
            $table->string('coord_geo')->nullable();
            $table->string('latitude')->nullable();
            $table->integer('responsable_communal')->nullable();
            $table->integer('hotel')->nullable();

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
        Schema::drop('communes');
    }

    /* --Generated with ❤ by Slugger ---*/

}
