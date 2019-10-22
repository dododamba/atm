@extends('layout.app')
@section('content')


<!-- 

<dashboard></dashboard>
 -->


                <div class="row">

                    <!-- Item -->
                    <div class="col-lg-4 col-md-6 col-xs-6">
                        <div class="dashboard-stat color-1">
                            <div class="dashboard-stat-content"><h4> <?php  echo number_format($ca_jours,0,'.',' ') ?></h4> <span>Encaissements du jour  </span></div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Map2"></i></div>
                            <div class="dashboard-stat-item"><p>{{ date("Y-m-d  H:i:s")}}</p></div>
                        </div>
                    </div>

                    <!-- Item -->
                    <div class="col-lg-4 col-md-6 col-xs-6">
                        <div class="dashboard-stat color-2">
                            <div class="dashboard-stat-content"><h4>{{number_format($ca_mois,0,'.',' ') }}</h4> <span>Encaissements du mois</span></div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                            <div class="dashboard-stat-item"><p>{{ date("M-Y")}}</p></div>
                        </div>
                    </div>


                    <!-- Item -->
                    <div class="col-lg-4 col-md-6 col-xs-6">
                        <div class="dashboard-stat color-4">
                            <div class="dashboard-stat-content"><h4>{{$total_contribuables}}</h4> <span>Nombre de Contribuables</span></div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Add-UserStar"></i></div>
                            <div class="dashboard-stat-item"><p>Nombre de tous les contribuables !</p></div>
                        </div>
                    </div>

                  
                </div>


              
                <div class="row">
                    <h4 class="gray"> Recettes par taxes</h4>
                    <div class="col-lg-12 col-md-12 col-xs-12 traffic">
                        <div class="dashboard-list-box">
                            <div class="table-box">

                                <table class="basic-table">
                                    <thead class="gray">
                                        <tr>
                                            <th>id</th>
                                            <th>Categorie</th>                          
                                            <th>Total du mois</th>       
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ca_by_taxe as $line )
                                        <tr>
                                            <td>{{$line->id}}</td>
                                            <td>{{$line->libelle_taxe}}</td>
                                            <td>{{ number_format($line->montant,0,"."," ")}}</td>    
                                        </tr>
                                        @endforeach                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>  
                </div>

                 <div class="row">
                    <h4 class="gray"> Recettes par categorie de taxes</h4>
                    <div class="col-lg-12 col-md-12 col-xs-12 traffic">
                        <div class="dashboard-list-box">
                            <div class="table-box">

                                <table class="basic-table">
                                    <thead class="gray">
                                        <tr>
                                            <th>id</th>
                                            <th>Nom de la taxe </th>
                                            <th>Total du mois</th>       
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ca_by_cat as $line )
                                        <tr>
                                            <td>{{$line->id}}</td>                      
                                            <td>{{$line->libelle}}</td>
                                            <td>{{ number_format($line->montant,0,","," ")}}</td>
                                        </tr>
                                        @endforeach                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>  
                </div>
             
          
            </div>
            
        
@endsection