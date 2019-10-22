<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Migration class   CreateTaxesTable
|
|
|
|*/



class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('taxes', function(Blueprint $table) {
                $table->increments('id');
                $table->string('code_taxe');
$table->string('libelle_taxe');
$table->string('slug');
$table->integer('categorie');

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
        Schema::drop('taxes');
    }

     /* --Generated with ❤ by Slugger ---*/

}
