<template>
    <div>
        <h4>Information générale du partenaire</h4>
        <hr>
        <div class="row">
            <div class="col-5">
                <b-row>
                    <div class="col-12">
                        <b> Nom du Partenaire : </b> {{detail_partenaire.nom}} <br><br>
                        <b> Type du Partenaire : </b> {{detail_partenaire.type}} <br><br>
                        <b> Etat du partenaire  : </b> {{ etat_partenaire }} <br><br> <br><br>
                    </div>
                </b-row>
                <b-row v-if="etat === 1">
                    <div  class="col-12">
                        <b-button block variant="success" size="sm" @click="activer" v-if="is_controller || is_admin">
                            Activer le compte
                        </b-button>
                    </div>
                </b-row>
                <b-row v-else-if="etat === 2" >
                    <div class="col-12" >
                        <b-button variant="danger" block size="sm" @click="bloquer" v-if="is_controller || is_admin">
                            Bloquer le partenaire
                        </b-button>
                    </div>
                </b-row>
                <b-row v-else-if="etat === 3" >
                    <div class="col-12">
                        <b-button variant="danger" block size="sm" @click="desactiver" v-if="is_controller || is_admin">
                            Désactiver le partenaire
                        </b-button>
                    </div>
                </b-row>
            </div>
            <div class="col-4">
                <b> Adresse partenaire : </b> {{detail_partenaire.adresse}} <br><br>
                <b> Email : </b> {{detail_partenaire.user.email}} <br><br>
                <b> Numéro de tel : </b> {{detail_partenaire.numero_tel}} <br><br>
                <b>Pièces jointes : </b>
                <ul>
                    <li v-for="(p, index) in detail_partenaire.pieces" :key="index" >
                        <a  :href="p.url_file"  target="_blank">
                            voir la piece : {{index + 1}}
                        </a>
                    </li>
                </ul>

                <b-row v-if="etat === 3" >
                    <div class="col-12">
                        <b-button variant="success" block size="sm" @click="debloquer" v-if="is_controller || is_admin">
                            Débloquer le partenaire
                        </b-button>
                    </div>
                </b-row>
            </div>
            <div class="col-3 image-div">
                <img id="myImg" :src="logo"  @click="showLogo" alt="Logo Partenaire" v-b-tooltip.hover title="Cliquer pour zoomer">
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <h4>Agence principale</h4>
                <table class="table ">
                    <tbody>
                    <tr>
                        <td> <b>Nom agence  :</b></td>
                        <td>{{ detail_partenaire.agence_principale.libelle}}</td>
                    </tr>
                    <tr>
                        <td><b> Contact  :</b></td>
                        <td>{{ detail_partenaire.agence_principale.contact}}</td>
                    </tr>
                    <tr>
                        <td> <b>Adresse  :</b></td>
                        <td>{{ detail_partenaire.agence_principale.adresse}}</td>
                    </tr>
                    <tr>
                        <td><b>Ville  :</b></td>
                        <td>{{ville_principale}}</td>
                    </tr>
                    <tr>
                        <td><b>Email  :</b></td>
                        <td>{{detail_partenaire.agence_principale.email}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-6">
                <h4>Localisation des agences du partenaire</h4>
                <map-component></map-component>
            </div>
        </div>
        <hr>
        <b-row>
            <div class="col-12">
                <b-card no-body>
                    <b-tabs content-class="mt-3" pills>
                        <b-tab v-if="detail_partenaire.type==='Entreprise'" title="Agences" active>

                            <table class="table text-center">
                                <thead class="text-uppercase thead-light">
                                <tr class="text-dark">
                                    <th scope="col">Libelle </th>
                                    <th scope="col">ville</th>
                                    <th scope="col">Contact </th>
                                    <th scope="col">Adresse </th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="agence in agences">
                                    <td>{{ agence.libelle }}</td>
                                    <td>{{ agence.ville}}</td>
                                    <td>{{ agence.contact}}</td>
                                    <td>{{ agence.adresse}}</td>
                                    <td>{{ agence.email}}</td>
                                    <td>
                                        <b-button pill variant="info" size="sm" v-b-tooltip.hover title="Détail agence"
                                                  @click="detail_agence(agence)">
                                            <i class="fa fa-info-circle"></i>
                                        </b-button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </b-tab>
                        <b-tab v-if="detail_partenaire.type==='Entreprise'"  title="Voyages">
                            <voyage-partenaire :partenaire="partenaire"></voyage-partenaire>
                        </b-tab>
                        <b-tab title="Locations" >
                            <location-partenaire :partenaire="partenaire"></location-partenaire>
                        </b-tab>
                    </b-tabs>
                </b-card>
            </div>
        </b-row>

        <!-- Modal détail agence-->
        <div>
            <b-modal v-model="showModalAgence" :title="titleModal" :header-bg-variant="headerBgVariant"
                     :header-text-variant="headerTextVariant" :body-bg-variant="bodyBgVariant"
                     :body-text-variant="bodyTextVariant" :footer-bg-variant="footerBgVariant"
                     :footer-text-variant="footerTextVariant">
                <b-container fluid>
                        <div class="row">
                            <div class="col-6">
                                <b> Libelle : </b> {{agence_detail.libelle}} <br><br>
                                <b> Contact : </b> {{agence_detail.contact}} <br><br>
                                <b> Adresse : </b> {{agence_detail.adresse}} <br><br>
                            </div>
                            <div class="col-6" style="{text-align: right}">
                                <b> Ville  : </b> {{ agence_detail.ville }} <br><br>
                                <b> email  : </b> {{agence_detail.email}} <br><br>
                            </div>
                        </div>
                </b-container>

                <div slot="modal-footer" class="w-100">
                    <b-button
                            variant="primary"
                            size="sm"
                            class="float-right"
                            @click="showModalAgence=false">
                        Fermer
                    </b-button>
                </div>
            </b-modal>
        </div>
    </div>
</template>

<script>

    import axios from 'axios';
    import MapComponent from "./MapComponent";
    import * as handle_user from '../../handle_user';

    Vue.use(axios);

    export default {
        components: {MapComponent},
        props: ['partenaire'],

        data () {
            return {
                detail_partenaire : '',
                ville_principale: '',
                etat_partenaire: '',
                type_partenaire: null,
                ville_tmp: '',
                agences: [],

                etat: this.partenaire.etat,

                logo: this.partenaire.logo != null ? this.partenaire.logo : "/storage/defaults/default_image.png",

                all_cities: [],

                showModalAgence: false,
                agence_detail : '',
                // Config Modal
                titleModal: 'Détail agence',
                headerBgVariant: 'secondary',
                headerTextVariant: 'light',
                bodyBgVariant: 'light',
                bodyTextVariant: 'dark',
                footerBgVariant: 'warning',
                footerTextVariant: 'dark',

                // User infos
                is_admin : false,
                is_controller : false,
                is_agent : false,
            }
        },
        mounted() {
            var object = this ;

            handle_user.get_connected_user_role(
                () => {
                    this.load_all_cities();
                    this.charger_info_partenaire();
                    object.is_admin = handle_user.is_admin();
                    object.is_controller = handle_user.is_controlleur();
                    object.is_agent = handle_user.is_agent();
                }
            )
        },

        methods: {
            detail_agence(agence) {
                this.agence_detail = agence ;
                this.showModalAgence = ! this.showModalAgence;
                this.titleModal = 'Détail agence';
            },
            showLogo() {
                swal.fire({
                    showConfirmButton: false,
                    imageUrl: this.logo,
                    imageClass: 'image_modal',
                });
            },
            activer() {

                swal.fire({
                    title: 'êtes-vous sûr de vouloir Activer ce compte?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Activer!',
                    cancelButtonText:'Non, annuler'
                }).then((result) => {
                    if (result.value) {
                        axios.get('/partenaire/activate/'+this.detail_partenaire.slug)
                            .then( (response) => {
                                swal.fire(
                                    'Activation!',
                                    'Le Compte a été activé.',
                                    'success'
                                );
                                this.lire_etat(2);
                            })
                    }
                })

            },

            desactiver() {

                swal.fire({
                    title: 'êtes-vous sûr de vouloir Désactiver ce compte?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Désactiver!',
                    cancelButtonText:'Non, annuler'
                }).then((result) => {
                    if (result.value) {
                        axios.get('/partenaire/desactivate/'+this.detail_partenaire.slug)
                            .then( (response) => {
                                swal.fire(
                                    'Désactivation!',
                                    'Le partenaire a été désactivé.',
                                    'success'
                                );
                                this.lire_etat(1);
                            });
                    }
                })
            },

            bloquer() {

                swal.fire({
                    title: 'êtes-vous sûr de vouloir Bloquer ce partenaire?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Bloquer!',
                    cancelButtonText:'Non, annuler'
                }).then((result) => {
                    if (result.value) {
                        axios.get('/partenaire/bloquer/'+this.detail_partenaire.slug)
                            .then( (response) => {
                                swal.fire(
                                    'Bloqué!',
                                    'Le partenaire a été bloqué.',
                                    'success'
                                );
                            });
                        this.lire_etat(3);
                    }
                })
            },

            debloquer() {

                swal.fire({
                    title: 'êtes-vous sûr de vouloir déboquer ce partenaire?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, débloquer!',
                    cancelButtonText:'Non, annuler'
                }).then((result) => {
                    if (result.value) {
                        axios.get('/partenaire/debloquer/'+this.detail_partenaire.slug)
                            .then( (response) => {
                                swal.fire(
                                    'Bloqué!',
                                    'Le partenaire a été debloqué.',
                                    'success'
                                );
                            });
                        this.lire_etat(2);
                    }
                })
            },


            lire_etat(etat) {
                this.etat = etat ;
                switch (etat) {
                    case 1:
                        this.etat_partenaire = 'Compte pas encore activé';
                        break;
                    case 2:
                        this.etat_partenaire = 'Compte activé';
                        break;
                    case 3:
                        this.etat_partenaire = 'Partenaire bloqué';
                        break
                }

            },
            charger_info_partenaire() {
                // On doit recuperer le partenaire avcec ses relations
                axios.get('/partenaire/'+this.partenaire.slug)
                    .then( (response) => {
                        this.detail_partenaire = response.data.content;

                        this.lire_etat(this.detail_partenaire.etat);
                        // Calcul du type du partenaire
                        this.type_partenaire = this.detail_partenaire.type === 'Entreprise' ?  true : false;

                        this.detail_partenaire.agences.forEach( (agence) => {
                                this.agences.push({
                                    libelle: agence.libelle,
                                    contact: agence.contact,
                                    adresse: agence.adresse,
                                    email: agence.email,
                                    ville: this.ville_id(agence.ville)
                                    })
                        });
                        // On charger la ville à partir de l'ID
                        this.ville_principale = this.ville_id(this.detail_partenaire.agence_principale.ville);
                    })
                    .catch(error => { console.log(error)})
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
                        });
                    }).catch(err => console.log(err));
            },

            ville_id(id_seek){
                let $ville = '';
                this.all_cities.forEach( (city) => {
                    if (city.id === id_seek) {
                        $ville = city.nom;
                    }
                });
                return $ville;
            },

        },
    }
</script>

<style scoped>
    .image-div img{
        max-width: 80%;
        max-height: 80%;
        border-radius: 5px;
    }

    hr {
        border: 2px solid #17a2b8;
    }
    h4 {
        color: #002752;
        font-family: 'Droid serif', serif;
        font-size: 20px;
        font-weight: 400; font-style: italic; line-height: 44px; text-align: left;
    }
    li {
        display: inline;
        list-style: none; /* pour enlever les puces sur IE7 */
        margin: 10px;
    }

</style>