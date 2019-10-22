<template>
    <div class="card">
        <div class="card-title">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="text-info">{{titre}}</h3>
                </div>
                <div class="col-md-6" style="text-align: right;">
                    <div v-if="list">
                        <button class="button " v-on:click="onCreate()" size="sm">+ Catégorie</button>
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
                <list-taxecat></list-taxecat>
            </template>

            <template v-if="detail">
                <detail-taxecat :taxecat=taxecat_detail></detail-taxecat>
            </template>

            <template v-if="create">
                <create-taxecat></create-taxecat>
            </template>

            <template v-if="update">
                <update-taxecat :slug=taxecat_update></update-taxecat>
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
                taxecat_detail:null,
                taxecat_update: null ,
                titre: "Liste des catégories de taxe",
            }
        },
        mounted() {

            /*
             *  On écoute les événements pour les modifications et le détail venant
             *  du component listPartenaire
             */
            this.$root.$on('detail-taxecat', (taxecat) => {
                this.onDetail(taxecat);
            });

            this.$root.$on('update-taxecat' , (taxecat) => {
                this.onUpdate(taxecat);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Création d'une taxecat";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des catégories de taxe";
            },

            onUpdate(taxecat) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du taxecat : " + " " + taxecat.titre;
                this.taxecat_update = taxecat;
            },

            onDetail(taxecat) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du taxecat : "+" " +taxecat.titre;
                this.taxecat_detail= taxecat;
            }
        }
    }
</script>

<style scoped>

</style>