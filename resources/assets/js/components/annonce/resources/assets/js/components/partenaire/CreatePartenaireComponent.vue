<template>
    <div class="card">
        <div class="card-body">
            <b-form @submit.prevent="onSubmit" @reset="onResetForm" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-9">
                        <div class="row">
                            <b-form-group class="col-6">
                                <label class="obligatoire"> Nom du partenaire : </label>
                                <b-form-input placeholder="Saisir le nom du partenaire ici" v-model="name"
                                              :state="valid_name" required>
                                </b-form-input>
                                <p v-if="errors.name" style="color: red"> {{errors.name[0]}}</p>
                            </b-form-group>

                            <b-form-group class="col-6">
                                <label> Site web du partenaire : </label>
                                <b-form-input placeholder="Le Site web du partenaire" v-model="site_web">
                                </b-form-input>
                            </b-form-group>
                        </div>
                        <div class="row">
                            <b-form-group class="col-6">
                                <label class="obligatoire"> Adresse du partenaire :  </label>
                                <b-form-input placeholder="Saisir l'adresse du partenaire" v-model="adresse_partenaire"
                                            :state="valid_adresse_partenaire">
                                </b-form-input>
                                <p v-if="errors.adresse_partenaire" style="color: red">
                                    {{errors.adresse_partenaire[0]}}
                                </p>
                            </b-form-group>

                            <b-form-group class="col-6">
                                <label class="obligatoire" >Email : </label>
                                <b-form-input placeholder="Email du partenaire" v-model="email_partenaire"
                                                :state="valid_email_partenaire">
                                </b-form-input>
                                <p v-if="errors.email_partenaire" style="color: red"> {{errors.email_partenaire[0]}}</p>
                            </b-form-group>
                        </div>

                        <div class="row">
                            <b-form-group  class="col-6">
                                <label class="obligatoire"> Type partenaire : </label>
                                <b-form-select v-model="type_partenaire" :options="type_entreprise" :state="valid_type_partenaire" >
                                    <template slot="first">
                                        <option :value="null" disabled> -- Selectionnez un type --</option>
                                    </template>
                                </b-form-select>
                                <p v-if="errors.type_partenaire" style="color: red"> {{errors.type_partenaire[0]}}</p>
                            </b-form-group>

                            <b-form-group class="col-6">
                                <label >Langue :</label>
                                <b-form-select v-model="langue" :options="langues">
                                    <template slot="first">
                                        <option :value="null" disabled> -- Choisir la langue --</option>
                                    </template>
                                </b-form-select>
                            </b-form-group>
                        </div>
                    </div>

                    <div class="col-3">
                        <imageComponent :logo=null></imageComponent>
                        <label>Logo du partenaire</label>
                        <p v-if="errors.logo" style="color: red"> {{errors.logo[0]}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-9">
                        <b-form-group>
                            <label>Description : </label>
                            <b-form-textarea
                                    style="height: 85%; max-height: 100%;"
                                    v-model="description"
                                    placeholder="Saisissez la description de du partenaire ici ..."
                                    rows="5"
                                    :state="valid_description"
                            ></b-form-textarea>
                            <p v-if="errors.description" style="color: red"> {{errors.description[0]}}</p>
                        </b-form-group>
                    </div>
                    <div class="col-3">
                        <br>
                        <b-button block size="sm" variant="info" onclick="document.getElementById('piece_jointe').click()">
                            <i style="font-size: 20px;" class="fa fa-paperclip" aria-hidden="true"></i> Joindre pièce
                        </b-button>
                        <input id="piece_jointe"
                               style="display: none"
                               type="file" @change="onInputFile"/>
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

                <div class="row">
                    <div class="col-12">
                        <hr>
                        <h2>Informations sur agence principale</h2>
                    </div>
                </div>
                <div class="row">

                    <b-form-group class="col-4">
                        <label class="obligatoire">Nom de l'agence : </label>
                        <b-form-input placeholder="Nom agence" v-model="libelle_agence" :state="valid_libelle_agence">
                        </b-form-input>
                        <p v-if="errors.libelle_agence" style="color: red">
                            {{errors.libelle_agence[0]}}
                        </p>
                    </b-form-group>

                    <b-form-group class="col-4">
                        <label class="obligatoire">Numéro du télephone de l'agence: </label>
                        <b-form-input placeholder="expempple: 07 09 09 43 3" v-model="contact_agence"></b-form-input>
                    </b-form-group>

                    <b-form-group class="col-4">
                        <label class="obligatoire"> Adresse de l'agence : </label>
                        <b-form-input placeholder="Libreville - Awendjé" v-model="adresse_agence"></b-form-input>
                        <p v-if="errors.adresse_agence" style="color: red"> {{errors.adresse_agence[0]}}</p>
                    </b-form-group>

                </div>
                <div class="row">
                    <b-form-group class="col-4">
                        <label >Email agence : </label>
                        <b-form-input placeholder="example@email.com" v-model="email_agence" :state="valid_email_agence"></b-form-input>
                        <p v-if="errors.email_agence" style="color: red">
                            {{errors.email_agence[0]}}
                        </p>
                    </b-form-group>
                    <b-form-group class="col-4">
                        <label >Pays de l'agence</label>
                        <b-form-select v-model="pays_agence" :options="pays" v-on:input="charger_ville">
                            <template slot="first">
                                <option :value="null" disabled> -- Selectionnez un pays --</option>
                            </template>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group class="col-4">
                        <label class="obligatoire"> Ville de l'agence : </label>
                        <b-form-select v-model="ville_agence" :options="villes" required>
                            <template slot="default">
                                <option :value="null" disabled> -- Selectionnez une ville --</option>
                            </template>
                        </b-form-select>
                    </b-form-group>
                </div>
                <div class="row">
                    <h4 class="col-4">Localisation de l'agence : </h4>
                    <b-form-group class="col-4">
                        <label >Longitude : </label>
                        <b-form-input placeholder="Exemple: - 2.287592" v-model="longitude_agence" ></b-form-input>
                    </b-form-group>

                    <b-form-group class="col-4">
                        <label >Latitude : </label>
                        <b-form-input placeholder="Exemple 48.862725" v-model="latitude_agence" ></b-form-input>
                    </b-form-group>
                </div>
                <div class="row">
                    <div class="col-6">
                        <b-button block type="reset" variant="danger">Annuler</b-button>
                    </div>
                    <div class="col-6">
                        <b-button block type="submit" variant="info" >Enregistrer</b-button>
                    </div>
                </div>
            </b-form>

        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {

        data() {
            return {
                name: '',
                site_web: '',
                adresse_partenaire: '',
                email_partenaire:'',
                type_partenaire: null,
                langue: null,
                description: '',
                libelle_agence: '',
                contact_agence: '',
                adresse_agence:'',
                email_agence: '',
                pays_agence: null,
                ville_agence: null,
                latitude_agence: null,
                longitude_agence: null,
                logo: null,
                pays: [] ,
                all_cities: [],
                villes: [],
                pieces_jointes: [],
                files_tmp: [],

                errors: [],
                type_entreprise: [
                    {value: 'Entreprise', text: 'Entreprise'},
                    {value: 'Particulier', text: 'Particulier'},
                ],

                langues : [
                        {value:'français', text: 'Français'},
                        {value:'anglais', text: 'Anglais'}
                    ],
            }
        },

        computed: {

            valid_email_agence() {
                    return this.errors.email_agence == null ? null: false ;
            },
            valid_email_partenaire() {
                    return this.errors.email_partenaire == null ? null: false ;
            },
            valid_type_partenaire() {
                    return this.errors.type_partenaire == null ? null: false ;
            },
            valid_adresse_partenaire() {
                    return this.errors.adresse_partenaire == null ? null: false ;
            },
            valid_description() {
                    return this.errors.valid_description == null ? null: false ;
            },
            valid_libelle_agence() {
                    return this.errors.libelle_agence == null ? null: false ;
            },

            valid_name() {
                return this.errors.name == null ? null : false;
            }
        },
        mounted() {

            // On écoute le composant image
            this.$root.$on('image' , (image_loaded) => {
                this.put_logo(image_loaded);
            });

            this.load_countries();
            this.load_all_cities();
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
                if (this.pieces_jointes.length === 2 ) {
                    toast.fire({
                        type: 'error',
                        title: 'Nombre max !',
                        html: `Vous ne pouvez pas ajouter plus de deux fichiers !!`
                     })
                    return ;
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

            put_logo(image) {
                this.logo = image;
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
            charger_ville() {
                this.villes = [];
                this.all_cities.forEach( (city) => {
                    if (city.pays_id === this.pays_agence) {
                        this.villes.push({
                            value: city.id,
                            text: city.nom,
                        });
                    }
                });
            },

            onSubmit() {
                var new_partenaire = {
                    'name': this.name,
                    'site_web': this.site_web,
                    'adresse_partenaire': this.adresse_partenaire,
                    'email_partenaire': this.email_partenaire,
                    'type_partenaire': this.type_partenaire,
                    'langue': this.langue,
                    'description': this.description,
                    'libelle_agence': this.libelle_agence,
                    'contact_agence': this.contact_agence,
                    'adresse_agence': this.adresse_agence,
                    'email_agence': this.email_agence,
                    'pays_agence': this.pays_agence,
                    'ville_agence': this.ville_agence,
                    'latitude_agence' : this.latitude_agence,
                    'longitude_agence': this.longitude_agence,
                    'pieces_jointes': this.pieces_jointes.length !== 0 ? this.pieces_jointes : null,
                    'logo' : this.logo
                };

                axios.post('/partenaire', new_partenaire)
                    .then((response) => {
                        if(response.data.status === 1) {
                            this.errors = [];
                            toast.fire({
                                type: 'success',
                                title: 'Succès',
                                html: 'Partenaire créé avec succès'
                            });
                            this.onResetForm();
                        }else {
                            this.errors = response.data.errors;
                            toast.fire({
                                type: 'error',
                                title: 'Erreur !',
                                html: response.data.message
                            });
                        }
                    }).catch((response) => {
                        console.log(response);
                });
            },

            onResetForm() {
                this.name = '',
                this.site_web = '',
                this.adresse_partenaire = '',
                this.email_partenaire ='',
                this.type_partenaire ='',
                this.langue = '',
                this.description = '',
                this.libelle_agence = '',
                this.contact_agence ='',
                this.adresse_agence ='',
                this.email_agence = '',
                this.pays_agence = null,
                this.ville_agence =null,
                this.logo = null
            },
        }

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