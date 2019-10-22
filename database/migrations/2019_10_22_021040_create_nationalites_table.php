<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Migration class   CreateNationalitesTable
|
|
|
|*/



class CreateNationalitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('nationalites', function(Blueprint $table) {
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
        Schema::drop('nationalites');
    }

     /* --Generated with ❤ by Slugger ---*/

}
