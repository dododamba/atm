<template>

    <div>


        <vue-bootstrap4-table :rows="items" :columns="columns" :config="config" :class="classes">
            <template slot="action" slot-scope="props">

                <div class="row">
                    <button type="button" rel="tooltip" class="btn btn-info btn-icon btn-sm btn-neutral "
                            title="detail" @click="onDetail(props.cell_value)">
                        <i class="fa fa-info"></i>
                    </button>

                </div>

            </template>

        </vue-bootstrap4-table>





    </div>


</template>

<script>
    import VueAxios from 'vue-axios';
    import axios from 'axios';
    import BootstrapVue from 'bootstrap-vue';
    import DatePicker from 'vue2-datepicker';
    import Swal from 'sweetalert2'


    Vue.use(BootstrapVue);
    Vue.use(VueAxios, axios);

    export default {
        name: "List",
        components: {DatePicker},

        data() {
            return {
                items: [],
                item: '',
                columns: [
                    {

                        label: "#",
                        filter: {
                            type: "simple",
                            placeholder: "id ..."
                        },
                        name: "id", // access nested objects properties with "."
                        sort: true,
                    },
                    {

                        label: "Commenté Par",
                        filter: {
                            type: "simple",
                            placeholder: "auteur ..."
                        },
                        name: "utilisateur", // access nested objects properties with "."
                        sort: true,
                    },
                    {

                        label: "Commenté sur",

                        name: "owner_column", // access nested objects properties with "."
                        sort: true,
                    },
                    {

                        label: "Date de Commentaire",
                        name: "created_at", // access nested objects properties with "."
                        sort: true,
                    },
                    {

                        label: "Action",
                        slot_name: "action",
                        name: "id"
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
            this._fetch('/api/commentaire');
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

            _delete(item) {
                let _self = this;
                var _item = item;
                var _slug = _item.slug;


                Swal.fire({
                    title: 'Confirmer la suppression du commentaire ' + _item.nom,
                    html: '<h1><i class="fa fa-warning" style="color: orangered"></i></h1>',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                    cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/delete-personnel/' + _slug)
                            .then(function (response) {
                            }).catch(function (response) {
                        });
                        this._fetch('/api/personnel?page=' + this.current_page_);
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