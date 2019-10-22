<template>
    <div class="col-lg-12 col-sm-12">
        <div id="add-listing">
            <form  v-on:submit.prevent="store()" enctype="multipart/form-data">
                <!-- Section -->
                <div class="add-listing-section">

                    <!-- Headline -->
                    <div class="add-listing-headline">
                        <h3><i class="sl sl-icon-doc"></i> Détail Hotel de Ville</h3>
                    </div>

                    <!-- Title -->

                    <div class="row with-forms">
                        <div class="col-md-6">
                            <label>Nom de l'Hotel de Ville <i
                                    class="text-danger glyphicon glyphicon-asterisk"></i></label>
                            <input class="search-field" type="text" v-model="hotel.nom_hotel">

                            <p class="text-danger" v-if="validations">
                                {{ validations.nom_hotel }}
                            </p>

                        </div>
                        <div class="col-md-6">
                            <label>Ville <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                            <input class="search-field" type="text" v-model="hotel.ville">
                            <p class="text-danger" v-if="validations">
                                {{ validations.ville }}
                            </p>
                        </div>
                    </div>

                    <div class="row with-forms">
                        <div class="col-md-12">
                            <label>Fonctionnaire Responsable <i
                                    class="text-danger glyphicon glyphicon-asterisk"></i></label>
                            <select class="chosen-select-no-single" v-model="hotel.responsable">
                                <option disabled>Selectioner le fonctionnaire responsable</option>
                                <option value=""></option>
                                <option v-bind:value="r.id" v-for="r in responsables">{{ r.nom }} {{ r.prenom }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="validations">
                                {{ validations.responsable }}
                            </p>
                        </div>
                    </div>

                   <!--

                    <div class="row with-forms">
                        <div class="col-md-12">
                            <div v-if="!image">
                                <label>Logo</label>
                                <input @change="onFileChange"  type="file"/>
                            </div>
                            <div v-else>
                                <img :src="image"/>
                                <button @click="removeImage" class="button"><i class="glyphicon glyphicon-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>


                   -->
                </div>

                <!-- Section -->
                <div class="add-listing-section">

                    <!-- Headline -->
                    <div class="add-listing-headline">
                        <h3><i class="sl sl-icon-doc"></i>Adresse</h3>
                    </div>

                    <!-- Title -->
                    <div class="row with-forms">
                        <div class="col-md-12">
                            <label>Contact <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                            <input class="search-field" type="text" v-model="hotel.contact">
                        </div>
                        <p class="text-danger" v-if="validations">
                            {{ validations.contact }}
                        </p>
                    </div>
                    <div class="row with-forms">
                        <div class="col-md-12">
                            <label>Adresse <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                            <textarea class="search-field" v-model="hotel.adresse"></textarea>
                        </div>
                        <p class="text-danger" v-if="validations">
                            {{ validations.adresse }}
                        </p>

                    </div>

                    <div class="row with-forms">
                        <div class="col-md-6">
                            <label>Longitude </label>
                            <input class="search-field" type="text" v-model="hotel.longitude">
                            <p class="text-danger" v-if="validations">
                                {{ validations.logitude }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label>Latitude </label>
                            <input class="search-field" type="text" v-model="hotel.latitude">
                            <p class="text-danger" v-if="validations">
                                {{ validations.latitude }}
                            </p>
                        </div>
                    </div>
                </div>

                <button class="button preview" type="submit">Enregistrer <i class="fa fa-arrow-circle-right"></i>
                </button>
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
                image: '',
                responsables: [],
                hotel: {
                    nom_hotel: '',
                    ville: '',
                    responsable: '',
                    contact: '',
                    logo: '',
                    adresse: '',
                    longitude: '',
                    latitude: '',
                }
            }
        },

        mounted() {
            this._responsable();
        },
        methods: {

            _responsable() {
                let _self = this;
                axios.get('/responsable')
                    .then(function (response) {
                        _self.responsables = response.data.content.data;
                    }).catch(function (response) {
                });
            },


            get_cuurent_user() {
                var _self = this;
                axios.get('/get-connected-user').then(function (response) {
                    _self.connected_user_ = response.data.user;
                    _self.hotel.ajouter_par = _self.connected_user_.id;
                })
            },

            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            removeImage: function (e) {
                this.image = '';
            },

            store() {
                var _self = this;

                var _hotel = {
                    'nom_hotel': _self.hotel.nom_hotel,
                    'ville': _self.hotel.ville,
                    'responsable': _self.hotel.responsable,
                    'contact': _self.hotel.contact,
                    'logo': _self.image,
                    'adresse': _self.hotel.adresse,
                    'longitude': _self.hotel.longitude,
                    'latitude': _self.hotel.latitude,
                };

                let formData = new FormData();
                formData.append('file', _hotel);
                const config = {

                    headers: { 'content-type': 'multipart/form-data' }

                }



                axios.post('/hotel', _hotel)
                    .then(function (response) {
                        _self.message_ = response.data.content.message;
                        _self.status_ = response.data.content.status;
                        _self.validations = response.data.content.error;

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
    img {
        width: 30%;
        margin: auto;
        display: block;
        margin-bottom: 10px;
    }
</style>