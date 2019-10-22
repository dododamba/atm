<template>
    <b-card>
        <b-card-title>
            <div class="row">
                <div class="col-6">
                    <h4> {{titre}}</h4>
                </div>
                <div class="col-6" style="text-align: right;">
                    <div v-if="list">
                        <b-button variant="outline-success" v-on:click="onCreate()" size="sm">+ Personnel</b-button>
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
                <list-personnel></list-personnel>
            </template>

            <template v-if="create">
                <create-personnel></create-personnel>
            </template>

            <template v-if="update">
                <update-personnel :slug=personnel_update></update-personnel>
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
                personnel_detail:null,
                personnel_update: null ,
                titre: "Liste des personnel",
            }
        },
        mounted() {

            /*
             *  On écoute les événements pour les modifications et le détail venant
             *  du component listPartenaire
             */
            this.$root.$on('detail-personnel', (personnel) => {
                this.onDetail(personnel);
            });

            this.$root.$on('update-personnel' , (personnel) => {
                this.onUpdate(personnel);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Enregistrement Personnel";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste du Personnel";
            },

            onUpdate(slug) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification   ";
                this.personnel_update = slug;
            },


        }
    }
</script>

<style scoped>

</style>