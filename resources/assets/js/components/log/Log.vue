<template>


    <div class="card">
        <div>
            <div class="card-title">
                <div class="row">
                    <div class="col-6">
                        <h4> Historiques d'utilisation <i class="fa fa-globe"></i> </h4>
                    </div>
                </div>
                <hr class="colorgraph"><br>
            </div>
            <div class="card-text">


                <vue-bootstrap4-table :rows="items" :columns="columns" :config="config" :class="classes">
                </vue-bootstrap4-table>



            </div>
        </div>
    </div>

</template>

<script>
    import VueAxios from 'vue-axios';
    import axios from 'axios';
    import BootstrapVue from 'bootstrap-vue';

    Vue.use(BootstrapVue);

    Vue.use(VueAxios, axios);
    export default {
        activate: '#activate',
        el: '#app',

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

                        label: "Log",
                        filter: {
                            type: "simple",
                            placeholder: "log ..."
                        },
                        name: "action", // access nested objects properties with "."
                        sort: true,
                    },
                    {

                        label: "IP",
                        filter: {
                            type: "simple",
                            placeholder: "ip ..."
                        },
                        name: "adresseIp", // access nested objects properties with "."
                        sort: true,
                    },
                    {

                        label: "Location",
                        filter: {
                            type: "simple",
                            placeholder: "location ex : Libreville ..."
                        },
                        name: "location", // access nested objects properties with "."
                        sort: true,
                    },
                    {

                        label: "Table",
                        filter: {
                            type: "simple",
                            placeholder: "table ..."
                        },
                        name: "table", // access nested objects properties with "."
                        sort: true,
                    },
                    {

                        label: "Utilisateur",
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
            this.list('/api/log');
        },


        methods: {
            list(url) {
                let ar = this;
                axios.get(url)
                    .then(function (response) {
                        ar.items = response.data.meta;
                    }).catch(function (response) {
                });

            },
        }
    }
</script>
<style>

    #redone {
        color: red;
    }

    #green {
        color: green;
    }

    #transparent {
        color: transparent;
    }

    .bg-sensei {
        background-color: #4c84ff;
    }

    .bg-sensei tr th {
        color: #ffffff;
        text-transform: capitalize;
    }
</style>
<style lang="scss">
    .panel-o {
        padding: 1.5rem 2rem;
        /* position: absolute; */
        background-color: #fff;
        width: 100%;
        height: 100%;
        border: none;
        overflow: hidden;
    }

    .meta {
        top: 0;
        left: 0;
        z-index: 1;
        margin: 0;
        position: relative;
        text-align: center;
        padding: 2rem 4rem;
        border-right: 1px solid transparent;

        picture {
            position: relative;
            display: inline-block;
        }

        img {
            object-fit: cover;
        }

        .avatar {
            border-radius: 50%;
        }

        .company-logo {
            position: absolute;
            bottom: -0.5rem;
            right: 0;
        }

        .name {
            font-size: 2rem;
            text-align: center;
            margin-top: 1rem;
            font-weight: 300;
        }

        .title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 1rem 0 0;
        }
    }

</style>