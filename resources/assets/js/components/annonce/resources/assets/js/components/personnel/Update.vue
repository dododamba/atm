<template>
    <div class="col-md-11">

        <form v-on:submit.prevent="update(personnel)">

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
                        <input class="form-control" type="email" v-model="personnel.compte.email">
                    </div>
                    <p id="red" v-if="validations">
                        {{ validations.email }}
                    </p>
                    <p style="font-size: 90%">ex. info@techomegapartners.com</p>
                </div>


                <div class="col-md-6">
                    <label class="text-dark mt-4 font-weight-medium" for="">Téléphone</label>
                    <div class="form-group">
                        <input class="form-control" type="text" v-model="personnel.compte.telephone">
                    </div>
                    <p style="font-size: 90%">ex. +24100000000</p>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    <label class="text-dark font-weight-medium" for="">Date d'embauche <strong class="text-danger">(*)</strong></label>
                    <div class="form-group">
                        <date-picker v-model="personnel.date_embauche" valueType="format" lang="en" ></date-picker>
                    </div>
                    <p id="red" v-if="validations">
                        {{ validations.date_embauche }}
                    </p>
                    <p style="font-size: 90%">ex. 08/08/2008</p>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-dark font-weight-medium" for="">Date de Naissance <strong class="text-danger">(*)</strong></label>
                        <date-picker v-model="personnel.date_naissance" valueType="format" lang="en" ></date-picker>
                    </div>
                    <p id="red" v-if="validations">
                        {{ validations.date_naissance }}
                    </p>
                    <p style="font-size: 90%">ex. 08/08/2008</p>
                </div>

            </div>


            <div class="row">
                <div class="col-md-12">
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
    import DatePicker from 'vue2-datepicker'

    Vue.use(axios);
    export default {
        name: "Update",
        props: ['slug'],
        data() {
            return {
                message_: '',
                connected_user_: '',
                status: '',
                validations: [],
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
            this._getPersonnel(this.slug);
        },
        methods: {
            getRole() {
                let app = this;
                axios.get('api/role-personnel')
                    .then(function (response) {
                        app.roles_ = response.data.content.roles;
                    })
                    .catch();
            },
            _getPersonnel(slug) {
                let _self = this;
                axios.get('/personnel/'+slug)
                    .then(function (response) {
                        _self.personnel = response.data.content;

                        console.log(_self.personnel)

                    }).catch(function (response) {
                });
            },
            update(personnel) {
                var _self = this;
                var _personnel = _self.personnel;
                _personnel = personnel;

                axios.post('/update-personnel', _personnel)
                    .then(function (response) {
                        _self.message_ = response.data.content.message;
                        _self.status = response.data.content.status;
                        _self.validations = response.data.content.error;

                        console.log(_self.validations, _self.status, _self.message_);
                        if (_self.status === 1) {
                            Swal.fire(
                                'Succès!',
                                _self.message_,
                                'success'
                            )
                        }
                        if (_self.status === 0) {
                            Swal.fire(
                                'Echec!',
                                _self.message_,
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
#red{
    color: red;
}
</style>