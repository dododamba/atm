<template>
    <div class="row">
        <div class="col-md-12" v-if="items">

            <vue-bootstrap4-table :rows="items" :columns="columns" :config="config" :class="classes">
                <template slot="nom" slot-scope="props">
                    <i>
                        {{props.cell_value}}
                    </i>
                </template>
                <template slot="nom" slot-scope="props">
                    <i>
                        {{props.cell_value}}
                    </i>
                </template>
                <template slot="prenom" slot-scope="props">
                    <i>
                        {{props.cell_value}}
                    </i>
                </template>
                <template slot="sexe" slot-scope="props">
                    <i>
                        {{props.cell_value}}
                    </i>
                </template>
                <template slot="date_naissance" slot-scope="props">
                    <i>
                        {{props.cell_value}}
                    </i>
                </template>
                <template slot="compte.email" slot-scope="props">
                    <i>
                        {{props.cell_value}}
                    </i>
                </template>
                <template slot="compte.langue" slot-scope="props">
                    <i>
                        {{props.cell_value}}
                    </i>
                </template>
                <template slot="compte.telephone" slot-scope="props">
                    <i>
                        {{props.cell_value}}
                    </i>
                </template>
                <template slot="compte.user_role.nom" slot-scope="props">
                    <i>
                        {{props.cell_value}}
                    </i>
                </template>


                <template slot="statut" slot-scope="props">
                    <p v-if="props.cell_value != null " class="text-success"
                    >
                        Activé
                    </p>
                    <p v-else class="text-danger">

                        Desactivé
                    </p>
                </template>
                <template slot="date_embauche" slot-scope="props">
                    <i>
                        {{props.cell_value}}
                    </i>
                </template>
                <template slot="compte.last_login" slot-scope="props">
                    <i>
                        {{props.cell_value}}
                    </i>
                </template>
                <template slot="compte.created_at" slot-scope="props">
                    <i>
                        {{props.cell_value}}
                    </i>
                </template>
                <template slot="action" slot-scope="props">


                    <div class="row">
                        <button type="button" rel="tooltip" class="btn btn-default btn-icon btn-sm btn-neutral"
                                title="detail" @click="role(props.cell_value)">
                            <i class="fa fa-suitcase"></i>
                        </button>


                        <button type="button" rel="tooltip" class="btn btn-info btn-icon btn-sm btn-neutral"
                                title="detail" @click="show(props.cell_value)">
                            <i class="fa fa-user"></i>
                        </button>


                        <button type="button" rel="tooltip" class="btn btn-success btn-icon btn-sm btn-neutral"
                                title="mise à jours" @click="onUpdate(props.cell_value)">
                            <i class="fa fa-edit"></i>
                        </button>


                        <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm btn-neutral"
                                title="suppression" @click="_delete(props.cell_value)">
                            <i class="fa fa-times"></i>


                        </button>


                        <button type="button" rel="tooltip" class="btn btn-warning btn-icon btn-sm btn-neutral"
                                title="modification mot de pass" @click="_password(props.cell_value)">
                            <i class="fa fa-lock"></i>
                        </button>

                        <button type="button" rel="tooltip" class="btn btn-default btn-icon btn-sm btn-neutral"
                                title="Activer ou desactiver" @click="_activate(props.cell_value)">
                            <i class="fa fa-check"></i>
                        </button>


                    </div>


                </template>
            </vue-bootstrap4-table>


        </div>
        <template v-if="items == null" class="row">
            <b-alert show variant="danger">Pas de personnel enregistré pour le moment</b-alert>
        </template>
    </div>


</template>

<script>
    import VueAxios from 'vue-axios';
    import axios from 'axios';
    import BootstrapVue from 'bootstrap-vue';
    import DatePicker from 'vue2-datepicker';
    import Swal from 'sweetalert2';
    import VueBootstrap4Table from 'vue-bootstrap4-table'


    Vue.use(BootstrapVue);
    Vue.use(VueAxios, axios);

    export default {
        name: "List",
        components: {DatePicker},

        data() {
            return {
                items: [],
                item: '',
                _secret: '',
                status: '',
                is_completed: [],
                roles_: {
                    id: '',
                    name: '',
                },
                message: '',
                message_: '',
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
                name: '',
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
                    compte: {
                        email: '',
                        role: '',
                        slug: '',
                        telephone: '',
                        langue: '',
                        role: '',
                        password: '',
                        password_confirmation: '',
                    }

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
                columns: [
                    {

                        label: "Matricule",
                        filter: {
                            type: "simple",
                            placeholder: "matricule"
                        },
                        name: "matricule",
                        sort: true,
                    },
                    {

                        label: "Nom",
                        filter: {
                            type: "simple",
                            placeholder: "Nom"
                        },
                        name: "nom",
                        sort: true,
                    },
                    {

                        label: "Prenom",
                        filter: {
                            type: "simple",
                            placeholder: "Prenom"
                        },
                        name: "prenom",
                        sort: true,
                    },
                    {

                        label: "Sexe",
                        filter: {
                            type: "simple",
                            placeholder: "Sexe"
                        },
                        name: "sexe",
                        sort: true,
                    },
                    {

                        label: "Deate de Naissance",
                        name: "date_naissance",
                        sort: false,
                    },
                    {

                        label: "Email",
                        filter: {
                            type: "simple",
                            placeholder: "Email"
                        },
                        name: "compte.email",
                        sort: false,
                    },
                    {

                        label: "Langue",
                        filter: {
                            type: "select",
                            placeholder: "Langue",
                            mode: "multi",
                            options: [
                                {
                                    "name": "Français",
                                    "value": "fr"
                                },
                                {
                                    "name": "Anglais",
                                    "value": "en"
                                }
                            ]
                        },
                        name: "compte.langue",
                        sort: false,
                    },
                    {

                        label: "Telephone",
                        filter: {
                            type: "simple",
                            placeholder: "Telephone"
                        },
                        name: "compte.telephone",
                        sort: false,
                    },
                    {

                        label: "Derniere Connexion",
                        name: "compte.last_login",
                        sort: false,
                    },
                    {

                        label: "Role",
                        name: "compte.user_role.nom",
                        sort: false,
                    },
                    {

                        label: "Satut",
                        name: "compte.is_active",
                        slot_name: "statut",

                        sort: false,
                    },
                    {

                        label: "Date de creation",
                        name: "compte.created_at",
                        sort: false,
                    },
                    {

                        label: "Date d'embauche'",
                        name: "date_embauche",
                        sort: false,
                    },
                    {

                        label: "Action",
                        slot_name: "action",
                        name: "slug"
                    },
                ],
                config: {
                    pagination: true,
                    pagination_info: true,
                    num_of_visibile_pagination_buttons: 7,
                    per_page: 10,
                    checkbox_rows: true,
                    highlight_row_hover: true,
                    rows_selectable: true,
                    show_refresh_button: false,
                    show_reset_button: false,
                    multi_column_sort: false,
                    global_search: {
                        placeholder: "Recherche...",
                        visibility: true,
                        case_sensitive: false
                    },
                    card_title: "",
                    card_mode: false,
                    selected_rows_info: false,
                    per_page_options: [5, 10, 20, 30],
                },
                classes: {
                    table: "table-bordered table-striped"
                }
            }
        },
        mounted() {
            this._fetch('/personnel');
            this._role();
        },
        methods: {
            _fetch(url) {
                let _self = this;
                axios.get(url,)
                    .then(function (response) {
                        _self.items = response.data.content.personnels;
                        _self.roles_ = response.data.content.roles;
                        _self.current_page_ = _self.items.current_page;

                    }).catch(function (response) {
                });
            },
            _getPersonnel(slug) {
                let _self = this;
                axios.get('/personnel/' + slug)
                    .then(function (response) {
                        _self.personnel = response.data.content;
                        _self.status = _self.personnel.compte.is_active;
                    }).catch(function (response) {
                });
            },
            _oauth() {
                let _self = this;
                axios.get('/oauth/clients')
                    .then(response => {
                        _self._secret = response.data;
                    });
            },
            _role() {
                let _self = this;
                axios.get('/role-personnel')
                    .then(function (response) {
                        _self.roles_ = response.data.content.roles;
                    })
                    .catch();
            },

            _activate(slug) {
                let _self = this;
                _self._getPersonnel(slug);
                var _item = _self.personnel;
                var _slug = _item.compte.slug;
                if (this.status != null) {
                    Swal.fire({
                        title: 'Désactiver le compte de ' + _item.nom,
                        html: '<h1><i class="fa fa-warning" style="color: orangered"></i></h1>',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                        cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller'
                    }).then((result) => {
                        if (result.value) {
                            axios.get('/personnel/desactivate/' + _slug)
                                .then(function (response) {
                                });
                            this._fetch('/personnel' );
                            this.personnel = null;

                            Swal.fire(
                                'Succès !',
                                'Le compte a été désactivé avec succès!',
                                'success'
                            )

                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire(
                                'Abandon !',
                                'La désactivation n\'a pas été éffectué !',
                                'error'
                            )
                        }
                    })
                } else {
                    Swal.fire({
                        title: 'Activer le compte de ' + _item.nom,
                        html: '<h1><i class="fa fa-warning" style="color: orangered"></i></h1>',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                        cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller'
                    }).then((result) => {
                        if (result.value) {
                            axios.get('/personnel/activate/' + _slug)
                                .then(function (response) {
                                });
                            this._fetch('/personnel' );
                            this.personnel = null;

                            Swal.fire(
                                'Succès !',
                                'Le compte a été activé avec succès!',
                                'success'
                            )

                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire(
                                'Abandon !',
                                'L\'activation n\'a pas été éffectué !',
                                'error'
                            )
                        }
                    })
                }


            },
            _delete(slug) {
                let _self = this;
                _self._getPersonnel(slug);
                var _item = _self.personnel;
                var _slug = _item.compte.slug;


                Swal.fire({
                    title: 'Confirmer la suppression du compte ' + _item.nom,
                    html: '<h1><i class="fa fa-warning" style="color: orangered"></i></h1>',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                    cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/delete-personnel/' + _slug)
                            .then(function (response) {
                            }).catch(function (response) {
                        });
                        this._fetch('/personnel');
                        this.personnel = null;

                        Swal.fire(
                            'Supprimé !',
                            'Le compte a été supprimé avec succès!',
                            'success'
                        )

                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'Abandon !',
                            'La suppression n\'a pas été éffectué !',
                            'error'
                        )
                    }
                })
            },

            show(slug) {
                let _self = this;
                _self._getPersonnel(slug);
                var personnel = _self.personnel;
                var statut = personnel.compte.is_active;

                if (statut == null) {
                    var _statut = 'Désactivé';
                } else {
                    var _statut = 'Activé';
                }
                Swal.fire({
                    title: '<strong>Détail</strong>',
                    html:
                        '<p><u>Matricule :</u> ' + personnel.matricule + ' </p>' +
                        '<p><u>Nom :</u> ' + personnel.nom + ' </p>' +
                        '<p><u>Prénom :</u> ' + personnel.prenom + ' </p>' +
                        '<p><u>Email :</u> ' + personnel.compte.email + ' </p>' +
                        '<p><u>Téléphone :</u> ' + personnel.compte.telephone + ' </p>' +
                        '<p><u>Sexe :</u> ' + personnel.sexe + ' </p>' +
                        '<p><u>Langue :</u> ' + personnel.compte.langue + ' </p>' +
                        '<p><u>Statut :</u><b> ' + _statut + '</b> </p>' +
                        '<p><u>Role :</u><b> ' + personnel.compte.user_role.nom + '</b> </p>' +
                        '<p><u>Date d\'embauche :</u> ' + personnel.date_embauche + ' </p>' +
                        '<p><u>Date de naissance :</u> ' + personnel.date_naissance + ' </p>' +
                        '<p><u>Date de création :</u> ' + personnel.created_at + ' </p>',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                });
                _self.personnel = null

            },

            _ifUserActivatedYet() {
                let _self = this;
                var _item = _self.personnel;
                var activated = _item.compte.is_active;
                if (activated != null) {
                    return false;
                } else {
                    return true;
                }

            },

            _onActiveAction(slug) {
                let _self = this;
                _self._getPersonnel(slug);
                var _item = _self.personnel;
                var _slug = _self.personnel.compte.slug;
                var _assert = _self._ifUserActivatedYet();
                if (_assert = !null) {
                    Swal.fire({
                        title: 'Désactiver le compte de ' + _item.nom,
                        html: '<h1><i class="fa fa-warning" style="color: orangered"></i></h1>',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                        cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller'
                    }).then((result) => {
                        if (result.value) {
                            axios.get('/personnel/desactivate/' + _slug)
                                .then(function (response) {
                                });
                            this._fetch('/personnel' );
                            Swal.fire(
                                'Succès !',
                                'Le compte a été désactivé avec succès!',
                                'success'
                            )

                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire(
                                'Abandon !',
                                'La désactivation n\'a pas été éffectué !',
                                'error'
                            )
                        }
                    })
                } else {
                    Swal.fire({
                        title: 'Activer le compte de ' + _item.nom,
                        html: '<h1><i class="fa fa-warning" style="color: orangered"></i></h1>',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                        cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller'
                    }).then((result) => {
                        if (result.value) {
                            axios.get('/personnel/activate/' + _slug)
                                .then(function (response) {
                                });
                            this._fetch('/personnel' );
                            Swal.fire(
                                'Succès !',
                                'Le compte a été activé avec succès!',
                                'success'
                            )

                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire(
                                'Abandon !',
                                'L\'activation n\'a pas été éffectué !',
                                'error'
                            )
                        }
                    })
                }

            },
            role(slug) {
                let _self = this;
                _self._getPersonnel(slug);
                var _item = _self.personnel;
                var _slug = _item.compte.slug;
                var _roles = _self.roles_;
                var _roleOption = {};
                var _selected = {};


                _roles.forEach(function (element) {
                    _roleOption[element.id] = element.name;
                });


                Swal.fire({
                    title: 'Modification Profile utilisateur ',
                    input: 'select',
                    inputPlaceholder: 'Selection un role',
                    inputOptions: _roleOption,
                    focusConfirm: false,

                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                    cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller',

                }).then((result) => {
                    _selected = result.value;
                    if (result.value) {
                        axios.post('/update-role/' + _slug + '?id=' + _selected)
                            .then(function (response) {
                            }).catch(function (response) {
                        });
                        this._fetch('/personnel');
                        this.personnel = null;
                        Swal.fire(
                            'Succès !',
                            'Le role utilisateur a été mise à jours !',
                            'success'
                        )

                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'Abandon !',
                            'Le role utilisateur n\'a pas été mise à jours !',
                            'error'
                        )
                    }
                })
            },
            _password(slug) {
               let _self = this;
                _self._getPersonnel(slug);
                var _item = _self.personnel;
                var _slug = _item.compte.slug;

            console.log(_item)

                Swal.fire({
                    title: 'Modification mot de pass ' + _item.nom,
                    text: 'Un mot de Pass par défault sera crée!',
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                    cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller'
                }).then((result) => {
                    if (result.value) {
                        var _personel = _self.compte;

                        _personel.email = item.compte.email;
                        _personel.role = item.compte.id;
                        _personel.slug = item.compte.slug;
                        _personel.telephone = item.compte.telephone;
                        _personel.langue = item.compte.langue;
                        _personel.role = item.compte.user_role.id;
                        _personel.password = _self.password;
                        _personel.password_confirmation = _self.password_confirmation;



                        axios.post('/reset-password', _personel)
                            .then(function (response) {
                                _self.message_ = response.data.content.message;
                                _self.status = response.data.content.status;
                                _self.validations = response.data.content.error;
                                console.log(_self.message_)
                            })
                            .catch(function (response) {
                                console.log(response);
                            });
                        this._fetch('/personnel' );
                        this.personnel = null;

                        Swal.fire(
                            'Succès !',
                            ' Le mot de pass a été mise à jours avec succès !',
                            'success'
                        )

                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'Abandon !',
                            'Le mot de pass a pas été réinitialisé !',
                            'error'
                        )
                    }
                })
            },
            profileUpdate(slug) {
                let _self = this;
                _self._getPersonnel(slug);
                var _item = _self.personnel;
                var _slug = _item.compte.slug;

                axios.post('/update-role/' + _slug + '?name=' + _name.name)
                    .then(function (response) {
                        _self.message_ = response.data.content.message;
                        _self.status = response.data.content.status;
                        _self.validations = response.data.content.error;
                    }).catch(function (response) {
                });
                this.$refs['profile'].hide();
                this._fetch('/personnel' );
            },
            onUpdate(personnel) {
                this.$root.$emit('update-personnel', personnel);
            },

            update(item) {
                var _self = this;
                var _personnel = _self.personnel;
                _personnel = item;

                axios.post('/update-personnel', _personnel)
                    .then(function (response) {
                        _self.message_ = response.data.content.message;
                        _self.status = response.data.content.status;
                        _self.validations = response.data.content.error;

                        console.log(_self.validations, _self.status, _self.message_);
                        if (_self.status === 0) {
                            Swal.fire(
                                'Echec!',
                                _self.message_,
                                'error'
                            )
                        }

                    }).catch(function (response) {
                });
                this.$refs['edit'].hide();
                this._fetch('/personnel' );
            }


        }

    }
</script>

<style scoped>

</style>