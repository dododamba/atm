<template>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">


    <div class="dashboard-list-box">
            <h4 class="gray"> <i class="glyphicon glyphicon-th-list"></i> Catégorie des taxes</h4>
        <div class="table-box">
        <table class="basic-table booking-table">
                <thead>
                        <tr>
                            <th>ID</th><th>Libellé</th><th>Description</th> <th>Date de création</th> <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                     <tr  v-for="item in items.data">
                           <td>{{ item.id }}</td>
                           <td>{{ item.libelle }}</td>
                           <td>{{ item.description }}</td>
                           <td>{{ item.created_at }}</td>
                           <td class="textright">
                                <div class="dropdown">
                                    <button class="button gray dropdown-toggle" type="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="fa fa-list"></span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="">
                                           <a class="dropdown-item">Detail</a>
                                           <a class="dropdown-item" >Editer</a>
                                          <a class="dropdown-item" >Supprimer</a>                 
                                    </div>
                                </div>
                            </td>
                       </tr>
                   
                    </tbody>
        </table>
        </div>
    </div>
    <div class="pagination-container">
        <nav class="pagination">
            <ul>
                <li><a href="#" class="current-page">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#"><i class="sl sl-icon-arrow-right"></i></a></li>
            </ul>
        </nav>
    </div>
</div>
    </div>

</template>

<script>
    import VueAxios from 'vue-axios';
    import axios from 'axios';
    import BootstrapVue from 'bootstrap-vue';
    import Swal from 'sweetalert2'

    Vue.use(BootstrapVue);
    Vue.use(VueAxios, axios);

    export default {
        name: "List",
        data() {
            return {
                items: [],
                message_: '',
                connected_user_: '',
                status_: '',
                validations: [],
                categorie: {
                    libelle: '',
                    description: '',
                    ajouter_par: '',
                },

            }
        },
        mounted() {
            this._fetch('/taxecat');
        },
        methods: {
            _fetch(url) {
                let _self = this;
                axios.get(url)
                    .then(function (response) {
                        _self.items = response.data.content;
                    }).catch(function (response) {
                });
            },
            _getCategorie(slug) {
                let _self = this;
                axios.get('/taxecat/' + slug)
                    .then(function (response) {
                        _self.categorie = response.data.content;
                    }).catch(function (response) {
                });
            },

            _setNull() {
                this.categorie = null;
            },
            _delete(slug) {
                let _self = this;
                _self._getCategorie(slug);
                var _item = _self.categorie;
                var _slug = _item.slug;


                Swal.fire({
                    title: 'Confirmer la suppression de la catégorie ' + _item.nom,
                    html: '<h1><i class="fa fa-warning" style="color: orangered"></i></h1>',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                    cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/taxecat/' + _slug)
                            .then(function (response) {
                            }).catch(function (response) {
                        });
                        _self._setNull();
                        this._fetch('/taxecat');
                        Swal.fire(
                            'Succès !',
                            'La catégorie a été supprimé avec succès!',
                            'success'
                        )

                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'Abandon !',
                            'La suppression n\'a pas été éffectué !',
                            'error'
                        )
                    }
                })
            },
            onUpdate(slug) {
                this.$root.$emit('update-categorie', slug);
            },

            onDetail(slug) {
                let _self = this;
                _self._getCategorie(slug);
                var categorie = _self.categorie;
                var _nom = categorie.nom;
                var _desc = categorie.description;

                Swal.fire({
                    title: '<strong>Détail catégorie</strong>',
                    html:
                        '<p><u>Nom :</u> ' + _nom + ' </p>' +
                        '<p><u> Description :</u>  </p>' + _desc + ' <br>',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,

                });
            }

        }
    }
</script>

<style scoped>
</style>