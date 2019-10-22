@extends('layout.app')
@section('content')

        <style>
            .basic-table thead th{
                padding : 5px;
                /*text-align: center;*/
            }
            .basic-table tbody td{
                padding : 5px;
            }
            #find{
                padding : 5px;
                border: 2px solid  midnightblue;
                font-size: 18px;
                color: #333;
                font-weight: bolder;
            }
            #find:focus{
                border: 2px solid  midnightblue;
            }

            fieldset{
                border : 1px solid #ccc;
                min-height: 250px;
                height: 20vh;
                margin-top: 15px;
            }
            fieldset legend{
                width : auto;
                border: none;
                font-size: 17px;
                font-weight: bold;
                text-transform: uppercase;
                color: #40820f;

            }
            .amount{
                padding: 2px;
                color: #fff;

                -webkit-border-radius: 3px;
                -moz-border-radius: 3px;
                border-radius: 3px;
            }
            .totalAmount{
                background-color: dodgerblue;
            }

            .penaliteAmount{
             background-color: orangered;
            }

            .margin-bottom{
                margin-bottom: 20px;
            }

            .border-bottom{
                border-bottom: 1px solid #bbb;
            }

            #montantRecu{
                font-size: 18px;
                font-weight: bold;
                color: darkblue;
            }
            #montantRecu::-webkit-inner-spin-button,
            #montantRecu::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

        </style>
        <div>
            <h3 class="title">{{ $title }} </h3>
        </div>
        <div class="row">
            <div class="col-md-6">
                <fieldset>
                    <legend>Rechercher</legend>
                    <form id="searchForm">
                        {{ csrf_field() }}
                        <div class="form-group col-xs-12">
                            <input type="text" class="form-control" id="find" placeholder="Rechercher">
                        </div>
                    </form>
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <div class="dashboard-list-box">
                                <div class="table-box">
                                    <table class="basic-table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Matricule</th>
                                                <th width="60%">Nom</th>
                                                <th>Fonction</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody id="contribuable-table-body">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                </fieldset>
            </div>
            <div class="col-md-6">
                <fieldset>
                    <legend>A payer</legend>

                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="dashboard-list-box">
                            <div class="table-box margin-bottom border-bottom">
                                <table class="basic-table">
                                    <thead>
                                        <tr>
                                            <th width="20%">Code</th>
                                            <th width="60%">Libelle</th>
                                            <th>Montant/Taux</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listetaxe-table-body">

                                    </tbody>
                                </table>
                            </div>
                            <div class="margin-top">
                                <table>
                                    <tr><td>Penalite (XAF):</td><td><span id="penalite" class="amount penaliteAmount"> 0.0</span></td></tr>
                                    <tr><td>Total (XAF):</td><td><span id="total" class="amount totalAmount">0.0</span></td></tr>
                                </table>

                            </div>
                        </div>
                    </div>

                </fieldset>
            </div>
            <div class="col-md-12">
                <fieldset style="min-height:150px;">
                    <legend>Encaissement</legend>
                    <div class="form-group col-xs-6">
                        <label for="">Montant recu(XAF)</label>
                        <input type="number" name="montantRecu" id="montantRecu" value="0" class="form-control">
                    </div>
                    <div class="form-group col-xs-6">
                        <label for="">Reliquat(XAF)</label>
                        <input type="text" name="" id="reliquat" class="form-control" value="0" disabled="">
                    </div>
                </fieldset>

            </div>
            <div class="col-md-12  ">
                <form id="sendingform">
                    <input type="hidden" name="idUser" value="{{Sentinel::getUser()->id}}">
                    <input type="hidden" name="idContribuable">
                    <input type="hidden" name="idHotel">
                    <input type="hidden" name="idTaxe">
                    <input type="hidden" name="montantEnc">
                    <input type="hidden" name="penalite">

                    <button type="button" class="btn btn-success col-md-3" style="float: right;margin: 10px;" id="btnSendData">Enregistrer</button>
                    <button class="btn btn-danger col-md-3" style="float: right;margin: 10px;">Annuler</button>            
                </form>
            </div>
        </div>

        
            </div>
        </div>
@endsection