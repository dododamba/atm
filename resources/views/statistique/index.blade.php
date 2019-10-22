@extends('layout.app')
@section('title')
Statistiques
@stop

@section('content')
    <div class="card">
        <div class="card-title">
            <div class="row">
                <div class="col-md-12">
                <h3 class="gray"> <i class="fa fa-chart"></i> Statistiques</h3>
                </div>
               
            </div>
            <hr class="colorgraph"><br>
        </div>
        <div class="card-body">

        <div class="col-lg-12 col-sm-12">
            <div id="add-listing">
                <!-- Section -->
                <div class="add-listing-section">
                    
                        <!-- Headline -->
                        <div class="add-listing-headline">
                            <h3><i class="sl sl-icon-doc"></i> Statistiques </h3>
                        </div>
                        <form action="" method="POST">
                            {{ csrf_field()}}
                        <!-- Title -->
                            <div class="row with-forms">
                                <div class="col-md-12">
                                    <label>Choissez les Statistiques à affichez   <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                    <div id="role" class="form-group {{ $errors->has('role') ? 'has-error' : ''}}">
                                       <div class="col-sm-12">
                                           <select name="stat" id="stat">
                                               <option value=""></option>
                                               <option value="1">Encaissement</option>
                                               <option value="0">Decaissement</option>
                                           </select>
                                       </div>
                                   </div>                            
                                 </div>
                            </div>

                            <div class="row with-forms">
                                <div class="col-md-6">
                                    <label for="">Date début</label>
                                    <input type="date" name="date_debut" value=" {{ old('date_debut') }}">
                                </div>

                                <div class="col-md-6">
                                        <label for="">Date fin</label>
                                        <input type="date" name="date_fin" value="{{ old('date_debut') }}">
                                    </div>

                            </div>
                            <div class="row with-forms">
                                <div class="col-md-12">
                                    <button class="btn btn-warning col-md-12">ACTUALISER</button>
                                </div>
                            </div>
                        </form>
                </div>
                
                <div class="dashboard-list-box">
                    <h4 class="gray">
                        <i class="glyphicon glyhicon-th-list"></i>
                        Historique des encaissements
                        <span><a class="btn btn-sm btn-success" style= "float:right;" id="print-stats">Imprimer</a></span>
                    </h4>

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

                </div>
            </div>
        </div>
    </div>
    <div class="pdfcontainer">
        <iframe id="framepdf" src="" frameborder="0"></iframe>
        <button id="closePdf" class="btn btn-danger customBtnClose">FERMER</button>
    </div>
    <div id="gifloader" style="display: none;">
        <img src="{{  url('images/loader.gif') }}" alt="">
    </div>
@endsection
@section('js')
    <script>
/*      $(document).ready(function(){

        var stat = $('#stat').val();
        console.log(stat)

    }); */
    </script>
@endsection