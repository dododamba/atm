<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Connection</title>
  @include('auth._css')

</head>
<body>
  	<div class="limiter">
        <div class="container-login100">
          <div class="wrap-login100" style="background: #00417C;">
             <form action="{{route('login')}}" method="POST" class="login100-form validate-form">
                {{ csrf_field() }}

             @if (Session::has('message'))
             
             <div class="alert alert-{{(Session::get('status')=='error')?'danger':Session::get('status')}} " alert-dismissable fade in id="sessions-hide">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               <strong>{{Session::get('status')}}!</strong> {!! Session::get('message') !!}
               </div>
                @endif
 
               @if ($errors->has('global'))
                   <div class="sufee-danger alert with-close alert-danger alert-dismissible fade show">
                       <span class="badge badge-pill badge-errot">Erreur</span>
                       <strong>{{ $errors->first('global') }}</strong>
 
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
               @endif
 
              <span class="login100-form-logo">
                <img src="{{url('images/logo-mairie.png')}}" alt="" style="width: 140px;">
              </span>
    
              <span class="login100-form-title p-b-34 p-t-27">
               Connexion
              </span>
    
              <div class="wrap-input100 validate-input" data-validate = "Enter username">
                {!! Form::text('email', null, ['class' => 'input100','placeholder '=>'Matricule']) !!}
                {!! $errors->first('email', '<p class="help-block text-danger">:message</p>') !!}
                <span class="focus-input100" data-placeholder="&#xf207;"></span>
              </div>
    
              <div class="wrap-input100 validate-input" data-validate="Enter password">
                {!! Form::password('password', ['class' => 'input100','placeholder '=>'Mot de passe']) !!}
                {!! $errors->first('password', '<p class="help-block text-danger">:message</p>') !!}
                <span class="focus-input100" data-placeholder="&#xf191;"></span>
              </div>
        
              <div class="container-login100-form-btn">
                <button class="login100-form-btn"  name="Submit" type="submit">
                  Connexion
                </button>
              </div>
    
              <div class="text-center p-t-90">
                <a class="txt1" href="#">
                  Mot de pass oublié?
                </a>
              </div>
             {!! Form::close() !!}
            </div>
        </div>
      </div>

</body>
</html>