<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Migration class   CreateUsersTable
|
|
|
|*/



class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('users', function(Blueprint $table) {
                $table->increments('id');
                $table->string('matricule')->nullable();
                $table->string('nom')->nullable();
                $table->string('prenom')->nullable();
                $table->date('date_naiss')->nullable();
                $table->string('fonction')->nullable();
                $table->string('email');
                $table->string('password');
                $table->string('slug')->nullable();
                $table->string('langue')->nullable();
                $table->string('telephone')->nullable();
                $table->string('permissions')->nullable();
                $table->string('remember_token')->nullable();
                $table->integer('role')->nullable();
                $table->string('reset_token')->nullable();
                $table->string('last_login')->nullable();
                $table->integer('commune')->nullable();


                $table->unique('email');
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
        Schema::drop('users');
    }

     /* --Generated with ❤ by Slugger ---*/

}
