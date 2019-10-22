<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Migration class   CreateProprietairesTable
|
|
|
|*/



class CreateProprietairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('proprietaires', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nom');
$table->string('prenom');
$table->date('naisssance');
$table->integer('nationalite');
$table->string('adresse');
$table->string('num_piece_id');
$table->string('nature_piece_id');
$table->string('tel');
$table->string('naissance');
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
        Schema::drop('proprietaires');
    }

     /* --Generated with ❤ by Slugger ---*/

}
