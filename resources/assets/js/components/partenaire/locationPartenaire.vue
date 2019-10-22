<template>
    <div class="row">
        <div class="col-12" v-if="liste_locations != null">
            <!-- User Interface controls -->
            <b-row class="toolbar">
                <b-col md="5" style="text-align: left">
                    <b-row class="my-1">
                        <b-col sm="7" style="text-align: right">
                            <label >Nombre d'éléments par page</label>
                        </b-col>
                        <b-col sm="3" style="text-align: left">
                            <b-form-select v-model="perPage" :options="pageOptions" size="sm"></b-form-select>
                        </b-col>
                    </b-row>
                </b-col>
                <div class="col-4 offset-3" >
                    <div class="wrap">
                        <div class="search">
                            <b-form-input v-model="filter" class="searchTerm" placeholder="Que cherchez-vous ?"> </b-form-input>
                            <button type="button" class="searchButton">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </b-row>
            <b-table
                    stacked="md"
                    :items="liste_locations"
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"
                    :filter="filter"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    :sort-direction="sortDirection"
                    @filtered="onFiltered"
                    class="table responsive table-bordered"
            >
                <template slot="get_ville" slot-scope="row">
                    {{ row.value.nom}}
                </template>

                <template slot="titre" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="date_debut_human" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="date_fin_human" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="etat" slot-scope="row">
                    {{ libelle_etat(row.value)}}
                </template>

                <template slot="actions" slot-scope="row">
                    <b-button block variant="info" size="sm" @click="onShowDetail(row.item)">
                        Détail
                    </b-button>
                </template>
            </b-table>
            <b-row>
                <hr>
                <div class="offset-8 col-4" style="text-align: right">
                    <b-pagination
                            v-model="currentPage"
                            :total-rows="totalRows"
                            :per-page="perPage"
                            first-text="⏮"
                            prev-text="⏪"
                            next-text="⏩"
                            last-text="⏭"
                            class="mt-4"
                    ></b-pagination>

                </div>
            </b-row>
        </div>
        <div class="col-12" v-if="liste_locations==null">
            <b-alert show variant="warning">
                Pas de Location enregistré par ce partenaire pour le moment !
            </b-alert>
        </div>

        <!-- le modal details -->
        <div>
            <b-modal  v-model="showModalDetail"
                      title="Détail du voyage"
                      :header-bg-variant="headerBgVariant"
                      :header-text-variant="headerTextVariant"
                      :body-bg-variant="bodyBgVariant"
                      :body-text-variant="bodyTextVariant"
                      :footer-bg-variant="footerBgVariant"
                      :footer-text-variant="footerTextVariant"
                      size="lg">
                <b-row>
                    <div class="col-6">
                        <b>Titre: </b> {{location_detail.titre}}
                        <hr>
                        <b>Début de disponibilité : </b> {{location_detail.date_debut_human}}
                        <hr>
                        <b>Fin de disponibilité : </b> {{location_detail.date_fin_human}}
                        <hr>
                    </div>
                    <div class="col-6">
                        <b>Description : </b>
                        <hr>
                        {{location_detail.description}}
                    </div>
                </b-row>
                <b-row v-if="has_image">
                    <vue-easy-lightbox
                            :visible="visible"
                            :imgs="images"
                            :index="index_image"
                            @hide="handleHide"
                    ></vue-easy-lightbox>
                    <div class="col-12" >
                        <img class="image-item" v-for="(image, index) in images" :key="index"
                             :src="image"
                             alt="" v-b-tooltip.hover title="Cliquez pour zoomer"
                             v-on:click="showImages(index)">
                    </div>
                </b-row>
                <div slot="modal-footer" class="w-100">
                    <b-button  variant="danger" size="sm" class="float-right" @click="showModalDetail=false" >
                        Fermer
                    </b-button>
                </div>
            </b-modal>
        </div>
    </div>
</template>

<script>
    import VueAxios from 'vue-axios';
    import axios from 'axios';
    Vue.use(VueAxios, axios);

    export default {
        props: ['partenaire'],
        data(){

            return {
                liste_locations : null,



                // Pour les detaial

                index_image: 0,
                visible: false,
                images: [],
                has_image: false,

                location_detail: '',
                showModalDetail: false,

                // Config Modal
                headerBgVariant: 'dark',
                headerTextVariant: 'light',
                bodyBgVariant: 'light',
                bodyTextVariant: 'dark',
                footerBgVariant: 'warning',
                footerTextVariant: 'dark',

                fields: [
                    {key: 'get_ville', label: 'Ville',  sortable: true, sortDirection: 'desc'},
                    {key: 'titre', label: 'titre',  sortable: true, sortDirection: 'desc'},
                    {key: 'date_debut_human', label: 'Date début',  sortable: true, sortDirection: 'desc'},
                    {key: 'date_fin_human', label: 'Date fin'},
                    {key: 'etat', label: 'etat',  sortable: true, sortDirection: 'desc'},
                    {key: 'actions', label: 'Actions'},
                ],

                // La pagination
                totalRows: 1,
                currentPage: 1,
                perPage: 10,
                pageOptions: [5, 10, 15],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
            }
        },
        mounted() {
            this.all_location();
        },

        methods: {



            showImages(index) {
                this.index_image = index;
                this.visible = true;
            },
            handleHide() {
                this.visible = false
            },

            init_location(location) {

                this.images = [];
                // on charge le tableau d'image à afficher
                for (let i = 0 ; i < location.images.length; i++) {
                    this.images.push(location.images[i].nom);
                }
                this.has_image = location.images.length > 0 ;
            },


            libelle_etat(code_etat) {
                switch (code_etat) {
                    case 1 :
                        return 'Non Validé';
                    case 2 :
                        return 'Validé';
                    case 3 :
                        return 'publié';
                    case 4 :
                        return 'Désactivé'
                }
            },


            all_location() {
                this.liste_locations = null;
                axios.get('/location/partenaire/'+this.partenaire.slug)
                    .then((response) => {
                        this.liste_locations = response.data.content;
                        this.liste_locations = this.liste_locations.length === 0 ? null: this.liste_locations;
                    }).catch( (err) => {
                    this.liste_locations = null;
                });
            },


            onShowDetail(location) {
                this.location_detail = location;
                this.init_location(this.location_detail);
                this.showModalDetail = true;
            },

            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1;
            }
        },
    }
</script>


<style scoped>

    .image-item {
        width: 100px;
        height: 80px;
        position: relative;
        padding: 2px;
        cursor: pointer;
        border: 1px solid #ddd;
        border-radius: 10%;
    }

    .search {
        width: 100%;
        display: flex;
    }

    .searchTerm {
        width: 100%;
        border: 2px solid #00B4CC;
        border-right: none;
        padding: 5px;
        height: 40px;
        border-radius: 5px 0 0 5px;
        color: #9DBFAF;
    }

    .searchTerm:focus{
        color: #10707f;
    }

    .searchButton {
        width: 40px;
        height: 40px;
        border: 1px solid #00B4CC;
        background: #00B4CC;
        text-align: center;
        color: #fff;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
        font-size: 20px;
    }

    /*Resize the wrap to see the search bar change!*/
    .wrap{
        width: 100%;
        position: relative;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        margin-bottom: 20px;
    }
    label {
        color: #002752;
        display: block;
        font-size: 15px;
    }

    select{
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
        font-size: 15px;
        color: lightblue;
    }

</style>