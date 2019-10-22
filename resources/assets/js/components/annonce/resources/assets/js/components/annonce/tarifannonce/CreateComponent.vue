

<template>
    <b-card >
        <hr  class="mnhr">

        <form @submit.prevent="onSubmit" enctype="multipart/form-data">

            <template>

                <ul class="nav  nav-tabs" id="myTab" role="tablist">


                    <li class="baccouleur nav-item">
                        <a class="nav-link count text-dark" v-bind:class="{active : etape===1} " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Choix & Tarif</a>
                    </li>
                    <li class="baccouleur nav-item">
                        <a class="nav-link count text-dark" v-bind:class="{active : etape===2} " id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Verification & validations</a>
                    </li>
                    <li class="baccouleur nav-item">
                        <a class="nav-link count text-dark" v-bind:class="{active : etape===3} " id="contact-tab" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact2" aria-selected="false"> Liste Type Mise a jours</a>
                    </li>
                    


                </ul>
                <hr  class="mnhr">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" v-bind:class="{active : etape===1,show : etape===1} " id="home" role="tabpanel" aria-labelledby="home-tab">


                        

                       
                
                    



                        <hr>
                        <div class="row ">

                            <div class="form-group col-4">
                                <h6 class='text-default'><span class="important">Nombre des caractéres </span> <em class="text-light"></em></h6>
                                <input required type="number"  @keypress="numerotel($event)" step="5" min="0" max="100" class=" form-control form-control-lg"  :maxlength="max" id="nbrecaractere" v-model="nbrecaractere" name="nbrecaractere" placeholder="Caractéres" />
                                <p class='text-right text-small' style="color: midnightblue" v-bind:class="">{{this.nbrecaractere}} à  {{this.prix}} &nbsp  {{this.devise}}</p>


                                <!--select class="browser-default custom-select custom-select-lg mb-3  text-primary form-control-sm" id="partenaire" name="partenaire" v-model="partenaire" >
                                    <option selected>Selectionner</option>
                                    <option v-for="option in partenaires" v-bind:value="option.value">
                                        {{ option.text }}
                                    </option>
                                </select>
                                <span>Sélectionné : {{ selected }}</span-->
                            </div>
                            <div class=" form-group col-4">
                                <h6 class='text-default'><span class="important">Devise</span> <em class="text-light">(selectioner)</em></h6>
                                <select required class="browser-default custom-select custom-select-lg mb-3  text-primary form-control-sm" id="devise" name="devise" v-model="devise" >
                                    <option value="XAF FCFA">XAF (FCFA)</option>
                                      <option value="XOF">XOF (FCFA)</option>
                                        <option value="USD">Dollar Americain</option>
                                    <option value="Eco">Eco</option>

                                    <option value="€">Euro (€)</option>
                                </select>
                                <small class="form-text text-muted">Choisir La devise</small>

                            </div>

                            <div class=" form-group col-4">
                                <h6 class='text-default'><span class="important">Prix Equivalent :</span> <em class="text-light">(saisir)</em></h6>

                                <div v-if="this.devise">


                                    <input required  type="number" step="1" min="0" max="100" @keypress="numerotel($event)" id="prix" v-model="prix" name="prix" placeholder="prix" class="form-control"><small class="form-text text-muted">saisir prix en {{ this.devise }}</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row ">

                            <div class="form-group col-6">
                                <h6 class=' text-default'><span  class="important">Prix par Image:</span> <em class="text-light">(saisir)</em></h6>

                                <input type="number" step="1.5" min="0" max="100" @keypress=" empechsaisie($event)" class=" form-control form-control-lg"  :maxlength="max" id="priximage" v-model="priximage" name="priximage" placeholder="prix de l'image " required />
                                <p class='text-right text-small' style="color: midnightblue" v-bind:class="">{{this.priximage}} |&nbsp  {{this.devise}} | Par Image</p>


                            </div>


                            <div class=" form-group col-6">
                                <h6 class='text-default'><span class="important">Devise Pour Images</span> <em class="text-light">(selectioner)</em></h6>
                                <select required class="browser-default custom-select custom-select-lg mb-3  text-primary form-control-sm" id="devise1" name="devise" v-model="devise" >
                                    <option value="XAF FCFA">XAF (FCFA)</option>
                                      <option value="XOF">XOF (FCFA)</option>
                                        <option value="USD">Dollar Americain</option>
                                        <option value="Eco">Eco</option>
                                    <option value="€">Euro (€)</option>
                                   
                                </select>
                                <small class="form-text text-muted"></small>


                            </div>
                        </div>

                        <hr>
                        <h6>Parametre</h6>
                        <hr>
                        <div class="row ">
                                            <div class="form-group col-6">
                                                <h6 class='text-default'><span class="important">Type Annonce </span> <em class="text-light">(saisir)</em></h6>

                                                <select required class="browser-default custom-select custom-select-lg mb-3  text-primary form-control-sm"
                                                        id="type" name="type" v-model="type" >
                                                    <option disabled selected>Selectionner</option>


                                                    <option v-for="record in records1.content.data" v-bind:value="record.id" >
                                                        {{ record.libelle }}
                                                    </option>
                                                </select>

                                                <span>Sélectionné : {{ selected1 }}</span>


                                            </div>

                                            <div v-if="this.type!=''"  class="form-group col-6">
                            <h6 class='text-default' ><span class="important">Position de l'annonce sur ecran:</span> <em class="text-light">(selectionner)</em></h6>

                                                <select required class="browser-default custom-select custom-select-lg  text-primary form-control-sm" id="positionId" name="positionId" v-model="positionId" >

                                <option v-for="record in records.content.data" v-bind:value="record.id">
                                    {{ record.libelle }}
                                </option>
                            </select>
                            <span>Sélectionné : {{ selected }}</span>

                                            </div>

                                        </div>
                      
                        <hr>
                    </div>
                    <div class="tab-pane fade"  v-bind:class="{active : etape===2,show : etape===2} " id="profile" role="tabpanel" aria-labelledby="profile-tab">


  <hr>
                        <h2>Verifier l'Information Saisie</h2> <br>
                          <hr>
                        <h6 class='text-default'><span class="important">Devise : </span> <em class="text-light">(i)</em>{{this.devise}}</h6><br/>
                        <h6 class='text-default'><span class="important">Nonbre de caractéres : </span> <em class="text-light">(i)</em>{{this.nbrecaractere}}</h6><br/>
                        <h6 class='text-default'><span class="important">Prix equivalent: </span> <em class="text-light">(i)</em>{{this.prix}}</h6><br/>
                        <h6 class='text-default'><span class="important">Une Image coute : </span> <em class="text-light">(i)</em>{{this.priximage}} {{this.devise}}</h6><br/>
                        <h6 class='text-default'><span class="important">Alors {{this.nbrecaractere}} Caractere Coutent : </span> <em class="text-light">(i)</em>{{this.prix}}{{this.devise}}</h6><br/>

                        <hr>
                    </div>
                    
                    <div class="tab-pane fade"  v-bind:class="{active : etape===3,show : etape===3 } " id="contact1" role="tabpanel" aria-labelledby="contact-tab1">
                       
                   
                        <h2>Liste des Types Annonces Disponibles</h2> <br>
                        <hr>
                        <div >
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
                                  
                                    <template slot="etat" slot-scope="row">
                                        {{ row.value == 2 ? 'Activé' : 'Non activé'}}
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
                                <b-alert show variant="danger">Pas de types annonces enregistré pour le moment</b-alert>
                            </template>
                        </div>


                        <hr>
                    </div>
                </div>

            </template>
            <div class="card-footer">
                 <hr  class="mnhr">
                <div class="row " v-if="etape==2">
                    <div class="col-3" v-if="etape>1">
                        <button type="button"  class="btn btn-block btn-outline-success pull-left"  v-on:click="etape--"  >
                            <i class="fa fa-fast-backward fa-1x"></i>
                            Retour
                        </button>
                    </div>

                    <div  class="col-3" v-if="etape<3" >
                        <button type="reset" class="btn btn-block btn-outline-danger ">
                            <i class="fa fa-ban"></i> <strong>Annuler</strong>
                        </button>
                    </div>

                    <div class="col-3"  v-if="etape==2">
                        <div>
                             <button class="btn btn-outline-success btn-block " type="submit">
                                            <i class="fa fa-dot-circle-o"></i> <strong> <b>Enregistrer</b></strong>
                                        </button>

                        </div>
                      

                    </div>
                    <div class="col-3"  v-if="etape < 2">
                        <button type="button" class="btn btn-block pull-center btn-outline-primary" @click="etape++">
                            Suivant<i class="fa fa-fast-forward fa-1x" aria-hidden="true"></i>
                        </button>
                    </div>






                </div>
                <div class="row " v-else>
                    <div class="col-4" v-if="etape>1">
                        <button type="button"  class="btn btn-block btn-outline-success pull-left"  v-on:click="etape--"  >
                            <i class="fa fa-fast-backward fa-1x"></i>
                            Retour
                        </button>
                    </div>

                    <div  class="col-4" >
                        <button type="reset" class="btn btn-block btn-outline-danger ">
                            <i class="fa fa-ban"></i> <strong>Annuler</strong>
                        </button>
                    </div>


                    <div class="col-4"  v-if="etape < 3">
                        <button type="button" class="btn btn-block pull-center btn-outline-primary" @click="etape++">
                            Suivant<i class="fa fa-fast-forward fa-1x" aria-hidden="true"></i>
                        </button>
                    </div>





                </div>







            </div>
        </form>





    </b-card>
</template>






<script>
    import axios from 'axios';
    import Multiselect from 'vue-multiselect';

    export default {
        components: { Multiselect },

        data() {
            return {
                info: '',
                type: '',
                etape: 1,
                tabIndex: 0,
                editRec: [],
                errors: [],

                fields: [
                    { key: 'libelle', label: 'libelle', sortable: true, class: 'text-center' ,sortDirection: 'desc' },
                    { key: 'description', label: 'description', sortable: true, class: 'text-center' },
                    { key: 'created_at_human', label: 'Crée le' ,sortable: true, class: 'text-center'},
                    { key: 'actions', label: 'Actions', class: 'text-center' }
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

                value: [
                    { name: 'Javascript', code: 'js' }
                ],
                options: [
                    { name: 'Vue.js', code: 'vu' },
                    { name: 'Javascript', code: 'js' },
                    { name: 'Open Source', code: 'os' }
                ],

                libelle: '',
                selected: 'Une position',
                selected1: 'Un Type',
                max: 1000,
                description: '',
                devise: '',
                max: 0,
                devise: '',
                devise1: '',
                nbrecaractere: 0,
                prix: 0,
                priximage: 0,
                positionId: '',
                positions: [],
                partenaires: [],

            }
        },

        mounted() {
            //this.load_partenaire();
            this.load_position();
            this.all_types();


        },
        methods: {
            get(slug) {
                axios.get(`/typeannonce/${slug}`)
                    .then(response => this.editRec = response.data.content)
                    .catch(
                        function(response){
                            console.log(response)

                        })
            },

            onDetail(partenaire) {
                this.$root.$emit('detail-partenaire', partenaire );
            },

            onUpdate(partenaire) {
                this.$root.$emit('update-partenaire', partenaire );
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
                        axios.delete('/typeannonce/'+part.slug)
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

            addTag (newTag) {
                const tag = {
                    name: newTag,
                    code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                this.options.push(tag)
                this.value.push(tag)
            },
              
            load_position() {

                let ar = this;
                axios.get('/positionannonce?page=${page}')
                    .then(function(response){
                        ar.records = response.data;
                        console.log(ar.records)
                    }).catch(
                    function(response){
                        console.log(response)

                    }
                );
            },
            load_partenaire() {

                axios.get('/partenaire')
                    .then((response) =>{
                        response.data.content.forEach( (partenaire) => {
                            this.partenaires.push({
                                value: partenaire.id,
                                text: partenaire.nom_partenaire,
                            });
                        });
                        //console.log(this.partenaires);
                        console.log(response);


                    }).catch((response) => {
                        console.log(response);
                    }
                );
            },
            //EMPECHE SAISIE DES CARACTRERE BIZARE
            empechsaisie: function($event) {
                let specials=/[*|\":<>[\]{}`\\()';@&$]/;
                if((($event.keyCode >= 60) && ($event.keyCode <= 64) || ($event.keyCode >= 123) && ($event.keyCode <= 125) || ($event.keyCode >= 35) && ($event.keyCode <= 38))){
                    $event.returnValue = false;
                    return;
                }
                $event.returnValue = true;
            },
            numerotel: function($event) {
                // return phone.replace(/[^0-9]/g, '')
                //     .replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');

                //let specials=/[*|\":<>[\]{}`\\()';@&$]/;
                if ($event.charCode === 0 || /\d/.test(String.fromCharCode($event.charCode))) {
                    return true
                } else {
                    $event.preventDefault();
                }
            },
            // compte des mots
            countdown: function() {
                this.remainingCount = this.maxCount - this.description.length;
                // this.hasError = this.remainingCount < 0;
            },

 onResetForm() {
              
                    this.libelle = '',
                    this.description = '',
                    this.positionId = '',
                    this.nbrecaractere = '',
                    this.devise = '',
                    this.prix = '',
                     this.priximage = '',
                        this.etape=3


                   
            },

            onSubmit() {
                var new_annonce = {
                   
                    'position': this.positionId,
                    'type_annonce': this.type,
                    'nbre_caractere': this.nbrecaractere,
                    'devise': this.devise,
                    'prix_caractere': this.prix,
                    'prix_image': this.priximage,


                }

                axios.post('/tarifannonce', new_annonce)
                    .then(() => {
                        toast.fire({
                            type: 'success',
                            title: 'Enregistrer avec succes!'
                        });
this.onResetForm();
                       


                    }).catch((response) => {
                    alert("enregistrer")
                    console.log(response);
                });
            },
        }

    }
</script>

<style scoped>
    span.important:after {
        content: " *";
        color: red;
        font-size: 15px;
    }
    h6.important:after {
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

    .baccouleur{
        background-color: aqua;
        border: 0 none;
    }

</style>