<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Migration class   CreatePaysTable
|
|
|
|*/



class CreatePaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('pays', function(Blueprint $table) {
                $table->increments('id');
                $table->string('libelle');
$table->string('pays');
$table->integer('indicatif');
$table->string('iso');
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
        Schema::drop('pays');
    }

     /* --Generated with ❤ by Slugger ---*/

}
