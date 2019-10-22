<template>
    <div class="row">
        <div class="col-md-12" v-if="items">
            <vue-bootstrap4-table :rows="items" :columns="columns" :config="config" :class="classes">
                <template slot="action" slot-scope="props">

                    <div class="row">
                        <button type="button" rel="tooltip" class="btn btn-info btn-icon btn-sm btn-neutral "
                                title="detail" @click="onDetail(props.cell_value)">
                            <i class="fa fa-info"></i>
                        </button>
                        <button type="button" rel="tooltip" class="btn btn-warning btn-icon btn-sm btn-neutral "
                                title="detail" @click="onUpdate(props.cell_value)">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm btn-neutral "
                                title="supprimer" @click="_delete(props.cell_value)">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </div>

                </template>

            </vue-bootstrap4-table>

            <template v-if="items == null" class="row">
                <b-alert show variant="danger">Pas de hotel enregistré pour le moment</b-alert>
            </template>
        </div>
    </div>

</template>

<script>
    import VueAxios from 'vue-axios';
    import axios from 'axios';
    import BootstrapVue from 'bootstrap-vue';
    import Swal from 'sweetalert2'


    Vue.use(BootstrapVue);
    Vue.use(VueAxios, axios);

    export default {
        name: "List",
        data() {
            return {
                items: [],
                message_: '',
                connected_user_: '',
                status_: '',
                validations: [],
                hotel: {
                    nom: '',
                    description: '',
                    ajouter_par: '',
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

                        label: "Description",
                        filter: {
                            type: "simple",
                            placeholder: "description ...."
                        },
                        name: "description", // access nested objects properties with "."
                        sort: true,
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
            this._fetch('/api/hotel');
        },
        methods: {
            _fetch(url) {
                let _self = this;
                axios.get(url)
                    .then(function (response) {
                        _self.items = response.data.content;
                    }).catch(function (response) {
                });
            },
            _getHotel(slug) {
                let _self = this;
                axios.get('/api/hotel/' + slug)
                    .then(function (response) {
                        _self.hotel = response.data.content;
                    }).catch(function (response) {
                });
            },

            _setNull() {
                this.hotel = null;
            },
            _delete(slug) {
                let _self = this;
                _self._getHotel(slug);
                var _item = _self.hotel;
                var _slug = _item.slug;


                Swal.fire({
                    title: 'Confirmer la suppression ? ' + _item.nom,
                    html: '<h1><i class="fa fa-warning" style="color: orangered"></i></h1>',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                    cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/hotel/' + _slug)
                            .then(function (response) {
                            }).catch(function (response) {
                        });
                        _self._setNull();
                        this._fetch('/api/hotel');
                        Swal.fire(
                            'Succès !',
                            'La catégorie a été supprimé avec succès!',
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
            onUpdate(slug) {
                this.$root.$emit('update-hotel', slug);
            },

            onDetail(slug) {
                let _self = this;
                _self._getHotel(slug);
                var hotel = _self.hotel;
                var _nom = hotel.nom;
                var _desc = hotel.description;

                Swal.fire({
                    title: '<strong>Détail catégorie</strong>',
                    html:
                        '<p><u>Nom :</u> ' + _nom + ' </p>' +
                        '<p><u> Description :</u>  </p>' + _desc + ' <br>',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,

                });
            }

        },
        watch: {
            items() {
                immediate: true,
                    this._fetch('/api/hotel');

            }

        }
    }
</script>

<style scoped>
</style>