<template>
    <div class="card">
        <div class="card-title">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="text-info">{{titre}}</h3>
                </div>
                <div class="col-md-6" style="text-align: right;">
                    <div v-if="list">
                        <button class="button " v-on:click="onCreate()" size="sm">+ Ajouter</button>
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
                <list-contribuable></list-contribuable>
            </template>

            <template v-if="detail">
                <detail-contribuable :contribuable=contribuable_detail></detail-contribuable>
            </template>

            <template v-if="create">
                <create-contribuable></create-contribuable>
            </template>

            <template v-if="update">
                <update-contribuable :slug=contribuable_update></update-contribuable>
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
                contribuable_detail:null,
                contribuable_update: null ,
                titre: "Liste des contribuable",
            }
        },
        mounted() {

            /*
             *  On écoute les événements pour les modifications et le détail venant
             *  du component listPartenaire
             */
            this.$root.$on('detail-contribuable', (contribuable) => {
                this.onDetail(contribuable);
            });

            this.$root.$on('update-contribuable' , (contribuable) => {
                this.onUpdate(contribuable);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Création d'une contribuable";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des contribuables";
            },

            onUpdate(contribuable) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du contribuable : " + " " + contribuable.titre;
                this.contribuable_update = contribuable;
            },

            onDetail(contribuable) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du contribuable : "+" " +contribuable.titre;
                this.contribuable_detail= contribuable;
            }
        }
    }
</script>

<style scoped>

</style>