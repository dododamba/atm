<template>
    <div class="card">
        <div class="card-title">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="text-info">{{titre}}</h3>
                </div>
                <div class="col-md-6" style="text-align: right;">
                    <div v-if="list">
                        <button class="button " v-on:click="onCreate()" size="sm">+ Hotel de ville</button>
                    </div>

                    <div v-if="!list">
                        <button class="button " v-on:click="onList()" size="sm"> << Liste</button>
                    </div>
                </div>
            </div>
            <hr class="colorgraph"><br>
        </div>
        <div class="card-body">
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

        </div>
    </div>
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
                titre: "Liste des Hotel de ville",
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
                this.titre = "Création d'une hotel";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des Hotels de ville";
            },

            onUpdate(hotel) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du hotel : " + " " + hotel.nom_hotel;
                this.hotel_update = hotel;
            },

            onDetail(hotel) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du hotel : "+" " +hotel.nom_hotel;
                this.hotel_detail= hotel;
            }
        }
    }
</script>

<style scoped>

</style>