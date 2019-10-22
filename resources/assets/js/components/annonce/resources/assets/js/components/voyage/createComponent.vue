<template>

    <div>
        <b-form @submit.prevent="onSubmit" @reset="onRestForm">
            <div class="row">
                <div class="col-9">
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="partenaireId" class="obligatoire"> Partenaire </label>
                            <select v-model="form_voyage.partenaire" class="form-control" id="partenaireId">
                                <option value="null" disabled selected> -- Choisir -- </option>
                                <option :value=partenaire.value v-for="partenaire in partenaires">{{partenaire.text}}</option>
                            </select>
                            <p v-if="errors.partenaire" style="color: red">
                                {{errors.partenaire[0]}}
                            </p>
                        </div>
                        <div class="form-group col-4">
                            <label class="obligatoire"> Date du voyage</label>
                            <date-picker
                                    width="100%"
                                    v-model="form_voyage.date_depart"
                                    type="date" lang="fr" valueType="format" format="DD/MM/YYYY"
                                    :first-day-of-week="1" :not-before="new Date()" :open-date="new Date()">
                            </date-picker>
                            <p v-if="errors.date_depart" style="color: red">
                                {{errors.date_depart[0]}}
                            </p>
                        </div>

                        <div class="form-group col-4">
                            <label class="obligatoire"> Heure de départ  </label>
                            <date-picker
                                    width="100%"
                                    v-model="form_voyage.heure_depart" format="HH:mm"
                                    type="time" lang="fr" valueType="format">
                            </date-picker>
                            <p v-if="errors.heure_depart" style="color: red">
                                {{errors.heure_depart[0]}}
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="nombre_place" class="form-control-label obligatoire"> Nombre de places</label>
                            <input type="number"  v-model="form_voyage.nombre_place" class="form-control" id="nombre_place">
                            <p v-if="errors.nombre_place" style="color: red">
                                {{errors.nombre_place[0]}}
                            </p>
                        </div>
                        <div class="form-group col-4">
                            <label for="numero_voyage" class="form-control-label obligatoire"> Numéro de voyage  </label>
                            <input v-model="form_voyage.num_voyage" type="text"  class="form-control" id="numero_voyage">
                            <p v-if="errors.num_voyage" style="color: red">
                                {{errors.num_voyage[0]}}
                            </p>
                        </div>
                        <div class="form-group col-4">
                            <label class="form-control-label"> Durée du voyage </label>
                            <date-picker
                                    width="100%"
                                    v-model="form_voyage.duree_voyage" format="HH:mm"
                                    type="time" lang="fr" valueType="format">
                            </date-picker>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <imageComponent :logo=null ></imageComponent>
                </div>
            </div>

            <div class="row">
                <div class="form-group  col-3">
                    <label for="pays_depart" class="col-form-label"> Pays de départ</label>
                    <select v-model="form_voyage.pays_depart" id="pays_depart" class="form-control" @click="charger_ville_depart">
                        <option value="null" disabled selected> -- Changer -- </option>
                        <option :value=p.value v-for="p in liste_pays"> {{p.text}}</option>
                    </select>
                </div>
                <div class="form-group  col-3">
                    <label for="ville_depart" class="col-form-label obligatoire"> Ville de départ </label>
                    <select v-model="form_voyage.ville_depart" id="ville_depart" class="form-control">
                        <option value="null" disabled selected> ---- </option>
                        <option :value=v.value v-for="v in liste_ville_depart"> {{v.text}}</option>
                    </select>
                    <p v-if="errors.ville_depart" style="color: red">
                        {{errors.ville_depart[0]}}
                    </p>
                </div>

                <div class="form-group  col-3">
                    <label for="pays_arrive" class="col-form-label"> Pays de départ</label>
                    <select v-model="form_voyage.pays_arrive" id="pays_arrive" class="form-control" @click="charger_ville_arrive">
                        <option value="null" disabled selected> ................. </option>
                        <option :value=p.value v-for="p in liste_pays"> {{p.text}}</option>
                    </select>
                </div>
                <div class="form-group  col-3">
                    <label for="ville_arrivee" class="col-form-label obligatoire"> Ville arrivée </label>
                    <select v-model="form_voyage.ville_arrivee" id="ville_arrivee" class="form-control">
                        <option value="null" disabled selected> ............... </option>
                        <option :value=v.value v-for="v in liste_ville_arrivee"> {{v.text}}</option>
                    </select>
                    <p v-if="errors.ville_arrivee" style="color: red">
                        {{errors.ville_arrivee[0]}}
                    </p>
                </div>
            </div>


            <!-- ITINÉRAIRE -->
            <div class="row">
                <div class="col-12">
                    <h4>Itinéraire du voyage</h4>

                    <ul>
                        <li v-if="form_voyage.ville_depart">
                            <a href="javascript:void(0)" v-b-tooltip.hover title="Ville de départ" >
                                {{nom_ville(form_voyage.ville_depart)}}
                            </a>
                            &nbsp; &nbsp;
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </li>
                        <li v-for="(ville, index) in ville_itineraire" :key="index">
                            <b-button-group size="sm" >
                                <b-button v-b-tooltip.hover title="Modifier la ville"  @click="updateVille(ville)" >
                                    {{nom_ville(ville.ville)}}
                                </b-button>
                                <b-button variant="danger">
                                    <i v-b-tooltip.hover title="Enlvèver cette ville" style="color: #772510; cursor: pointer;"
                                       @click="removeVille(index)" class="fa fa-times" aria-hidden="true">
                                    </i>
                                </b-button>
                            </b-button-group>
                            &nbsp; &nbsp;
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </li>
                        <li v-if="form_voyage.ville_arrivee">
                            <a href="javascript:void(0)" v-b-tooltip.hover title="Ville d'arrivée" >{{nom_ville(form_voyage.ville_arrivee)}}</a>
                        </li>

                        <li v-if="form_voyage.ville_arrivee && form_voyage.ville_depart">
                            <b-button size="sm" variant="success" @click="showModalAddVille" v-b-tooltip.hover title="Ajouter ville" >
                                <i class="fa fa-plus-square" aria-hidden="true"></i>
                            </b-button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="moyen_transport" class="obligatoire"> Moyen de transport </label>
                            <select v-model="form_voyage.moyen_transport" class="form-control" id="moyen_transport">
                                <option value="null" disabled selected >-- Changer le moyen de transport --</option>
                                <option :value=mt.value v-for="mt in moyen_transports">{{mt.text}}</option>
                            </select>
                            <p v-if="errors.moyen_transport" style="color: red">
                                {{errors.moyen_transport[0]}}
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="description">Description du voyage</label>
                            <textarea class="form-control" rows="10" v-model="form_voyage.description" id="description" ></textarea>
                        </div>
                        <p v-if="errors.description" style="color: red">
                            {{errors.description[0]}}
                        </p>
                    </div>

                </div>
                <div class="col-6">
                    <br> <br>
                    <div class="row">
                        <div class="col-3"><b>Classes</b></div>
                        <div class="col-5"><b>Prix enfant (F CFA)</b></div>
                        <div class="col-4"><b>Prix Adulte (F CFA)</b></div>
                    </div>
                    <hr>
                    <div class="row" v-for="(classe, index) in classes" :key="index">
                        <div class="col-3"><b>{{classe.libelle}}</b></div>
                        <div class="col-5">
                            <b-form-input size="sm" v-model="form_voyage.tarif[index].prix_enfant" type="number">
                            </b-form-input>
                        </div>
                        <div class="col-4">
                            <b-form-input size="sm"  v-model="form_voyage.tarif[index].prix_adulte" type="number">
                            </b-form-input>
                        </div>
                        <hr>
                        <p v-if="error_tarif" style="color: red">
                            Vous devez renseigner au moins un prix adulte
                        </p>
                    </div>
                    <div class="row" style="margin-top: 20px">
                        <div class="col-6">
                            <b-button type="reset" block variant="danger">Annuler</b-button>
                        </div>
                        <div class="col-6">
                            <b-button type="submit" block variant="success">Enregistrer </b-button>
                        </div>
                    </div>
                </div>
            </div>
        </b-form>

        <!-- le modal  Add or Update Ville-->
        <div>
            <b-modal v-model="showModalVille" :title="titleModal" :header-bg-variant="headerBgVariant"
                     :header-text-variant="headerTextVariant" :body-bg-variant="bodyBgVariant"
                     :body-text-variant="bodyTextVariant" :footer-bg-variant="footerBgVariant"
                     :footer-text-variant="footerTextVariant">
                <b-container fluid>
                    <form @submit.prevent="addVille">
                            <div class="row">
                                <b-form-group class="col-6">
                                    <label >Pays</label>
                                    <b-form-select v-model="ville_form.pays" :options="liste_pays" v-on:input="charger_ville(ville_form.pays)" >
                                        <template slot="first">
                                            <option :value="null" disabled> -- Choisir --</option>
                                        </template>
                                    </b-form-select>
                                </b-form-group>
                                <b-form-group class="col-6">
                                    <label> Ville </label>
                                    <b-form-select v-model="ville_form.ville" :options="villes" required>
                                        <template slot="default">
                                            <option :value="null" disabled> --Choisir--</option>
                                        </template>
                                    </b-form-select>
                                </b-form-group>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <br>
                                    <label style="margin-right: 15px;display: inline;"> Escale dans la ville ? </label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" v-model="ville_form.escale" id="inlineRadio1" value=true>
                                        <label class="form-check-label" for="inlineRadio1" style="padding-left: 5px;">Oui</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" v-model="ville_form.escale"  id="inlineRadio2" value=false>
                                        <label class="form-check-label" for="inlineRadio2" style="padding-left: 5px;">Non</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                </b-container>

                <b-row slot="modal-footer" class="w-100" fluid>
                    <div class="col-4"><b-button block variant="danger" @click="showModalVille=false" >
                        Annuler
                    </b-button></div>
                    <div class="col-4 offset-3"><b-button type="submit" block variant="success" @click="addVille" >
                        Valider
                    </b-button> </div>
                    <div class="col-1"></div>
                </b-row>
            </b-modal>
        </div>

    </div>
</template>

<script>
    import axios from 'axios';
    import DatePicker from 'vue2-datepicker';

    export default {
        components: { DatePicker},
        data() {
            return {
                options: [
                    { text: 'Oui', value: true },
                    { text: 'Non', value: false }
                ],
                form_voyage: {
                    num_voyage: '',
                    pays_depart: null,
                    ville_depart: null,
                    pays_arrive: null,
                    ville_arrivee: null,
                    moyen_transport: null,
                    date_depart: '',
                    partenaire: null,
                    heure_depart: '',
                    duree_voyage: '',
                    image_voyage: '',
                    description: '',

                    tarif: [],
                    itineraire: [],
                },

                ville_form: {
                    pays: null,
                    ville: null,
                    escale: true,
                    index: null
                },
                ville_itineraire: [],
                errors: [],
                error_tarif: false,
                image_default: '',
                partenaires: [],
                classes: [],
                liste_ville: [],
                liste_pays: [],
                villes: [],
                liste_ville_depart: [],
                liste_ville_arrivee: [],
                moyen_transports: [
                    {text: 'Routier', value: 1},
                    {text: 'Ferroviaire', value: 2},
                    {text: 'Maritime', value: 3},
                    {text: 'Aérien' , value: 4},
                ],


                disabledDates: {
                    to: new Date(Date.now() - 8640000)
                },

                showModalVille: false,
                // Config Modal
                titleModal: 'Ajouter une ville à l\'itinéraire',
                headerBgVariant: 'dark',
                headerTextVariant: 'light',
                bodyBgVariant: 'light',
                bodyTextVariant: 'dark',
                footerBgVariant: 'warning',
                footerTextVariant: 'dark',
            }
        },
        computed: {
            valid_date_depart() {
                return this.errors.date_depart == null ? null: false;
            }
        },
        mounted() {
            // Recuperer tous les partenaire de la base de données
            this.recuperer_partenaire();

            // Charger les pays
            this.load_countries();

            // Charger les différents type de classe
            this.load_classe();

            // Charger les villes
            this.load_cities();

            // On écoute le composant image
            this.$root.$on('image' , (image_loaded) => {
                this.put_image(image_loaded);
            })

        },
        methods: {


            updateVille(ville) {
                this.ville_form.escale = ville.escale;
                this.ville_form.ville = ville.ville;
                this.ville_form.pays = ville.pays;
                this.ville_form.index = ville.index;
                this.showModalAddVille();
            },

            addVille() {
                if (this.ville_form.index === null ) {
                    this.ville_itineraire.push({
                        'pays': this.ville_form.pays,
                        'ville' : this.ville_form.ville,
                        'escale' : this.ville_form.escale,
                        'index': this.ville_itineraire.length
                    });
                } else {
                    this.ville_itineraire[this.ville_form.index] = {
                        'pays': this.ville_form.pays,
                        'ville' : this.ville_form.ville,
                        'escale' : this.ville_form.escale,
                        'index': this.ville_form.index
                    };
                }

                this.ville_form.escale = true;
                this.ville_form.ville = null;
                this.ville_form.pays = null;
                this.ville_form.index = null;
                this.showModalVille = false;
            },
            removeVille(index) {
                this.ville_itineraire.splice(index, 1);
            },

            showModalAddVille() {
                    this.showModalVille = true;
            },

            nom_ville(id_ville) {
                let name = '';
                this.liste_ville.forEach( (city) => {
                    if (city.id === id_ville) {
                        name = city.nom;
                    }
                });
                return name;
            },


            // Charger les villes
            load_cities() {
                this.liste_ville = [];
                let villes = [];
                this.axios.get('/ville')
                    .then((response) => {
                        villes = response.data.content;
                        villes.forEach((ville) => {
                            this.liste_ville.push({
                                id: ville.id,
                                nom: ville.nom,
                                pays_id: ville.pays.id
                            })
                        })
                    }).catch(err => console.log(err));
            },


            put_image(image) {
                this.form_voyage.image_voyage = image;
            },

            onSubmit() {

                // On doit se rassurer qu'on a saisi au moins un prix adulte
                // pour ce faire on doit parcourir le tableau des tarifs
                var exist = false;
                let i = 0;
                let all_tarif =this.form_voyage.tarif;

                while(i < all_tarif.length && !exist) {
                    if(all_tarif[i].prix_adulte !== "") {
                        exist = true;
                    }
                    i++;
                }
                if (exist) {
                    this.errors = [];
                    this.error_tarif = false;
                    this.form_voyage.itineraire = this.ville_itineraire;
                    axios.post('/voyage' , this.form_voyage)
                        .then((response) => {
                            if(response.data.status === 1) {
                                this.onRestForm();
                                toast.fire({
                                    type: 'success',
                                    title: 'Voyage planifié avec succès'
                                });
                            } else {
                                this.errors = response.data.errors;
                                toast.fire({
                                    type: 'error',
                                    title: 'Erreur !',
                                    html: response.data.message
                                });
                            }

                        }).catch(response => console.log(response));
                } else {
                    this.error_tarif = true;
                    toast.fire({
                        type: 'error',
                        title: 'Vous devez renseigner au moins un prix pour adulte'
                    });
                }
            },

            onRestForm() {
                    this.form_voyage.num_voyage = '';
                    this.form_voyage.pays_depart = null;
                    this.form_voyage.ville_depart = null;
                    this.form_voyage.pays_arrive = null;
                    this.form_voyage.ville_arrivee = null;
                    this.form_voyage.moyen_transport = null;
                    this.form_voyage.date_depart = '';
                    this.form_voyage.partenaire = null;
                    this.form_voyage.heure_depart = '';
                    this.form_voyage.duree_voyage = '';
                    this.form_voyage.image_voyage = '';
                    this.form_voyage.description = '';
                    this.form_voyage.nombre_place = '';

            },
            load_classe() {
                this.classes = [];
                axios.get('/classe')
                    .then( (response) => {
                        response.data.content.forEach((classe) => {
                           this.classes.push({
                               id: classe.id,
                               libelle: classe.libelle
                           });
                           this.form_voyage.tarif.push({
                               'classe': classe.id,
                               'prix_enfant': '',
                               'prix_adulte': ''
                           })
                        });
                    }).catch((response) => {

                });
            },

            recuperer_partenaire() {
                let part = [];
                axios.get('/partenaire')
                    .then( (response) => {
                        part = response.data.content;

                        /*
                            On charge seulement les partenaire qui ont le droit d'effectuer une planification voyage
                            c'est-à-dire les types entreprises
                            et leur compte doit être activé
                         */

                        part.forEach((par) => {
                            if (par.type_partenaire === 'Entreprise' && par.etat === 2){
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


            // En fonction du pays de depart
            charger_ville_depart() {
                this.liste_ville_depart = [];
                this.liste_ville.forEach( (city) => {
                    if (city.pays_id === this.form_voyage.pays_depart) {
                        this.liste_ville_depart.push({
                            value: city.id,
                            text: city.nom,
                        });
                    }
                });
            },

            charger_ville_arrive() {
                this.liste_ville_arrivee = [];
                this.liste_ville.forEach( (city) => {
                    if (city.pays_id === this.form_voyage.pays_arrive) {
                        this.liste_ville_arrivee.push({
                            value: city.id,
                            text: city.nom,
                        });
                    }
                });
            },

            load_countries() {
                axios.get('/pays')
                    .then((response) =>{
                        response.data.content.pays.data.forEach( (country) => {
                            this.liste_pays.push({
                                value: country.id,
                                text: country.nom,
                            });
                        });

                    }).catch((response) => {
                        console.log(response);
                    }
                );
            },

            // En fonction du pays de depart
            charger_ville(id_pays) {
                this.villes = [];
                this.liste_ville.forEach( (city) => {
                    if (city.pays_id === id_pays) {
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
    label {
        color: #002752;
        display: block;
        font-size: 15px;
    }

    label.obligatoire:after {
        content: " *";
        color: red;
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
    li {
        display: inline;
        list-style: none; /* pour enlever les puces sur IE7 */
        margin: 10px;
    }

    li a {
        display: inline-block;
        padding: 5px 10px;
        text-decoration: none;
        color: #fff;
        font-weight: bold;
        background: #999;

        border-radius: 5px;
    }
</style>