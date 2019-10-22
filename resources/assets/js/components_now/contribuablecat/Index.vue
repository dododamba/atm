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
                <list-contribuablecat></list-contribuablecat>
            </template>

            <template v-if="detail">
                <detail-contribuablecat :contribuablecat=contribuablecat_detail></detail-contribuablecat>
            </template>

            <template v-if="create">
                <create-contribuablecat></create-contribuablecat>
            </template>

            <template v-if="update">
                <update-contribuablecat :slug=contribuablecat_update></update-contribuablecat>
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
                contribuablecat_detail:null,
                contribuablecat_update: null ,
                titre: "Liste des catégories de contribuable",
            }
        },
        mounted() {

            /*
             *  On écoute les événements pour les modifications et le détail venant
             *  du component listPartenaire
             */
            this.$root.$on('detail-contribuablecat', (contribuablecat) => {
                this.onDetail(contribuablecat);
            });

            this.$root.$on('update-contribuablecat' , (contribuablecat) => {
                this.onUpdate(contribuablecat);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Création d'une contribuablecat";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des catégories de contribuable";
            },

            onUpdate(contribuablecat) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du contribuablecat : " + " " + contribuablecat.titre;
                this.contribuablecat_update = contribuablecat;
            },

            onDetail(contribuablecat) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du contribuablecat : "+" " +contribuablecat.titre;
                this.contribuablecat_detail= contribuablecat;
            }
        }
    }
</script>

<style scoped>

</style>