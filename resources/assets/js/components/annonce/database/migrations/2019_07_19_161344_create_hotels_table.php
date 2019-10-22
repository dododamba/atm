<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateHotelsTable
|
|
|
|*/



class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create('hotels', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nom');
                $table->text('description');
                $table->integer('classement');
                $table->string('adresse');
                $table->string('telephone');
                $table->string('site_web');
                $table->string('email');
                $table->string('longitude');
                $table->string('latitude');
                $table->integer('partenaire');
                $table->integer('ville');
                $table->string('slug');

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
        Schema::drop('hotels');
    }

     /* --Generated with ❤ by Slugger ---*/

}
