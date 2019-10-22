<template>
    <div>
        <b-form @submit="onSubmit">
            <div class="row">
                <div class="col-9">
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="partenaireId"> Partenaire : {{voyage.partenaire}}</label>
                            <select v-model="form_voyage.partenaire" class="form-control" id="partenaireId">
                                <option value="null" disabled selected> -- Changer -- </option>
                                <option :value=partenaire.value v-for="partenaire in partenaires">{{partenaire.text}}</option>
                            </select>
                        </div>
                        <div class="form-group  col-4">
                            <label> Date : {{voyage.date_simple}}</label>
                            <date-picker
                                    width="100%"
                                    v-model="form_voyage.date_depart"
                                    type="date" lang="fr" valueType="format" format="DD/MM/YYYY"
                                    :first-day-of-week="1">
                            </date-picker>
                        </div>

                        <div class="form-group col-4">
                            <label> Heure : {{voyage.heure_depart}} </label>
                            <date-picker
                                    width="100%"
                                    v-model="form_voyage.heure_depart" format="HH:mm"
                                    type="time" lang="fr" valueType="format">
                            </date-picker>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="nombre_place" class="form-control-label"> Nombre de place :  {{voyage.nombre_place}}</label>
                            <input type="number"  v-model="form_voyage.nombre_place" class="form-control" id="nombre_place">
                        </div>
                        <div class="form-group col-4">
                            <label for="numero_voyage" class="form-control-label"> Numéro de voyage : {{voyage.numero}} </label>
                            <input v-model="form_voyage.num_voyage" type="text"  class="form-control" id="numero_voyage">
                        </div>
                        <div class="form-group col-4">
                            <label> Durée : {{voyage.duree}} </label>
                            <date-picker
                                    width="100%"
                                    v-model="form_voyage.duree_voyage" format="HH:mm"
                                    type="time" lang="fr" valueType="format">
                            </date-picker>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <imageComponent :logo=image_voyage></imageComponent>
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
                    <label for="ville_depart" class="col-form-label"> Ville de départ : {{voyage.ville_depart}}</label>
                    <select v-model="form_voyage.ville_depart" id="ville_depart" class="form-control">
                        <option value="null" disabled selected> ---- </option>
                        <option :value=v.value v-for="v in liste_ville_depart"> {{v.text}}</option>
                    </select>
                </div>

                <div class="form-group  col-3">
                    <label for="pays_arrive" class="col-form-label"> Pays de départ</label>
                    <select v-model="form_voyage.pays_arrive" id="pays_arrive" class="form-control" @click="charger_ville_arrive">
                        <option value="null" disabled selected> ---- </option>
                        <option :value=p.value v-for="p in liste_pays"> {{p.text}}</option>
                    </select>
                </div>
                <div class="form-group  col-3">
                    <label for="ville_arrivee" class="col-form-label"> Ville arrivée : {{voyage.ville_arrivee}}</label>
                    <select v-model="form_voyage.ville_arrivee" id="ville_arrivee" class="form-control">
                        <option value="null" disabled selected> ---- </option>
                        <option :value=v.value v-for="v in liste_ville_arrivee"> {{v.text}}</option>
                    </select>
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
                                <b-button v-b-tooltip.hover title="Modifier la ville"  @click="updateVille(index)" >
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
                            <label for="moyen_transport"> Moyen de transport : {{name_transport(voyage.moyen_transport)}}</label>
                            <select v-model="form_voyage.moyen_transport" class="form-control" id="moyen_transport">
                                <option value="null" disabled selected >-- Changer le moyen de transport --</option>
                                <option :value=mt.value v-for="mt in moyen_transports">{{mt.text}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-12">
                            <label for="description">Description du voyage</label>
                            <textarea v-model="form_voyage.description" class="form-control" id="description" rows="5"></textarea>
                        </div>
                    </div>

                </div>
                <div class="col-6">
                    <table class="table text-center  table-borderless">
                        <thead class="text-uppercase">
                        <tr >
                            <th scope="col">Classes </th>
                            <th scope="col">Prix Enfant (F CFA) </th>
                            <th scope="col">Prix Adulte (F CFA) </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(classe, index) in form_voyage.tarif" :key="index">
                            <td> {{classe.libelle}} </td>
                            <td>
                                <b-form-input size="sm" v-model="form_voyage.tarif[index].prix_enfant" type="number">

                                </b-form-input>
                            </td>
                            <td>
                                <b-form-input size="sm"  v-model="form_voyage.tarif[index].prix_adulte" type="number">

                                </b-form-input>

                            </td>

                        </tr>
                        </tbody>
                    </table>

                    <p v-if="error_tarif" style="color: red">
                        Vous devez renseigner au moins un prix adulte
                    </p>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-block btn-success">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </b-form>


        <!-- le modal  Add Ville-->
        <div>
            <b-modal v-model="showModalVille" :title="titleModal" :header-bg-variant="headerBgVariant"
                     :header-text-variant="headerTextVariant" :body-bg-variant="bodyBgVariant"
                     :body-text-variant="bodyTextVariant" :footer-bg-variant="footerBgVariant"
                     :footer-text-variant="footerTextVariant">
                <b-container style="width: auto">
                    <div>
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
                    </div>
                </b-container>

                <b-row slot="modal-footer" class="w-100" fluid>
                    <div class="col-4"><b-button block variant="danger" @click="showModalVille=false" >
                        Annuler
                    </b-button></div>
                    <div class="col-4 offset-3"><b-button type="submit" block variant="success" @click="addVille" >
                        Ajouter
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
        props: ['voyage'],
        components: {DatePicker},
        data() {
            return {

                options: [
                    { text: 'Oui', value: true },
                    { text: 'Non', value: false }
                ],
                form_voyage: {
                    num_voyage: this.voyage.numero,
                    pays_depart: null,
                    ville_depart: null,
                    pays_arrive: null,
                    ville_arrivee: null,
                    moyen_transport: null,
                    date_depart: this.voyage.date_depart,
                    heure_depart:this.voyage.heure_depart,
                    partenaire: null,
                    description: this.voyage.description,
                    duree: this.voyage.duree,
                    nombre_place: this.voyage.nombre_place,
                    itineraire: this.voyage.itineraire,
                    image: null,
                    ville_itineraire: [],
                    deleted_ville_itineraire: [],

                    tarif: [],
                },

                ville_form: {
                    pays: null,
                    ville: null,
                    escale: true,
                    update: false,
                    index: null,
                },
                image_voyage: null,
                partenaires: [],
                classes: [],
                ville_itineraire: [],
                error_tarif: false,

                villes: [],
                liste_tarif: [],
                liste_ville: [],
                liste_pays: [],
                liste_ville_depart: [],
                liste_ville_arrivee: [],
                moyen_transports: [
                    {text: 'Routier', value: 1},
                    {text: 'Ferroviaire', value: 2},
                    {text: 'Maritime', value: 3},
                    {text: 'Aérien' , value: 4},
                ],

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
        mounted() {

            this.load_image();
            // Recuperer tous les partenaire de la base de données
            this.recuperer_partenaire();

            // Charger les pays
            this.load_countries();

            //Charger les villes
            this.load_cities();

            // Charger les différents type de classe
            this.load_classe();

            //init itineraire
            this.init_itineraire();

            // On écoute le composant image
            this.$root.$on('image' , (image_loaded) => {
                this.change_image(image_loaded);
            });
        },
        methods: {

            updateVille(index) {
                this.ville_form.pays = this.id_pays_ville(this.ville_itineraire[index].ville);
                this.ville_form.ville = this.ville_itineraire[index].ville;
                this.ville_form.escale = this.ville_itineraire[index].escale;
                this.ville_form.update = true;
                this.ville_form.index = index;
                this.showModalAddVille();
            },


            // La function qui retourne l'id du pays d'une ville
            id_pays_ville(id_ville) {
                let pays_id = 0;
                this.liste_ville.forEach( (city) => {
                    if (city.id === id_ville) {
                        pays_id = city.pays_id;
                    }
                });
                return pays_id;
            },

            init_itineraire() {
                axios.get('/itineraire/'+this.voyage.itineraire)
                    .then((response) => {
                        this.form_voyage.ville_depart = response.data.content.ville_depart.id;
                        this.form_voyage.ville_arrivee = response.data.content.ville_arrivee.id;
                        this.ville_itineraire = response.data.content.ville_itineraire;
                    }).catch(err => console.log(err))
            },
            addVille() {
                if (! this.ville_form.update) {
                    this.ville_itineraire.push({
                        'id': 0,
                        'ville' : this.ville_form.ville,
                        'escale' : this.ville_form.escale
                    });
                } else {
                    var $id = this.ville_itineraire[this.ville_form.index].id;
                    this.ville_itineraire[this.ville_form.index] = {
                        'id': $id,
                        'ville' : this.ville_form.ville,
                        'escale' : this.ville_form.escale,
                    };
                }

                this.showModalVille = false;
                this.ville_form.escale = true;
                this.ville_form.ville = null;
                this.ville_form.pays = null;
                this.ville_form.index = null ;
                this.ville_form.update = false;
            },
            removeVille(index) {
                if(this.ville_itineraire[index].id !== 0) {
                    // c'est une ville qu'on doit enlèver dans l'itenaire qui est éjà dans la BD
                    this.form_voyage.deleted_ville_itineraire.push(this.ville_itineraire[index].id )
                }
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

            has_changed() {
                return (this.form_voyage.num_voyage !==  this.voyage.numero ||
                this.form_voyage.pays_depart !==  null ||
                this.form_voyage.ville_depart !==  null ||
                this.form_voyage.pays_arrive !==  null ||
                this.form_voyage.ville_arrivee !==  null ||
                this.form_voyage.moyen_transport !==  null ||
                this.form_voyage.date_depart !==  this.voyage.date_depart ||
                this.form_voyage.heure_depart !== this.voyage.heure_depart ||
                this.form_voyage.partenaire !==  null ||
                this.form_voyage.description !==  this.voyage.description ||
                this.form_voyage.duree !==  this.voyage.duree ||
                this.form_voyage.nombre_place !==  this.voyage.nombre_place ||
                this.form_voyage.itineraire !==  this.voyage.itineraire ||
                this.form_voyage.image !==  null);
            },

            load_image(){
                if (this.voyage.image !== null) {
                    this.image_voyage = this.voyage.image.nom;
                    this.form_voyage.image = this.voyage.image.nom;
                }
            },

            change_image($image) {
                this.form_voyage.image = $image;
            },
            name_transport(code) {

                switch (code) {
                    case 1 :
                        return 'Routier';
                    case 2 :
                        return 'Ferroviaire';
                    case 3 :
                        return 'Maritime';
                    case 4 :
                        return 'Aérien'
                }
            },
            onSubmit(evt) {
                evt.preventDefault();

                // On doit se rassurer qu'on a saisi au moins un prix adulte
                // pour ce faire on doit parcourir le tableau des tarifs
                var exist = false;
                let i = 0;
                let all_tarif =this.form_voyage.tarif;
                while(i < all_tarif.length && !exist) {
                    if(all_tarif[i].prix_adulte !== null && all_tarif[i].prix_adulte !== '') {
                        exist = true;
                    }
                    i++;
                }

                if(this.has_changed() && exist) {
                    this.form_voyage.ville_itineraire = this.ville_itineraire;
                    axios.put('/voyage/' + this.voyage.slug , this.form_voyage)
                        .then((response) => {
                            toast.fire({
                                type: 'success',
                                title: 'Le voyage a été modifié'
                            });
                        }).catch((response) => {
                        console.log(response);
                    });
                }else {
                    var message_error = '';
                    if(!exist) {
                        this.error_tarif = true;
                        message_error = 'Vous devez renseigner au moins un prix adulte';
                    } else {
                        message_error = 'Vous n\'avez pas effectué de modification';
                    }
                    toast.fire({
                        type: 'error',
                        title: 'Mauvaise mise à jour',
                        html: message_error
                    });
                }


            },

            onRestForm() {
                this.form_voyage = {
                    num_voyage: '',
                    pays_depart: null,
                    ville_depart: null,
                    pays_arrive: null,
                    ville_arrivee: null,
                    moyen_transport: null,
                    date_depart: '',
                    partenaire: null,
                    description: '',

                    tarif: []
                };
            },
            load_classe: function () {
                this.classes = [];
                axios.get('/classe')
                    .then((response) => {
                        response.data.content.forEach((classe) => {

                            let trouve = false;
                            this.voyage.tarifs.forEach((t) => {
                                if (t.classe === classe.id) {
                                    this.form_voyage.tarif.push({
                                        id: t.id,
                                        classe: classe.id,
                                        libelle: classe.libelle,
                                        prix_enfant: t.prix_enfant,
                                        prix_adulte: t.prix_adulte
                                    });
                                    trouve = true;
                                }
                            });
                            if (!trouve) {
                                this.form_voyage.tarif.push({
                                    id: null,
                                    classe: classe.id,
                                    libelle: classe.libelle,
                                    prix_enfant: '',
                                    prix_adulte: ''
                                })
                            }
                        });
                    }).catch((response) => {

                });

            },

            // Recupère les partenaire qui ont le droit de faire une planification de voyage
            recuperer_partenaire() {
                let part = [];
                axios.get('/partenaire')
                    .then( (response) => {
                        part = response.data.content;

                        // On charge seulement les partenaire qui ont le droit d'effectuer une planification voyage
                        part.forEach((par) => {
                            if (par.type_partenaire === 'Entreprise' && par.is_actived){
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
        }
    }
</script>
<style scoped>
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

