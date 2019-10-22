<template>
    <div>
        <b-row>
            <div class="col-9">
                <div class="row">
                    <div class="col-6">
                        <b>Nom du partenaire: </b> {{voyage_detail.partenaire}}
                    </div>
                    <div class="col-6">
                        <b>Numéro du Voyage: </b> &nbsp; &nbsp;
                        <span class="badge badge-info">{{voyage_detail.numero}}</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6"><b>Ville de départ  : </b> {{voyage_detail.ville_depart}} </div>
                    <div class="col-6"><b>Ville d'arrivée  : </b> {{voyage_detail.ville_arrivee}}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6"><b>Date de départ : </b> {{voyage_detail.date_depart_human}} </div>
                    <div class="col-6"><b>Moyen de transport :</b> {{voyage_detail.moyen_transport}}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6"><b>Nombre de place : </b> {{voyage_detail.nombre_place}}</div>
                    <div class="col-6"><b>Date de création : </b> {{voyage_detail.created_at_human}}</div>
                </div>
            </div>
            <div class="col-3 image-div">
                <img v-if="voyage_detail.image != null" :src="voyage_detail.image.nom" alt="Image du voyage">
                <img v-else src="/storage/defaults/default_image.png" alt="default image">
            </div>
        </b-row>
        <hr>
        <b-row>
            <div class="col-12">
                <label>Itinéraire du voyage</label>
                <ul>
                    <li>
                        <b-button variant="danger" v-b-tooltip.hover title="Ville de départ" size="sm">
                            {{voyage_detail.ville_depart}}
                        </b-button>
                        &nbsp; &nbsp;
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </li>
                    <li v-for="(v, index) in villes_itineraire" :key="index">
                        <b-button size="sm">
                            {{nom_ville(v.ville)}} &nbsp; ({{pays_ville(v.ville)}}) &nbsp;
                            <span class="badge badge-warning" v-if="v.escale" v-b-tooltip.hover title="Escale prevue dans cette ville" >
                                e
                            </span>
                        </b-button>
                        &nbsp; &nbsp;
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </li>
                    <li>
                        <b-button variant="success" size="sm" v-b-tooltip.hover title="Ville d'arrivée" >{{voyage_detail.ville_arrivee}}</b-button>
                    </li>
                </ul>
                <hr>
            </div>
        </b-row>
        <b-row>
            <div class="col-7">
                <b>Description du voyage</b> <br><br>
                <p style="text-align: justify; color: #0c2646">{{voyage_detail.description}}</p>
            </div>
            <div class="col-5">
                <b>Les différents tarifs</b> <br><br>
                <div class="single-table">
                    <table class="table text-center table-bordered">
                        <thead class="text-uppercase">
                        <tr >
                            <th scope="col">Classe </th>
                            <th scope="col">Prix Enfant (F CFA)</th>
                            <th scope="col">Prix Adulte (F CFA)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="t in voyage_detail.tarifs">
                            <td> {{libelle_classe(t.classe)}} </td>
                            <td>{{t.prix_enfant}}</td>
                            <td>{{t.prix_adulte}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </b-row>
        <hr>
        <div class="row">
            <div class="col-7">
                <b>Etat de la planification : </b> &nbsp; &nbsp;
                <span class="badge badge-pill"
                v-bind:class="{
                    nonActive: voyage_detail.etat === 1,
                    active: voyage_detail.etat === 2,
                    publie: voyage_detail.etat === 3,
                    blocked: voyage_detail.etat === 4,
                }">{{libelle_etat(voyage_detail.etat)}}
                </span>
            </div>
            <div class="col-5">
                <b-button type="submit" v-if="is_controller || is_admin"  variant="success" block
                          @click="change_state(voyage_detail.slug, voyage_detail.etat)" >
                    {{button_message}}
                </b-button>
            </div>
        </div>
    </div>
</template>

<script>

    import VueAxios from 'vue-axios';
    import * as handle_user from '../../handle_user';
    import axios from 'axios';
    Vue.use(VueAxios, axios);
    export default {
        props: ['voyage'],

        data() {
            return {
                voyage_detail :this.voyage,
                button_message : '',
                liste_classe: [],
                villes_itineraire: [],
                liste_ville: [],
                pays : [],

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
                    object.is_admin = handle_user.is_admin();
                    object.is_controller = handle_user.is_controlleur();
                    object.is_agent = handle_user.is_agent();
                    this.load_classe();
                    this.message_button(this.voyage.etat);
                    this.load_itineraire();
                    this.load_cities();
                    this.load_countries();
                }
            )
        },
        methods: {

            nom_ville(id_ville) {
                let name = '';
                this.liste_ville.forEach( (city) => {
                    if (city.id === id_ville) {
                        name = city.nom;
                    }
                });
                return name;
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

            load_itineraire() {
                axios.get('/itineraire/'+this.voyage_detail.itineraire)
                    .then((response) => {
                        let var_ville = response.data.content.ville_itineraire;
                        var_ville.forEach((item) => {
                            this.villes_itineraire.push(item)
                        })

                    })
            },
            load_classe() {
                this.liste_classe = [];
                axios.get('/classe')
                    .then((response) => {
                        response.data.content.forEach((classe) => {
                            this.liste_classe.push({
                                id: classe.id,
                                libelle: classe.libelle
                            })
                        })
                    }).catch(err => console.log(err));
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


            pays_ville(id_ville) {
                var $pays = '';

                this.liste_ville.forEach( (city) => {
                    if (city.id === id_ville) {
                        $pays = this.nom_pays(city.pays_id);
                    }
                });

                return $pays;
            },

            nom_pays($id_pays) {
                let name = '';
                this.pays.forEach( (p) => {
                    if (p.value === $id_pays) {
                        name = p.text;
                    }
                });
                return name;
            },

            libelle_etat(code_etat) {
                switch (code_etat) {
                    case 1 :
                        return 'Non Validé';
                    case 2 :
                        return 'Validé';
                    case 3 :
                        return 'publié';
                    case 4 :
                        return 'Désactivé'
                }
            },

            libelle_classe(id) {
                var libelle = '';
                this.liste_classe.forEach((classe) => {
                    if (classe.id === id)
                        libelle =  classe.libelle;
                });
                return libelle;
            },

            message_button(etat) {
                switch (etat) {
                    case 1 :
                        this.button_message = 'Valider la planification';
                        break;
                    case 2 :
                        this.button_message =  'Publier le voyage';
                        break;
                    case 3 :
                        this.button_message =  'Désactiver le voyage';
                        break;
                    case 4 :
                        this.button_message =  'Publier le voyage'
                }
            },
            change_state(slug, etat){
                var message_action = '';
                switch (etat) {
                    case 1 :
                        message_action = 'Voyage a été Validé';
                        break;
                    case 2 :
                        message_action =  'Voyage Publié';
                        break;
                    case 3 :
                        message_action =  'Voyage Désactivé';
                        break;
                    case 4 :
                        message_action =  'Voyage  publié'
                }

                swal.fire({
                    title: 'êtes-vous sûr de vouloir changer l\'état de ce voyage?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui',
                    cancelButtonText:'Non, annuler'
                }).then((result) => {
                    if (result.value) {
                        axios.put('/change_state_voyage/'+slug)
                            .then((response) => {
                                swal.fire(
                                    message_action,
                                    'L\'état du voyage a été modifié.',
                                    'success'
                                );
                                this.message_button(response.data.etat);
                                this.voyage_detail.etat = response.data.etat;
                            })
                            .catch(err => console.log(err));
                    }
                })
            },
        }

    }
</script>

<style scoped>

    .image-div img{
        border-radius: 5px;
    }
    label {
        color: #002752;
        display: block;
        font-size: 15px;
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

    .nonActive {
        background-color: #3C4858;
    }

    .active {
        background-color: #92ac56;
    }

    .publie{
        background-color: #1c7430;
    }
    .blocked {
        background-color:  red;
    }

</style>