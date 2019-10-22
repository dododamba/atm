@extends('layout.app')
@section('title')
Historique de connection
@stop

@section('content')
<div class="col-lg-12 col-md-12 col-xs-12">


    
    <div class="dashboard-list-box">
            <h4 class="gray"> <i class="glyphicon glyhicon-th-list"></i>Historique des actions </h4>
        <div class="table-box">
        <table class="basic-table booking-table">
                <thead>
                        <tr>
                            <th>Date et Heure</th>
                            <th>Utilisateur</th>
                            <th>Montant</th> 
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $listerEncaissements as $l)
                        <tr>
                            <td>{{$l->created_at}}</td>
                            <td>{{\App\User::find($l->idUser)->nom}}</td>
                            <td>{{ number_format($l->montantEnc,0,","," ") }}</td> 
                            <td> 
                                <div class="dropdown">
                                    <button class="button gray dropdown-toggle" type="button" id=""
                                            data-toggle="dropdown-toggledown" aria-haspopup="true" aria-expanded="true">
                                        <span class="fa fa-list "></span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="">
                                        <a class="dropdown-item">Detail</a>
                                        <a class="dropdown-item">Editer</a>
                                        <a class="dropdown-item">Supprimer</a>
                                    </div>
                                </div>
                            </td> 
                            
                        </tr>
                        @endforeach
                   
                    </tbody>
        </table>
        </div>
    </div>
    <div class="pagination-container">
        <nav class="pagination">
            <ul>
                <li><a href="#" class="current-page">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#"><i class="sl sl-icon-arrow-right"></i></a></li>
            </ul>
        </nav>
    </div>
</div>

@endsection
