<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateTypechambresTable
|
|
|
|*/



class CreateTypechambresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create('typechambres', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nom');
                $table->text('description');
                $table->string('image');
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
        Schema::drop('typechambres');
    }

     /* --Generated with ❤ by Slugger ---*/

}
