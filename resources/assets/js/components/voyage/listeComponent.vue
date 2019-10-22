<template>
    <div class="row">
        <div class="col-12" v-if="liste_voyages != null || recherche_approfondi">
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
                        <label for="moyen_transport" > Moyen de transport </label>
                        <select v-model="search_form.moyen_transport" class="form-control" id="moyen_transport">
                            <option :value="null"  selected > -- toutes les voies  -- </option>
                            <option :value=mt.value v-for="mt in moyen_transports">{{mt.text}}</option>
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <label for="etat_voyage" > état du voyage </label>
                        <select v-model="search_form.etat_voyage" class="form-control" id="etat_voyage">
                            <option :value="null"  selected > -- toutes les voyages -- </option>
                            <option :value=e.value v-for="e in liste_etats">{{e.text}}</option>
                        </select>
                    </div>
                </b-row>
                <div class="row">
                    <div class="form-group  col-3">
                        <label for="pays_depart" class="col-form-label"> Pays de départ</label>
                        <select v-model="search_form.pays_depart" id="pays_depart" class="form-control" @click="charger_ville_depart">
                            <option :value="null" selected> Tous les pays </option>
                            <option :value=p.value v-for="p in liste_pays"> {{p.text}}</option>
                        </select>
                    </div>
                    <div class="form-group  col-3">
                        <label for="ville_depart" class="col-form-label"> Ville de départ </label>
                        <select v-model="search_form.ville_depart" id="ville_depart" class="form-control">
                            <option :value="null"  selected> toutes les villes </option>
                            <option :value=v.value v-for="v in liste_ville_depart"> {{v.text}}</option>
                        </select>
                    </div>

                    <div class="form-group  col-3">
                        <label for="pays_arrive" class="col-form-label"> Pays de destination </label>
                        <select v-model="search_form.pays_arrive" id="pays_arrive" class="form-control" @click="charger_ville_arrive">
                            <option :value="null"  selected> Tous les pays </option>
                            <option :value=p.value v-for="p in liste_pays"> {{p.text}}</option>
                        </select>
                    </div>
                    <div class="form-group  col-3">
                        <label for="ville_arrivee" class="col-form-label"> Ville de destination </label>
                        <select v-model="search_form.ville_arrivee" id="ville_arrivee" class="form-control">
                            <option :value="null"> Toutes les villes</option>
                            <option :value=v.value v-for="v in liste_ville_arrivee"> {{v.text}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 offset-4">
                        <b-button @click="cancel_search" size="sm" variant="danger">Annuler</b-button>
                        <b-button @click="search_voyage" size="sm" variant="success">Chercher </b-button>
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
                <div class="col-7">
                    <div class="wrap">
                        <div class="search">
                            <b-form-input v-model="filter" class="searchTerm" placeholder="Que cherchez-vous ?"> </b-form-input>
                            <button type="button" class="searchButton" @click="deeper_search">
                                Approfondi
                            </button>
                        </div>
                    </div>
                </div>
            </b-row>
            <b-table
                    stacked="md"
                    :items="liste_voyages"
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
                <template slot="partenaire" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="ville_depart" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="ville_arrivee" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="moyen_transport" slot-scope="row">
                    {{row.value}}
                </template>

                <template slot="date_depart" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="libelle_etat" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="actions" slot-scope="row">
                    <b-button pill variant="info" v-b-tooltip.hover title="Détail du voyage" size="sm" @click="onShowDetail(row.item)">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                    </b-button>
                    <b-button pill variant="warning" size="sm"  v-b-tooltip.hover title="Modifier"
                              v-if="!is_agent || row.item.etat===1" @click="updateVoyage(row.item)">
                        <i class="fa fa-pencil-square-o"></i>
                    </b-button>
                    <b-button pill variant="danger" size="sm"  v-b-tooltip.hover title="Supprimer"
                              v-if="is_admin || is_controller" @click="removeVoyage(row.item, row.index)">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </b-button>
                </template>
            </b-table>
            <b-row>
                <hr>
                <div class="col-5">
                    <br>
                    <b-button
                            @click="all_voyage(pagination_backend.page+1, pagination_backend.par_page)"
                            size="sm" variant="success"
                            v-if="liste_voyages.length<pagination_backend.total && !recherche_approfondi"
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
        <template v-if="liste_voyages==null && !recherche_approfondi" class="col-12">
            <b-alert show variant="danger" class="col-12">Pas de Voyage enregistré pour le moment</b-alert>
        </template>
    </div>
</template>

<script>

    import VueAxios from 'vue-axios';
    import axios from 'axios';
    import DatePicker from 'vue2-datepicker';
    import * as handle_user from '../../handle_user';
    Vue.use(VueAxios, axios);

    export default {
        components: {DatePicker},
        data(){
            return {
                liste_voyages : [],

                fields: [
                    {key: 'partenaire', label: 'partenaire',  sortable: true, sortDirection: 'desc'},
                    {key: 'ville_depart', label: 'Ville départ',  sortable: true, sortDirection: 'desc'},
                    {key: 'ville_arrivee', label: 'Ville arrivée',  sortable: true, sortDirection: 'desc'},
                    {key: 'moyen_transport', label: 'Moyen',  sortable: true, sortDirection: 'desc'},
                    {key: 'date_depart_human', label: 'Date départ'},
                    {key: 'libelle_etat', label: 'etat',  sortable: true, sortDirection: 'desc'},
                    {key: 'actions', label: 'Actions'},
                ],

                // La pagination
                totalRows: 1,
                currentPage: 1,
                perPage: 10,
                pageOptions: [5, 10, 15, 20],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,


                pagination_backend: {
                    'page': 1,
                    'par_page': 300,
                    'total': 0,
                    'total_page': 0,
                    'count': 0,
                },

                // Variable pour recherche approfondie
                recherche_approfondi: false,
                liste_ville: [],
                liste_pays: [],
                villes: [],
                liste_ville_depart: [],
                liste_ville_arrivee: [],


                search_form: {
                    'date_debut': '',
                    'date_fin': '',
                    'pays_depart': null,
                    'pays_arrive': null,
                    'ville_depart': null,
                    'ville_arrivee': null,
                    'moyen_transport': null,
                    'etat_voyage' : null,
                },
                moyen_transports: [
                    {text: 'Routier', value: 1},
                    {text: 'Ferroviaire', value: 2},
                    {text: 'Maritime', value: 3},
                    {text: 'Aérien' , value: 4},
                ],
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
            var object =this ;
            handle_user.get_connected_user_role(
                () => {
                    this.all_voyage(this.pagination_backend.page, this.pagination_backend.par_page);
                    object_encours.is_admin = handle_user.is_admin();
                    object_encours.is_controller = handle_user.is_controlleur();
                    object_encours.is_agent = handle_user.is_agent();
                });
        },

        methods: {

            search_voyage() {
                axios.post('/voyage/deeper_search', this.search_form)
                    .then((response) => {
                        this.liste_voyages = [];
                        this.remplir_data_table(response.data);
                    }).catch(err => console.log(err))
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

            // En fonction du pays de depart
            charger_ville_depart() {
                this.search_form.ville_depart = null;
                this.liste_ville_depart = [];
                this.liste_ville.forEach( (city) => {
                    if (city.pays_id === this.search_form.pays_depart) {
                        this.liste_ville_depart.push({
                            value: city.id,
                            text: city.nom,
                        });
                    }
                });
            },

            charger_ville_arrive() {
                this.search_form.ville_arrivee = null;
                this.liste_ville_arrivee = [];
                this.liste_ville.forEach( (city) => {
                    if (city.pays_id === this.search_form.pays_arrive) {
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

            cancel_search(){
                this.liste_voyages = [];
                this.all_voyage(1, this.pagination_backend.par_page);
                this.recherche_approfondi = false;
                this.search_form.pays_depart = null ;
                this.search_form.pays_arrive = null ;
                this.search_form.ville_arrivee = null ;
                this.search_form.ville_depart = null ;
                this.search_form.date_debut = '' ;
                this.search_form.date_fin = '';
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

            removeVoyage(voyage, index) {
                swal.fire({
                    title: 'êtes-vous sûr de vouloir  supprimer?',
                    text: "Vous ne pourrez plus le récuperer! ",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Supprimer!',
                    cancelButtonText:'Non, annuler'
                }).then((result) => {if (result.value) {
                    axios.delete('/voyage/'+voyage.slug)
                        .then( (response) => {
                            swal.fire(
                                'Supprimé!',
                                'Le voyage a été supprimé.',
                                'success'
                            );
                            this.liste_voyages.splice($index, 1);
                            this.pagination_backend.total = this.pagination_backend.total - 1;
                        })
                }
                })
            },

            // La function qui de la liste de voyage un voyage dont on connait l'id
            delete_from_liste(id_voyage) {
                var $index = 0;
                this.liste_voyages.forEach((voyage) => {
                    if(voyage.id === id_voyage) {
                        this.liste_voyages.splice($index, 1);
                        this.pagination_backend.total = this.pagination_backend.total - 1;
                        return;
                    }
                    $index ++ ;
                })
            },
            remplir_data_table($voyages) {
                $voyages.forEach((voyage) => {
                    axios.get('/itineraire/' + voyage.itineraire.slug)
                        .then((itt) => {
                            this.liste_voyages.push({
                                id: voyage.id,
                                numero: voyage.numero,
                                date_depart: voyage.date_depart,
                                moyen_transport: this.name_transport(voyage.moyen_transport),
                                nombre_place: voyage.nombre_place,
                                etat: voyage.etat,
                                libelle_etat: this.libelle_etat(voyage.etat),
                                image: voyage.image,
                                heure_depart: voyage.heure_depart,
                                slug: voyage.slug,
                                created_at_human: voyage.created_at_human,
                                date_depart_human: voyage.date_depart_human,
                                personnel: voyage.valider_par,
                                ville_depart: itt.data.content.ville_depart.nom,
                                ville_arrivee: itt.data.content.ville_arrivee.nom,
                                partenaire: voyage.partenaire.nom_partenaire,
                                itineraire: voyage.itineraire.slug,
                                tarifs: voyage.tarif,
                                description: voyage.description,
                                duree: voyage.duree,
                                date_simple: voyage.date_simple
                            });
                        }).catch(err => console.log(err));
                });
            },

            all_voyage(page, par_page){
                axios.get('/voyage?page='+page+'&parPage='+par_page)
                    .then( (response) => {
                        this.pagination_backend.count = response.data.content.pagination.count;
                        this.pagination_backend.page = response.data.content.pagination.current_page;
                        this.pagination_backend.par_page = response.data.content.pagination.per_page;
                        this.pagination_backend.total = response.data.content.pagination.total;
                        this.pagination_backend.total_page = response.data.content.pagination.total_pages;
                        this.remplir_data_table(response.data.content.data);
                    }).catch( (err) => {
                    console.log(err)
                });
            },


            onShowDetail(voyage) {
                this.$root.$emit('detail-voyage', voyage);
            },

            updateVoyage(voyage) {
                if (voyage.etat !== 3){
                    this.$root.$emit('update-voyage', voyage);
                } else {
                    swal.fire({
                        title: 'Oops !!!!! ',
                        text: 'Vous ne pouvez pas un modifier un voyage déjà publié!',
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
