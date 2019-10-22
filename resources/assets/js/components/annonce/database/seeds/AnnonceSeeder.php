<?php

use Illuminate\Database\Seeder;

class AnnonceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('annonces')->insert([
            [


                'titre' => 'test',
                'contenue' =>'test',
                'dateDebut' =>'test',
                'dateFin' =>'test',
                'prix' =>'test',
                'slug' =>'test',
                'nombreCaratere' =>'4',
                'position' =>'',
                'etat' => '1',
                'date_validation' =>'',
                'utilisateur' => '1',
                'partenaire' =>'1',
                'valider_par' => '1',
                'slug' => str_randomize(10)
            ]

        ]);

        DB::table('positionannonces')->insert([
            [
                'libelle' => 'test',
                'description' => 'test',
                'slug' => str_randomize(10)

            ]
        ]);

        DB::table('tarifannonces')->insert([
            [
                'prix_image' =>'3',
                'prix_caractere' =>'3',
                'position' =>'1',
                'annoce' =>'1',
                'slug' => str_randomize(10)
            ]
        ]);

        DB::table('typeannonces')->insert([
            [
                'libelle' => 'test',
                'description' => 'test',
                'slug' => str_randomize(10)
            ]
        ]);



    }
}
