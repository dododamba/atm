<template>
      <div class="col-lg-12 col-sm-12">
                        <div id="add-listing">
            <form v-on:submit.prevent="store()">

                            <!-- Section -->
                            <div class="add-listing-section">

                                <!-- Headline -->
                                <div class="add-listing-headline">
                                    <h3><i class="sl sl-icon-doc"></i> Informations</h3>
                                </div>

                                <!-- Title -->
                                <div class="row with-forms">
                                    <div class="col-md-6">
                                        <label>Libellé <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                        <input class="search-field" type="text" v-model="taxe.libelle_taxe">
                                         <p class="text-danger" v-if="validations">
                                       {{ validations.libelle_taxe }}
                                    </p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Code <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                        <input class="search-field" type="text" v-model="taxe.code_taxe">
                                         <p class="text-danger" v-if="validations">
                                       {{ validations.code_taxe }}
                                    </p>
                                    </div>
                                </div>

                                <div class="row with-forms">
                    
                    
                                     <div class="col-md-12">
                                        <label>Categorie <i class="text-danger glyphicon glyphicon-asterisk"></i></label>
                                       <select class="chosen-select-no-single" v-model="taxe.categorie">
                                            <option disabled>Selectioner une Catégorie</option>
                                            <option value=""></option>
                                            <option v-bind:value="r.id" v-for="r in categories">{{ r.libelle }}</option>
                                         </select>                                   
                                      <p class="text-danger" v-if="validations">
                                       {{ validations.categorie }}
                                    </p>
                                     </div>
                                   
                                </div>
                                <!-- Row -->
                            
                                <!-- Row / End -->
                            </div>
                            <!-- Section / End -->

                            <!-- Section -->
                          
                            <!-- Section / End -->

                        


                            <button type="submit" class="button preview">Enregistrer <i class="fa fa-arrow-circle-right"></i></button>
            </form>
                        </div>
                    </div>
</template>

<script>

    import axios from 'axios';
    import Swal from 'sweetalert2';

    Vue.use(axios);

    export default {
        props: ['slug'],

        data() {
            return {
              message_: '',
                connected_user_: '',
                status_: '',
                validations: [],
                categories : [],
                taxe: {
                    libelle_taxe: '',
                    code_taxe: '',
                    categorie: '',
                }
            }
        },

        mounted() {
            this._categorie();
            this._taxe(this.slug);

        },

        methods: {
              _categorie(){
                let _self = this;
                axios.get('/taxecat')
                    .then(function (response) {
                        _self.categories = response.data.content.data;
                        console.log(_self.categories)
                    }).catch(function (response) {
                });
            },
            _taxe(slug) {
                let _self = this;
                axios.get('/taxe-show/' + slug)
                    .then(function (response) {
                        _self.taxe = response.data.content;
                        console.log( _self.taxe);
                    }).catch(function (response) {
                });
            },

            update(){
                var _self = this;
                var _slug = _self.taxe.slug;
                var _taxe = _self.taxe;

                axios.put('/taxe/'+ _slug,_taxe)
                    .then(function (response) {
                        _self.message_ = response.data.content.message;
                        _self.status_ = response.data.content.status;
                        _self.validations = response.data.content.error;

                        console.log(_self.message_, _self.validations, _self.status_)
                        if (_self.status_ === 1) {
                            Swal.fire(
                                'Succès!',
                                _self.message_,
                                'success'
                            )
                        }
                        if (_self.status_ === 0) {
                            Swal.fire(
                                'Echec!',
                                _self.message_,
                                'error'
                            )
                        }


                    }).catch(function (response) {

                });
            },

        }
    }
</script>

<style scoped>

</style>