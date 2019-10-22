<template>
   
<div>
    <div id="dashboard">

            <!-- Responsive Navigation Trigger -->
            <a href="#" class="dashboard-responsive-nav-trigger"><i class="fa fa-reorder"></i> Dashboard Navigation</a>  

            <div class="dashboard-sticky-nav">
                <div class="content-left pull-left">
                    <a href="dashboard.html"><img src="images/Yatra-white.png" alt="logo"></a>
                </div>
                <div class="content-right pull-right">
                    <div class="search-bar">
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control" id="search" placeholder="Search Now">
                                <a href="#"><span class="search_btn"><i class="fa fa-search" aria-hidden="true"></i></span></a>
                            </div>
                        </form>
                    </div>
                    <div class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <div class="profile-sec">
                                <div class="dash-image">
                                    <img src="images/comment.jpg" alt="">
                                </div>
                                <div class="dash-content">
                                    <h4>Loural Teak</h4>
                                    <span>Post Manager</span>
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
                                <i class="sl sl-icon-envelope-open"></i>
                                <span class="notify">3</span>
                            </div>
                        </a>
                        <div class="dropdown-menu notification-menu">
                        <h4> 23 Messages</h4>
                        <ul>
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
                        <p class="all-noti"><a href="#">See all messages</a></p>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <div class="dropdown-item">
                                <i class="sl sl-icon-bell"></i>
                                <span class="notify">3</span>
                            </div>
                        </a>
                        <div class="dropdown-menu notification-menu">
                            <h4> 599 Notifications</h4>
                            <ul>
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
            <div class="dashboard-nav">
                <div class="dashboard-nav-inner" style="">
                    <ul>
                        <li class="active"><a href="dashboard.html"><i class="sl sl-icon-settings"></i> Dashboard</a></li>
                        <li><a href="dashboard-my-profile.html"><i class="sl sl-icon-user"></i> Edit Profile</a></li>
                        <li><a href="dashboard-addtour.html"><i class="sl sl-icon-plus"></i> Add Tour</a></li>
                        <li>
                            <a><i class="sl sl-icon-layers"></i> Tour Listing</a>
                            <ul>
                                <li><a href="dashboard-list.html">Active <span class="nav-tag green">6</span></a></li>
                                <li><a href="dashboard-list.html">Pending <span class="nav-tag yellow">1</span></a></li>
                                <li><a href="dashboard-list.html">Expired <span class="nav-tag red">2</span></a></li>
                            </ul>   
                        </li>
                        <li><a href="dashboard-booking.html"><i class="sl sl-icon-list"></i> Booking List</a></li>
                        <li><a href="dashboard-history.html"><i class="sl sl-icon-folder"></i> History</a></li>
                        <li><a href="dashboard-reviews.html"><i class="sl sl-icon-star"></i> Reviews</a></li>
                        <li><a href="index.html"><i class="sl sl-icon-power"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
            <div class="dashboard-content">
                <div class="row">

                    <!-- Item -->
                    <div class="col-lg-3 col-md-6 col-xs-6">
                        <div class="dashboard-stat color-1">
                            <div class="dashboard-stat-content"><h4>6</h4> <span>Active Listings</span></div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Map2"></i></div>
                            <div class="dashboard-stat-item"><p>Someone bookmarked your listing!</p></div>
                        </div>
                    </div>

                    <!-- Item -->
                    <div class="col-lg-3 col-md-6 col-xs-6">
                        <div class="dashboard-stat color-2">
                            <div class="dashboard-stat-content"><h4>726</h4> <span>Total Bookings</span></div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                            <div class="dashboard-stat-item"><p>Someone bookmarked your listing!</p></div>
                        </div>
                    </div>


                    <!-- Item -->
                    <div class="col-lg-3 col-md-6 col-xs-6">
                        <div class="dashboard-stat color-3">
                            <div class="dashboard-stat-content"><h4>95</h4> <span>Total Reviews</span></div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Add-UserStar"></i></div>
                            <div class="dashboard-stat-item"><p>Someone bookmarked your listing!</p></div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-xs-6">
                        <div class="dashboard-stat color-4">
                            <div class="dashboard-stat-content"><h4>126</h4> <span>Bookmarks</span></div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Heart"></i></div>
                            <div class="dashboard-stat-item"><p>Someone bookmarked your listing!</p></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12 traffic">
                        <div class="dashboard-list-box">
                            <h4 class="gray">Recent Bookings</h4>
                            <div class="table-box">
                                <table class="basic-table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Booking ID</th>
                                            <th>Destination</th>
                                            <th>No of Tickets</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>01/01/2017</td>
                                            <td class="t-id">C001</td>
                                            <td>Dubai</td>
                                            <td>5</td>
                                            <td>$300.00</td>
                                        </tr>
                                        <tr>
                                            <td>01/01/2017</td>
                                            <td class="t-id">C081</td>
                                            <td>Grece - Zakynthos</td>
                                            <td>5</td>
                                            <td>$300.00</td>
                                        </tr>
                                        <tr>
                                            <td>01/01/2017</td>
                                            <td class="t-id">C001</td>
                                            <td>Bulgary - Sunny Beach</td>
                                            <td>5</td>
                                            <td>$300.00</td>
                                        </tr>
                                        <tr>
                                            <td>01/01/2017</td>
                                            <td class="t-id">C001</td>
                                            <td>France - Paris</td>
                                            <td>5</td>
                                            <td>$300.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="row">      
                    <!-- Recent Activity -->
                    <div class="col-lg-7 col-md-12 col-xs-12 traffic">
                        <div class="dashboard-list-box with-icons margin-top-20">
                            <h4 class="gray">Recent Activities</h4>
                            <ul>
                                <li>
                                    <i class="list-box-icon sl sl-icon-layers"></i> Your listing <strong><a href="#">Hotel Govendor</a></strong> has been approved!
                                    <a href="#" class="close-list-item"><i class="fa fa-close"></i></a>
                                </li>

                                <li>
                                    <i class="list-box-icon sl sl-icon-star"></i> Kathy Brown left a review <div class="numerical-rating high" data-rating="5.0"></div> on <strong><a href="#">Burger House</a></strong>
                                    <a href="#" class="close-list-item"><i class="fa fa-close"></i></a>
                                </li>

                                <li>
                                    <i class="list-box-icon sl sl-icon-heart"></i> Someone bookmarked your <strong><a href="#">Burger House</a></strong> listing!
                                    <a href="#" class="close-list-item"><i class="fa fa-close"></i></a>
                                </li>

                                <li>
                                    <i class="list-box-icon sl sl-icon-star"></i> Kathy Brown left a review <div class="numerical-rating mid" data-rating="3.0"></div> on <strong><a href="#">Airport</a></strong>
                                    <a href="#" class="close-list-item"><i class="fa fa-close"></i></a>
                                </li>

                                <li>
                                    <i class="list-box-icon sl sl-icon-heart"></i> Someone bookmarked your <strong><a href="#">Burger House</a></strong> listing!
                                    <a href="#" class="close-list-item"><i class="fa fa-close"></i></a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 col-xs-12 traffic">
                        <div class="dashboard-list-box margin-top-20 user-list">
                            <h4 class="gray">User List</h4>
                            <ul>
                                <li>
                                    <div class="user-list-item">
                                        <div class="user-list-image">
                                            <img src="images/comment.jpg" alt="">
                                        </div>
                                        <div class="user-list-content">
                                            <h4>Loural Teak</h4>
                                            <span>Post Manager</span>
                                        </div>
                                        <div class="user-btns">
                                            <a href="#" class="button">View</a>
                                            <a href="#" class="button">Edit</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="user-list-item">
                                        <div class="user-list-image">
                                            <img src="images/comment.jpg" alt="">
                                        </div>
                                        <div class="user-list-content">
                                            <h4>Jim Gordon</h4>
                                            <span>Post Manager</span>
                                        </div>
                                        <div class="user-btns">
                                            <a href="#" class="button">View</a>
                                            <a href="#" class="button">Edit</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="user-list-item">
                                        <div class="user-list-image">
                                            <img src="images/comment.jpg" alt="">
                                        </div>
                                        <div class="user-list-content">
                                            <h4>Loural Teak</h4>
                                            <span>Post Manager</span>
                                        </div>
                                        <div class="user-btns">
                                            <a href="#" class="button">View</a>
                                            <a href="#" class="button">Edit</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="user-list-item">
                                        <div class="user-list-image">
                                            <img src="images/comment.jpg" alt="">
                                        </div>
                                        <div class="user-list-content">
                                            <h4>Loural Teak</h4>
                                            <span>Post Manager</span>
                                        </div>
                                        <div class="user-btns">
                                            <a href="#" class="button">View</a>
                                            <a href="#" class="button">Edit</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="user-list-item">
                                        <div class="user-list-image">
                                            <img src="images/comment.jpg" alt="">
                                        </div>
                                        <div class="user-list-content">
                                            <h4>Joseph Dean</h4>
                                            <span>Post Manager</span>
                                        </div>
                                        <div class="user-btns">
                                            <a href="#" class="button">View</a>
                                            <a href="#" class="button">Edit</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- site traffic -->
                    <div class="col-lg-4 col-md-4 mar-b-30">
                        <div class="dashboard-list-box">
                            <h4 class="gray">Site Traffic</h4>
                            <div id="chartContainer" style="height: 250px; width: 100%;"></div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 mar-b-30">
                        <div class="dashboard-list-box">
                            <h4 class="gray">Bar Chart</h4>
                            <div id="barchart" style="height: 250px; width: 100%;"></div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <div class="dashboard-list-box">
                            <h4 class="gray">Search Engine</h4>
                            <div id="piechart" style="height: 250px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Content / End -->
            <!-- Copyrights -->
            <div class="copyrights">
                <p>2018 <i class="fa fa-copyright" aria-hidden="true"></i> Yatra by <a href="https://www.cyclonethemes.com" target="_blank">Cyclone Themes</a></p>
            </div>
        </div>
</div>

</template>

<script>
    import VueAxios from 'vue-axios';
    import axios from 'axios';
    import BootstrapVue from 'bootstrap-vue';
    import Swal from 'sweetalert2'


    Vue.use(BootstrapVue);
    Vue.use(VueAxios, axios);

    export default {
        name: "List",
        data() {
            return {
                items: [],
                message_: '',
                connected_user_: '',
                status_: '',
                validations: [],
                categorie: {
                    nom: '',
                    description: '',
                    ajouter_par: '',
                },


            }
        },
        mounted() {
            this._fetch('/contribuable');
        },
        methods: {
            _fetch(url) {
                let _self = this;
                axios.get(url)
                    .then(function (response) {
                        _self.items = response.data.content;
                    }).catch(function (response) {
                });
            },
            _getCategorie(slug) {
                let _self = this;
                axios.get('/contribuable/' + slug)
                    .then(function (response) {
                        _self.categorie = response.data.content;
                    }).catch(function (response) {
                });
            },

            _setNull() {
                this.categorie = null;
            },
            _delete(item) {
                let _self = this;
            
                Swal.fire({
                    title: 'Confirmer la suppression de la catégorie ' + item.nom +' ' + item.prenoms,
                    html: '<h1><i class="fa fa-warning" style="color: orangered"></i></h1>',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                    cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/contribuable/' + item.slug)
                            .then(function (response) {
                            }).catch(function (response) {
                        });
                        this._fetch('/contribuable');
                        Swal.fire(
                            'Succès !',
                            'La catégorie a été supprimé avec succès!',
                            'success'
                        )

                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'Abandon !',
                            'La suppression n\'a pas été éffectué !',
                            'error'
                        )
                    }
                })
            },
            onUpdate(slug) {
                this.$root.$emit('update-categorie', slug);
            },

            onDetail(slug) {
                let _self = this;
                _self._getCategorie(slug);
                var categorie = _self.categorie;
                var _nom = categorie.nom;
                var _desc = categorie.description;

                Swal.fire({
                    title: '<strong>Détail catégorie</strong>',
                    html:
                        '<p><u>Nom :</u> ' + _nom + ' </p>' +
                        '<p><u> Description :</u>  </p>' + _desc + ' <br>',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,

                });
            }

        }

        
    }
</script>

<style scoped>
</style>