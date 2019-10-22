<template>
    <div class="card">
        <div class="card-title">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="text-info">{{titre}}</h3>
                </div>
                <div class="col-md-6" style="text-align: right;">
                    <div v-if="list">
                        <button class="button " v-on:click="onCreate()" size="sm">+ Commune</button>
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
                <list-commune></list-commune>
            </template>

            <template v-if="detail">
                <detail-commune :commune=commune_detail></detail-commune>
            </template>

            <template v-if="create">
                <create-commune></create-commune>
            </template>

            <template v-if="update">
                <update-commune :slug=commune_update></update-commune>
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
                commune_detail:null,
                commune_update: null ,
                titre: "Liste des communes ",
            }
        },
        mounted() {

            /*
             *  On écoute les événements pour les modifications et le détail venant
             *  du component listPartenaire
             */
            this.$root.$on('detail-commune', (commune) => {
                this.onDetail(commune);
            });

            this.$root.$on('update-commune' , (commune) => {
                this.onUpdate(commune);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Création d'une commune";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des Communes ";
            },

            onUpdate(commune) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification de la commune : " + " " + commune.titre;
                this.commune_update = commune;
            },

            onDetail(commune) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail de la commune : "+" " +commune.titre;
                this.commune_detail= commune;
            }
        }
    }
</script>

<style scoped>

</style>