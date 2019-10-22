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
                            <th>Action</th> 
                            <th>Materiel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $listeActions as $l)
                        <tr>
                            <td>{{$l->created_at}}</td>
                            <td>{{\App\User::find($l->idUser)->nom}}</td>
                            <td>{{ $l->libelleAction}}</td> 
                            <td>{{ $l->deviceInfo}}</td> 
                            
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
