<template>
    <div>
        <b-row>
            <div class="col-6">
                <b>Nom du partenaire: </b> {{location.get_partenaire.nom_partenaire}}
                <hr>
                <b>Titre: </b> {{location.titre}}
                <hr>
                <b>Début de disponibilité : </b> {{location.date_debut_human}}
                <hr>
                <b>Fin de disponibilité : </b> {{location.date_fin_human}}
                <hr>
            </div>
            <div class="col-6">
                <b>Description : </b>
                <hr>
                {{location.description}}
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
        <b-row>
            <div class="col-6"></div>
            <div class="col-6" style="text-align: right;">
                <b-button v-if="is_admin || is_controller" block type="submit"  variant="secondary"  @click="change_state(location.slug)" >
                    {{button_message}}
                </b-button>
            </div>
        </b-row>
    </div>

</template>

<script>

    import VueAxios from 'vue-axios';
    import axios from 'axios';
    import * as handle_user from '../../handle_user';


    Vue.use(VueAxios, axios);

    export default {
        props: ['location'],

        data() {
            return {
                button_message: '',


                index_image: 0,
                visible: false,
                images: [],
                has_image: false,
                etat_location: this.location.etat,

                // User Role
                is_admin : false,
                is_controller : false,
                is_agent : false,

            }
        },
        mounted() {
            var object = this;

            handle_user.get_connected_user_role(()=>{
                object.is_admin = handle_user.is_admin();
                object.is_controller = handle_user.is_controlleur();
                object.is_agent = handle_user.is_agent();
                this.init_location();
            });
        },

        methods: {


            showImages(index) {
                this.index_image = index;
                this.visible = true;
            },
            handleHide() {
                this.visible = false
            },

            button_message_text($etat) {
                switch ($etat) {
                    case 1 :
                        this.button_message = 'Valider la planification';
                        break;
                    case 2 :
                        this.button_message =  'Publier la planification';
                        break;
                    case 3 :
                        this.button_message =  'Désactiver la planification';
                        break;
                    case 4 :
                        this.button_message =  'Publier la planification'
                }
            },

            init_location() {
                this.button_message_text(this.location.etat);

                // on charge le tableau d'image à afficher
                for (let i = 0 ; i < this.location.images.length; i++) {
                    this.images.push(this.location.images[i].nom);
                }
                this.has_image = this.location.images.length > 0 ;
            },

            // 1 -> 2 -> 3 -> 4 -> 3
            // 1 -> 2 -> 3 -> 4 -> 3
            change_state(slug){
                var message_action = '';
                var new_state = 0;
                switch (this.etat_location) {
                    case 1 :
                        message_action = 'Location a été Validé';
                        new_state = 2;
                        break;
                    case 2 :
                        message_action =  'Location Publié';
                        new_state = 3;
                        break;
                    case 3 :
                        message_action =  'Location Désactivé';
                        new_state = 4;
                        break;
                    case 4 :
                        message_action =  'Location  publié';
                        new_state = 3;
                        break;
                }

                swal.fire({
                    title: 'êtes-vous sûr de vouloir changer l\'état de cette location?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui',
                    cancelButtonText:'Non, annuler'
                }).then((result) => {
                    if (result.value) {
                        axios.put('/change_state_location/'+slug)
                            .then((response) => {
                                swal.fire(
                                    message_action,
                                    'L\'état de la location a été modifié.',
                                    'success'
                                );
                                this.button_message_text(new_state);
                                this.etat_location = new_state ;
                            })
                            .catch(err => console.log(err));
                    }
                })
            },
        }
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
</style>