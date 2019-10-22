<style>
    .dashboard-nav{
        background-color: #005294;
        font-family: Times, 'Helvetica Neue', Helvetica, sans-serif
        font-size: 0.2cm
    }
    .dashboard-nav ul li a{
        color: #fff;
    }

    .dashboard-nav ul li{
        font-size:20px;
    }

    .dashboard-nav-inner{
        background-color: #005294;
        max-height: 600px;

    }

    .dashboard-nav ul li{
        border-color : #005294;
    }

   



</style>
<div class="dashboard-nav whiter" style=" overflow: scroll; ">
        <div class="dashboard-nav-inner ">
            <ul style="margin-bottom: 120px;">
                <li><a href="{{url('dashboard')}}"><i class="im im-icon-Dashboard"></i> Tableau de bord</a></li>

                <li class="<?php if(url()->current() == url("encaisser") || url()->current() == url("recette") ){echo 'active';}  ?>" >
                    <a><i class="im im-icon-Money-Bag"></i> Caisse </a>
                    <ul>
                        <li  ><a href="{{url('versement')}}">Encaisser versement </a></li>
                        <li  ><a href="{{url('encaisser')}}">Encaisser paiement </a></li>
                        <li><a href="{{url('recette')}}">Recette</a></li>
                    </ul>
                </li>
                <li><a href="#"><i class="im im-icon-Dollar"></i> Recouvrement </a></li>

                <li class="<?php if(url()->current() == url("user") || url()->current() == url("role") || url()->current() == url("historique") ){echo 'active';}  ?>" >
                    <a><i class="fa fa-tasks"></i>  Contribuables </a>
                    <ul>
                        <li><a href="{{route('pages.liste-categorietaxe')}}">Catégorie de taxe </a></li>
                        <li><a href="{{route('pages.liste-taxes')}}">Liste des Taxes </a></li>
                        <li><a href="{{route('pages.liste-categoriecontribuables')}}">Categories Contribuables </a></li>
                        <li><a href="{{route('pages.liste-contribualbes')}}">Contribuables </a></li>
                    

                    </ul>
                </li>

                <li><a href="{{ url('statistiques') }}"><i class="im im-icon-Bar-Chart3"></i> Statistiques</a></li>

                <li class="<?php if(url()->current() == url("user") || url()->current() == url("role") || url()->current() == url("historique") ){echo 'active';}  ?>" >
                    <a><i class="sl sl-icon-settings"></i> Paramètres </a>
                    <ul>
                        
                        <li><a href="{{url('user')}}?type=admin">Employés </a></li>
                        <li><a href="{{url('user')}}?type=admin">Utilisateurs </a></li>
                        <li><a href="{{url('role')}}">Role et permissions</a></li>
                        <li><a href="{{route('pages.liste-communes')}}">Communes </a></li>
                        <li><a href="{{route('pages.liste-hotels')}}">Hotel de ville </a></li>
                        <li><a href="historiques"> Historiques</a></li>                          

                    </ul>
                </li>
                
                <li><a href="{{url('/logout')}}"><i class="sl sl-icon-power"></i> Se Deconnecter</a></li>
            </ul>
        </div>
    </div>