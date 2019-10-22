<template>
    <div class="card card-default">
        <div class="card-header  " v-if="list">
            <h3 class="display-6"> Les Tarifs Dispos
            <button class="btn btn-success btn-sm pull-right"  v-on:click="onCreate()" variant="outline-success" >
                <i class="fa fa-plus "></i></button></h3>

        </div>

        <div class="card-header  " v-if="!list">
            <h3 class="display-6"> Inserer les Tarifs
            <button class="btn btn-success btn-sm pull-right"  v-on:click="onList()" variant="outline-success" >
                <i class="fa fa-arrow-left"></i></button></h3>


        </div>


        <div class="">

            <hr>
        </div>
        <div class="card-body">
            <template v-if="list">
                <tarifannonce-list></tarifannonce-list>
            </template>

            <template v-if="create">
                <tarifcreateannonce></tarifcreateannonce>
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
                position_detail:null,
                titre: "",
            }
        },
        mounted() {
            this.$root.$on('', () => {
                this.create = false;
                this.list =true;
                this.detail = true;
                this.titre=" Détail du position : "+" " +position.nom_position;
                this.position_detail= position;
            })
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.titre = "Création d'une position Annonce";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.titre = "Liste des Positions";
            },
        }
    }
</script>

