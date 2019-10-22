<template>

    <div>
        <b-form @submit.prevent="onSubmit" @reset="onRestForm">
            <b-row>
                <div class="col-6">
                    <b-row>
                        <div class="form-group col-6">
                            <label for="partenaireId" class="obligatoire"> Partenaire</label>
                            <select v-model="form_location.partenaire" class="form-control" id="partenaireId" required>
                                <option value="null" disabled selected> -- choisir partenaire -- </option>
                                <option :value=partenaire.value v-for="partenaire in partenaires">{{partenaire.text}}</option>
                            </select>
                            <p v-if="errors.partenaire" style="color: red">
                                {{errors.partenaire[0]}}
                            </p>
                        </div>
                        <div class="form-group col-6">
                            <label for="titre_location" class="form-control-label obligatoire"> Titre </label>
                            <input type="text"  v-model="form_location.title" class="form-control" id="titre_location" required>
                            <p v-if="errors.title" style="color: red">
                                {{errors.title[0]}}
                            </p>
                        </div>
                    </b-row>
                    <b-row>
                        <div class="form-group col-6">
                            <label class="obligatoire"> Date début disponibilité</label>
                            <date-picker
                                    width="100%"
                                    v-model="form_location.date_debut"
                                    type="date" lang="fr"  value-type='format'
                                    :first-day-of-week="1" :not-before="new Date()">
                            </date-picker>
                            <p v-if="errors.date_debut" style="color: red">
                                {{errors.date_debut[0]}}
                            </p>
                        </div>
                        <div class="form-group col-6">
                            <label class="obligatoire"> Date fin disponibilité  </label>
                            <date-picker
                                    width="100%"
                                    v-model="form_location.date_fin"
                                    type="date" lang="fr" value-type='format'
                                    :first-day-of-week="1" :not-before=form_location.date_debut>
                            </date-picker>
                            <p v-if="errors.date_fin" style="color: red">
                                {{errors.date_fin[0]}}
                            </p>
                        </div>
                    </b-row>
                    <b-row>
                        <b-form-group class="col-6">
                            <label>Pays</label>
                            <b-form-select v-model="form_location.pays_location" :options="pays" v-on:input="charger_ville(form_location.pays_location)">
                                <template slot="first">
                                    <option :value="null" disabled> -- Selectionnez un pays --</option>
                                </template>
                            </b-form-select>
                        </b-form-group>
                        <b-form-group class="col-6">
                            <label class="obligatoire">Ville</label>
                            <b-form-select v-model="form_location.ville_location" :options="villes" required>
                                <template slot="first">
                                    <option :value="null" disabled> -- Selectionnez une ville --</option>
                                </template>
                            </b-form-select>
                            <p v-if="errors.ville_location" style="color: red">
                                {{errors.ville_location[0]}}
                            </p>
                        </b-form-group>
                    </b-row>
                </div>
                <div class="form-group col-6">
                    <label for="description">Description de la location</label>
                    <textarea class="form-control" rows="5"
                              style="height: 85%; max-height: 100%;"
                              v-model="form_location.description" id="description"
                              placeholder="Saisissez la description de votre object en location"
                    ></textarea>
                    <p v-if="errors.description" style="color: red">
                        {{errors.description[0]}}
                    </p>
                </div>
            </b-row>

            <b-row class="col-12">
                <multiple-image :old_images=old_images></multiple-image>
            </b-row>
            <div class="row">
                <div class="col-6">
                    <b-button type="reset" block variant="danger">Annuler</b-button>
                </div>
                <div class="col-6">
                    <b-button type="submit" block variant="success">Enregistrer </b-button>
                </div>
            </div>
        </b-form>
    </div>
</template>


<script>
    import axios from 'axios';
    import DatePicker from 'vue2-datepicker';

    export default {
        props: ['location'],
        components: { DatePicker},
        data() {
            return {

                form_location: {
                    'partenaire': null,
                    'title': '',
                    'description': '',
                    'date_debut': '',
                    'date_fin': '',
                    'photos': [],
                    'image_to_remove': null,
                    'pays_location': null,
                    'ville_location': null,
                },
                errors: [],
                partenaires: [],

                update: false,
                pays: [] ,
                all_cities: [],
                villes: [],
                old_images: this.location === null ? null: this.location.images
            }
        },
        computed: {
            valid_date_depart() {
                return this.errors.date_depart == null ? null: false;
            }
        },
        mounted() {

            this.init_form();

            // Recuperer tous les partenaire de la base de données
            this.recuperer_partenaire();


            this.load_countries();
            this.load_all_cities();
            // On écoute le composant image
            this.$root.$on('images' , (images_loaded) => {
                this.put_image(images_loaded);
            });

            this.$root.$on('images_to_remove', (tab_id) => {
               this.form_location.image_to_remove = tab_id;
            });

        },
        methods: {

            init_form() {
               if ( this.location == null) {
                   this.update = false;
               } else {
                   this.update = true;
                   this.form_location.partenaire = this.location.partenaire;
                   this.form_location.description = this.location.description;
                   this.form_location.title = this.location.titre;
                   this.form_location.date_fin = this.location.date_fin_disponibilite;
                   this.form_location.date_debut = this.location.date_debut_disponibilite;
               }

            },

            put_image(images) {
                this.form_location.photos = images;
            },

            is_updated(){
                return !(
                    this.form_location.partenaire === this.location.partenaire &&
                    this.form_location.description === this.location.description &&
                    this.form_location.title === this.location.titre &&
                    this.form_location.date_fin === this.location.date_fin_disponibilite &&
                    this.form_location.date_debut === this.location.date_debut_disponibilite &&
                    this.form_location.photos === [] &&
                    this.form_location.image_to_remove === null
                ) ;
            },

            onSubmit() {

                if(this.update) {
                    // Nous sommes dans un de modification de location
                    if (!this.is_updated()) {
                        swal.fire({
                            title: 'Pas de modification!',
                            type: 'error',
                            text: 'Vous n\'avez rien modifié!!!',
                        });
                    } else {
                        axios.put('api/location/'+this.location.slug, this.form_location)
                            .then((response) => {
                                swal.fire({
                                    title: 'Modification!',
                                    type: 'success',
                                    text: 'Location modifiée avec succès!!!',
                                });
                            })
                    }
                } else {
                    axios.post('/location', this.form_location)
                        .then((response) => {
                            if (response.data.status === 0 ) {
                                this.errors = response.data.errors;
                                toast.fire({
                                    type: 'error',
                                    title: 'Erreur !',
                                    html: response.data.message
                                });
                            } else {
                                swal.fire({
                                    title: 'Création!',
                                    type: 'success',
                                    text: 'Location planifié !!!',
                                });
                            }
                        }).catch(error => console.log(error));
                }

            },

            onRestForm() {

            },

            recuperer_partenaire() {
                let part = [];
                axios.get('/partenaire')
                    .then( (response) => {
                        part = response.data.content;

                        /*
                          On recupère tous les partenaires activés
                         */
                        part.forEach((par) => {
                            if (par.etat === 2){
                                this.partenaires.push({
                                    value: par.id,
                                    text: par.nom_partenaire,
                                });
                            }
                        });
                    }).catch((response) => {
                    this.partenaires = [];
                });
            },

            load_countries() {
                axios.get('/pays')
                    .then((response) =>{
                        response.data.content.pays.data.forEach( (country) => {
                            this.pays.push({
                                value: country.id,
                                text: country.nom,
                            });
                        });

                    }).catch((response) => {
                        console.log(response);
                    }
                );
            },

            // Charger les villes
            load_all_cities() {
                this.all_cities = [];
                let cities = [];
                this.axios.get('/ville')
                    .then((response) => {
                        cities = response.data.content;
                        cities.forEach((ville) => {
                            this.all_cities.push({
                                id: ville.id,
                                nom: ville.nom,
                                pays_id: ville.pays.id
                            })
                        })
                    }).catch(err => console.log(err));
            },


            // En fonction du pays de depart
            charger_ville($id_pays) {
                this.villes = [];
                this.all_cities.forEach( (city) => {
                    if (city.pays_id === $id_pays) {
                        this.villes.push({
                            value: city.id,
                            text: city.nom,
                        });
                    }
                });
            },
        }
    }
</script>

<style scoped>
    label.obligatoire:after {
        content: " *";
        color: red;
        font-size: 15px;
    }
    label {
        color: #002752;
        display: block;
        font-size: 15px;
    }
    select, input, textarea{
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        border: 1px solid #C2C2C2;
        box-shadow: 1px 1px 4px #EBEBEB;
        -moz-box-shadow: 1px 1px 4px #EBEBEB;
        -webkit-box-shadow: 1px 1px 4px #EBEBEB;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        padding: 7px;
        outline: none;
    }
</style>