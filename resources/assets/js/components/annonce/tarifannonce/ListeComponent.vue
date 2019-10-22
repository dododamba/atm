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
                                  <th scope="col">N¤</th>
                                <th scope="col"></th>

                               
                                <th scope="col">Type</th>
                               
                                <th scope="col">Prix Par Caractere</th>
                                <th scope="col">Prix Image</th>
                                <th scope="col">Inserer le</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="record in records.content.data" class="text-center">
                                <td v-text="conteur++">
                           

                        </td>
                         <td class="img-row">
                          <div class="img-wrapper">
                            <img src="" class="img-raised">
                          </div>
                        </td>
                       
                                <td v-text="record.type_annonce"></td>
                                
                                <td v-text="record.prix_caractere/record.nbre_caractere+record.devise"></td>
                                 <td v-text="record.prix_image+record.devise"></td>
                               <td v-text="record.created_at_human"></td>
                               

                                <td>

                                    <button disabled class="btn btn-outline-info btn-sm  btn-link" title="Détail de l'annonce"  data-toggle="modal" data-target="#viewRecord" @click="get(record.slug)"><i class="fa fa-eye"></i></button>

                                    <button disabled class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editRecord" @click="get(record.slug)"><i class="fa fa-edit"></i></button>

                                    <button class="btn btn-outline-danger btn-sm" @click="remove(record.slug)"><i class="fa fa-trash"></i></button>
                                    <button disabled class="btn btn-outline-primary btn-sm" @click="activation(record.slug)"><i class="fa fa-globe"></i></button>
                                </td>





                            </tr>


                            </tbody>
                        </table>
                    </div>
               
                <div class="col-md-4 offset-4 mt-4">
                    <pagination :data="records" v-on:pagination-change-page="list(page)"></pagination>
                </div>
          
      

        <div id="modal">
            <create-tarifannonce @recordAdded="list"></create-tarifannonce>
            <edit-tarifannonce :editRec="editRec" @recordUpdated="list"></edit-tarifannonce>
            <show-tarifannonce :viewRec="editRec"></show-tarifannonce>
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
                conteur:0,
                 record1 : {},
                record2 : {},
                records : [],
                records1 : [],
                records2 : [],
                editRec: [],
                errors: [],
                
                is_completed:[]
            }
        },


        components: {
            Pagination
        },


        mounted() {
           
            this.load_position();
            this.all_types();


        },
        methods: {
             all_types(page) {
                let ar = this;
                if (typeof page === 'undefined') {
                    page = 1;
                }

                axios.get('/typeannonce?page=${page}')
                    .then(function(response){
                        ar.records1 = response.data;
                        this.totalRows = this.records1.length;

                        console.log(ar.records1)
                    }).catch(
                    function(response){
                        console.log(response)

                    }
                );

            },
             load_position() {

                let ar = this;
                axios.get('/positionannonce?page=${page}')
                    .then(function(response){
                        ar.records2 = response.data;
                        console.log(ar.records2)
                    }).catch(
                    function(response){
                        console.log(response)

                    }
                );
            },
           



            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }

                axios.get(`/tarifannonce?page=${page}`)
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

                axios.get('/tarifannonce?page=${page}').then(function(response){
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

                axios.get(`/tarifannonce/${slug}`)
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
                            axios.delete(`/tarifannonce/${slug}`)
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
                                axios.put(`/tarifannonce/${slug}`, this.record)
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
                    axios.get(`/tarifannonce/search/${this.search}`)
                        .then(response => this.records = response)
                        .catch(error => console.log(error))
                } else {
                    this.list();
                }
            }
        },
        created() {
            axios.get('/tarifannonce')
                .then(response => this.records = response.data)
                .catch(error => console.log(error))
        }
    }
</script>

