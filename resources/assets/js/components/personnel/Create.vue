<template>

    <div class="col-md-11">


        <form v-on:submit.prevent="store()">

            <div class="row">
                <div class="col-md-12">
                    <p id="red">Les Champs marqués par un (*) sont obligatoires</p>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <label class="text-dark mt-4 font-weight-medium" for="">Nom <strong class="text-danger">(*)</strong></label>
                    <div class="form-group">
                        <input class="form-control" type="text" v-model="personnel.nom">
                    </div>
                    <p id="red" v-if="validations">
                        {{ validations.nom }}
                    </p>
                    <p style="font-size: 90%">ex. John</p>
                </div>


                <div class="col-md-6">
                    <label class="text-dark mt-4 font-weight-medium" for="">Prenom <strong class="text-danger">(*)</strong></label>
                    <div class="form-group">
                        <input class="form-control" type="text" v-model="personnel.prenom">
                    </div>
                    <p id="red" v-if="validations">
                        {{ validations.prenom }}
                    </p>
                    <p style="font-size: 90%">ex. Snow</p>
                </div>


            </div>

            <div class="row">
                <div class="col-md-6">
                    <label class="text-dark mt-4 font-weight-medium" for="">Matricule <strong class="text-danger">(*)</strong></label>
                    <div class="form-group">
                        <input class="form-control" type="text" v-model="personnel.matricule">
                    </div>
                    <p id="red" v-if="validations">
                        {{ validations.matricule }}
                    </p>
                    <p style="font-size: 90%">ex. ITC094-R2</p>
                </div>


                <div class="col-md-6">
                    <label class="text-dark mt-4 font-weight-medium" for="">Sexe <strong class="text-danger">(*)</strong></label>
                    <select class="form-control" v-model="personnel.sexe">
                        <option value="">Selectioner le sexe</option>
                        <option value="M">Masculin</option>
                        <option value="F">Féminin</option>
                    </select>
                    <p style="font-size: 90%">ex. Femme</p>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <label class="text-dark mt-4 font-weight-medium" for="">Email <strong class="text-danger">(*)</strong></label>
                    <div class="form-group">
                        <input class="form-control" type="email" v-model="personnel.email">
                    </div>
                    <p id="red" v-if="validations">
                        {{ validations.email }}
                    </p>
                    <p style="font-size: 90%">ex. info@techomegapartners.com</p>
                </div>


                <div class="col-md-6">
                    <label class="text-dark mt-4 font-weight-medium" for="">Téléphone</label>
                    <div class="form-group">
                        <input class="form-control" type="text" v-model="personnel.telephone">
                    </div>
                    <p style="font-size: 90%">ex. +24100000000</p>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    <label class="text-dark font-weight-medium" for="">Date d'embauche <strong class="text-danger">(*)</strong></label>
                    <div class="form-group">
                        <input class="form-control" type="date" v-model="personnel.date_embauche">
                    </div>
                    <p id="red" v-if="validations">
                        {{ validations.date_embauche }}
                    </p>
                    <p style="font-size: 90%">ex. 08/08/2008</p>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-dark font-weight-medium" for="">Date de Naissance <strong class="text-danger">(*)</strong></label>
                        <input class="form-control" type="date" v-model="personnel.date_naissance">
                    </div>
                    <p id="red" v-if="validations">
                        {{ validations.date_naissance }}
                    </p>
                    <p style="font-size: 90%">ex. 08/08/2008</p>
                </div>

            </div>


            <div class="row">
                <div class="col-md-6">
                    <label class="text-dark mt-4 font-weight-medium" for="">Langue</label>
                    <div class="form-group">
                        <select class="form-control" v-model="personnel.langue">
                            <option value="">Selectioner une langue</option>
                            <option value="fr">Fr</option>
                            <option value="en">En</option>

                        </select>
                    </div>
                    <p style="font-size: 90%">ex. Fr</p>
                </div>

                <div class="col-md-6">
                    <label class="text-dark font-weight-medium" for="">Role <strong class="text-danger">(*)</strong></label>
                    <div class="form-group">
                        <select class="form-control" v-model="personnel.role">
                            <option disabled>Selectioner un role</option>
                            <option value=""></option>
                            <option v-bind:value="r.id" v-for="r in roles_">{{ r.name }}</option>
                        </select>
                    </div>
                    <p id="red" v-if="validations">
                        {{ validations.role }}
                    </p>
                    <p style="font-size: 90%">ex. Role</p>
                </div>
            </div>


            <hr>
            <div class="row">
                <button class="btn btn-primary" type="submit">Valider</button>
                <button class="btn btn-default" type="reset">Recommencer</button>
            </div>
        </form>
    </div>

</template>

<script>
    import axios from 'axios';
    import Swal from 'sweetalert2';


    Vue.use(axios);
    export default {
        name: "Create",
        data() {
            return {
                is_completed: [],
                roles_: [],
                message: '',
                message_: '',
                dismissSecs: 7,
                dismissCountDown: 0,
                role_: '',
                status_: '',
                email_: '',
                birth_: '',
                password_confirmation: '',
                password: '',
                phone_: '',
                lang_: '',
                login_: '',
                created_: '',
                validations: [],
                current_page_: '',
                date_embauche: '',
                personnel: {
                    nom: '',
                    prenom: '',
                    matricule: '',
                    date_embauche: '',
                    matricule: '',
                    email: '',
                    role: '',
                    telephone: '',
                    langue: '',
                    sexe: '',
                    date_naissance: '',

                },
                compte: {
                    email: '',
                    role: '',
                    slug: '',
                    telephone: '',
                    langue: '',
                    role: '',
                    password: '',
                    password_confirmation: '',
                },
                password_: '',
                password_confirmation_: '',
            }
        },
        mounted() {
            this.getRole();
        },
        methods: {
            getRole() {
                let app = this;
                axios.get('/role-personnel')
                    .then(function (response) {
                        app.roles_ = response.data.content.roles;
                    })
                    .catch();
            },

            store() {
                var app = this;
                var newPersonnel = app.personnel;
                axios.post('/create/personnel', newPersonnel)
                    .then(function (response) {
                        app.message_ = response.data.content.message;
                        app.status_ = response.data.content.status;
                        app.validations = response.data.content.error;

                        console.log(app.message_, app.validations, app.status_)
                        if (app.status_ === 1) {
                            Swal.fire(
                                'Succès!',
                                app.message_,
                                'success'
                            )
                        }
                        if (app.status_ === 0) {
                            Swal.fire(
                                'Echec!',
                                app.message_,
                                'error'
                            )
                        }


                    }).catch(function (response) {

                });
            },


        }


    }
</script>

<style scoped>
    #red {
        color: red;
    }
</style>