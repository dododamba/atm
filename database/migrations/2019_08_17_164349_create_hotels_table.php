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
                $table->string('nom_hotel')->nullable();
$table->string('logo')->nullable();
$table->string('ville')->nullable();
$table->string('adresse')->nullable();
$table->string('contact')->nullable();
$table->string('responsable')->nullable();
$table->string('longitude')->nullable();
$table->string('latitude')->nullable();

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
