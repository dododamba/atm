<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(
            array(
                array('name'=>'Partenaire', 'slug'=>str_randomize(10)),
                array('name'=>'Client', 'slug'=>str_randomize(10)),
                array('name'=>'Controleur', 'slug'=>str_randomize(10)),
                array('name'=>'Agent', 'slug'=>str_randomize(10))
            ));

        DB::table('classes')->insert(
            array(
                array('libelle' => 'Ordinaire', 'description' => 'Ceci est la classe ordinaire', 'slug' => str_randomize(10))
            )
        );


        DB::table('annonces')->insert([
            [


                'titre' => 'test',
                'contenue' =>'On ne peut pas suprimer le test',
                'dateDebut' =>Carbon::parse('2020-01-01'),
                'dateFin' =>Carbon::parse('2020-01-01'),
                'prix' =>'20',
                'nombreCaratere' =>'4',
                'position' =>'1',
                'etat' => '1',
                'date_validation' =>Carbon::parse('2020-01-01'),
                'utilisateur' => '1',
                'partenaire' =>'1',
                'valider_par' => '1',
                //'slug' => str_randomize(10)
            ]

        ]);

        DB::table('positionannonces')->insert([
            [
                'libelle' => 'test',
                'description' => 'NON SUPRIMABMABLE',
               // 'slug' => str_randomize(10)

            ]
        ]);

        DB::table('tarifannonces')->insert([
            [
                'prix_image' =>'3',
                'prix_caractere' =>'3',
                'nbre_caractere' =>'3',
                'devise' =>'Eco',
                'position' =>'1',
                'type_annonce' =>'1',
            ]
        ]);

        DB::table('typeannonces')->insert([
            [
                'libelle' => 'test',
                'description' => 'NON SUPRIMABLE',
                //'slug' => str_randomize(10)
            ]
        ]);



    }
}
