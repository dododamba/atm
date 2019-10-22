

    <template>
        <b-card title="Création de Positions annonce" >
            <b-card-text>
                <form @submit.prevent="onSubmit" enctype="multipart/form-data">


                    <div class="form-group">
                        <h6 class=' text-default'><span  class="important">Titre</span> <em class="text-light">(saisir)</em></h6>

                        <input required type="text"  @keypress="empechsaisie($event)" class=" form-control form-control-lg"   id="libelle" v-model="libelle" name="libelle" placeholder="titre du position l'annonce" />
                        <p class='text-right text-small' style="color: midnightblue" v-bind:class="">{{this.libelle.length}} Caractéres saisies| maxi  30</p>

                    </div>

                    <hr>
                    <div class="form-group">
                        <h6 class='  text-default'><span class="important">Le Contenue du type annonce</span> <em class="text-light">(saisir)</em></h6>
                        <textarea required class="form-control" v-model="description" v-on:keyup="countdown" id="description" placeholder="Description " rows="12"></textarea>
                        <p class='text-right text-small'   style="color: midnightblue" v-bind:class="">{{this.description.length}}  Caractéres | 100</p>

                    </div>
                    <hr  class="mnhr">


                    <hr>


                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
  <button type="submit" variant="outline-success" v-on:click="onlist()" class="btn btn-block btn-outline-success btn-success ">
                            <i class="fa fa-dot-circle-o"></i> <strong>Enregistrer</strong>
                        </button>
                            </div>
                            <div class="col-6">
                                  <b-button type="reset"  class="btn btn-block btn-outline-danger btn-danger ">
                            <i class="fa fa-ban"></i> <strong>Annuler</strong>
                        </b-button>

                            </div>

                        </div>
                      
                      

                    </div>
                </form>
                <hr>
                  <hr  class="mnhr">

                <h2>Liste Des positions Annonces Mise a jour.</h2> <br>
                <hr>

                    <b-container class="row">
                        <div class="col-12" v-if="records1 != null">

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
                                    :items="records1.content.data"
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
                                <template slot="libelle" slot-scope="row">
                                    {{ row.value}}
                                </template>

                                <template slot="description" slot-scope="row">
                                    {{ row.value}}
                                </template>

                                <template slot="created_at_human" slot-scope="row">
                                    {{ row.value}}
                                </template>


                                <template slot="actions" slot-scope="row">


                                    <b-button  pill variant="danger" size="sm" v-b-tooltip.hover title="Supprimer"
                                               @click="remove(row.item)">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </b-button>
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
                        <div id="modal">
                            <create-typeannonce @recordAdded="all_types"></create-typeannonce>
                            <edit-typeannonce :editRec="editRec" @recordUpdated="all_types"></edit-typeannonce>
                            <show-typeannonce :viewRec="editRec"></show-typeannonce>
                        </div>
                        <template v-if="records1 == null" class="row">
                            <b-alert show variant="danger">Pas de positions annonces enregistré pour le moment</b-alert>
                        </template>
                    </b-container>











            </b-card-text>

        </b-card>
    </template>






<script>
    import axios from 'axios';

    export default {

        data() {
            return {
                libelle: '',
                description: '',
                editRec: [],
                errors: [],

                fields: [
                    { key: 'libelle', label: 'libelle', sortable: true, sortDirection: 'desc' },
                    { key: 'description', label: 'description', sortable: true, class: 'text-center' },
                    { key: 'created_at', label: 'Crée le' ,sortable: true, class: 'text-center'},
                    { key: 'actions', label: 'Suppression' }
                ],

                totalRows: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                record : {},
                records : {},
                records1 : {},


            }
        },

        mounted() {
            this.all_types();
        },
        methods: {
            // compte des mots
            countdown: function() {
                this.remainingCount = this.maxCount - this.contenue.length;
                // this.hasError = this.remainingCount < 0;
            },

            all_types(page) {
                let ar = this;
                if (typeof page === 'undefined') {
                    page = 1;
                }

                axios.get('/positionannonce?page=${page}')
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
            remove(part) {
                swal.fire({
                    title: 'êtes-vous sûr de vouloir supprimer?',
                    text: "Vous ne pourrez plus le récuperer! ",
                    type: '',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Supprimer!',
                    cancelButtonText:'Non, annuler'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/positionannonce/'+part.slug)
                            .then( (response) => {
                                swal.fire(
                                    'Supprimé!',
                                    'Le type a été supprimé.',
                                    'success'
                                );
                                this.all_types();
                            })
                    }
                })
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },


            onSubmit() {
                var new_annonce = {
                    'libelle': this.libelle,
                    'description': this.description,


                };

                axios.post('/positionannonce', new_annonce)
                    .then(() => {
                        toast.fire({
                            type: 'success',
                            title: 'Position annonce créer avec succées'
                        })
                        this.all_types();

                    }).catch((response) => {
                    alert("non enregistrer")
                    console.log(response);
                });
            },
        }

    }
</script>

<style scoped>
  .important:after {
        content: " *";
        color: red;
        font-size: 15px;
    }
    .count{
        font-size: 20px;
        color: green;
    }


    .mnhr{
        border: 3px solid green;
        border-radius: 1px;


    }

</style>