<template>
    <div class="row">
        <div class="col-12" v-if="list_partenaire != null || !recherche_approfondi">

            <!-- User Interface controls -->
            <b-row class="toolbar">
                <b-col md="5" style="text-align: left">
                    <b-row class="my-1">
                        <b-col sm="7" style="text-align: right">
                            <label >Nombre d'éléments par page</label>
                        </b-col>
                        <b-col sm="3" >
                            <b-form-select v-model="perPage" :options="pageOptions" size="sm"></b-form-select>
                        </b-col>
                    </b-row>
                    <b-row v-if="recherche_approfondi">
                        <div class="col-12">
                            <h3>{{message_approfondi}}</h3>
                        </div>
                    </b-row>
                </b-col>
                <div class="col-7">
                    <div class="row">
                        <div class="col-12">
                            <div class="wrap ">
                                <div class="search">
                                    <b-form-input v-model="filter" class="searchTerm" placeholder="Que cherchez-vous ?"> </b-form-input>
                                    <button type="button" class="searchButton" @click="deeper_search">
                                        Approfondi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <template v-if="recherche_approfondi">
                        <div class="row">
                            <b-form-group class="col-4">
                                <label >Pays de l'agence</label>
                                <b-form-select v-model="search.pays" :options="pays" v-on:input="charger_ville(search.pays)">
                                    <template slot="first">
                                        <option :value="null" disabled> -- Pays --</option>
                                    </template>
                                </b-form-select>
                            </b-form-group>
                            <b-form-group class="col-4">
                                <label> Ville de l'agence : </label>
                                <b-form-select  v-model="search.ville" :options="villes" v-on:input="partenaire_ville(search.ville)">
                                    <template slot="default">
                                        <option :value="null" disabled> -- Ville --</option>
                                    </template>
                                </b-form-select>
                            </b-form-group>
                        </div>
                    </template>
                </div>
            </b-row>
            <!-- Main table element -->
            <b-table
                stacked="md"
                :items="list_partenaire"
                :fields="fields"
                :current-page="currentPage"
                :per-page="perPage"
                :filter="filter"
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                :sort-direction="sortDirection"
                @filtered="onFiltered"
                head-variant="dark"
                class="table table-striped responsive table-bordered"
            >
                <template slot="nom_partenaire" slot-scope="row">
                    <b>{{ row.value}}</b>
                </template>

                <template slot="type_partenaire" slot-scope="row">
                    <b>{{ row.value}}</b>
                </template>

                <template slot="site_web" slot-scope="row">
                    <b>{{ row.value}}</b>
                </template>

                <template slot="etat" slot-scope="row">
                    <p v-bind:class="{
                    active: row.value === 2 ,
                    notactive: row.value===1 ,
                    blocked: row.value===3}">
                        {{lire_etat(row.value)}}
                    </p>
                </template>

                <template slot="actions" slot-scope="row">
                    <b-button pill variant="info" size="sm" v-b-tooltip.hover title="Détail du partenaire"  @click="onDetail(row.item)">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                    </b-button>
                    <b-button v-if="!is_agent || row.item.etat===1" pill variant="warning" size="sm"
                              v-b-tooltip.hover title="Modifier" @click="onUpdate(row.item)">
                        <i class="fa fa-pencil-square-o"></i>
                    </b-button>
                    <b-button v-if="is_admin|| is_controller" pill variant="danger" size="sm" v-b-tooltip.hover title="Supprimer"
                               @click="removePartenaire(row.item, row.index)">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </b-button>
                </template>
            </b-table>
            <b-row>
                <hr>
                <b-col class="my-1">
                    <div style="float: right;">
                        <b-pagination
                                v-model="currentPage"
                                :total-rows="totalRows"
                                :per-page="perPage"
                                first-text="Début"
                                prev-text="Précédent"
                                next-text="Suivant"
                                last-text="Fin"
                                class="mt-4"
                        ></b-pagination>
                    </div>

                </b-col>
            </b-row>

        </div>
        <template v-if="list_partenaire == null" class="col-12">
            <b-alert show variant="danger">Pas de partenaire enregistré pour le moment</b-alert>
        </template>
    </div>
</template>

<script>

    import VueAxios from 'vue-axios';
    import axios from 'axios';
    import * as handle_user from '../../handle_user';
    Vue.use(VueAxios, axios);

    export default {
        data(){
            return {
                list_partenaire : [],
                partenaire: '',
                pays : [],
                all_cities: [],
                villes: [],

                recherche_approfondi : false,

                // Les entêtes du data table
                fields: [
                    { key: 'nom_partenaire', label: 'Nom Partenaire', sortable: true, sortDirection: 'desc' },
                    { key: 'type_partenaire', label: 'Type', sortable: true},
                    { key: 'site_web', label: 'Site Web' },
                    { key: 'etat', label: 'Status', sortable: true },
                    { key: 'actions', label: 'Actions'}
                ],

                message_approfondi: '',

                search: {
                  'pays': null,
                  'ville' : null,
                },


                disabledDates: {
                    to: new Date(Date.now() - 8640000)
                },

                // La pagination
                totalRows: 1,
                currentPage: 1,
                perPage: 10,
                pageOptions: [5, 10, 15],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,

                // User infos
                is_admin : false,
                is_controller : false,
                is_agent : false,

            }
        },
        mounted() {
            var object_encours = this ;
            handle_user.get_connected_user_role(
                () => {
                    object_encours.all_partenaire();
                    object_encours.load_all_cities();
                    object_encours.load_countries();
                    object_encours.is_admin = handle_user.is_admin();
                    object_encours.is_controller = handle_user.is_controlleur();
                    object_encours.is_agent = handle_user.is_agent();
                }
            );
        },

        methods: {

            partenaire_ville($ville) {
                this.list_partenaire = [] ;
                axios.get('/partenaire/deeper_search_villes/'+this.nom_ville($ville))
                    .then((response) => {
                        this.list_partenaire = response.data;
                        this.totalRows = this.list_partenaire.length;
                        this.message_approfondi = 'Partenaire de : ' + this.nom_ville($ville);

                    }).catch(err => console.log(err));
            },

            partenaire_pays($id_pays) {
                this.list_partenaire = [] ;
                axios.get('/partenaire/deeper_search_pays/'+this.nom_pays($id_pays))
                    .then((response) => {
                        this.list_partenaire = response.data;
                        this.totalRows = this.list_partenaire.length;
                        this.message_approfondi = 'Partenaire de : ' + this.nom_pays($id_pays);

                    }).catch(err => console.log(err));
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

            nom_pays($id_pays) {
                let name = '';
                this.pays.forEach( (p) => {
                    if (p.value === $id_pays) {
                        name = p.text;
                    }
                });
                return name;
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
            charger_ville(id_pays) {
                this.villes = [];
                this.partenaire_pays(id_pays);
                this.all_cities.forEach( (city) => {
                    if (city.pays_id === id_pays) {
                        this.villes.push({
                            value: city.id,
                            text: city.nom,
                        });
                    }
                });
            },

            nom_ville(id_ville) {
                let name = '';
                this.all_cities.forEach( (city) => {
                    if (city.id === id_ville) {
                        name = city.nom;
                    }
                });
                return name;
            },



            deeper_search() {
              this.message_approfondi = '';
              this.recherche_approfondi = !this.recherche_approfondi;
              this.all_partenaire();
            },
            removePartenaire(part, index) {
                if (part.etat === 2) {
                    swal.fire(
                        'Oupss !',
                        'Vous ne pouvez pas supprimer un partenaire actif',
                        'error'
                    );
                    return;
                }
                swal.fire({
                    title: 'êtes-vous sûr de vouloir supprimer?',
                    text: "Vous ne pourrez plus le récuperer! ",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Supprimer!',
                    cancelButtonText:'Non, annuler'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/partenaire/'+part.slug)
                            .then( (response) => {
                                swal.fire(
                                    'Supprimé!',
                                    'Le partenaire a été supprimé.',
                                    'success'
                                );
                                this.list_partenaire.splice(index , 1);
                                this.totalRows = this.totalRows - 1 ;
                            })
                    }
                })
            },

            lire_etat(etat) {
                switch (etat) {
                    case 1:
                        return 'Non Activé';
                    case 2:
                        return  'Activé';
                    case 3:
                        return 'Bloqué';
                }

            },

            all_partenaire() {
                axios.get('/partenaire')
                    .then( (response) => {
                        this.list_partenaire = response.data.content;
                        this.totalRows = this.list_partenaire.length;
                    }).catch( () => {
                    this.list_partenaire = null;
                });
            },

            onDetail(partenaire) {
                this.$root.$emit('detail-partenaire', partenaire );
            },

            onUpdate(partenaire) {

                if (partenaire.etat !== 1) {
                    swal.fire(
                        'Oupsss !',
                        'Vous ne pouvez pas modifier les informations  d\'un partenaire actif',
                        'error'
                    );
                    return;
                }
                this.$root.$emit('update-partenaire', partenaire );
            },

            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }

        },
    }
</script>
<style scoped>
    .image-div img{
        width: 200px;
        height: 150px;
    }

    .search {
        width: 100%;
        display: flex;
    }

    .searchTerm {
        width: 100%;
        border: 2px solid #00B4CC;
        border-right: none;
        padding: 5px;
        height: 40px;
        border-radius: 5px 0 0 5px;
        color: #9DBFAF;
    }

    .searchTerm:focus{
        color: #10707f;
    }

    .searchButton {
        height: 40px;
        border: 1px solid #00B4CC;
        background: #00B4CC;
        text-align: center;
        color: #fff;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
        font-size: 20px;
    }

    /*Resize the wrap to see the search bar change!*/
    .wrap{
        width: 100%;
        position: relative;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        margin-bottom: 20px;
    }
    label {
        color: #002752;
        display: block;
        font-size: 15px;
    }

    select{
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
        font-size: 15px;
        color: #0b2e13;
    }

    .notactive {
        font-size: 15px;
        color: #00669c;
    }

    .active {
        font-size: 15px;
        color: #1c7430;
    }

    .blocked {
        font-size: 15px;
        color: red;
    }
</style>
