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
            input[type='text'], input[type='number'], textarea, select{
                padding : 5px !important;
                border: 2px solid  midnightblue !important;
                font-size: 18px !important;
                color: #333 !important;
                font-weight: bolder !important;
            }
            #find:focus{
                border: 2px solid  midnightblue;
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

            <div class="col-md-12">
            
                  @if ($errors->any())
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
                        <h4><i class="fa fa-bell-o"></i>Erreurs</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                               <li style="font-size: 1.5rem;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                @endif
                @if(session()->get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
                        <h4><i class="fa fa-bell-o"></i>Felicitations</h4>
                        <p>{{session()->get('success')}}</p>
                    </div>
                @endif
                
                <form action="" method="POST">

                <fieldset style="padding: 15px;" >
                        
                        {{ csrf_field() }}
                        <div class="form-group col-xs-offset-2 col-xs-8">
                            <select  class="form-control" name="idEmp" required >
                                <option>Selectionner un agent</option>
                                @foreach ($listeAgents as $a)
                                    <option value="{{ $a->idEmp}}"> {{ $a->nomEmp}} {{ $a->prenomEmp}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-xs-offset-2 col-xs-8">
                            <select  class="form-control" name="idTaxe" required >
                                <option>Selectionner la taxe</option>
                                @foreach ($listeTaxes as $a)
                                    <option value="{{ $a->id}}"> {{ $a->libelle_taxe}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-xs-offset-2 col-xs-8">
                            <input type="number" class="form-control" id="montant" name="montantEnc" value="0"  required>
                        </div>
                        <div class="form-group col-xs-offset-2 col-xs-8">
                            <textarea type="text" class="form-control" name="Commentaires" placeholder="Commentaires" ></textarea>
                        </div>
                        <div class="form-group col-xs-offset-2 col-xs-8">
                              <input type="submit" class="btn btn-success col-md-3" style="float: right;margin: 10px;" name="send"value="Enregistrer">
                        <button class="btn btn-danger col-md-3" style="float: right;margin: 10px;">Annuler</button>  
                            </div>
                </fieldset>

              </form>
            </div>
          
            
        </div>
       
@endsection