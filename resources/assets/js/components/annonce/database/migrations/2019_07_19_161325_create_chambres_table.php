<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateChambresTable
|
|
|
|*/



class CreateChambresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create('chambres', function(Blueprint $table) {
                $table->increments('id');
                $table->string('numero');
                $table->boolean('disponibilité');
                $table->double('prix');
                $table->integer('type_chambre');
                $table->integer('hotel');
                $table->text('description');
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
        Schema::drop('chambres');
    }

     /* --Generated with ❤ by Slugger ---*/

}
