<template>
    <b-card title="">
        <b-card-text>

            <form v-on:submit.prevent="store()">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="name" class=" form-control-label">Nom <strong class="text-danger">(*)</strong></label>
                        <input type="text" id="name" v-model="ville.nom"
                               placeholder="Nom de la ville" class="form-control">
                        <p class="text-danger" v-if="validations">
                            {{ validations.nom }}
                        </p>
                    </div>
                </div>


                <div class="row">

                    <div class="col-md-12">
                        <label class="text-dark font-weight-medium" for="">Pays <strong class="text-danger">(*)</strong></label>
                        <div class="form-group">
                            <select class="form-control" v-model="ville.pays" @onchange="get_decoupage_un">
                                <option disabled>Selectioner un pays</option>
                                <option value=""></option>
                                <option v-bind:value="r.id" v-for="r in pays">{{ r.nom }}</option>
                            </select>
                        </div>
                        <p id="red" v-if="validations">
                            {{ validations.pays }}
                        </p>
                        <p style="font-size: 90%">ex. Tchad</p>
                    </div>

                    <!--
                    <div class="col-md-6">
                        <label class="text-dark font-weight-medium" for="">Découpage un <strong
                                class="text-danger">(*)</strong></label>
                        <div class="form-group">
                            <select class="form-control" v-model="ville.decoupage_un">
                                <option disabled>Selectioner un decoupage_un</option>
                                <option value=""></option>
                                <option v-bind:value="r.id" v-for="r in decoupage_un">{{ r.nom }}</option>
                            </select>
                        </div>
                        <p id="red" v-if="validations">
                            {{ validations.decoupage_un }}
                        </p>
                        <p style="font-size: 90%">ex. Tchad</p>
                    </div>
                     -->

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
                pays: [],
                decoupage_un: [],

                ville: {
                    nom: '',
                    pays: ''
                    ,
                }
            }
        },

        mounted() {
            this.get_pays();
        },
        methods: {
            get_pays() {
                var _self = this;
                axios.get('/pays').then(function (response) {
                    _self.pays = response.data.content.pays.data;
                })
            },
            get_decoupage_un() {
                var _self = this;
                axios.get('/pays/' + id + '/decoupage').then(function (response) {
                    _self.decoupage_un = response.data.content;
                })
            },
            store() {
                var _self = this;
                var _ville = _self.ville;
                console.log(_ville)
                axios.post('/ville', _ville)
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