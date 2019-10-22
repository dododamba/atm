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

                        <button type="button" rel="tooltip" class="btn btn-info btn-icon btn-sm btn-neutral"
                                title="detail" @click="show(props.cell_value)">
                            <i class="fa fa-user"></i>
                        </button>

                        <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm btn-neutral"
                                title="suppression" @click="_delete(props.cell_value)">
                            <i class="fa fa-times"></i>
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
            <b-alert show variant="danger">Pas de Categorie enregistré pour le moment</b-alert>
        </template>
    </div>


</template>

<script>
    import VueAxios from 'vue-axios';
    import axios from 'axios';
    import BootstrapVue from 'bootstrap-vue';
    import Swal from 'sweetalert2'
    import VueBootstrap4Table from 'vue-bootstrap4-table'


    Vue.use(BootstrapVue);
    Vue.use(VueAxios, axios);

    export default {
        name: "List",
        data() {
            return {
                items: [],
                item: '',
                status: '',
                is_completed: [],
                roles_: {
                    id: '',
                    name: '',
                },
                empty_: '',
                message: '',
                message_: '',
                status_: '',
                email_: '',
                birth_: '',
                name: '',
                role_: '',
                validations: [],
                current_page_: '',
                date_embauche: '',
                client: {
                    nom: '',
                    prenom: '',
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
                        is_active :'',
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

                columns: [
                    {

                        label: "Nom",
                        filter: {
                            type: "simple",
                            placeholder: "Nom"
                        },
                        name: "nom", // access nested objects properties with "."
                        sort: true,
                    },
                    {

                        label: "Prenom",
                        filter: {
                            type: "simple",
                            placeholder: "Prenom"
                        },
                        name: "prenom", // access nested objects properties with "."
                        sort: true,
                    },
                    {

                        label: "Sexe",
                        filter: {
                            type: "simple",
                            placeholder: "Sexe"
                        },
                        name: "sexe", // access nested objects properties with "."
                        sort: true,
                    },
                    {

                        label: "Deate de Naissance",
                        name: "date_naissance", // access nested objects properties with "."
                        sort: false,
                    },
                    {

                        label: "Email",
                        filter: {
                            type: "simple",
                            placeholder: "Email"
                        },
                        name: "compte.email", // access nested objects properties with "."
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
                        name: "compte.langue", // access nested objects properties with "."
                        sort: false,
                    },
                    {

                        label: "Telephone",
                        filter: {
                            type: "simple",
                            placeholder: "Telephone"
                        },
                        name: "compte.telephone", // access nested objects properties with "."
                        sort: false,
                    },
                    {

                        label: "Derniere Connexion",
                        name: "compte.last_login", // access nested objects properties with "."
                        sort: false,
                    },
                    {

                        label: "Role",
                        name: "compte.user_role.nom", // access nested objects properties with "."
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
                        name: "compte.created_at", // access nested objects properties with "."
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
                    show_refresh_button: false,
                    show_reset_button: false,
                    checkbox_rows: false,
                    highlight_row_hover: true,
                    rows_selectable: true,
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
            this._fetch('/api/client');
        },
        methods: {
            _fetch(url) {
                let _self = this;
                axios.get(url)
                    .then(function (response) {
                        _self.empty_ = response.data.message;
                        _self.items = response.data.content.clients;
                        _self.current_page_ = _self.items.current_page;

                    }).catch(function (response) {
                });
            },
            _getClient(slug) {
                let _self = this;
                axios.get('/api/client/' + slug)
                    .then(function (response) {
                        _self.client = response.data.content;
                    }).catch(function (response) {
                });
            },

            show(slug) {
                let _self = this;
                _self._getClient(slug);
                var client = _self.client;
                var statut = client.compte.is_active;

                if (statut == null) {
                    var _statut = 'Désactivé';
                } else {
                    var _statut = 'Activé';
                }
                Swal.fire({
                    title: '<strong>Détail</strong>',
                    html:
                        '<p><u>Nom :</u> ' + client.nom + ' </p>' +
                        '<p><u>Prénom :</u> ' + client.prenom + ' </p>' +
                        '<p><u>Email :</u> ' + client.compte.email + ' </p>' +
                        '<p><u>Téléphone :</u> ' + client.compte.telephone + ' </p>' +
                        '<p><u>Sexe :</u> ' + client.sexe + ' </p>' +
                        '<p><u>Langue :</u> ' + client.compte.langue + ' </p>' +
                        '<p><u>Statut :</u><b> ' + _statut + '</b> </p>' +
                        '<p><u>Date de naissance :</u> ' + client.date_naissance + ' </p>' +
                        '<p><u>Date de création :</u> ' + client.created_at + ' </p>',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                });
                _self.client = null

            },
            _activate(slug) {
                let _self = this;
                _self._getClient(slug);
                var _item = _self.client;
                var _slug = _item.compte.slug;
                var statut = _item.compte.is_active;

                if (statut != null) {
                    Swal.fire({
                        title: 'Désactiver le compte de ' + _item.nom,
                        html: '<h1><i class="fa fa-warning" style="color: orangered"></i></h1>',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                        cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller'
                    }).then((result) => {
                        if (result.value) {
                            axios.get('api/client/desactivate/' + _slug)
                                .then(function (response) {
                                });
                            this._fetch('/api/client');
                            this.client = null;

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
                            axios.get('api/client/activate/' + _slug)
                                .then(function (response) {
                                });
                            this._fetch('/api/client');
                            this.client = null;

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
                _self._getClient(slug);
                var _item = _self.client;
                var _slug = _item.slug;


                Swal.fire({
                    title: 'Confirmer la suppression du compte ' + _item.nom,
                    html: '<h1><i class="fa fa-warning" style="color: orangered"></i></h1>',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                    cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/delete-client/'+_slug)
                            .then(function (response) {
                            }).catch(function (response) {
                        });
                        this._fetch('/api/client');
                        this.client = null;

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


        }

    }
</script>

<style scoped>
</style>