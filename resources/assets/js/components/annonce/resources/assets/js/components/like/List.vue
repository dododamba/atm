<template>
    <div class="row">
        <div class="col-md-12" v-if="items">
            <vue-bootstrap4-table :rows="items" :columns="columns" :config="config" :class="classes">
            </vue-bootstrap4-table>
        </div>
        <template v-if="items == null" class="row">
            <b-alert show variant="danger">Liste Vide</b-alert>
        </template>
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
                message_: '',
                created_: '',
                article: {
                },

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

                        label: "Article liké",
                        filter: {
                            type: "simple",
                            placeholder: "article ..."
                        },
                        name: "table",
                        sort: true,
                    },
                    {

                        label: "Liké Par",
                        filter: {
                            type: "simple",
                            placeholder: "utilisateur ..."
                        },
                        name: "user", // access nested objects properties with "."
                        sort: true,
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
            this._fetch('/api/like');
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


        }

    }
</script>

<style scoped>
</style>