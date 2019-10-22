<template>
    <b-card title="">
        <b-card-text>

            <form v-on:submit.prevent="store()">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="name" class=" form-control-label">Titre</label>
                        <input type="text" id="name" v-model="categorie.nom"
                               placeholder="Nom de la categorie" class="form-control">
                        <p class="text-danger" v-if="validations">
                            {{ validations.nom }}
                        </p>
                    </div>
                </div>

                <input type="hidden" v-model="categorie.ajouter_par">
                <div class="form-group shadow-textarea">
                    <label for="description">Description</label>
                    <textarea class="form-control z-depth-1" v-model="categorie.description" id="description" rows="3"
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
                categorie: {
                    nom: '',
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
                    _self.categorie.ajouter_par = _self.connected_user_.id;
                })
            },
            store() {
                var _self = this;
                var _categorie = _self.categorie;
                axios.post('/api/categoriearticle', _categorie)
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