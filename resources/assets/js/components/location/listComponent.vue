<template>
    <div class="row">
        <div class="col-12" v-if="liste_locations != null || recherche_approfondi">
            <template v-if="recherche_approfondi">
                <b-row>
                    <div class="form-group col-3">
                        <label> Date début</label>
                        <date-picker
                                width="100%"
                                v-model="search_form.date_debut"
                                type="date" lang="fr"
                                value-type='format'
                                :first-day-of-week="1">
                        </date-picker>
                    </div>
                    <div class="form-group col-3">
                        <label> Date fin </label>
                        <date-picker
                                width="100%"
                                v-model="search_form.date_fin"
                                type="date"  lang="fr" value-type='format'
                                :first-day-of-week="1" :not-before=search_form.date_debut>
                        </date-picker>
                    </div>
                    <div class="form-group col-3">
                        <label for="etat_location" > état de la location </label>
                        <select v-model="search_form.etat" class="form-control" id="etat_location">
                            <option :value="null"  selected > -- toutes les locations -- </option>
                            <option :value=e.value v-for="e in liste_etats">{{e.text}}</option>
                        </select>
                    </div>
                </b-row>
                <div class="row">
                    <div class="form-group  col-3">
                        <label for="pays" class="col-form-label"> Pays </label>
                        <select v-model="search_form.pays" id="pays" class="form-control" @click="charger_ville">
                            <option :value="null" selected> Tous les pays </option>
                            <option :value=p.value v-for="p in liste_pays"> {{p.text}}</option>
                        </select>
                    </div>
                    <div class="form-group  col-3">
                        <label for="ville_depart" class="col-form-label"> Ville </label>
                        <select v-model="search_form.ville" id="ville_depart" class="form-control">
                            <option :value="null"  selected> toutes les villes </option>
                            <option :value=v.value v-for="v in ville_pays"> {{v.text}}</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <br><br>
                        <b-button block @click="cancel_search" size="sm" variant="outline-danger">
                            Annuler</b-button>
                    </div>
                    <div class="col-3">
                        <br><br>
                        <b-button block @click="search_location" size="sm" variant="outline-success">
                            Chercher </b-button>
                    </div>
                </div>
                <hr>
            </template>

            <!-- User Interface controls -->
            <b-row class="toolbar">
                <b-col md="5">
                    <b-row class="my-1">
                        <b-col sm="7">
                            <label >Nombre d'éléments par page</label>
                        </b-col>
                        <b-col sm="3">
                            <b-form-select v-model="perPage" :options="pageOptions" size="sm"></b-form-select>
                        </b-col>
                    </b-row>
                </b-col>
                <div class="col-7" >
                    <div class="wrap">
                        <div class="search">
                            <b-form-input v-model="filter" class="searchTerm" placeholder="Que cherchez-vous ?"> </b-form-input>
                            <button type="button" class="searchButton" @click="deeper_search">
                                Approfondir
                            </button>
                        </div>
                    </div>
                </div>
            </b-row>
            <b-table
                    stacked="md"
                    :items="liste_locations"
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"
                    :filter="filter"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    :sort-direction="sortDirection"
                    @filtered="onFiltered"
                    class="table responsive table-bordered"
            >
                <template slot="get_partenaire" slot-scope="row">
                    {{ row.value.nom_partenaire}}
                </template>

                <template slot="get_ville" slot-scope="row">
                    {{ row.value.nom}}
                </template>

                <template slot="titre" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="date_debut_human" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="date_fin_human" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="etat" slot-scope="row">
                    {{ libelle_etat(row.value)}}
                </template>

                <template slot="actions" slot-scope="row">
                    <b-button pill variant="info" v-b-tooltip.hover title="Détail du voyage" size="sm" @click="onShowDetail(row.item)">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                    </b-button>
                    <b-button pill variant="warning" size="sm"
                              v-if="!is_agent || row.item.etat===1"
                              v-b-tooltip.hover title="Modifier"
                              @click="updateLocation(row.item)">
                        <i class="fa fa-pencil-square-o"></i>
                    </b-button>
                    <b-button v-if="is_admin || is_controller" pill variant="danger" size="sm"  v-b-tooltip.hover title="Supprimer"
                              @click="removeLocation(row.item, row.idex)">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </b-button>
                </template>
            </b-table>
            <b-row>
            <div class="col-5">
                 <br>
                 <b-button
                         @click="next_page_location(pagination_backend.next_page)"
                         size="sm" variant="success"
                         v-if="pagination_backend.next_page !== null"
                 >
                     Charger plus d'éléments
                 </b-button>
             </div>
             <div class="col-7">
                 <div class="pagination_class">
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
             </div>
            </b-row>
        </div>
        <template v-if="liste_locations==null" class="col-12">
            <b-alert show variant="warning" class="col-12">
                Pas de Locations enregistré pour le moment
            </b-alert>
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
              liste_locations : null,

              pagination_backend: {
                  'page': 1,
                  'par_page': 300,
                  'total': 0,
                  'next_page': null,
                  'total_page': 0,
                  'count': 0,
              },
              url_all_location : '/location',

                fields: [
                    {key: 'get_partenaire', label: 'partenaire',  sortable: true, sortDirection: 'desc'},
                    {key: 'get_ville', label: 'Ville',  sortable: true, sortDirection: 'desc'},
                    {key: 'titre', label: 'titre',  sortable: true, sortDirection: 'desc'},
                    {key: 'date_debut_human', label: 'Date début',  sortable: true, sortDirection: 'desc'},
                    {key: 'date_fin_human', label: 'Date fin'},
                    {key: 'etat', label: 'etat',  sortable: true, sortDirection: 'desc'},
                    {key: 'actions', label: 'Actions'},
                ],

                // La pagination
                totalRows: 0,
                currentPage: 1,
                perPage: 10,
                pageOptions: [5, 10, 15],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,

                // Variable pour recherche approfondie
                recherche_approfondi: false,
                ville_pays: [],
                liste_pays: [],
                villes: [],


                search_form: {
                    'date_debut': '',
                    'date_fin': '',
                    'pays': null,
                    'ville': null,
                    'etat' : null
                },
                liste_etats: [
                    {text: 'Non validé', value: 1},
                    {text: 'Validé', value: 2},
                    {text: 'Publié', value: 3},
                    {text: 'Désactivé' , value: 4},
                ],

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
                    this.all_location(this.url_all_location);
                });
        },

        methods: {
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

            search_location() {
                axios.post('/location/deeper_search', this.search_form)
                    .then((response) => {
                        this.liste_locations =response.data;
                    }).catch(err => console.log(err))
            },

            // Charger les villes
            load_cities() {
                this.villes = [];
                let $villes = [];
                this.axios.get('/ville')
                    .then((response) => {
                        $villes = response.data.content;
                        $villes.forEach((ville) => {
                            this.villes.push({
                                id: ville.id,
                                nom: ville.nom,
                                pays_id: ville.pays.id
                            })
                        })
                    }).catch(err => console.log(err));
            },

            // En fonction du pays de depart
            charger_ville() {
                this.search_form.ville = null;
                this.ville_pays = [];
                this.villes.forEach( (city) => {
                    if (city.pays_id === this.search_form.pays) {
                        this.ville_pays.push({
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

            cancel_search() {
                this.recherche_approfondi = false;
                this.search_form.pays = null ;
                this.search_form.ville = null ;
                this.search_form.date_debut = '' ;
                this.search_form.date_fin = '';
                this.search_form.etat = null;
                this.all_location(this.url_all_location);
            },

            deeper_search() {
                if (this.recherche_approfondi)
                    this.cancel_search();
                else {
                    this.load_countries();
                    this.load_cities();
                    this.recherche_approfondi = true;
                }
            },
            removeLocation(location, index) {
                swal.fire({
                    title: 'êtes-vous sûr de vouloir  supprimer?',
                    text: "Vous ne pourrez plus le récuperer! ",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Supprimer!',
                    cancelButtonText:'Non, annuler'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/location/'+location.slug)
                            .then( (response) => {
                                swal.fire(
                                    'Supprimé!',
                                    'La location a été supprimé.',
                                    'success'
                                );
                                this.liste_locations.splice(index, 1);
                                this.totalRows = this.totalRows -1 ;
                            })
                    }
                })
            },


            all_location(url) {
                this.liste_locations = null;
                axios.get(url)
                .then((response) => {
                    this.liste_locations = response.data.content.data;
                    this.pagination_backend.next_page = response.data.content.next_page_url;
                }).catch( (err) => {
                    this.liste_locations = null;
                });
            },

            next_page_location(url) {
                axios.get(url)
                    .then((response) => {
                        this.pagination_backend.next_page = response.data.content.next_page_url;
                        response.data.content.data.forEach((location) => {
                            this.liste_locations.push(location);
                        })
                    }).catch( err => console.log(err));
            },

            onShowDetail(location) {
                this.$root.$emit('detail-location', location);
            },

            updateLocation(location) {
                if (location.etat !== 3){
                    this.$root.$emit('update_location', location);
                } else {
                    swal.fire({
                        title: 'Oops...',
                        text: 'Vous ne pouvez pas un modifier une location déjà publié! \n desactivez la publication',
                    })
                }
            },

            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1;
            }
        },
    }
</script>


<style scoped>
    .pagination_class {
        float: right;
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
        font-size: 15px;
    }
    .pagination_class {
        float: right;
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
        padding: 5px;
        outline: none;
        font-size: 15px;
        color: lightblue;
    }

</style>
