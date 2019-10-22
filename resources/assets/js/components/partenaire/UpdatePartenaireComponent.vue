<template>
    <div class="card">
        <div class="card-body">
        <form @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="row">
                <div class="col-9">
                    <div class="row">
                        <b-form-group class="col-6">
                            <label class="obligatoire">Nom du partenaire</label>
                            <b-form-input size="sm" id="name"  v-model="partenaire_form.name" type="text" required></b-form-input>
                        </b-form-group>

                        <b-form-group class="col-6">
                            <label for="site_web"> Site web du partenaire :</label>
                            <b-form-input size="sm" id="site_web"  v-model="partenaire_form.site_web" type="text"></b-form-input>
                        </b-form-group>
                    </div>
                    <div class="row">

                        <b-form-group label-for="adresse" class="col-6">
                            <label class="obligatoire">Adresse du partenaire</label>
                            <b-form-input size="sm" id="adresse"  v-model="partenaire_form.adresse_partenaire" type="text" required></b-form-input>
                        </b-form-group>
                        <b-form-group class="col-6">
                            <label class="obligatoire" >Email : </label>
                            <b-form-input v-model="partenaire_form.email_partenaire">
                            </b-form-input>
                        </b-form-group>

                    </div>
                    <div class="row">
                        <b-form-group class="col-6">
                            <label for="numero_tel"  >Numero du téléphone</label>
                            <b-form-input size="sm" id="numero_tel"  v-model="partenaire_form.numero_tel" type="text"></b-form-input>
                        </b-form-group>

                        <b-form-group  class="col-6">
                            <label for="typePartenaire" class="obligatoire"> Type du partenaire: {{partenaire_form.type_partenaire}}</label>
                            <b-form-select id="typePartenaire" v-model="partenaire_form.type_partenaire" :options="liste_type">
                                <template slot="first">
                                    <option :value="null" disabled> --Changer le type du partenaire--</option>
                                </template>
                            </b-form-select>

                        </b-form-group>
                    </div>
                </div>
                <div class="col-3">
                    <imageComponent :logo="detail_partenaire.logo"></imageComponent>
                    <label > Logo du partenaire</label>
                </div>
            </div>

            <div class="row">
                <b-form-group class="col-9">
                    <label for="description" >Description du partenaire</label>
                    <b-form-textarea
                            id="description"
                            v-model="partenaire_form.description"
                            rows="5"
                            style="height: 85%; max-height: 100%;">
                    </b-form-textarea>
                </b-form-group>
                <div class="col-3">
                    <br>
                    <b-button block size="sm" variant="info" onclick="document.getElementById('piece_jointe').click()">
                        <i style="font-size: 20px;" class="fa fa-paperclip" aria-hidden="true"></i> Pièces Jointes
                    </b-button>
                    <input id="piece_jointe"
                           style="display: none"
                           type="file"
                           multiple @change="onInputFile"/>
                    <div v-show="pieces_jointes.length">
                        <p v-for="(file, index) in pieces_jointes" :key="index">
                            <span v-text="files_tmp[index].name"></span>(
                            <span v-text="getFileSize(files_tmp[index].size)"></span>)
                            <i v-b-tooltip.hover title="Supprimer" style="color: #772510; cursor: pointer;"
                               @click="removeFile(index)" class="fa fa-times" aria-hidden="true">
                            </i>
                        </p>
                    </div>

                </div>
            </div>


            <!-- Si ce n'est pas un partenaire de type Entreprise alors -->
            <template v-if="!isEntreprise">
                <hr>
                <h2> Information agence principale </h2>
                <div class="row">
                    <b-form-group class="col-4" >
                        <label for="libelle_agence" class="obligatoire">Nom agence</label>
                        <b-form-input size="sm" type="text" id="libelle_agence" v-model="agence_form.libelle"> </b-form-input>
                    </b-form-group>

                    <b-form-group class="col-4">
                        <label for="contact_agence" > Contact agence</label>
                        <b-form-input size="sm" type="text" id="contact_agence" v-model="agence_form.contact"> </b-form-input>
                    </b-form-group>

                    <b-form-group class="col-4">
                        <label for="adresse_agence" class="obligatoire"> Adresse</label>
                        <b-form-input size="sm" type="text" id="adresse_agence" v-model="agence_form.adresse"> </b-form-input>
                    </b-form-group>
                </div>
                <div class="row">
                    <b-form-group class="col-4">
                        <label for="email_agence"> Email agence </label>
                        <b-form-input size="sm" type="email" id="email_agence" v-model="agence_form.email"> </b-form-input>
                    </b-form-group>
                    <b-form-group class="col-4">
                        <label > Pays agence principale</label>
                        <b-form-select v-model="agence_form.pays" :options="pays" v-on:input="charger_ville(agence_form.pays)" >
                            <template slot="first">
                                <option :value="null" disabled> -- Selectionnez un pays --</option>
                            </template>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group class="col-4">
                        <label class="obligatoire"> Ville agence : {{ville_id(detail_partenaire.agence_principale.ville)}}</label>
                        <b-form-select v-model="agence_form.ville" :options="villes">
                            <template slot="first">
                                <option :value="null" disabled> -- Selectionnez une ville --</option>
                            </template>
                        </b-form-select>
                    </b-form-group>
                </div>
                <div class="row">
                    <h4 class="col-4">Localisation de l'agence : </h4>
                    <b-form-group class="col-4">
                        <label >Longitude : </label>
                        <b-form-input placeholder=" - 2.287592" v-model="agence_form.longitude" ></b-form-input>
                    </b-form-group>

                    <b-form-group class="col-4">
                        <label >Latitude : </label>
                        <b-form-input placeholder=" 48.862725" v-model="agence_form.latitude" ></b-form-input>
                    </b-form-group>
                </div>
            </template>

            <div class="row">
                <div class="col-3 offset-9">
                    <br> <br>
                    <b-button block type="submit"  variant="success" size="sm" class="float-right" >
                        Engregistrer
                    </b-button>
                </div>
            </div>
            <!-- les autres agences du partenaire seulement si c'est un partenaire type entreprise -->
           <template v-if="isEntreprise">
               <div class="row">
                   <div class="col-6">
                       <h4>Manager agences du partenaire</h4>
                   </div>
                   <div class="col-6">
                       <div style="text-align: right">
                           <b-button variant="outline-success" v-on:click="add_agence_modal()" size="sm">
                               <i class="fa fa-plus"></i> Ajouter Agence
                           </b-button>
                       </div>
                   </div>
                   <hr>
               </div>
               <div class="row">
                   <div class="single-table col-12">
                       <div class="table-responsive">
                           <table class="table text-center">
                               <thead class="text-uppercase thead-dark">
                               <tr class="text-white">
                                   <th scope="col">Libelle </th>
                                   <th scope="col">Contact </th>
                                   <th scope="col">Adresse </th>
                                   <th scope="col">Email</th>
                                   <th scope="col">ville</th>
                                   <th scope="col">Action</th>
                               </tr>
                               </thead>
                               <tbody>
                               <tr v-for="agence in agences">
                                   <td>{{ agence.libelle }}</td>
                                   <td>{{ agence.contact}}</td>
                                   <td>{{ agence.adresse}}</td>
                                   <td>{{ agence.email}}</td>
                                   <td>{{ ville_id(agence.ville)}}</td>
                                   <td>
                                       <b-button pill variant="warning" size="sm" v-b-tooltip.hover title="Modifier"  @click="update_agence_modal(agence)">
                                           <i class="fa fa-pencil-square-o"></i>
                                       </b-button>
                                       <b-button pill variant="danger" size="sm" v-b-tooltip.hover title="Supprimer"
                                          @click="delete_agence(agence)">
                                           <i class="fa fa-trash-o" aria-hidden="true"></i>
                                       </b-button>

                                   </td>
                               </tr>

                               </tbody>
                           </table>
                       </div>
                   </div>

               </div>
            </template>
        </form>

        <!-- le modal -->
        <div>
            <b-modal v-model="showModal" :title="titleModal" :header-bg-variant="headerBgVariant"
                    :header-text-variant="headerTextVariant" :body-bg-variant="bodyBgVariant"
                    :body-text-variant="bodyTextVariant" :footer-bg-variant="footerBgVariant"
                     :footer-text-variant="footerTextVariant" size="lg">
                <b-container style="width: auto">
                    <div>
                        <form @submit.prevent="handle_agence">
                        <b-row >
                            <b-form-group class="col-6">
                                <label class="obligatoire">Nom agence : </label>
                                <b-form-input size="sm" type="text" v-model="agence_form.libelle"> </b-form-input>
                                <p v-if="errors_agence.libelle" style="color: red">
                                    {{errors_agence.libelle[0]}}
                                </p>
                            </b-form-group>

                            <b-form-group class="col-6">
                                <label >Contact agence</label>
                                <b-form-input size="sm" type="text" v-model="agence_form.contact"> </b-form-input>
                                <p v-if="errors_agence.contact" style="color: red">
                                    {{errors_agence.contact[0]}}
                                </p>
                            </b-form-group>

                        </b-row>
                        <div class="row">
                            <b-form-group class="col-6">
                                <label class="obligatoire">Adresse </label>
                                <b-form-input size="sm" type="text" v-model="agence_form.adresse"> </b-form-input>
                                <p v-if="errors_agence.adresse" style="color: red">
                                    {{errors_agence.adresse[0]}}
                                </p>
                            </b-form-group>

                            <b-form-group class="col-6">
                                <label > Email</label>
                                <b-form-input size="sm" type="email" v-model="agence_form.email"> </b-form-input>
                                <p v-if="errors_agence.email" style="color: red">
                                    {{errors_agence.email[0]}}
                                </p>
                            </b-form-group>
                        </div>
                        <div class="row">
                            <b-form-group class="col-6">
                                <label >Pays agence</label>
                                <b-form-select v-model="agence_form.pays" :options="pays" v-on:input="charger_ville(agence_form.pays)" >
                                    <template slot="first">
                                        <option :value="null" disabled> -- Choisir --</option>
                                    </template>
                                </b-form-select>
                            </b-form-group>
                            <b-form-group class="col-6">
                                <label v-if="modification"> Ville Actuelle : {{ville_id(ville_tmp)}}</label>
                                <label v-if="!modification"> Ville agence : </label>
                                <b-form-select v-model="agence_form.ville" :options="villes" required>
                                    <template slot="default">
                                        <option :value="null" disabled> --Choisir--</option>
                                    </template>
                                </b-form-select>
                                <p v-if="errors_agence.ville" style="color: red">
                                    {{errors_agence.ville[0]}}
                                </p>
                            </b-form-group>
                        </div>
                        <div class="row">
                            <b-form-group class="col-6">
                                <label >Longitude </label>
                                <b-form-input size="sm" type="text" v-model="agence_form.longitude"> </b-form-input>
                            </b-form-group>

                            <b-form-group class="col-6">
                                <label > Latitude</label>
                                <b-form-input size="sm" type="email" v-model="agence_form.latitude"> </b-form-input>
                            </b-form-group>
                        </div>
                    </form>

                    </div>
                </b-container>

                    <b-row slot="modal-footer" class="w-100" fluid>
                        <div class="col-4"><b-button block variant="danger" @click="showModal=false" >
                            Annuler
                        </b-button></div>
                        <div class="col-3"></div>
                        <div class="col-4"><b-button type="submit" block variant="success" @click="handle_agence" >
                            Engregistrer
                        </b-button> </div>
                        <div class="col-1"></div>
                    </b-row>
            </b-modal>
        </div>
        </div>
    </div>


</template>

<script>

    import axios from 'axios';

    Vue.use(axios);

    export default {
        props: ['partenaire'],

        data () {
            return {

                modalShow: false,
                ville_tmp: '',
                detail_partenaire: '',
                agences: [],

                modification: false,
                isEntreprise: false,

                pays: [] ,
                all_cities: [],
                villes: [],
                pieces_jointes: [],
                files_tmp: [],


                partenaire_form : {
                    name: '',
                    site_web: '',
                    adresse_partenaire: '',
                    email_partenaire:'',
                    type_partenaire:'',
                    description: '',
                    numero_tel: '',
                    logo : null,
                    etat: null,
                },


                liste_type: [
                    { value: 'Entreprise', text: 'Entreprise' },
                    { value: 'Particulier', text: 'Particulier' }
                ],

                errors_agence: [],
                agence_form: {
                    libelle: '',
                    contact: '',
                    adresse: '',
                    email: '',
                    slug: '',
                    longitude: '',
                    latitude: '',
                    pays: null,
                    ville: null,
                    partenaire: null,
                },


                agence_principale: '',

                showModal: false,
               // Config Modal
                titleModal: 'Modification',
                headerBgVariant: 'dark',
                headerTextVariant: 'light',
                bodyBgVariant: 'light',
                bodyTextVariant: 'dark',
                footerBgVariant: 'warning',
                footerTextVariant: 'dark'
            }
        },

        mounted() {
            this.charger_info_partenaire();
            this.load_countries();
            this.load_all_cities();

            // On écoute le composant image
            this.$root.$on('image' , (image_loaded) => {
                this.put_logo(image_loaded);
            });
        },

        methods: {


            removeFile(index) {
                this.files_tmp.splice(index, 1);
                this.pieces_jointes.splice(index, 1);
            },
            onInputFile(e) {
                const files = e.target.files;

                Array.from(files).forEach(file => this.addFile(file));
            },
            addFile(file) {
                if (!file.type.match('image.*') && !file.type.match('application.pdf')  ) {
                    toast.fire({
                        type: 'error',
                        title: 'Erreur !',
                        html: `${file.name} n'est ni une image ni un pdf`
                    });
                    return;
                }

                this.files_tmp.push(file);

                var reader = new FileReader();

                reader.onload = (e) => this.pieces_jointes.push(e.target.result);

                reader.readAsDataURL(file);
            },

            getFileSize(size) {
                const fSExt = ['Bytes', 'KB', 'MB', 'GB'];
                let i = 0;

                while(size > 900) {
                    size /= 1024;
                    i++;
                }

                return `${(Math.round(size * 100) / 100)} ${fSExt[i]}`;
            },

            put_logo($image) {
                this.partenaire_form.logo = $image;
            },

            charger_info_partenaire() {

                // On recupère le partenaire avec toutes ses relations
                axios.get('/partenaire/'+this.partenaire.slug)
                    .then( (response) => {
                        this.detail_partenaire = response.data.content;

                        // Agn=ence principale
                        this.agence_principale = this.detail_partenaire.agence_principale;


                        // On initialise le formulaire
                        this.partenaire_form.name = this.detail_partenaire.nom;
                        this.partenaire_form.site_web = this.detail_partenaire.site_web;
                        this.partenaire_form.adresse_partenaire = this.detail_partenaire.adresse;
                        this.partenaire_form.description = this.detail_partenaire.description;
                        this.partenaire_form.numero_tel = this.detail_partenaire.numero_tel;
                        this.partenaire_form.type_partenaire = this.detail_partenaire.type;
                        this.partenaire_form.logo = this.detail_partenaire.logo;
                        this.partenaire_form.etat = this.detail_partenaire.etat;

                        // Calcul du type du partenaire
                        this.isEntreprise = (this.detail_partenaire.type === 'Entreprise')?true:false;

                        this.agences = [];

                        if (this.isEntreprise) { // Est-ce un partenaire de type Entreprise
                            // Dans ce cas charger ses agences

                            this.detail_partenaire.agences.forEach( (agence) => {
                                    this.agences.push({
                                        libelle: agence.libelle,
                                        contact: agence.contact,
                                        adresse: agence.adresse,
                                        email: agence.email,
                                        longitude: agence.longitude,
                                        latitude: agence.latitude,
                                        ville: this.ville_id(agence.ville),
                                        id_ville: agence.ville,
                                        slug: agence.slug,
                                        id: agence.id,
                                    });
                            });

                        } else {
                            // On intialise le formulaire agence principale

                            this.agence_form.libelle = this.agence_principale.libelle;
                            this.agence_form.contact = this.agence_principale.contact;
                            this.agence_form.adresse = this.agence_principale.adresse;
                            this.agence_form.email = this.agence_principale.email;
                            this.agence_form.ville = this.agence_principale.ville;
                            this.agence_form.latitude = this.agence_principale.latitude;
                            this.agence_form.longitude = this.agence_principale.longitude;

                        }

                        // On charger la ville à partir de l'ID
                        this.ville_principale = this.ville_id(this.detail_partenaire.agence_principale.ville)                    })
                    .catch(error => { console.log(error)})
            },

            update_agence_modal(agence) {

                this.errors_agence = [];
                this.agence_form.libelle = agence.libelle;
                this.agence_form.contact = agence.contact;
                this.agence_form.adresse = agence.adresse;
                this.agence_form.email = agence.email;
                this.agence_form.slug = agence.slug;
                this.agence_form.longitude = agence.longitude;
                this.agence_form.latitude = agence.latitude;
                this.agence_form.pays = null;
                this.agence_form.ville = agence.id_ville;
                this.agence_form.partenaire= this.detail_partenaire.id;

                this.ville_tmp = agence.ville;
                this.modification =  true ;

                this.showModal = !this.showModal;
                this.titleModal = "Modification de l'agence";
            },

            delete_agence(agence) {

                // On ne doit pas supprimer l'agence principale
                if (agence.id == this.detail_partenaire.agence_principale.id) {
                    swal.fire({
                        type: 'error',
                        title: 'Oops !!!!!',
                        text: 'Vous ne pouvez pas supprimer l\'agence principale !',
                    })
                }else {
                    swal.fire({
                        title: 'êtes-vous sûr de vouloir supprimer cette agence?',
                        text: "Vous ne pourrez plus le récuperer! ",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, Supprimer!',
                        cancelButtonText:'Non, annuler'
                    }).then((result) => {
                        if (result.value) {
                            axios.delete('/agence/' + agence.slug)
                                .then( (response) => {
                                    swal.fire({
                                        title: 'Supprimé!',
                                        type: 'success',
                                        texte: 'L\'agence a été supprimé.',
                                    });
                                    this.charger_info_partenaire();
                                })
                        }
                    })
                }
            },


            add_agence_modal() {
                this.errors_agence = [];

                this.agence_form.libelle = '';
                this.agence_form.contact = '';
                this.agence_form.adresse = '';
                this.agence_form.email = '';
                this.agence_form.slug = '';
                this.agence_form.pays = null;
                this.agence_form.ville = null;
                this.agence_form.longitude = '';
                this.agence_form.latitude = '' ;
                this.agence_form.partenaire= this.detail_partenaire.id;


                this.showModal = !this.showModal;
                this.titleModal = "Ajout d'une agence";
                this.modification = false;
            },

            partenaireChanged() {
                if (this.partenaire_form.name === this.detail_partenaire.nom &&
                    this.partenaire_form.site_web === this.detail_partenaire.site_web &&
                    this.partenaire_form.adresse_partenaire === this.detail_partenaire.adresse &&
                    this.partenaire_form.description === this.detail_partenaire.description &&
                    this.partenaire_form.numero_tel === this.detail_partenaire.numero_tel &&
                    this.partenaire_form.type_partenaire === this.detail_partenaire.type &&
                    this.partenaire_form.logo === this.detail_partenaire.logo &&
                    this.partenaire_form.etat === this.detail_partenaire.etat) {
                    return false

                } else {
                    return true

                }
            },

            agenceChanged() {

               if (this.agence_principale.libelle === this.agence_form.libelle &&
                    this.agence_principale.contact === this.agence_form.contact &&
                    this.agence_principale.adresse === this.agence_form.adresse &&
                    this.agence_principale.email === this.agence_form.email &&
                    this.agence_principale.longitude === this.agence_form.longitude &&
                    this.agence_principale.latitude === this.agence_form.latitude &&
                    this.agence_principale.ville === this.agence_form.ville) {
                   return false;

               } else {
                   return true;
               }
            },

            onSubmit(){

                let isChanged = false;
                // On teste s'il y a eu changement

                if(this.partenaireChanged()){
                    axios.put('/partenaire/' + this.detail_partenaire.slug, this.partenaire_form)
                        .then((response) => {
                            if (!this.isEntreprise && this.agenceChanged()) {
                                axios.put('/agence/' + this.agence_principale.slug, this.agence_form)
                                    .then((response) => {
                                        toast.fire({
                                            type: 'success',
                                            title: 'Succès',
                                            html: 'Partenaire Modifié avec succès'
                                        });
                                    })
                            } else {
                                toast.fire({
                                    type: 'success',
                                    title: 'Succès',
                                    html: 'Partenaire Modifié avec succès'
                                });
                            }
                            this.charger_info_partenaire();
                        })
                        .catch(err => console.log(err));
                } else {
                    if (!this.isEntreprise && this.agenceChanged()) {
                        axios.put('/agence/' + this.agence_principale.slug, this.agence_form)
                            .then((response) => {
                                toast.fire({
                                    type: 'success',
                                    title: 'Succès',
                                    html: 'Partenaire Modifié avec succès'
                                });
                                this.charger_info_partenaire();
                            })
                    } else {
                        toast.fire({
                            type: 'error',
                            title: 'Attention !',
                            html: 'Vous n\'avez modifié aucune information'
                        });
                    }
                }
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
                this.all_cities.forEach( (city) => {
                    if (city.pays_id === id_pays) {
                        this.villes.push({
                            value: city.id,
                            text: city.nom,
                        });
                    }
                });
            },


            ville_id(id_seek){
                let $ville = id_seek;
                this.all_cities.forEach( (city) => {
                    if (city.id === id_seek) {
                        $ville = city.nom;
                    }
                });
                return $ville;
            },

            handle_agence(){
                if (this.modification) {
                    // Nous sommes dans le cas de modification d'une agence
                    axios.put('/agence/' + this.agence_form.slug, this.agence_form )
                        .then((response) => {
                            swal.fire(
                                'Modifié!',
                                'L\'agence a été modifié.',
                                'success'
                            );
                            this.charger_info_partenaire();
                            this.showModal = false ;
                        }).catch(err => console.log(err))

                } else {
                    // Nous sommes dans la création d'une d'une agence

                    axios.post('/agence/', this.agence_form )
                        .then((response) => {
                            if (response.data.status === 1 ) {
                                this.showModal = false ;
                                this.charger_info_partenaire();
                                this.errors_agence = [],
                                swal.fire(
                                    'Ajout!',
                                    'L\'agence a été ajouté.',
                                    'success'
                                );
                            } else  {
                                // Erreurs de validation
                                this.errors_agence = response.data.errors;
                                toast.fire({
                                    type: 'error',
                                    title: 'Ajout!',
                                    html : response.data.message
                                });
                            }
                        }).catch(err => console.log(err))
                }
            }

        },
    }
</script>

<style scoped>
    label.obligatoire:after {
        content: " *";
        color: red;
        font-size: 15px;
    }
    label {
        color: #002752;
        display: block;
        font-size: 15px;
    }
    h2 {
        color: #005cbf;
        font-size: 30px;
        font-weight: bold;
    }
    span {
        color: #0b2e13;
        font-size: 10px;
    }
    select, input, textarea{
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
    }
</style>