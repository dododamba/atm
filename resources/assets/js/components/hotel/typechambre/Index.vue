<template>
    <b-card>
        <b-card-title>
            <div class="row">
                <div class="col-6">
                    <h4> {{titre}}</h4>
                </div>
                <div class="col-6" style="text-align: right;">
                    <div v-if="list">
                        <b-button variant="outline-success" v-on:click="onCreate()" size="sm">+ Type de chambre</b-button>
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
                <list-typechambre></list-typechambre>
            </template>

            <template v-if="detail">
                <detail-typechambre :typechambre=typechambre_detail></detail-typechambre>
            </template>

            <template v-if="create">
                <create-typechambre></create-typechambre>
            </template>

            <template v-if="update">
                <update-typechambre :slug=typechambre_update></update-typechambre>
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
                typechambre_detail:null,
                typechambre_update: null ,
                titre: "Liste des type de chambre",
            }
        },
        mounted() {

            /*
             *  On écoute les événements pour les modifications et le détail venant
             *  du component listPartenaire
             */
            this.$root.$on('detail-typechambre', (typechambre) => {
                this.onDetail(typechambre);
            });

            this.$root.$on('update-typechambre' , (typechambre) => {
                this.onUpdate(typechambre);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Création d'une Categorie";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des Categories";
            },

            onUpdate(typechambre) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du Categorie : " + " " + typechambre.titre;
                this.typechambre_update = typechambre;
            },

            onDetail(typechambre) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du Categorie : "+" " +typechambre.titre;
                this.typechambre_detail= typechambre;
            }
        }
    }
</script>

<style scoped>

</style>
