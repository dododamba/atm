<template>
    <b-card title="">

            <form @submit.prevent="submitFiles()" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-danger">Les Champs marqués par un (*) sont obligatoires</p>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-12">
                        <label class="text-dark font-weight-medium" for="">Titre (*)</label>
                        <input type="text" id="name" v-model="article.titre"
                               placeholder="Titre de l'article" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="text-dark font-weight-medium" for="">Categorie (*)</label>
                    <div class="form-group">
                        <select class="form-control" v-model="article.categorie">
                            <option disabled>Selectioner une Catégorie</option>
                            <option value=""></option>
                            <option v-bind:value="r.id" v-for="r in categories">{{ r.nom }}</option>
                        </select>
                    </div>
                    <p id="red" v-if="validations">
                        {{ validations.role }}
                    </p>
                </div>
                <div class="form-group shadow-textarea">
                    <label class="text-dark font-weight-medium" for="">Contenu (*)</label>
                    <textarea class="form-control" v-model="article.contenu"></textarea>

                    <p class="text-danger" v-if="validations">
                        {{ validations.description }}
                    </p>
                </div>

                <hr>

  

      <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Images   <button type="button" class="btn btn-info" v-on:click="addFiles()">Ajouter </button> </div>
                    <div class="card-body">
                       <div class="row">
                            <div class="col-md-3">
                                  <input type="file" id="files" style="visibility:hidden;position:absolute;top:0;left:0" ref="files" accept="image/*" multiple v-on:change="handleFilesUpload()"/>
                            </div><br/>
                            <div class="col-md-6" v-for="(file, key) in files">
                                <img class="img-responsive" height="70" width="90" v-bind:ref="'image'+parseInt( key )"/>
                            </div>

                       </div>
                    </div>
                </div>
            </div>
        </div>





       

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-offset-3 col-sm-3">
                            <button type="submit" class="btn btn-primary form-control">
                                <i class="fa fa-check"></i> Enregistrer
                            </button>
                        </div>
                        <div class="col-sm-offset-3 col-sm-3">
                            <button type="reset" class="btn btn-danger form-control">
                                <i class="fa fa-ban"></i> Recommencer
                            </button>
                        </div>
                    </div>
                </div>

            </form>


    </b-card>
</template>
<script>
    import axios from 'axios';

        Vue.use(axios);


    export default {

        data() {
            return {
                categories : [],
                images : [],
                url: null,
                        files: [],

                image: '',
                article : {
                   titre : '',
                   contenu : '',
                   auteur : '',
                   categorie : '',
                    image: ''
               },
            }
        },

        mounted() {
            this._categorie();
        },
        methods: {
 
           addPict : function() {
              this.images.push(Vue.util.extend({}, this.image))
           },

        onFileChange(e) {
            const file = e.target.files[0];
             var i = 1;
            
            this.url[i] = URL.createObjectURL(file);
             
            },
            _categorie(){
                let _self = this;
                axios.get('/api/categoriearticle')
                    .then(function (response) {
                        _self.categories = response.data.content;
                    }).catch(function (response) {
                });
            },

    
           onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            uploadImage(){
                axios.post('/image/store',{image: this.image}).then(response => {
                   if (response.data.success) {
                     alert(response.data.success);
                   }
                });
            },
            _store(){
                let _self = this;
                var article_form = {
                    'titre' : _self.article.titre,
                    'categorie' : _self.article.categorie,
                    'contenu' : _self.article.contenu,
                    image: _self.images
                };
 
            console.log(article_form)

               /* axios.post('/api/article', article_form)
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

                });*/

            },

             addFiles(){
        this.$refs.files.click();
      },

      /*
        Submits files to the server
      */
      submitFiles(){
          let _self = this;
        /*
          Initialize the form data
        */
        let formData = new FormData();

        /*
          Iteate over any file sent over appending the files
          to the form data.
        */
        for( var i = 0; i < _self.files.length; i++ ){
          let file = _self.files[i];

          formData.append('files[' + i + ']', file);
        }


                var article_form = {
                    'titre' : _self.article.titre,
                    'categorie' : _self.article.categorie,
                    'contenu' : _self.article.contenu,
                    image: _self.images
                };


                console.log(formData.values());
        /*
          Make the request to the POST /select-files URL
        
        axios.post( '/file-multiple-preview',
          formData,
          {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
          }
        ).then(function(){
          console.log('SUCCESS!!');
        })
        .catch(function(){
          console.log('FAILURE!!');
        });*/
      },

      /*
        Handles the uploading of files
      */
      handleFilesUpload(){
        /*
          Get the uploaded files from the input.
        */
        let uploadedFiles = this.$refs.files.files;

        /*
          Adds the uploaded file to the files array
        */
        for( var i = 0; i < uploadedFiles.length; i++ ){
          this.files.push( uploadedFiles[i] );
        }

        /*
          Generate image previews for the uploaded files
        */
        this.getImagePreviews();
      },

      /*
        Gets the preview image for the file.
      */
      getImagePreviews(){
        /*
          Iterate over all of the files and generate an image preview for each one.
        */
        for( let i = 0; i < this.files.length; i++ ){
          /*
            Ensure the file is an image file
          */
          if ( /\.(jpe?g|png|gif)$/i.test( this.files[i].name ) ) {
            /*
              Create a new FileReader object
            */
            let reader = new FileReader();

            /*
              Add an event listener for when the file has been loaded
              to update the src on the file preview.
            */
            reader.addEventListener("load", function(){
              this.$refs['image'+parseInt( i )][0].src = reader.result;
            }.bind(this), false);

            /*
              Read the data for the file in through the reader. When it has
              been loaded, we listen to the event propagated and set the image
              src to what was loaded from the reader.
            */
            reader.readAsDataURL( this.files[i] );
          }
        }
      }

        }


    }
</script>
<style>
</style>
