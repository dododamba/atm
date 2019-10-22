<template>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <h4> {{titre}}
                        <i v-if="create" class="fa fa-plus" aria-hidden="true"></i>
                        <i v-if="update" class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        <i v-if="list" class="fa fa-bars" aria-hidden="true"></i>
                    </h4>
                </div>
                <div class="col-6" style="text-align: right;">
                    <div v-if="list">
                        <b-button variant="info" v-on:click="onCreate()">Planifier un voyage </b-button>
                    </div>

                    <div v-if="!list">
                        <b-button variant="secondary" v-on:click="onList()"> Retourner à la liste des voyages</b-button>
                    </div>
                </div>
            </div>
            <hr>
            <template v-if="list">
                <liste-voyage></liste-voyage>
            </template>
            <template v-if="update">
                <update-voyage :voyage=voyage_update></update-voyage>
            </template>
            <template v-if="create">
                <create-voyage></create-voyage>
            </template>
            <template v-if="detail">
                <detail-voyage :voyage="voyage_detail"></detail-voyage>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                list: true,
                detail: false,
                create: false,
                update: false,
                voyage_update:null,
                voyage_detail: null,
                titre: "Liste des voyages",
            }
        },
        mounted() {
            this.$root.$on('update-voyage', (voyage) => {
                this.create = false;
                this.list =false;
                this.update = true;
                this.detail = false;
                this.titre=" Modification du voyage ";
                this.voyage_update = voyage;
            });
            this.$root.$on('detail-voyage', (voyage) => {
                this.create = false;
                this.list =false;
                this.update = false;
                this.detail = true;
                this.titre="Détail du voyage";
                this.voyage_detail = voyage;
            })
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.update = false;
                this.detail =false;
                this.titre = "Création d'un voyage";
            },
            onList() {
                this.create = false;
                this.detail =false;
                this.list =true;
                this.update = false;
                this.titre = "Liste des voyages";
            },
        }
    }
</script>

<style scoped>
    hr {
        border: 5px solid #23272b;
        border-radius: 5px;
    }
    h4 {
        color: #002752;
        font-family: 'Droid serif', serif;
        font-size: 36px;
        font-weight: 400; font-style: italic; line-height: 44px; margin: 0 0 12px; text-align: left;
    }
</style>