<template>


    <div>

        <div class="pull-right"> <b-button  variant="success" @click="_create()">+ Découpage Un</b-button></div>

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
                status: '',
                decoupageun :{
                    id: '',
                    iso: '',
                    name: '',
                    numcode: '',
                    nicename: '',
                    iso3: '',
                    phonecode: '',
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

                        label: "Libelle",
                        filter: {
                            type: "simple",
                            placeholder: "libelle ...."
                        },
                        name: "libelle", // access nested objects properties with "."
                        sort: true,
                    },
                    {

                        label: "Pays",
                        filter: {
                            type: "simple",
                            placeholder: "pays ...."
                        },
                        name: "pays.nom", // access nested objects properties with "."
                        sort: true,
                    },
                    {

                        label: "Action",
                        slot_name: "action",
                        name : "id"
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
            this._fetch('/api/decoupageun');
        },
        methods: {
            _fetch(url) {
                let _self = this;
                axios.get(url)
                    .then(function (response) {
                        _self.empty_ = response.data.message;
                        _self.items = response.data.content.decoupageun;
                        _self.current_page_ = _self.items.current_page;

                        console.log(_self.items)

                    }).catch(function (response) {
                });
            },

            _create(){

                let _self = this;


                Swal.fire({
                    title: 'Enregistrement decoupageun ',
                    input: 'text',
                    focusConfirm: false,

                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                    cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller',

                }).then((result) => {
                    if (result.value) {
                        axios.post('/api/decoupageun/')
                            .then(function (response) {
                            }).catch(function (response) {
                        });
                        this._fetch('/api/decoupageun?page=' + _self.current_page_);
                        Swal.fire(
                            'Succès !',
                            'Enregistrement effectué !',
                            'success'
                        )

                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'Abandon !',
                            'L\'enregistrement n\'a pas été effectué !',
                            'error'
                        )
                    }
                })
            },
            update(item) {
                var _self = this;
                var _decoupageun = _self.decoupageun;
                _decoupageun = item;

                axios.post('/api/update-decoupageun', _decoupageun)
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
                this._fetch('/api/decoupageun?page=' + this.current_page_);
            }


        }

    }
</script>

<style scoped>
</style>