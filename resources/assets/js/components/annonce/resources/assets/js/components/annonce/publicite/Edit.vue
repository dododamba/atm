<template>

	<modal-layouts name="editRecord" id="editRecord">
		
		<template slot="heading">Editer La publicite</template>

		<template slot="main">
			<div class="row">
			<div class="col-8">
				<div class="row form-group">
					<div class="col-12">
				<h6 class='text-default'><span class="important">Titre</span> <em class="text-light">(saisir)</em></h6>

				<input type="text"  v-model="editRec.titre"
					   @keydown="delete errors.titre"
					   @keypress=" empechsaisie($event)"
					   class=" form-control form-control-lg"  id="editRec.titre"
					   name="editRec.titre" placeholder="entête de l'annonce" />
				<p class='text-right text-small' style="color: midnightblue" v-bind:class="{'text-danger': hasError }">{{this.editRec.titre.length}} mots entregistrer| max  1000</p>



			</div>
			</div>
			  <hr>
                            <div class="row">
                                <div class="col-12">



                                            <h6 class='text-default'><span>Le Contenue de la publicite</span> <em class="text-light">(saisir)</em></h6>
                                            <VueTrix inputId="contenue" v-model="editRec.contenue"/>
                                           <p class='text-right text-small'   style="color: midnightblue" v-bind:class="{'text-danger': hasError }">{{this.editRec.contenue.length}} mots restantes|  max</p>





                                    <!--textarea class="form-control" @keypress="empechsaisiebizare($event)" v-model="contenue" v-on:keyup="countdown" id="contenue" placeholder="Contenue de l'annonce" rows="12"></textarea>
                                    <p class='text-right text-small'   style="color: midnightblue" v-bind:class="{'text-danger': hasError }">{{max-this.contenue.length}} caracteres restantes| {{ max }}</p-->

                                </div>
                            </div>
				<div class="form-group">

					<textarea class="form-control" @keydown="delete errors.contenue" style="display:none;" v-model="editRec.contenue" v-on:keyup="countdown" id="editRec.contenue" placeholder="Contenue de l'annonce" rows="12"></textarea>


				</div>

			</div>
				<div class=" col-4">
				<div class="form-group row">

				<h6 class='text-default'><span class="important"> </span> <em class="text-light">(CHOISIR)</em></h6>


				<div class="text-center" id="my-strictly-unique-vue-upload-multiple-image" style="display: flex; justify-content: center;">

					<vue-upload-multiple-image1
							:data-images="editRec.images "
							@upload-success="uploadImageSuccess"
							@before-remove="beforeRemove"
							@edit-image="editImage"
							@data-change="dataChange"
							@limit-exceeded="limitExceeded"
					></vue-upload-multiple-image1>

				</div>

			</div>
			</div>
			</div>


                      




			<hr>


			<div class="row">

				<div class="form-group col-4">


					<h6 class='text-default'><span class="important">Date de Debut Notée:</span> <em class="text-primary">{{editRec.dateDebutHuman}}</em></h6>

					<date-picker
							width="100%"
							v-model="editRec.dateDebut"
							minimum-view="'week'"
							type="date" lang="fr" valueType="format" format="YYYY/MM/DD"
							:first-day-of-week="1" :not-before="new Date()" :open-date="new Date()">
					</date-picker>

				</div>
				<div class="form-group col-4">
					<h6 class='text-default'><span class="important">Date     de     Fin  Prévue   : &nbsp</span> <em class="text-success">{{editRec.date_fin_human}}</em></h6>


					<date-picker

							width="100%"
							:minimumView="'month'"
							v-model="editRec.dateFin"
							type="date" lang="fr" valueType="format" format="YYYY/MM/DD"
							:first-day-of-week="1" :not-before="new Date()" :open-date="this.editRec.dateDebut<this.editRec.dateFin">
					</date-picker>



				</div>
				<div class=" form-group col-4 text-center ">

					<h6 class='text-center'><span class="important">Statut publicite : </span> <em class="text-light">(saisir)</em></h6>

					<select class="browser-default custom-select custom-select-lg mb-3 " id="etat" name="etat" style="width:190px;" v-model="editRec.etat">
						<option value="4">Publier</option>
						<option value="1">Desactivé</option>
						<option value="3">Bloquer</option>
					</select>


				</div>
			</div>

			<hr>




			<div class="row ">

				<div class="form-group col-6">
					<h6 class='text-default'><span class="important">Demandeur </span> <em class="text-light">(saisir)</em></h6>
					<input type="text"  @keypress=" empechsaisiebizare($event)" class=" form-control form-control-lg"  id="editRec.annonceur" v-model="editRec.annonceur" name="annonceur" placeholder="nom complet de l'annonceur " />



				</div>

				<div class=" form-group col-6">
					<h6 class='text-default'><span class="important">Contact Demandeur</span> <em class="text-light"></em></h6>


					<input type="text" @keypress="numerotel($event)" id="contact" v-model="editRec.contact" name="contact" placeholder="Contact" class="form-control"><small class="form-text text-muted">Contact Phone</small>
				</div>
			</div>







		</template>

		<template slot="footer">
			<button type="button" 
					class="btn btn-outline-secondary" 
					@click="clearModal" 
					data-dismiss="modal">Fermer</button>

			<button type="submit" 
					class="btn btn-outline-primary" 
					@click="updateRecord"
					data-dismiss="modal">Enregistrer </button>
		</template>

	</modal-layouts>

</template>

<script>

	import ModalLayouts from '../partials/ModalLayouts1'
	import axios from 'axios';
	import Datepicker from 'vuejs-datepicker';
	  import VueTrix from 'vue-trix';
	Vue.use( axios);

	export default {
		props: ['editRec'],

		data() {
			return {
				errors: [],
				hasError:'',




			}

		},

		components: { ModalLayouts,
		VueTrix,
			Datepicker},

		methods: {
			// compte des mots
			countdown: function() {
				this.remainingCount = this.maxCount - this.contenue.length;
				this.hasError = this.remainingCount < 0;
			},
			empechsaisie: function($event) {
				let specials=/[*|\":<>[\]{}`\\()';@&$]/;
				if((($event.keyCode >= 60) && ($event.keyCode <= 64) || ($event.keyCode >= 123) && ($event.keyCode <= 125) || ($event.keyCode >= 35) && ($event.keyCode <= 38))){
					$event.returnValue = false;
					return;
				}
				$event.returnValue = true;
			},
			numerotel: function($event) {
				// return phone.replace(/[^0-9]/g, '')
				//     .replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');

				//let specials=/[*|\":<>[\]{}`\\()';@&$]/;
				if ($event.charCode === 0 || /\d/.test(String.fromCharCode($event.charCode))) {
					return true
				} else {
					$event.preventDefault();
				}
			},

			updateRecord() {
				axios.put(`/annonce/${this.editRec.slug}`, this.editRec)
					.then(response => {
						this.$emit('recordUpdated', response);
						
						toast.fire({
						  type: 'success',
                            title: 'Enregistrer avec succes!'						});

						$('#editRecord').modal('hide');



					})
					.catch(error => this.errors = error.response.data.errors)
			},

			clearModal() {
				this.errors = [];
			},

			uploadImageSuccess(formData, index, fileList) {
				console.log('data', formData, index, fileList);
				//console.log(fileList[index].path);
				//console.log(this.dat);
				return this.images.push(fileList[index]);
				// Upload image api
				// axios.post('http://your-url-upload', { data: formData }).then(response => {
				//   console.log(response)
				// })
				// console.log(images);
			},






			beforeRemove (index, done, fileList) {
				console.log('index', index, fileList)
				toast.fire({
					type: 'success',
					title: 'Succès',
					html: 'Annonce créé avec succès'
				});
				var r = confirm("remove image")

				if (r == true) {
					done()
				} else {
				}
			},
			editImage (formData, index, fileList) {
				console.log('edit data', formData, index, fileList)
			},
			dataChange (data) {
				console.log(data)
			},

			limitExceeded(amount){
				console.log(amount)
			}
		}
	};
</script>

<style>
	#my-strictly-unique-vue-upload-multiple-image {
		font-family: 'Avenir', Helvetica, Arial, sans-serif;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
		text-align: center;
		color: #2c3e50;
		margin-top: 60px;
	}
/*
	h1, h2 {
		font-weight: normal;
	}

	ul {
		list-style-type: none;
		padding: 0;
	}

	li {
		display: inline-block;
		margin: 0 10px;
	}

	a {
		color: #42b983;
	}
	*/
</style>
