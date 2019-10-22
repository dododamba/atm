<template>
   <div class="col-lg-12 col-sm-12">
       <p class="text-danger">Les champs marqués par un ( <i class="text-danger glyphicon glyphicon-asterisk"></i>) sont obligatoires !</p>
                        <div id="add-listing">

            <form v-on:submit.prevent="store()">
                            <!-- Section -->
                            <div class="add-listing-section">

                                <!-- Headline -->
                                <div class="add-listing-headline">
                                    <h3><i class="sl sl-icon-doc"></i> Informations</h3>
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
                                    <div class="col-md-6">
                                        <label>Matricule </label>
                                        <input v-model="contribuable.matricule" class="search-field" type="text" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <label>N ° Pièce d'identité <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                        <input v-model="contribuable.num_piece_id" class="search-field" type="text" value="">
                                  <p class="text-danger" v-if="validations">
                                       {{ validations.num_piece_id }}
                                    </p>
                                    </div>

                                </div>

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

                                </div>

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

                                        <div class="col-md-6">
                                            <label>Pays de residence</label>
                                            <input v-model="contribuable.pays_residence" type="text">
                                        </div>

                                    </div>
                                    <!-- Row / End -->

                                </div>
                            </div>
                            <!-- Section / End -->




                            <button type="submit" class="button preview">Enregistrer <i class="fa fa-arrow-circle-right"></i></button>
                </form>
                        </div>
                    </div>
</template>

<script>
    import axios from 'axios';
    import Swal from 'sweetalert2';

    export default {

        data() {
            return {
                message_: '',
                connected_user_: '',
                status_: '',
                validations: [],
                categories : [],
                contribuable: {
                    matricule : '',
                    num_piece_id : '',
                    nom : '',
                    prenoms : '',
                    situation_matri : '',
                    nb_enfants : '',
                    nb_femmes : '',
                    date_naissance : '',
                    pays_residence : '',
                    ville_residence : '',
                    adresse : '',
                    tel : '',
                    email : '',
                    fonction : '',
                    service_direction : '',
                    is_fonctionnaire : '',
                    is_corp_habille : '',
                    is_enseignant : '',
                    salaire : '',
                    categorie : '',

                }
            }
        },

        mounted() {
            this._categorie();
        },


        methods: {
             _categorie(){
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

</style>