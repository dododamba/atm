<template>
    <b-card>
        <b-card-title>
            <div class="row">
                <div class="col-6">
                    <h4> {{titre}}</h4>
                </div>
                <div class="col-6" style="text-align: right;">
                    <div v-if="list">
                        <b-button variant="outline-success" v-on:click="onCreate()" size="sm">+ Ville</b-button>
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
                <list-ville></list-ville>
            </template>

            <template v-if="detail">
                <detail-ville :ville=ville_detail></detail-ville>
            </template>

            <template v-if="create">
                <create-ville></create-ville>
            </template>

            <template v-if="update">
                <update-ville :ville=ville_update></update-ville>
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
                ville_detail:null,
                ville_update: null ,
                titre: "Liste des ville",
            }
        },
        mounted() {

            /*
             *  On écoute les événements pour les modifications et le détail venant
             *  du component listPartenaire
             */
            this.$root.$on('detail-ville', (ville) => {
                this.onDetail(ville);
            });

            this.$root.$on('update-ville' , (ville) => {
                this.onUpdate(ville);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Création d'une ville";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des villes";
            },

            onUpdate(ville) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du ville : " + " " + ville.nom;
                this.ville_update = ville;
            },

            onDetail(ville) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du ville : "+" " +ville.nom;
                this.ville_detail= ville;
            }
        }
    }
</script>

<style scoped>

</style>