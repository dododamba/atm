<template>
    <b-card title="">
        <b-card-text>

            <form v-on:submit.prevent="store()">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="name" class=" form-control-label">Nom</label>
                        <input type="text" id="name" v-model="hotel.nom"
                               placeholder="Nom de l'hotel" class="form-control">
                        <p class="text-danger" v-if="validations">
                            {{ validations.nom }}
                        </p>
                    </div>
                </div>


                  <div class="row">
                       <div class="form-group col-4">
                        <label for="name" class=" form-control-label">Classement</label>
                        <input type="number" id="classement" v-model="hotel.classement"
                               placeholder="Nombre d'etoile" class="form-control">
                        <p class="text-danger" v-if="validations">
                            {{ validations.classement }}
                        </p>
                    </div>
                      <div class="form-group col-4">
                        <label for="name" class=" form-control-label">Adresse</label>
                        <input type="text" id="adresse" v-model="hotel.adresse"
                               placeholder="Adresse de l'hotel" class="form-control">
                        <p class="text-danger" v-if="validations">
                            {{ validations.adresse }}
                        </p>
                    </div>
                    <div class="form-group col-4">
                        <label for="name" class=" form-control-label">Site Internet</label>
                        <input type="text" id="name" v-model="hotel.site_web"
                               placeholder="Site web l'hotel" class="form-control">
                        <p class="text-danger" v-if="validations">
                            {{ validations.site_web }}
                        </p>
                    </div>
                  </div>
                  <div class="row">
                      <div class="form-group col-4">
                        <label for="telephone" class=" form-control-label">Telephone</label>
                        <input type="text" id="telephone" v-model="hotel.telephone"
                               placeholder="Numéro Téléphone de l'hotel" class="form-control">
                        <p class="text-danger" v-if="validations">
                            {{ validations.telephone }}
                        </p>
                    </div>
                    <div class="form-group col-4">
                        <label for="email" class=" form-control-label">Email</label>
                        <input type="text" id="email" v-model="hotel.email"
                               placeholder="Email de l'hotel" class="form-control">
                        <p class="text-danger" v-if="validations">
                            {{ validations.email }}
                        </p>
                    </div>

                    <div class="form-group col-4">
                        <label for="ville" class=" form-control-label">Ville</label>
                        <input type="text" id="ville" v-model="hotel.ville"
                               placeholder="Nom de la ville où se situe l'hotel" class="form-control">
                        <p class="text-danger" v-if="validations">
                            {{ validations.ville }}
                        </p>
                    </div>
                  </div>

                  <div class="row">
                         <div class="form-group col-6">
                        <label for="ville" class=" form-control-label">Longitude</label>
                        <input type="text" id="ville" v-model="hotel.longitude"
                               placeholder="Coodonnées Géographiques" class="form-control">
                        <p class="text-danger" v-if="validations">
                            {{ validations.longitude }}
                        </p>
                    </div>
                       <div class="form-group col-6">
                        <label for="latitude" class=" form-control-label">Latitude</label>
                        <input type="text" id="latitude" v-model="hotel.latitude"
                               placeholder="Coodonnées Géographiques" class="form-control">
                        <p class="text-danger" v-if="validations">
                            {{ validations.latitude }}
                        </p>
                    </div>
                  </div>
                <div class="form-group shadow-textarea">
                    <label for="description">Description</label>
                    <textarea class="form-control z-depth-1" v-model="hotel.description" id="description" rows="3"
                              placeholder="Entrez une description">

                </textarea>
                    <p class="text-danger" v-if="validations">
                        {{ validations.description }}
                    </p>
                </div>

                <hr>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-offset-3 col-sm-3">
                            <button type="submit" class="btn btn-primary form-control">
                                <i class="fa fa-check"></i> Enregistrer
                            </button>
                        </div>
                        <div class="col-sm-offset-3 col-sm-3">
                            <button type="reset" class="btn btn-danger form-control">
                                <i class="fa fa-ban"></i> Recommencer
                            </button>
                        </div>
                    </div>
                </div>

            </form>

        </b-card-text>

    </b-card>
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
                hotel: {
                    nom: '',
                    classement : '',
                    adresse : '',
                    telephone : '',
                    site_web : '',
                    email : '',
                    ville : '',
                    longitude : '',
                    latitude : '',
                    logo : '',
                    description: '',
                    ajouter_par: '',
                }
            }
        },

        mounted() {
            this.get_cuurent_user();
        },
        methods: {
            get_cuurent_user() {
                var _self = this;
                axios.get('/get-connected-user').then(function (response) {
                    _self.connected_user_ = response.data.user;
                    _self.hotel.ajouter_par = _self.connected_user_.id;
                })
            },
            store() {
                var _self = this;
                var _hotel = _self.hotel;
                axios.post('/api/hotelarticle', _hotel)
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