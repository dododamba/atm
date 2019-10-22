@extends('layout.app')
@section('title')
Contribualbes
@stop
@section('css')
<style>

.table-title h3 {
   color: #fafafa;
   font-size: 30px;
   font-weight: 400;
   font-style:normal;
   font-family: "Roboto", helvetica, arial, sans-serif;
   text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
   text-transform:uppercase;
}


/*** Table Styles **/

.table-fill {
  background: white;
  border-radius:3px;
  border-collapse: collapse;
  height: 320px;
  margin: auto;
  max-width: 600px;
  padding:5px;
  width: 100%;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
  animation: float 5s infinite;
}
 
th {
  color:#D5DDE5;;
  background:#1b1e24;
  border-bottom:4px solid #9ea7af;
  border-right: 1px solid #343a45;
  font-size:23px;
  font-weight: 100;
  padding:24px;
  text-align:left;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
  vertical-align:middle;
}

th:first-child {
  border-top-left-radius:3px;
}
 
th:last-child {
  border-top-right-radius:3px;
  border-right:none;
}
  
tr {
  border-top: 1px solid #C1C3D1;
  border-bottom-: 1px solid #C1C3D1;
  font-size:16px;
  font-weight:normal;
  text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
}
 
tr:hover td {
  background: #005294;
  color:#FFFFFF;
  border-top: 1px solid #22262e;
}
 
tr:first-child {
  border-top:none;
}

tr:last-child {
  border-bottom:none;
}
 
tr:nth-child(odd) td {
}
 
tr:nth-child(odd):hover td {
}

tr:last-child td:first-child {
  border-bottom-left-radius:3px;
}
 
tr:last-child td:last-child {
  border-bottom-right-radius:3px;
}
 
td {
  background:#FFFFFF;
  padding:20px;
  text-align:left;
  vertical-align:middle;
  font-weight:300;
  font-size:18px;
  text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
  border-right: 1px solid #C1C3D1;
}

td:last-child {
  border-right: 0px;
}

th.text-left {
  text-align: left;
}

th.text-center {
  text-align: center;
}

th.text-right {
  text-align: right;
}

td.text-left {
  text-align: left;
}

td.text-center {
  text-align: center;
}

td.text-right {
  text-align: right;
}

    </style>
@endsection
@section('content')
 
<div id="map"></div>

<div class="card">
    <div class="card-title">
        <div class="row">
            <div class="col-md-6">
                <h3 class="text-info">Liste des Contribualbes</h3>
            </div>
            <div class="col-md-6" style="text-align: right;">
             <a class="button"  href="{{route('pages.create-contribualbes')}}" size="sm">+ Ajouter</a>
            </div>
        </div>
        <hr class="colorgraph"><br>
    </div>
    <div class="card-body">
  

            <div class="col-md-12">
                    <div class="dashboard-list-box">
                        <h4 class="gray">Recaputilatif</h4>
                
                                <table class="col-md-12">
                            
                                <tbody class="table-hover">
                                <tr>
                                <td class="text-left">Chiffre d'affaire</td>
                                <td class="text-left"> {{$data['chiffre_affaire']}} </td> 
                                </tr>

                                <tr>
                                <td class="text-left">Capitale</td>
                                <td class="text-left"><p id="capitale">{{$data['capitale']}}</p></td>
                                </tr>

                                <tr>
                                <td class="text-left">Categorie </td>
                                <td class="text-left"> <p id="categorie">{{$data['categorie']}}</p></td>
                                </tr>

                                <tr>
                                <td class="text-left">Nom du Proprietaire</td>
                                <td class="text-left"><p id="nom_proprietaire">{{$data['nom_proprietaire']}}</p></td>
                                </tr>

                                <tr>
                                <td class="text-left">Prenom du Proprietaire</td>
                                <td class="text-left"><p id="">{{$data['prenom_proprietaire']}}</p></td>
                                <tr>

                                 <tr>
                                        <td class="text-left">Nationalité du Proprietaire</td>
                                        <td class="text-left">{{$data['nationalite_proprietaire']}}</td>
                                 </tr>
                               
                                <tr>
                                        <td class="text-left">Numero de pièce d'identité du Proprietaire</td>
                                        <td class="text-left"><p id="">{{$data['num_piece_id_proprietaire']}}</p></td>
                                </tr>
                                <tr>
                                        <td class="text-left">Nature de pièce d'identité du Proprietaire</td>
                                        <td class="text-left"><p id="">{{$data['nature_piece_id_proprietaire']}}</p></td>
                                </tr>
                                
                                <tr>
                                        <td class="text-left">Adresse du Proprietaire</td>
                                        <td class="text-left"><p id="">{{$data['adresse_proprietaire']}}</p></td>
                                </tr>

                               <tr>
                                    <td class="text-left">Numero de Telephone du Proprietaire</td>
                                <td class="text-left"><p id="">{{$data['telephone_proprietaire']}}</p></td>

                               </tr>
                               
                               <tr>
                                    <td class="text-left">Nom du Gérant</td>
                                <td class="text-left"><p id="">{{$data['nom_gerant']}}</p></td>
                               </tr>
                                
                               <tr>
                                    <td class="text-left">Prenom du Gérant</td>
                                    <td class="text-left"><p id="">{{$data['prenom_gerant']}}</p></td>
                               </tr>
                               
                               <tr>
                                    <td class="text-left">Nationalité du Gérant</td>
                                <td class="text-left"><p id="">{{$data['nationalite_gerant']}}</p></td></td>
                               </tr>
                              
                               <tr>
                                    <td class="text-left">Numero de pièce d'identité du Gérant</td>
                                    <td class="text-left"><p id="">{{$data['num_piece_id_gerant']}}</p></td>
                               </tr>
                               
                               <tr>
                                    <td class="text-left">Nature de pièce d'identité du Gérant</td>
                                <td class="text-left"><p id="">{{$data['nature_piece_id_gerant']}}</p></td>
                               </tr>
                               
                               <tr>
                                    <td class="text-left">Adresse du Gérant</td>
                                <td class="text-left"><p id="">{{$data['adresse_gerant']}}</p></td>
                               </tr>

                             <tr>
                                    <td class="text-left">Numero de Telephone du Gérant</td>
                                <td class="text-left"><p id="">{{$data['telephone_gerant']}}</p></td>
                             </tr>

                               <tr>
                                    <td class="text-left">Adresse de l'activité</td>
                                <td class="text-left"><p id="">{{$data['adresse_activite']}}</p></td>
                               </tr>
                            
                               <tr>
                                    <td class="text-left">Numero de Telephone de l'activité</td>
                                    <td class="text-left"><p id="">{{$data['telephone_activite']}}</p></td>
                               </tr>
                               
                               <tr>
                                    <td class="text-left">Ville de l'activité</td>
                                <td class="text-left"><p id="">{{$data['email_activite']}}</p></td>
                               </tr>
                               
                               <tr>
                                    <td class="text-left">Longitude</td>
                                <td class="text-left"><p id="">{{$data['lng']}}</p></td>
                               </tr>
                               <tr>
                                    <td class="text-left">Latitude</td>
                                <td class="text-left"><p id="">{{$data['lat']}}</p></td>
                               </tr>

                             
                               <tr>
                                    <td>

                                    </td>
                                    <td></td>
                                </tr>

                                <tfoot>

                                </tfoot>

                                </tbody>
                                </table>





                                

                                <div class="row">
                                      <a   href="#3a" data-toggle="tab" class="button"><< Modifier</a>
                                <a href="{{route('pages.session-contribuable')}}" class="button" style="background:green;color: #fff">Enregistrer <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                   </div>
                                
                    </div>
                </div>
    </div>
</div>
@endsection