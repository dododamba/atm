<template>
    <div class="card">
        <div class="card-title">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="text-info">{{titre}}</h3>
                </div>
                <div class="col-md-6" style="text-align: right;">
                    <div v-if="list">
                        <button class="button " v-on:click="onCreate()" size="sm">+ Taxe</button>
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
                <list-taxe></list-taxe>
            </template>

            <template v-if="detail">
                <detail-taxe :taxe=taxe_detail></detail-taxe>
            </template>

            <template v-if="create">
                <create-taxe></create-taxe>
            </template>

            <template v-if="update">
                <update-taxe :slug=taxe_update></update-taxe>
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
                taxe_detail:null,
                taxe_update: null ,
                titre: "Liste des taxes",
            }
        },
        mounted() {

            /*
             *  On écoute les événements pour les modifications et le détail venant
             *  du component listPartenaire
             */
            this.$root.$on('detail-taxe', (taxe) => {
                this.onDetail(taxe);
            });

            this.$root.$on('update-taxe' , (taxe) => {
                this.onUpdate(taxe);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Création d'une taxe";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des taxes";
            },

            onUpdate(taxe) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du taxe : " + " " + taxe.code_taxe;
                this.taxe_update = taxe;
            },

            onDetail(taxe) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du taxe : "+" " + taxe.code_taxe;
                this.taxe_detail= taxe;
            }
        }
    }
</script>

<style scoped>

</style>