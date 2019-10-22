@extends('layout.app')
@section('title')
Contribualbes
@stop

@section('content')
 

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
        <table class="basic-table booking-table">
            <thead>
                    <tr>
                        <th>ID</th><th>Nom</th><th>Prenom</th><th>Fonction</th> <th>Matricule</th> <th> N° Pièce</th> <th>Date d'Ajout</th><th>Action</th>
                    </tr>
                </thead>
                <tbody>
                 @foreach ($collection as $item)
                 <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nom }}</td>
                    <td>{{ $item->prenoms }}</td>
                    <td>{{ $item->fonction }}</td>
                    <td>{{ $item->matricule }}</td>
                    <td>{{ $item->num_piece_id}}</td>
                    <td>{{ $item->created_at }}</td>
                    <td class="textright">
                         <div class="dropdown">
                             <button class="button gray dropdown-toggle" type="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <span class="fa fa-list"></span>
                             </button>
                             <div class="dropdown-menu" aria-labelledby="">
                                   <a class="dropdown-item" >Supprimer</a>                 
                             </div>
                         </div>
                     </td>
                </tr>
                 @endforeach

               
                </tbody>
    </table>
    </div>
</div>
 
@endsection
