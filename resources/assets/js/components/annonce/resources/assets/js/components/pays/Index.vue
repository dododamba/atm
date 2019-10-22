<template>
    <b-card>
        <b-card-title>
            <div class="row">
                <div class="col-6">
                    <h4> {{titre}}</h4>

                </div>

            </div>
            <hr class="colorgraph"><br>
        </b-card-title>
        <b-card-text>
            <template v-if="list">
                <list-pays></list-pays>
            </template>

            <template v-if="detail">
                <detail-pays :pays=pays_detail></detail-pays>
            </template>

            <template v-if="create">
                <create-pays></create-pays>
            </template>

            <template v-if="update">
                <update-pays :pays=pays_update></update-pays>
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
                pays_detail:null,
                pays_update: null ,
                titre: "Liste des pays",
            }
        },
        mounted() {

            this.$root.$on('detail-pays', (pays) => {
                this.onDetail(pays);
            });

            this.$root.$on('update-pays' , (pays) => {
                this.onUpdate(pays);
            });
        },
        methods: {
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des payss";
            },

            onUpdate(pays) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du pays : " + " " + pays.titre;
                this.pays_update = pays;
            },

            onDetail(pays) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du pays : "+" " +pays.titre;
                this.pays_detail= pays;
            }
        }
    }
</script>

<style scoped>
</style>