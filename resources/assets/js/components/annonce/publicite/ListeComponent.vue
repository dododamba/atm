<template>
  <b-card  >
            <b-card-text>


           
               


                    <div class="card-body">
                        <input @keyup="searchRecord" class="form-control mb-3" placeholder="Recherche "
                               type="text"
                               v-model="search">
                        <table class="table  table-striped table-bordered">

                        <thead class="text-uppercase text-primary">
                            <tr class="text-primary text-center">
                                <th scope="col"></th>
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
                                <td class="img-row">
                          <div class="img-wrapper">
                            <img src="" class="img-raised">
                          </div>
                        </td>
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
                    </div>
               
                <div class="col-md-4 offset-4 mt-4">
                    <pagination :data="records" v-on:pagination-change-page="list"></pagination>
                </div>
          
      

        <div id="modal">
            <create-pub @recordAdded="list"></create-pub>
            <edit-pub :editRec="editRec" @recordUpdated="list"></edit-pub>
            <show-pub :viewRec="editRec"></show-pub>
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
                record : {},
                records : {},
                editRec: [],
                errors: [],
                
                is_completed:[]
            }
        },


        components: {
            Pagination
        },


        methods: {
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

            get(slug) {

                axios.get(`/annonce/${slug}`)
                    .then((response) =>{ this.editRec = response.data.content;
                    console.log(editRec)
                    })
                    .catch(
                    function(response){
                    console.log(response)

                })
            },

            remove(slug) {
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
                            axios.delete(`/annonce/${slug}`)
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
            activation (slug) {
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
                                this.record.etat = 4;
                                axios.put(`/annonce/${slug}`, this.record)
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

