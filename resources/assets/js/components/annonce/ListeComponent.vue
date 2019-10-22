<template>
  <b-card  >
            <b-card-text>


       
               

                        <div class="tab-content" id="myTabContent">
                            <ul class="nav  nav-tabs" id="myTab" role="tablist">


                                <li class="baccouleur nav-item">
                                    <a class="nav-link count  text-dark" v-bind:class="{active : etape===1} " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"> Liste  Detailé</a>
                                </li>
                                <li class="baccouleur nav-item">
                                    <a class="nav-link count text-dark" v-bind:class="{active : etape===2} " id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Liste pour les suppressions</a>
                                </li>
                                <!--li class="nav-item">
                                    <a class="nav-link count text-dark" v-bind:class="{active : etape===3} " id="contact-tab" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact2" aria-selected="false">Images</a>
                                </li>
                                <li class="nav-item count">
                                    <a class="nav-link count text-dark" v-bind:class="{active : etape===4} " id="contact-tab1" data-toggle="tab" href="#contact1" role="tab" aria-controls="contact1" aria-selected="false">Validation</a>
                                </li-->


                            </ul>
                            <hr  class="mnhr">
                             <div class="tab-pane fade" v-bind:class="{active : etape===1,show : etape===1} " id="home" role="tabpanel" aria-labelledby="home-tab">
                                <liste2></liste2>
                            </div>
                              <div class="tab-pane fade"  v-bind:class="{active : etape===2,show : etape===2} " id="profile" role="tabpanel" aria-labelledby="profile-tab">



                                <div class="col-12" v-if="records != null">

                                    <!-- User Interface controls -->
                                    <b-row class="toolbar">
                                        <b-col md="5" style="text-align: left">
                                            <b-row class="my-1">
                                                <b-col sm="7" style="text-align: left">
                                                    <label >Nombre d'éléments par page</label>
                                                </b-col>
                                                <b-col sm="3" >
                                                    <b-form-select v-model="perPage" :options="pageOptions" size="sm"></b-form-select>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                        <b-col md="7" style="text-align: right">
                                            <b-row>
                                                <b-col md="7" style="text-align: right">
                                                    <b-form-group label="Recherche par mot clé" >
                                                    </b-form-group>
                                                </b-col>
                                                <b-col md="5">
                                                    <b-form-input v-model="filter" placeholder="Saisir ici"></b-form-input>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                    <!-- Main table element -->
                                    <b-table
                                            stacked="md"
                                            :items="records.content.data"
                                            :fields="fields"
                                            :current-page="currentPage"
                                            :per-page="perPage"
                                            :filter="filter"
                                            :sort-by.sync="sortBy"
                                            :sort-desc.sync="sortDesc"
                                            :sort-direction="sortDirection"
                                            @filtered="onFiltered"
                                            head-variant="hight"
                                            class="table table-striped responsive table-bordered" cellspacing="0" width="100%"
                                    >
                                        <template slot="titre" slot-scope="row">
                                            {{ row.value}}
                                        </template>

                                        <template slot="annonceur" slot-scope="row">
                                            {{ row.value}}
                                        </template>
                                        <template slot="contact" slot-scope="row">
                                            {{ row.value}}
                                        </template>

                                        <template slot="dateDebutHuman" slot-scope="row">
                                            {{ row.value}}
                                        </template>
                                        <template slot="date_fin_human" slot-scope="row">
                                            {{ row.value}}
                                        </template>
                                        <!--template slot="created_at_human" slot-scope="row">
                                            {{ row.value}}
                                        </template-->
                                        <template slot="positions.libelle" slot-scope="row">
                                            {{ row.value}}
                                        </template>
                                        <template slot="etat" slot-scope="row">

                                            <button v-if="row.value == 2 " class="btn btn-success btn-link " disabled
                                                    data-toggle="modal" data-target="#viewRecord" @click="get(record.slug)"> Active
                                            </button>
                                            <button v-if="row.value==1" class="btn btn-danger btn-xs  btn-link " disabled data-toggle="modal" data-target="#viewRecord" @click="get(row.item)">
                                                Désactive
                                            </button>
                                            <button v-if="row.value==3" class="btn btn-danger btn-xs  btn-link " disabled data-toggle="modal" data-target="#viewRecord" @click="get(row.item)">
                                                Debloquer
                                            </button>
                                            <button v-if="row.value==4" class="btn btn-success btn-xs  btn-link " disabled data-toggle="modal" data-target="#viewRecord" @click="get(row.item)">
                                                Publier
                                            </button>                                </template>

                                        <template slot="actions" slot-scope="row">


                                            <!--button class="btn btn-outline-info btn-sm  btn-link" title="Détail de l'annonce"  data-toggle="modal" data-target="#viewRecord" @click="get(row.item)"><i class="fa fa-eye"></i></button-->

                                            <!--button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editRecord" @click="get(row.item)"><i class="fa fa-edit"></i></button-->

                                            <button class="btn btn-outline-danger btn-sm" @click="remove(row.item)"><i class="fa fa-trash"></i></button>
                                            <!--button class="btn btn-outline-primary btn-sm" @click="activation(row.item)"><i class="fa fa-globe"></i></button-->

                                        </template>
                                    </b-table>
                                    <b-row>
                                        <b-col class="my-1">
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

                                        </b-col>
                                    </b-row>

                                </div>
                            </div>
                           
                        </div>

                        <template v-if="records == null" class="row">
                            <b-alert show variant="danger">Pas de types annonces enregistré pour le moment</b-alert>
                        </template>
                   




                    <!--div class="card-body">
                        <input @keyup="searchRecord" class="form-control mb-3" placeholder="Recherche "
                               type="text"
                               v-model="search">
                        <table class="table">

                        <thead class="text-uppercase text-primary">
                            <tr class="text-primary text-center">
                                <th scope="col">Titre</th>
                                <th scope="col">Demandeur</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Date Debut</th>
                                <th scope="col">Date Fin</th>
                                <th scope="col">Status</th>
                                <th scope="col">action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="record in records.content.data" class="text-center">
                                <td v-text="record.titre"></td>
                                <td v-text="record.annonceur"></td>
                                <td v-text="record.contact"></td>
                                <td v-text="record.dateDebutHuman"></td>
                                <td v-text="record.date_fin_human"></td>
                                <td>

                                    <button v-if="record.etat == 2 " class="btn btn-success btn-link " disabled
                                            data-toggle="modal" data-target="#viewRecord" @click="get(record.slug)"> Active
                                    </button>
                                    <button v-if="record.etat==1" class="btn btn-danger btn-xs  btn-link " disabled data-toggle="modal" data-target="#viewRecord" @click="get(record.slug)">
                                        Désactive
                                    </button>
                                    <button v-if="record.etat==3" class="btn btn-danger btn-xs  btn-link " disabled data-toggle="modal" data-target="#viewRecord" @click="get(record.slug)">
                                        Debloquer
                                    </button>
                                    <button v-if="record.etat==4" class="btn btn-success btn-xs  btn-link " disabled data-toggle="modal" data-target="#viewRecord" @click="get(record.slug)">
                                        Publier
                                    </button>
                                </td>

                                <td>

                                    <button class="btn btn-outline-info btn-sm  btn-link" title="Détail de l'annonce"  data-toggle="modal" data-target="#viewRecord" @click="get(record.slug)"><i class="fa fa-eye"></i></button>

                                    <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editRecord" @click="get(record.slug)"><i class="fa fa-edit"></i></button>

                                    <button class="btn btn-outline-danger btn-sm" @click="remove(record.slug)"><i class="fa fa-trash"></i></button>
                                    <button class="btn btn-outline-primary btn-sm" @click="activation(record.slug)"><i class="fa fa-globe"></i></button>
                                </td>





                            </tr>


                            </tbody>
                        </table>
                    </div-->

                    <hr>
                    <div class="card-footer">
                        
                        <div class="row ">
                            <div class="col-12" v-if="etape>1">
                                <button type="button"  class="btn btn-block btn-outline-success pull-left"  v-on:click="etape--"  >
                                    <i class="fa fa-fast-backward fa-1x"></i>
                                    Retour
                                </button>
                            </div>




                            <div class="col-12"  v-if="etape!=2">
                                <button type="button" class="btn btn-block pull-center btn-outline-primary" @click="etape++">
                                    Suivant<i class="fa fa-fast-forward fa-1x" aria-hidden="true"></i>
                                </button>
                            </div>


                        </div>




     <hr  class="mnhr">

                    </div>


                
                <!--div class="col-md-4 offset-4 mt-4">
                    <pagination :data="records" v-on:pagination-change-page="list"></pagination>
                </div-->
          

        <div id="modal">
            <create @recordAdded="list"></create>
            <edit :editRec="editRec" @recordUpdated="getResults"></edit>
            <show :viewRec="editRec"></show>
        </div>

 




 </b-card-text>

        </b-card>


</template>
<script>
    import Pagination from 'laravel-vue-pagination'
    import VueAxios from 'vue-axios';
    import axios from 'axios';
    import BootstrapVue from 'bootstrap-vue'

    Vue.use(BootstrapVue)

    Vue.use(VueAxios, axios);
    export default {
        activate : '#activate',

        data(){
            return {

                fields: [
                    { key: 'titre', label: 'Titre', sortable: true ,sortDirection: 'desc' ,  class: 'text-center' },
                    { key: 'contact', label: 'Contact', sortable: true, class: 'text-center' },
                    { key: 'annonceur', label: 'Annonceur', sortable: true, class: 'text-center' },
                    { key: 'dateDebutHuman', label: 'Date de Debut' ,sortable: true, class: 'text-center'},
                    { key: 'date_fin_human', label: 'Date de Fin' ,sortable: true, class: 'text-center'},
                    { key: 'etat', label: 'Status', sortable: true },
                    { key: 'actions', label: 'Actions', class: 'text-center' }
                ],

                etape: 1,
                totalRows: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                parti: [],
                row: {},
                filter: null,

                record : {},
                records : {},
                editRec: [],
                errors: [],
                search: '',
                is_completed:[]
            }
        },


        components: {
            Pagination
        },


        methods: {
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },

            onShowDetail(location) {
                this.$root.$emit('detail-location', location);
            },



            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }

                axios.get(`/annonce?page=${page}`)
                    .then(response => this.records = response.data)
                    .catch(response => console.log(response))
            },

            refreshRecord(record) {
                this.records = record.data;
            },



            activate(){
                this.$refs['my-modal'].show()

            },

            list(page)
            {
                let ar = this;
                if (typeof page === 'undefined') {
                    page = 1;
                }

                axios.get('/annonce?page=${page}').then(function(response){
                    ar.records = response.data;
                    console.log(response);
                    console.log(records);
                }).catch(
                    function(response){
                        console.log(response);
                        console.log(records);

                    }
                );
                console.log(list());

            },



            refreshRecord(record) {
                this.records = record.data.content;
            },


            get(part) {

                axios.get(`/annonce/`+part.slug)
                    .then((response) =>{ this.editRec = response.data.content;
                        console.log(editRec)
                    })
                    .catch(
                        function(response){
                            console.log(response)

                        })
            },

            remove(part) {
                swal.fire({
                    title: 'êtes-vous sûr de vouloir  supprimer?',
                    text: "Vous ne pourrez plus le récuperer! ",
                    type: '',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Supprimer!',
                    cancelButtonText:'Non, annuler'
                })
                    .then((result) => {
                        if (result.value) {
                            axios.delete(`/annonce/`+part.slug)
                                .then(response => {
                                    this.refreshRecord(response);

                                    swal.fire(

                                        'Supprimé!',
                                        'L\'annonce a été supprimé.',
                                        'success'
                                    );
                                    this.list();
                                })
                        }
                    })
            },
// IB ACTIVATION
            activation (part) {
                swal.fire({
                    title: 'Voulez vous Changer le status?',
                    text: "Vous en  avez la possibilité! ",
                    type: '',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui',
                    cancelButtonText:'Non, annuler'
                })
                    .then((result) => {
                        if (result.value) {
                            //console.log(part);
                            this.part.etat=4;


                            console.log(part);

                            axios.put(`/annonce/`+this.part.slug)
                                .then(response => {
                                    this.refreshRecord(response);

                                    swal.fire(
                                        'Activée avec succés!',
                                        'L\'annonce est accésible au public',
                                        'success'
                                    );
                                    this.list();
                                })
                        }
                    })
            },

            searchRecord() {
                if (this.search.length >= 3) {
                    axios.get(`/annonce/search/${this.search}`)
                        .then(response => this.records = response)
                        .catch(error => console.log(error))
                } else {
                    this.list();
                }
            }
        },
        created() {
            axios.get('/annonce')
                .then(response => this.records = response.data)
                .catch(error => console.log(error))
        }
    }
</script>
<style scoped>
    .count{
        font-size: 20px;
        color: green;
    }


    .mnhr{
        border: 3px solid green;
        border-radius: 1px;


    }
    .baccouleur{
        background-color: aqua;
        border: 0 none;
    }
</style>

