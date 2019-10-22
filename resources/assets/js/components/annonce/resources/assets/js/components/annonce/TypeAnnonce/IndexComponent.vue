<template>
    <div class="card card-default">
        <div class="card-header bg-primary text-white" v-if="list"><h3 class="display-6"> Les Types d'Annonces
            <button class="btn btn-success btn-sm pull-right"  v-on:click="onCreate()" variant="outline-success" >
                <i class="fa fa-plus "></i></button></h3>

        </div>

        <div class="card-header bg-primary text-white" v-if="!list"><h3 class="display-6"> Créer un Nouveau Type Annonce
            <button class="btn btn-success btn-sm pull-right"  v-on:click="onList()" variant="outline-success" >
                <i class="fa fa-arrow-left"></i></button></h3>


        </div>


        <div class="">

            <hr>
        </div>
        <div class="card-body">
            <template v-if="list">
              <typeannonce-list></typeannonce-list> 

            </template>

            <template v-if="create">
                 <typecreateannonce></typecreateannonce>
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
                types_detail:null,
                titre: "Liste des Types  d'Annonces",
            }
        },
        mounted() {
            this.$root.$on('detail-types', (types) => {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.titre=" Détail du types : "+" " +types.nom_types;
                this.types_detail= types;
            })
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.titre = "Création d'un type";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.titre = "Liste des Types d'Annonces";
            },
        }
    }
</script>

