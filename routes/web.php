<?php

 header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Headers: *");
 header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");


Route::auth();
Route::get('/', ['uses' => 'HomeController@home']);
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/index.html', ['uses' => 'HomeController@home']);
Route::get('permission', 'AdminDashboardController@nopermission')->name('need-permission');
Route::get('/permission', 'AdminDashboardController@nopermission')->name('permission');


Route::group(['middleware' => ['web', 'auth', 'permission','logactions']], function () {
    Route::get('dashboard', ['uses' => 'HomeController@dashboard', 'as' => 'home.dashboard']);
    Route::get('dashboard/index.html', ['uses' => 'HomeController@dashboard', 'as' => 'home.dashboard']);
    Route::get('token', 'Auth\\LoginController@getAccessToken')->name('web-api.getAccessToken');

    //users
    Route::resource('user', 'UserController');
    Route::get('user/{user}/permissions', ['uses' => 'UserController@permissions', 'as' => 'user.permissions']);
    Route::post('user/{user}/save', ['uses' => 'UserController@save', 'as' => 'user.save']);
    Route::get('user/{user}/activate', ['uses' => 'UserController@activate', 'as' => 'user.activate']);
    Route::get('user/{user}/deactivate', ['uses' => 'UserController@deactivate', 'as' => 'user.deactivate']);
    Route::post('user/ajax_all', ['uses' => 'UserController@ajax_all']);
    //roles
    Route::resource('role', 'RoleController');
    Route::get('role/{role}/permissions', ['uses' => 'RoleController@permissions', 'as' => 'role.permissions']);
    Route::post('role/{role}/save', ['uses' => 'RoleController@save', 'as' => 'role.save']);
    Route::post('role/check', ['uses' => 'RoleController@check']);

    //user administrations
    Route::get('/users?type=admin', 'UserController@index')->name('pages.user');
   
    Route::get('api', 'AdminDashboardController@api')->name('pages.api');

    /**
     * Dominique DAMBA
     *
     * API Routes Mapping
     */


    Route::get('contribuable', 'ContribuableController@index')->name('web-api.contribuable-liste');
    Route::get('contribuable/{id}', 'ContribuableController@show')->name('web-api.contribuable-detail');
    Route::post('contribuable', 'ContribuableController@store')->name('web-api.contribuable-enregistrement');
    Route::post('contribuable/{id}', 'ContribuableController@update')->name('web-api.contribuable-mise-a-jours');
    Route::delete('contribuable/{slug}', 'ContribuableController@destroy')->name('web-api.contribuable-suppression');

    Route::get('contribuablecat', 'CategorieContribuableController@index')->name('web-api.categorie-contribuable-liste');
    Route::get('contribuablecat/{slug}', 'CategorieContribuableController@show')->name('web-api.categorie-contribuable-detail');
    Route::post('contribuablecat', 'CategorieContribuableController@store')->name('web-api.categorie-contribuable-enregistrement');
    Route::post('contribuablecat/{slug}', 'CategorieContribuableController@update')->name('web-api.categorie-contribuable-mise-a-jours');
    Route::delete('contribuablecat/{slug}', 'CategorieContribuableController@destroy')->name('web-api.categorie-contribuable-suppression');
    
    Route::get('taxecat', 'CategorieTaxeController@index')->name('web-api.categorie-taxe-liste');
    Route::get('taxecat/{slug}', 'CategorieTaxeController@show')->name('web-api.categorie-taxe-detail');
    Route::post('taxecat', 'CategorieTaxeController@store')->name('web-api.categorie-taxe-enregistrement');
    Route::post('taxecat/{slug}', 'CategorieTaxeController@update')->name('web-api.categorie-taxe-mise-a-jours');
    Route::delete('taxecat/{slug}', 'CategorieTaxeController@destroy')->name('web-api.categorie-taxe-suppression');
    
    Route::get('taxe', 'TaxeController@index')->name('web-api.taxe-liste');
    Route::get('taxe-show/{slug}', 'TaxeController@show')->name('web-api.taxe-detail');
    Route::post('taxe', 'TaxeController@store')->name('web-api.taxe-enregistrement');
    Route::post('taxe/{id}', 'TaxeController@update')->name('web-api.taxe-mise-a-jours');
    Route::delete('taxe/{slug}', 'TaxeController@destroy')->name('web-api.taxe-suppression');

    Route::get('commune', 'CommuneController@index')->name('web-api.commune-liste');
    Route::get('commune/{slug}', 'CommuneController@show')->name('web-api.commune-detail');
    Route::post('commune', 'CommuneController@store')->name('web-api.commune-enregistrement');
    Route::post('commune/{slug}', 'CommuneController@update')->name('web-api.commune-mise-a-jours');
    Route::delete('commune/{slug}', 'CommuneController@destroy')->name('web-api.commune-suppression');


    Route::get('hotel', 'HotelController@index')->name('web-api.hotel-liste');
    Route::get('hotel/{slug}', 'HotelController@show')->name('web-api.hotel-detail');
    Route::post('hotel', 'HotelController@store')->name('web-api.hotel-enregistrement');
    Route::post('hotel/{slug}', 'HotelController@update')->name('web-api.hotel-mise-a-jours');
    Route::delete('hotel/{slug}', 'HotelController@destroy')->name('web-api.hotel-suppression');


    Route::get('responsable', 'HotelController@responsable')->name('web-api.employees-liste');


    /**
     * Page mapping
     */
    Route::get('historiques', 'PageController@historiques')->name('pages.liste-historiques');

    Route::get('contribualbes', 'PageController@contribualbes')->name('pages.liste-contribualbes');
    Route::get('contribualbes/create', 'PageController@createContribualbes')->name('pages.create-contribualbes');
    Route::get('contribualbes/recap', 'PageController@recapContribualbes')->name('pages.recap-contribualbes');
    Route::get('contribualbes/store-from-recap', 'PageController@storeFromSession')->name('pages.sesion-contribualbes');


    Route::get('categoriecontribuables', 'PageController@categoriecontribuables')->name('pages.liste-categoriecontribuables');
    Route::get('taxes', 'PageController@taxes')->name('pages.liste-taxes');
    Route::get('hotels', 'PageController@hotels')->name('pages.liste-hotels');
    Route::get('categorietaxe', 'PageController@categorietaxe')->name('pages.liste-categorietaxe');
    Route::get('communes', 'PageController@commune')->name('pages.liste-communes');


    Route::get('statistiques', 'PageController@statistique')->name('pages.liste-statistiques');
    Route::post('statistiques', 'PageController@statistique')->name('pages.liste-statistiques');
    Route::get('printstats', 'PageController@printstats')->name('pages.print-stats');

    Route::get('/map', function() {
        $data = session()->get('data');
        return view('contribualbes.map',compact('data'));
    })->name('pages.map');

    //  Profile management

    Route::get('profile', 'AdminDashboardController@profile')->name('pages.mon-profile');
    Route::get('profile/edit', 'AdminDashboardController@profileEdit')->name('pages.mon-profile-edit');


    Route::get('encaisser', 'EncaissementController@nouvelEncaissement')->name('pages.encaisser');
    //Route::Post('encaisser', 'EncaissementController@enregistrerEncaissement')->name('encaisser');
    Route::get('recette', 'EncaissementController@listerEncaissements')->name('pages.recette');
    Route::get('versement', 'EncaissementController@nouveauVersement')->name('pages.encaisser');
    
    Route::post('versement', 'EncaissementController@enregistrerVersement')->name('pages.versement');

    Route::post('chercherContribuable','ContribuablesController@findContribuable');
    Route::post('getListesTaxes','ContribuablesController@getTaxes');
    Route::post('saveContribuable','ContribuablesController@save');
});
