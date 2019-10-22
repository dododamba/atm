<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Migration class   CreateCategorietaxesTable
|
|
|
|*/



class CreateCategorietaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('categorietaxes', function(Blueprint $table) {
                $table->increments('id');
                $table->string('libelle');
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
        Schema::drop('categorietaxes');
    }

     /* --Generated with ❤ by Slugger ---*/

}
