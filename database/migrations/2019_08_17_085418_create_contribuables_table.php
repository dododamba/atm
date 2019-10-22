<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Migration class   CreateContribuablesTable
|
|
|
|*/



class CreateContribuablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('contribuables', function(Blueprint $table) {
                $table->increments('id');
                $table->string('matricule')->nullable();
                    $table->string('num_piece_id')->nullable();
                    $table->string('nom')->nullable();
                    $table->string('prenoms')->nullable();
                    $table->string('situation_matri')->nullable();
                    $table->integer('nb_enfants')->nullable();
                    $table->integer('nb_femmes')->nullable();
                    $table->date('date_naissance')->nullable();
                    $table->string('pays_residence')->nullable();
                    $table->string('ville_residence')->nullable();
                    $table->string('adresse')->nullable();
                    $table->string('tel')->nullable();
                    $table->string('email')->nullable();
                    $table->string('fonction')->nullable();
                    $table->string('service_direction')->nullable();
                    $table->boolean('is_fonctionnaire')->nullable();
                    $table->boolean('is_corp_habille')->nullable();
                    $table->boolean('is_enseignant')->nullable();
                    $table->float('salaire')->nullable();
                    $table->integer('categorie')->nullable();
                    $table->string('slug')->nullable();

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
        Schema::drop('contribuables');
    }

     /* --Generated with ❤ by Slugger ---*/

}
