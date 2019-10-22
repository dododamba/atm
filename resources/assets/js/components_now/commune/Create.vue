<template>
    <div class="col-lg-12 col-sm-12">
        <div id="add-listing">
            <form  v-on:submit.prevent="store()" enctype="multipart/form-data">
                <!-- Section -->
                <div class="add-listing-section">

                    <!-- Headline -->
                    <div class="add-listing-headline">
                        <h3><i class="sl sl-icon-doc"></i> Détail Commune</h3>
                    </div>

                    <!-- Title -->

                    <div class="row with-forms">
                        <div class="col-md-6">
                            <label>Nom de la commune <i
                                    class="text-danger glyphicon glyphicon-asterisk"></i></label>
                            <input class="search-field" type="text" v-model="commune.nom_commune">

                            <p class="text-danger" v-if="validations">
                                {{ validations.nom_commune }}
                            </p>

                        </div>
                        <div class="col-md-6">
                            <label>Code de la commune <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                            <input class="search-field" type="text" v-model="commune.code_commune">
                            <p class="text-danger" v-if="validations">
                                {{ validations.code_commune }}
                            </p>
                        </div>
                    </div>

                    <div class="row with-forms">
                        <div class="col-md-12">
                            <label>Fonctionnaire Responsable  de la Commune<i
                                    class="text-danger glyphicon glyphicon-asterisk"></i></label>
                            <select class="chosen-select-no-single" v-model="commune.responsable">
                                <option disabled>Selectioner le fonctionnaire responsable</option>
                                <option value=""></option>
                                <option v-bind:value="r.id" v-for="r in responsables">{{ r.nom }} {{ r.prenom }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="validations">
                                {{ validations.responsable_communal}}
                            </p>
                        </div>

                        <div class="col-md-12">
                            <label>Hotel de ville <i
                                    class="text-danger glyphicon glyphicon-asterisk"></i></label>
                            <select class="chosen-select-no-single" v-model="commune.hotel">
                                <option disabled>Selectioner le fonctionnaire responsable</option>
                                <option value=""></option>
                                <option v-bind:value="r.id" v-for="r in hotels">{{ r.nom_hotel }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="validations">
                                {{ validations.hotel }}
                            </p>
                        </div>
                    </div>

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
                            <input class="search-field" type="text" v-model="commune.contact">
                        </div>
                        <p class="text-danger" v-if="validations">
                            {{ validations.contact }}
                        </p>
                    </div>
                    <div class="row with-forms">
                        <div class="col-md-12">
                            <label>Adresse <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                            <textarea class="search-field" v-model="commune.adresse"></textarea>
                        </div>
                        <p class="text-danger" v-if="validations">
                            {{ validations.adresse }}
                        </p>

                    </div>

                    <div class="row with-forms">
                        <div class="col-md-6">
                            <label>Longitude </label>
                            <input class="search-field" type="text" v-model="commune.longitude">
                            <p class="text-danger" v-if="validations">
                                {{ validations.coord_geo }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label>Latitude </label>
                            <input class="search-field" type="text" v-model="commune.latitude">
                            <p class="text-danger" v-if="validations">
                                {{ validations.latitude }}
                            </p>
                        </div>
                    </div>
                </div>

                 <div class="row with-forms">
                     <button class="button preview" type="submit">Enregistrer <i class="fa fa-arrow-circle-right"></i>
                     </button>
                 </div>
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
                hotels: [],
                commune: {
                    nom_commune: '',
                    code_commune: '',
                    responsable_communal: '',
                    contact: '',
                    hotel: '',
                    adresse: '',
                    longitude: '',
                    latitude: '',
                }
            }
        },

        mounted() {
            this._responsable();
            this._hotel()
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

            _hotel() {
                let _self = this;
                axios.get('/hotel')
                    .then(function (response) {
                        _self.hotels = response.data.content;
                        console.log((_self.hotels))
                    }).catch(function (response) {
                });
            },

            get_cuurent_user() {
                var _self = this;
                axios.get('/get-connected-user').then(function (response) {
                    _self.connected_user_ = response.data.user;
                    _self.commune.ajouter_par = _self.connected_user_.id;
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

                var _commune = {
                    'nom_commune': _self.commune.nom_commune,
                    'code_commune': _self.commune.code_commune,
                    'responsable_communal': _self.commune.responsable,
                    'contact': _self.commune.contact,
                    'hotel': _self.commune.hotel,
                    'adresse': _self.commune.adresse,
                    'coord_geo': _self.commune.longitude,
                    'latitude': _self.commune.latitude,
                };

                let formData = new FormData();
                formData.append('file', this.image);
                const config = {

                    headers: { 'content-type': 'multipart/form-data' }

                }



                axios.post('/commune', _commune)
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