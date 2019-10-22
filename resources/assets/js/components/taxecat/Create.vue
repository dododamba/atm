<template>
   <div class="col-lg-12 col-sm-12">
                        <div id="add-listing">
            <form v-on:submit.prevent="store()">
                            <!-- Section -->
                            <div class="add-listing-section">

                                <!-- Headline -->
                                <div class="add-listing-headline">
                                    <h3><i class="sl sl-icon-doc"></i> Détail catégorie</h3>
                                </div>

                                <!-- Title -->
                                <div class="row with-forms">
                                    <div class="col-md-12">
                                        <label>Libellé <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                        <input class="search-field" type="text" v-model="categorie.libelle">
                                    </div>
                                    <p class="text-danger" v-if="validations">
                                       {{ validations.libelle }}
                                    </p>
                                </div>

                                <div class="row with-forms">
                                    <div class="col-md-12">
                                        <label>Description</label>
                                        <textarea class="search-field" v-model="categorie.description"></textarea>
                                    </div>
                                    <p class="text-danger" v-if="validations">
                                       {{ validations.description }}
                                    </p>

                                </div>
                            </div>

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
                categorie: {
                    libelle: '',
                    description: '',
                }
            }
        },

        mounted() {
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
                axios.post('/taxecat', _categorie)
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

</style>