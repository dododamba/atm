<template>
    <div>

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

    </div>
</template>

<script>

    import axios from 'axios';

    Vue.use(axios);

    export default {
        props: ['partenaire'],

        data () {
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
        },

        methods: {
            _onLoaded(){

            }
        },
    }
</script>

<style scoped>

</style>