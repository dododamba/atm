<style>
    .content-left{
        background-color: #00529400;
        padding : 0;
    }

    .content-left img {
        width: 300px;
        height: 100px;
    }

</style>
                    <div class="dashboard-sticky-nav" style="background-color: #ededed;">
                            <div class="content-left pull-left">
                                <a href="{{url('/')}}"><img src="{{url('images/logo.jpg')}}" alt="logo" width="100" height="50"></a>
                            </div>
                            <div class="content-right pull-right" style="width:50%">
                                <div class="search-bar" style="padding:0; ">
                                   <img src="{{url('images/logo-mairie.png')}}" alt="" style="width: 80px;">
                                </div>
                                <div class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown">
                                        <div class="profile-sec">
                                            <div class="dash-image">
                                                <img src="images/comment.jpg" alt="">
                                            </div>
                                            <div class="dash-content">
                                                <h4>{{$connected->nom}} {{$connected->prenom}}</h4>
                                                <span> {{$connected->getRole->name}}</span>
                                            </div>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#"><i class="sl sl-icon-settings"></i>Settings</a></li>
                                        <li><a href="#"><i class="sl sl-icon-user"></i>Profile</a></li>
                                        <li><a href="#"><i class="sl sl-icon-lock"></i>Change Password</a></li>
                                        <li><a href="#"><i class="sl sl-icon-power"></i>Logout</a></li>
                                    </ul>
                                </div>
                           
                                <div class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown">
                                        <div class="dropdown-item">
                                            <i class="sl sl-icon-bell"></i>
                                            <span class="notify">2</span>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu notification-menu">
                                        <h4> 2 Notifications</h4>
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <div class="notification-item">
                                                        <div class="notification-image">
                                                            <img src="images/comment.jpg" alt="">
                                                        </div>
                                                        <div class="notification-content">
                                                            <p>Retard de paiement(MATR001).</p><span class="notification-time">il y a 2 heures</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="notification-item">
                                                        <div class="notification-image">
                                                            <img src="images/comment.jpg" alt="">
                                                        </div>
                                                        <div class="notification-content">
                                                            <p>You have a notification.</p><span class="notification-time">2 hours ago</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                          
                                        </ul>
                                        <p class="all-noti"><a href="#">See all notifications</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>