@extends('layout.app')
@section('title')
Contribualbes
@stop

@section('content')
 

<div class="card">
    <div class="card-title">
        <div class="row">
            <div class="col-md-6">
                <h3 class="text-info">Enregistrement d'un Contribualbe</h3>
            </div>
            <div class="col-md-6" style="text-align: right;">
             <a class="button"  href="{{route('pages.liste-contribualbes')}}" size="sm"> <span class="fa fa-list"></span> Liste</a>
            </div>
        </div>
        <hr class="colorgraph"><br>
    </div>
    <div class="card-body">
      

        <div class="row">
        
                <ul  class="nav nav-pills">
                        <li class="active">
                           <a  href="#1a" data-toggle="tab">Contribualbes</a>
                        </li>
                        <li>
                            <a href="#2a" data-toggle="tab">Gerant</a>
                        </li>
                        <li>
                            <a href="#3a" data-toggle="tab">Adresse</a>
                        </li>

                        <li>
                            <a href="#4a" data-toggle="tab">Coordonées Geographiques</a>
                        </li>

                        
                    </ul>
            
                    <p class="text-danger">Les champs marqués par un (<i class="text-danger glyphicon glyphicon-asterisk"></i>)
                        sont obligatoires !</p>

                    <form method="POST" action="{{ route('web-api.contribuable-enregistrement') }}">
                            {{ csrf_field() }}


                            <div class="tab-content clearfix">
            
                             <div class="tab-pane active" id="1a">
                                    <div class="add-listing-section">
            
                                            <!-- Headline -->
                                            <div class="add-listing-headline">
                                                <h3><i class="sl sl-icon-doc"></i> Informations du Contribuable </h3>
                                            </div>
                            
                                            <fieldset>
                                                <legend><b> Activités </b> </legend>
                                                <div class="row with-forms">
                                                    <div class="col-md-6">
                                                        <label>Chiffre d'affaire <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                                        <input name="chiffre_affaire" class="search-field" type="text" value="">
                                                    </div>
                            
                                                    <div class="col-md-6">
                                                        <label>Capitale <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                                        <input name="capitale" class="search-field" type="text" value="">
                                                    </div>
                            
                                                </div>
                            
                                                <div class="row with-forms">
                                                    <div class="col-md-12">
                                                        <label>Categorie <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                                        <select class="chosen-select-no-single" name="categorie">
                                                            <option disabled>Selectioner une Catégorie</option>
                                                            <option value=""></option>
                                                            @foreach ($categories as $item)
                                                        <option value="{{$item->id}}">{{$item->libelle}}</option>

                                                            @endforeach
                                                        </select>
                                            
                                                    </div>
                            
                                                </div>
                                            </fieldset>
                                            <!-- Title -->
                                            <fieldset>
                                                <legend><b> Proprietaire </b> </legend>
                                                <div class="row with-forms">
                                                    <div class="col-md-6">
                                                        <label>Nom <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                                        <input name="nom_partenaire" class="search-field" type="text" value="">
                                                    </div>
                            
                                                    <div class="col-md-6">
                                                        <label>Prenom <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                                        <input name="prenom_prenom" class="search-field" type="text" value="">
                                                    </div>
                            
                                                </div>
                            
                                                <div class="row with-forms">
                            
                                                        <div class="col-md-4">
                                                                <label>Nationalité <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                                                <select class="chosen-select-no-single" name="nationalite_proprietaire">
                                                                    <option disabled>Selectioner une Catégorie</option>
                                                                    <option value=""></option>
                                                                    @foreach ($nationalites as $item)
                                                                   <option value="{{$item->id}}">{{$item->libelle}}</option>
        
                                                                    @endforeach
                                                                </select>
                                                    
                                                            </div>

                                                    <div class="col-md-4">
                                                        <label>N ° Pièce d'identité <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                                        <input name="num_piece_id" class="search-field" type="text" value="">
                                                    </div>
                            
                                                    <div class="col-md-4">
                                                        <label>Nature Piece </label>
                                                        <input name="nature_piece_id" class="search-field" type="text" value="">
                                                    </div>
                            
                                                </div>
                                            </fieldset>

                                            <fieldset>
                                                 <legend>Adresse Proprietaire</legend>
                                                    <div class="row with-forms">
                                                            <div class="col-md-6">
                                                                 <label>Address</label>
                                                                 <input name="adresse_partenaire" type="text" placeholder="e.g. 964 School Street">
                                                             </div>
                                                             <!-- City -->
                                                           <div class="col-md-6">
                                                               <label>Telephone</label>
                                                                <input name="telephone_partenaire" type="text">
                                                          </div>
                                                 </div>
                                            </fieldset>
                                        </div>
                            
                            
                                        <a href="#2a" data-toggle="tab" class="button">Suivant >> </a> 

                                   
                                   
                                    </div>
            
                              <div class="tab-pane" id="2a">
                                    <div class="add-listing-section">
            
                                            <div class="add-listing-headline">
                                                <h3><i class="sl sl-icon-doc"></i> Informations du Gerant </h3>
                                            </div>
                            

                                            <fieldset>
                                                    <legend><b> Gérant  </b> </legend>
                                                    <div class="row with-forms">
                                                        <div class="col-md-6">
                                                            <label>Nom <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                                            <input name="nom_gerant" class="search-field" type="text" value="">
                                                        </div>
                                
                                                        <div class="col-md-6">
                                                            <label>Prenom <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                                            <input name="prenom_gerant" class="search-field" type="text" value="">
                                                        </div>
                                
                                                    </div>
                                
                                                    <div class="row with-forms">
                                
                                                            <div class="col-md-4">
                                                                    <label>Nationalité <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                                                    <select class="chosen-select-no-single" name="nationalite_gerant">
                                                                        <option disabled>Selectioner une Catégorie</option>
                                                                        <option value=""></option>
                                                                        @foreach ($nationalites as $item)
                                                                       <option value="{{$item->id}}">{{$item->libelle}}</option>
            
                                                                        @endforeach
                                                                    </select>
                                                        
                                                                </div>
    
                                                        <div class="col-md-4">
                                                            <label>N ° Pièce d'identité <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                                            <input name="num_piece_id_gerant" class="search-field" type="text" value="">
                                                        </div>
                                
                                                        <div class="col-md-4">
                                                            <label>Nature Piece </label>
                                                            <input name="nature_piece_id_gerant" class="search-field" type="text" value="">
                                                        </div>
                                
                                                    </div>
                                                </fieldset>
    
                                                <fieldset>
                                                     <legend>Adresse Gérant </legend>
                                                        <div class="row with-forms">
                                                                <div class="col-md-6">
                                                                     <label>Address</label>
                                                                     <input name="adresse_gerant" type="text" placeholder="e.g. 964 School Street">
                                                                 </div>
                                                                 <!-- City -->
                                                               <div class="col-md-6">
                                                                   <label>Telephone</label>
                                                                    <input name="telephone_gerant" type="text">
                                                              </div>
                                                     </div>
                                                </fieldset>


                                           
                                        </div>

                                        <a  href="#1a" data-toggle="tab" class="button"><< Précedent</a>
                                        <a href="#3a" data-toggle="tab" class="button">Suivant >> </a>


                              </div>
                                     
                              <div class="tab-pane" id="3a">
                                    <div class="add-listing-section">
                                            <div class="add-listing-headline">
                                                <h3><i class="sl sl-icon-map"></i> Adresse</h3>
                                            </div>
                                            <div class="submit-section">       
                                                <div class="row with-forms">
                                                    <div class="col-md-6">
                                                        <label>Address</label>
                                                        <input name="adresse_activite" type="text" placeholder="e.g. 964 School Street">
                                                    </div>
                            
                                                    <!-- City -->
                                                    <div class="col-md-6">
                                                        <label>Telephone</label>
                                                        <input name="telephone_activite" type="text">
                                                    </div>
                            
                                                    <div class="col-md-6">
                                                        <label>Email</label>
                                                        <input name="email_activite" type="text">
                                                    </div>
                            
                                                    <!-- Zip-Code -->
                                                    <div class="col-md-6">
                                                        <label>Ville </label>
                                                        <input name="ville_activite" type="text">
                                                    </div>    
                                                    
                                                </div>

                                
                            
                                            </div>
                                        </div>
                              

                                        <button  href="#2a" data-toggle="tab" class="button"><< Précedent</button>
                                        <button  href="#4a" data-toggle="tab" class="button">Suivant >> </button>

                                    </div>
            
            
                                
                                    <div class="tab-pane" id="4a">
                                            <div class="add-listing-section">
                                                    <div class="add-listing-headline">
                                                        <h3><i class="sl sl-icon-map"></i> Adresse</h3>
                                                    </div>
                                                    <div class="row with-forms">
                                                                    
                                                            <div class="col-md-6">
                                                                 <label>Longitude</label>
                                                                 <input name="lng" type="text" placeholder="9.655662"/>
                                                             </div>
        
                                                           <div class="col-md-6">
                                                               <label>Latitude</label>
                                                                <input name="lat" type="text" placeholder="0.9654488" />
                                                          </div>
                                                 </div>
        
                                                </div>
        
                                                <button  href="#3a" data-toggle="tab" class="button"><< Précedent</button>
                                                <button  style="background: #005294;color: #fff" type="submit" class="button" >Recapulatif <i class="fa fa-eye"></i>  </button>
        
                                            </div> 

            
            
                              </div>

                                 
                              </div>


                        </div>
                      
                    </form>
            
            
                    
        </div>   

    </div>
</div>
 
<script>
  recap(){
    document.getElementById('capitale').value=document.getElementsByName('capitale');

  }
</script>
@endsection
