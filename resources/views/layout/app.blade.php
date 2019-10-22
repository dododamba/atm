
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>@yield('title')</title>


    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
      <style>
          .whiter{
              background: #ffffff;
          }

          .whiter ul li {
            color: black;
          }
      </style>
     @include('layout._css')
     @yield('css')
</head>

<body>


        <div id="container-wrapper">
                <!-- Dashboard -->
                <div id="dashboard">
        
                    <!-- Responsive Navigation Trigger -->
                    <a href="#" class="dashboard-responsive-nav-trigger"><i class="fa fa-reorder"></i> Dashboard Navigation</a>  
                     
                    @include('layout._navbar')
                 
                     @include('layout._sidebar')

        
                    <div class="dashboard-content">
        
                        <div class="row" id="app">
                            @yield('content')
                        </div>
                    </div>
    
                   
                </div>
            </div>
        
        
            <div id="back-to-top">
                <a href="#"></a>
            </div>
        
            @include('layout._footer')   
            @include('layout._js')

@yield('js')
<script src="{{ mix('js/app.js') }}"></script> 
</body>
</html>
