<template>

    <div class="card">
        <div class="card-body">
            <div class="row header-page">
                <div class="col-6">
                    <h4> {{titre}}
                        <i v-if="create" class="fa fa-plus" aria-hidden="true"></i>
                        <i v-if="list" class="fa fa-bars" aria-hidden="true"></i>
                    </h4>
                </div>
                <div class="col-6" style="text-align: right;">
                    <div v-if="list">
                        <b-button variant="info" v-on:click="onCreate()">Planifier une location </b-button>
                    </div>

                    <div v-if="!list">
                        <b-button variant="secondary" v-on:click="onList()"> Retourner à la liste</b-button>
                    </div>
                </div>
            </div>
            <hr>
            <template v-if="list">
                <liste-location></liste-location>
            </template>
            <template v-if="create">
                <create-location :location=location_update></create-location>
            </template>
            <template v-if="detail">
                <detail-location :location=location_detail></detail-location>
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
                location_update:null,
                location_detail: null,
                titre: "Liste des Locations",
            }
        },
        mounted() {
            this.$root.$on('update_location', (location) => {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.titre="Modification du Location ";
                this.location_update= location;
            });

            this.$root.$on('detail-location', (location) => {
                this.onDetail(location);
            });

        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.titre = "Planification d'une location";
                this.location_update = null;
            },
            onList() {
                this.create = false;
                this.detail = false;
                this.list =true;
                this.titre = "Liste des locations";
            },

            onDetail(location) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.titre=" Détail de la Location ";
                this.location_detail = location;

            }
        }
    }
</script>

<style scoped>
    hr {
        border: 5px solid #23272b;
        border-radius: 5px;
    }
    h4 { color: #b48608; font-family: 'Droid serif', serif;
        font-size: 36px;
        font-weight: 400; font-style: italic; line-height: 44px; margin: 0 0 12px; text-align: left;
    }
</style>