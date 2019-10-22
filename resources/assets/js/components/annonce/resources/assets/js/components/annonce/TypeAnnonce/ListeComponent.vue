<template>
 <b-card  >
            <b-card-text>


         
          


                    <div class="card-body">
                       
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr class="text-primary text-center">
                                <th scope="col">libelle</th>
                                <th scope="col">Description</th>
                                <th scope="col">Date Creation</th>
                                <th scope="col">Detail</th>


                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="record in records.content.data" class="text-center">
                                <td v-text="record.libelle"></td>
                                <td v-text="record.description"></td>
                                <td v-text="record.created_at"></td>




                                <td>
                                    <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#viewRecord" @click="get(record.slug)"><i class="fa fa-eye"></i></button>

                                    <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editRecord" @click="get(record.slug)"><i class="fa fa-edit"></i></button>

                                    <button class="btn btn-outline-danger btn-sm" @click="remove(record.slug)"><i class="fa fa-trash"></i></button>
                                </td>

                            </tr>


                            </tbody>
                        </table>
                    </div>
             
                <div class="col-md-4 offset-4 mt-4">
                    <pagination :data="records" v-on:pagination-change-page="list"></pagination>
                </div>
           
    
        <div id="modal">
            <create-typeannonce @recordAdded="list"></create-typeannonce>
            <edit-typeannonce :editRec="editRec" @recordUpdated="getResults"></edit-typeannonce>
            <show-typeannonce :viewRec="editRec"></show-typeannonce>
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
                search: ''
            }
        },


        components: {
            Pagination
        },


        methods: {

            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }

                axios.get(`/typeannonce?page=${page}`)
                    .then(response => this.records = response.data)
                    .catch(error => console.log(error))
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

                axios.get('/typeannonce?page=${page}')
                    .then(function(response){
                        ar.records = response.data;
                        console.log(ar.records)
                    }).catch(
                    function(response){
                        console.log(response)

                    }
                );
            },



            refreshRecord(record) {
                this.records = record.data.content;
            },

            get(slug) {
                axios.get(`/typeannonce/${slug}`)
                    .then(response => this.editRec = response.data.content)
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
                            axios.delete(`/typeannonce/${slug}`)
                                .then(response => {
                                    this.refreshRecord(response);

                                    swal.fire(

                                        'Supprimé!',
                                        'Ce Type d\'annonce a été supprimé.',
                                        'success'
                                    );
                                    this.list();
                                })
                        }
                    })
            },

            searchRecord() {
                if (this.search.length >= 3) {
                    axios.get(`/typeannonce/search/${this.search}`)
                        .then(response => this.records = response)
                        .catch(error => console.log(error))
                } else {
                    this.list();
                }
            }
        },
        created() {
            axios.get('/typeannonce')
                .then(response => this.records = response.data)
                .catch(error => console.log(error))
        }




    }
</script>

