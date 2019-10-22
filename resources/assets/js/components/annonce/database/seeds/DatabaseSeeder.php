<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersGenerate::class);
        $this->call(RoleTableSeeder::class);
        //$this->call(AnnonceSeeder::class);
       // $this->call(ArticleSeeder::class);

    }
}
