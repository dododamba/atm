<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Migration class   CreateCategoriecontribuablesTable
|
|
|
|*/



class CreateCategoriecontribuablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('categoriecontribuables', function(Blueprint $table) {
                $table->increments('id');
                $table->string('libelle');
$table->text('description');

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
        Schema::drop('categoriecontribuables');
    }

     /* --Generated with ❤ by Slugger ---*/

}
