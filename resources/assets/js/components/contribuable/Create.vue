<template>
    <div class="col-lg-12 col-sm-12">
        <p class="text-danger">Les champs marqués par un ( <i class="text-danger glyphicon glyphicon-asterisk"></i>)
            sont obligatoires !</p>
        <div id="add-listing">

            <form v-on:submit.prevent="store()">


                <div class="add-listing-section">

                    <!-- Headline -->
                    <div class="add-listing-headline">
                        <h3><i class="sl sl-icon-doc"></i> Informations du Contribuable </h3>
                    </div>

                    <fieldset>
                        <legend><b> Activités </b> </legend>
                        <div class="row with-forms">
                            <div class="col-md-6">
                                <label>Chiffre d'affaire <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                <input v-model="contribuable.nom" class="search-field" type="text" value="">
                                <p class="text-danger" v-if="validations">
                                    {{ validations.nom }}
                                </p>
                            </div>

                            <div class="col-md-6">
                                <label>Capital <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                <input v-model="contribuable.prenoms" class="search-field" type="text" value="">
                                <p class="text-danger" v-if="validations">
                                    {{ validations.prenoms }}
                                </p>
                            </div>

                        </div>

                        <div class="row with-forms">


                            <div class="col-md-12">
                                <label>Categorie <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                <select class="chosen-select-no-single" v-model="contribuable.categorie">
                                    <option disabled>Selectioner une Catégorie</option>
                                    <option value=""></option>
                                    <option v-bind:value="r.id" v-for="r in categories">{{ r.libelle }}</option>
                                </select>
                                <p class="text-danger" v-if="validations">
                                    {{ validations.categorie }}
                                </p>
                            </div>

                        </div>
                    </fieldset>
                    <!-- Title -->
                    <fieldset>
                        <legend><b> Proprietaire </b> </legend>
                        <div class="row with-forms">
                            <div class="col-md-6">
                                <label>Nom <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                <input v-model="contribuable.nom" class="search-field" type="text" value="">
                                <p class="text-danger" v-if="validations">
                                    {{ validations.nom }}
                                </p>
                            </div>

                            <div class="col-md-6">
                                <label>Prenom <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                <input v-model="contribuable.prenoms" class="search-field" type="text" value="">
                                <p class="text-danger" v-if="validations">
                                    {{ validations.prenoms }}
                                </p>
                            </div>

                        </div>

                        <div class="row with-forms">

                            <div class="col-md-6">
                                <label>N ° Pièce d'identité <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                <input v-model="contribuable.num_piece_id" class="search-field" type="text" value="">
                                <p class="text-danger" v-if="validations">
                                    {{ validations.num_piece_id }}
                                </p>
                            </div>

                            <div class="col-md-6">
                                <label>Situaion Matimoniale </label>
                                <input v-model="contribuable.situation_matri" class="search-field" type="text" value="">
                            </div>

                        </div>
                    </fieldset>


                </div>


                <!-- Section -->
                <div class="add-listing-section">

                    <!-- Headline -->
                    <div class="add-listing-headline">
                        <h3><i class="sl sl-icon-doc"></i> Informations du Gerant </h3>
                    </div>

                    <!-- Title -->
                    <div class="row with-forms">
                        <div class="col-md-6">
                            <label>Nom <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                            <input v-model="contribuable.nom" class="search-field" type="text" value="">
                            <p class="text-danger" v-if="validations">
                                {{ validations.nom }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label>Prenom <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                            <input v-model="contribuable.prenoms" class="search-field" type="text" value="">
                            <p class="text-danger" v-if="validations">
                                {{ validations.prenoms }}
                            </p>
                        </div>

                    </div>

                    <div class="row with-forms">
                        <!-- <div class="col-md-6">
                             <label>Matricule </label>
                             <input v-model="contribuable.matricule" class="search-field" type="text" value="">
                         </div> -->
                        <div class="col-md-6">
                            <label>N ° Pièce d'identité <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                            <input v-model="contribuable.num_piece_id" class="search-field" type="text" value="">
                            <p class="text-danger" v-if="validations">
                                {{ validations.num_piece_id }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label>Situaion Matimoniale </label>
                            <input v-model="contribuable.situation_matri" class="search-field" type="text" value="">
                        </div>

                    </div>


                    <!--

                         <div class="row with-forms">
                   <div class="col-md-4">
                       <label>Situaion Matimoniale </label>
                       <input v-model="contribuable.situation_matri" class="search-field" type="text" value="">
                   </div>

                        <div class="col-md-4">
                       <label>Nombre des femmes </label>
                       <input v-model="contribuable.nb_femmes" class="search-field" type="number" value="">
                   </div>

                   <div class="col-md-4">
                       <label>Nombre d'enfant </label>
                       <input v-model="contribuable.nb_enfants" class="search-field" type="number" value="">
                   </div>


                                                   </div>

                                                   <div class="col-md-4">
                       <label>Categorie <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                      <select class="chosen-select-no-single" v-model="contribuable.categorie">
                           <option disabled>Selectioner une Catégorie</option>
                           <option value=""></option>
                           <option v-bind:value="r.id" v-for="r in categories">{{ r.libelle }}</option>
                        </select>
                     <p class="text-danger" v-if="validations">
                      {{ validations.categorie }}
                   </p>
                    </div>



                <div class="row with-forms">
                   <div class="col-md-4">
                       <label>Date de naissance <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                       <input v-model="contribuable.date_naissance" class="search-field" type="date" value="">
                  <p class="text-danger" v-if="validations">
                      {{ validations.date_naissance }}
                   </p>
                   </div>

                    <div class="col-md-4">
                       <label>Fonction <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                       <input v-model="contribuable.fonction" class="search-field" type="text" value="">
                   <p class="text-danger" v-if="validations">
                      {{ validations.fonction }}
                   </p>
                   </div>

               </div>

                   -->


                    <!-- Row -->

                    <!-- Row / End -->
                </div>
                <!-- Section / End -->

                <!-- Section -->
                <div class="add-listing-section">

                    <!-- Headline -->
                    <div class="add-listing-headline">
                        <h3><i class="sl sl-icon-map"></i> Adresse</h3>
                    </div>

                    <div class="submit-section">

                        <!-- Row -->
                        <div class="row with-forms">

                            <!-- City -->

                            <!-- Address -->
                            <div class="col-md-6">
                                <label>Address</label>
                                <input v-model="contribuable.adresse" type="text" placeholder="e.g. 964 School Street">
                            </div>

                            <!-- City -->
                            <div class="col-md-6">
                                <label>Telephone</label>
                                <input v-model="contribuable.tel" type="text">
                            </div>

                            <div class="col-md-6">
                                <label>Email</label>
                                <input v-model="contribuable.email" type="text">
                            </div>

                            <!-- Zip-Code -->
                            <div class="col-md-6">
                                <label>Ville de resirence</label>
                                <input v-model="contribuable.ville_residence" type="text">
                            </div>

                            <!-- Row


                             <div class="col-md-6">
                                                                      <label>Pays de residence</label>
                                                                      <input v-model="contribuable.pays_residence" type="text">
                                                                  </div>


                            / End -->

                        </div>
                        <!-- Row / End -->

                    </div>
                </div>
                <!-- Section / End -->


                <button type="submit" class="button preview">Enregistrer <i class="fa fa-arrow-circle-right"></i>
                </button>




                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form id="msform">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active">Personal Details</li>
                                <li>Social Profiles</li>
                                <li>Account Setup</li>
                            </ul>
                            <!-- fieldsets -->
                            <fieldset>
                                <h2 class="fs-title">Personal Details</h2>
                                <h3 class="fs-subtitle">Tell us something more about you</h3>
                                <input type="text" name="fname" placeholder="First Name"/>
                                <input type="text" name="lname" placeholder="Last Name"/>
                                <input type="text" name="phone" placeholder="Phone"/>
                                <input type="button" name="next" class="next action-button" value="Next"/>
                            </fieldset>
                            <fieldset>
                                <h2 class="fs-title">Social Profiles</h2>
                                <h3 class="fs-subtitle">Your presence on the social network</h3>
                                <input type="text" name="twitter" placeholder="Twitter"/>
                                <input type="text" name="facebook" placeholder="Facebook"/>
                                <input type="text" name="gplus" placeholder="Google Plus"/>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                <input type="button" name="next" class="next action-button" value="Next"/>
                            </fieldset>
                            <fieldset>
                                <h2 class="fs-title">Create your account</h2>
                                <h3 class="fs-subtitle">Fill in your credentials</h3>
                                <input type="text" name="email" placeholder="Email"/>
                                <input type="password" name="pass" placeholder="Password"/>
                                <input type="password" name="cpass" placeholder="Confirm Password"/>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                <input type="submit" name="submit" class="submit action-button" value="Submit"/>
                            </fieldset>
                        </form>
                        <!-- link to designify.me code snippets -->
                        <div class="dme_link">
                            <p><a href="http://designify.me/code-snippets-js/" target="_blank">More Code Snippets</a></p>
                        </div>
                        <!-- /.link to designify.me code snippets -->
                    </div>
                </div>




            </form>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Swal from 'sweetalert2';
    require('./form')

    export default {

        data() {
            return {
                message_: '',
                connected_user_: '',
                status_: '',
                validations: [],
                categories: [],
                contribuable: {
                    matricule: '',
                    num_piece_id: '',
                    nom: '',
                    prenoms: '',
                    situation_matri: '',
                    nb_enfants: '',
                    nb_femmes: '',
                    date_naissance: '',
                    pays_residence: '',
                    ville_residence: '',
                    adresse: '',
                    tel: '',
                    email: '',
                    fonction: '',
                    service_direction: '',
                    is_fonctionnaire: '',
                    is_corp_habille: '',
                    is_enseignant: '',
                    salaire: '',
                    categorie: '',

                }
            }
        },

        mounted() {
            this._categorie();
        },


        methods: {
            _categorie() {
                let _self = this;
                axios.get('/contribuablecat')
                    .then(function (response) {
                        _self.categories = response.data.content.data;
                        console.log(_self.categories)
                    }).catch(function (response) {
                });
            },

            get_cuurent_user() {
                var _self = this;
                axios.get('/get-connected-user').then(function (response) {
                    _self.connected_user_ = response.data.user;
                    _self.categorie.ajouter_par = _self.connected_user_.id;
                })
            },
            store() {
                var _self = this;
                var _contribuable = _self.contribuable;
                axios.post('/contribuable', _contribuable)
                    .then(function (response) {
                        _self.message_ = response.data.content.message;
                        _self.status_ = response.data.content.status;
                        _self.validations = response.data.content.error;

                        console.log(_self.message_, _self.validations, _self.status_)
                        if (_self.status_ === 1) {
                            Swal.fire(
                                'Succès!',
                                _self.message_,
                                'success'
                            )
                        }
                        if (_self.status_ === 0) {
                            Swal.fire(
                                'Echec!',
                                _self.message_,
                                'error'
                            )
                        }


                    }).catch(function (response) {

                });
            }
        }

    }
</script>

<style scoped>
    .fieldset {
        position: relative;
        padding: 10px;
        border: 1px solid #1F497D;
        border-radius: 5px;
    }

    legend
    {
        font-size:14px;
        font-weight:bold;
        margin-bottom: 0px;
        width: 35%;
        color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px 5px 5px 10px;
        background-color: #1F497D;
    }



    /*form styles*/
    #msform {
        text-align: center;
        position: relative;
        margin-top: 30px;
    }

    #msform fieldset {
        background: white;
        border: 0 none;
        border-radius: 0px;
        box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.4);
        padding: 20px 30px;
        box-sizing: border-box;
        width: 80%;
        margin: 0 10%;

        /*stacking fieldsets above each other*/
        position: relative;
    }

    /*Hide all except first fieldset*/
    #msform fieldset:not(:first-of-type) {
        display: none;
    }

    /*inputs*/
    #msform input, #msform textarea {
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 0px;
        margin-bottom: 10px;
        width: 100%;
        box-sizing: border-box;
        font-family: montserrat;
        color: #2C3E50;
        font-size: 13px;
    }

    #msform input:focus, #msform textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: 1px solid #ee0979;
        outline-width: 0;
        transition: All 0.5s ease-in;
        -webkit-transition: All 0.5s ease-in;
        -moz-transition: All 0.5s ease-in;
        -o-transition: All 0.5s ease-in;
    }

    /*buttons*/
    #msform .action-button {
        width: 100px;
        background: #ee0979;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 25px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }

    #msform .action-button:hover, #msform .action-button:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #ee0979;
    }

    #msform .action-button-previous {
        width: 100px;
        background: #C5C5F1;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 25px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }

    #msform .action-button-previous:hover, #msform .action-button-previous:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #C5C5F1;
    }

    /*headings*/
    .fs-title {
        font-size: 18px;
        text-transform: uppercase;
        color: #2C3E50;
        margin-bottom: 10px;
        letter-spacing: 2px;
        font-weight: bold;
    }

    .fs-subtitle {
        font-weight: normal;
        font-size: 13px;
        color: #666;
        margin-bottom: 20px;
    }

    /*progressbar*/
    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        /*CSS counters to number the steps*/
        counter-reset: step;
    }

    #progressbar li {
        list-style-type: none;
        color: white;
        text-transform: uppercase;
        font-size: 9px;
        width: 33.33%;
        float: left;
        position: relative;
        letter-spacing: 1px;
    }

    #progressbar li:before {
        content: counter(step);
        counter-increment: step;
        width: 24px;
        height: 24px;
        line-height: 26px;
        display: block;
        font-size: 12px;
        color: #333;
        background: white;
        border-radius: 25px;
        margin: 0 auto 10px auto;
    }

    /*progressbar connectors*/
    #progressbar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: white;
        position: absolute;
        left: -50%;
        top: 9px;
        z-index: -1; /*put it behind the numbers*/
    }

    #progressbar li:first-child:after {
        /*connector not needed before the first step*/
        content: none;
    }

    /*marking active/completed steps green*/
    /*The number of the step and the connector before it = green*/
    #progressbar li.active:before, #progressbar li.active:after {
        background: #ee0979;
        color: white;
    }


    /* Not relevant to this form */
    .dme_link {
        margin-top: 30px;
        text-align: center;
    }
    .dme_link a {
        background: #FFF;
        font-weight: bold;
        color: #ee0979;
        border: 0 none;
        border-radius: 25px;
        cursor: pointer;
        padding: 5px 25px;
        font-size: 12px;
    }

    .dme_link a:hover, .dme_link a:focus {
        background: #C5C5F1;
        text-decoration: none;
    }
</style>