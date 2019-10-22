<template>
    <b-card>
        <b-card-title>
            <div class="row">
                <div class="col-6">
                    <h4> {{titre}}</h4>
                </div>
                <div class="col-6" style="text-align: right;">
                    <div v-if="list">
                        <b-button variant="outline-success" v-on:click="onCreate()" size="sm">+ Hotel</b-button>
                    </div>

                    <div v-if="!list">
                        <b-button variant="outline-success" v-on:click="onList()" size="sm"> << Liste</b-button>
                    </div>
                </div>
            </div>
            <hr class="colorgraph"><br>
        </b-card-title>
        <b-card-text>
            <template v-if="list">
                <list-hotel></list-hotel>
            </template>

            <template v-if="detail">
                <detail-hotel :hotel=hotel_detail></detail-hotel>
            </template>

            <template v-if="create">
                <create-hotel></create-hotel>
            </template>

            <template v-if="update">
                <update-hotel :slug=hotel_update></update-hotel>
            </template>

        </b-card-text>
    </b-card>
</template>

<script>
    export default {
        data() {
            return {
                list: true,
                create: false,
                detail: false,
                update: false,
                hotel_detail:null,
                hotel_update: null ,
                titre: "Liste des hotels",
            }
        },
        mounted() {

            /*
             *  On écoute les événements pour les modifications et le détail venant
             *  du component listPartenaire
             */
            this.$root.$on('detail-hotel', (hotel) => {
                this.onDetail(hotel);
            });

            this.$root.$on('update-hotel' , (hotel) => {
                this.onUpdate(hotel);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Création d'un Hotel";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des Hotels";
            },

            onUpdate(hotel) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification de l\'Hotel : " + " " + hotel.nom;
                this.hotel_update = hotel;
            },

            onDetail(hotel) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail de l\'Hotel : "+" " +hotel.nom;
                this.hotel_detail= hotel;
            }
        }
    }
</script>

<style scoped>

</style>
