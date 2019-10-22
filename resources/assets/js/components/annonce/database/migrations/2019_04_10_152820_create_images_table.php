<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateImagesTable
|
|
|
|*/



class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('images', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nom');
                $table->string('alt')->nullable(true);
                $table->string('slug');
                $table->unsignedInteger('owner')->nullable(true);
                $table->unsignedInteger('sitetouristique')->nullable(true);

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
        Schema::drop('images');
    }


}
