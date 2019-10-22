 <template>
	
	<modal-layouts name="viewRecord">



		<template  slot="heading">
			<div class=""><h5>
				<label class ="text-primary">
					Details de :
					<strong><i>
						{{viewRec.titre}}</i>
					</strong>
				</label>
			</h5>
			</div>
			</template>

		<template slot="main" >







			<section class="form-dark mb-5">


				<div class="card-body">

						<!--label  class="text-dark form-control-label"><strong>Titre de l'annonce :</strong></label>

						<label class=" form-control-label text-primary">
							<strong><i>
								{{viewRec.titre}}</i>
							</strong>
						</label-->


					<!-- Section: form gradient -->
					<!-- Section: form dark -->



<div class="row">
	<div class="col-6">

		<div class="row text-dark form-group">
			<h6 class='text-default'><span class="important">Contenue De l'annonce</span> <em class="text-light">(saisi)</em></h6>


			<label class="md-textarea form-control z-depth-1 form-control text-primary" disabled rows="12">
				<div v-html="viewRec.contenue"></div>
			</label>


		</div>
		<hr>
		<div>

		</div>

		<div class="row form-group">
			<h5>
				<label  class="form-control-label text-dark label-medium"><strong>Crée le :</strong></label>
				<label class="text-primary form-control-label text-primary">
					<strong>
						&nbsp {{viewRec.created_at_human}}
					</strong>
				</label>
			</h5>



		</div>


		<div class="row form-group">
			<h5>
				<label  class="text-dark form-control-label"><strong>Valider le :</strong></label>

				<label class=" form-control-label text-primary">
					<strong>
						&nbsp {{viewRec.date_validation = (viewRec.date_validation)? viewRec.date_validation : 'pas encore valider'}}
					</strong>
				</label>
			</h5>


		</div>

		<div class="row form-group">
			<h5>
				<label  class="text-dark"><strong>Annonceur :</strong></label>
				<label class="  text-primary">
					<strong>
						&nbsp {{viewRec.annonceur}}
					</strong>
				</label>
			</h5>




		</div>

		<div class="row form-group">
			<h5>
				<label  class="text-dark"><strong>Contact de Annonceur :</strong></label>
				<label class="  text-primary">
					<strong>
						&nbsp {{viewRec.contact}}
					</strong>
				</label>
			</h5>


			<hr>

		</div>
		<div class="row form-group">
			<h5>
				<label  class="text-dark form-control-label"><strong>Début Planifié :</strong></label>

				<label class=" form-control-label text-primary">
					<strong>
						&nbsp {{viewRec.dateDebutHuman}}
					</strong>
				</label>
			</h5>



		</div>


		<div class="row form-group">
			<h5>
				<label  class="text-dark form-control-label"><strong>fin prévue :</strong></label>

				<label class=" form-control-label text-primary">
					<strong>
						&nbsp {{viewRec.date_fin_human}}
					</strong>
				</label>
			</h5>



		</div>
		<div class="row form-group">
			<h5>
				<label  class="text-dark form-control-label"><strong>Status actuelle :&nbsp</strong></label>
			</h5>
			<select class="browser-default  text-primary custom-select custom-select-lg mb-3 " id="etat" name="etat" style="width:200px;" disabled v-model="viewRec.etat">
				<option value="4">Publier</option>
				<option value="1">Desactivé</option>
				<option value="3">Bloquer</option>
			</select>





		</div>
	</div>
	<div class="col-6">



		<div class="row form-group">
			<h6 class='text-default'><span class="important"><i class="fa fa-camera fa-2x" aria-hidden="true"></i> </span> <em class="text-light"></em></h6>


			<div class="text-center" id="my-strictly-unique-vue-upload-multiple-image" style="display: flex; justify-content: center;">

				<vue-upload-multiple-image3   v-model="viewRec.images"
											  @upload-success="uploadImageSuccess"
											  @before-remove="beforeRemove"
											  @edit-image="editImage"
											  @data-change="dataChange"
											  @limit-exceeded="limitExceeded"
											  :data-images="viewRec.images"
				></vue-upload-multiple-image3>

			</div>
		</div>

<hr>

		<div class="row form-group">
			<h5>
				<label  class="text-dark form-control-label"><strong>Nombre caracteres:</strong></label>

				<label class=" form-control-label text-primary">
					<strong>
						{{viewRec.nombreCaratere}}&nbsp caracteres
					</strong>
				</label>
			</h5>


		</div>

		<div class="row form-group">
			<h5>
				<label  class="text-dark form-control-label"><strong>Net  a  payer:</strong></label>

				<label class=" form-control-label text-primary">
					<strong>
						{{viewRec.prix}}
					</strong>
				</label>
			</h5>


		</div>
		<div class="row form-group">
			<h5>
				<label  class="text-dark form-control-label"><strong>Reste  a  payer:</strong></label>

				<label class=" form-control-label text-primary">
					<strong>
						-{{viewRec.prix}}
					</strong>
				</label>
			</h5>


		</div>




		<div class="row form-group">
			<h5>
				<label  class="text-dark form-control-label"><strong>Etat payement :</strong></label>

				<label class=" form-control-label text-primary">
					<strong>
						Non payé
					</strong>
				</label>
			</h5>


		</div></div>
</div>



						<!--Grid row-->
								<div class="row d-flex align-items-center">

									<!--Grid column-->
									<div class="text-center col-md-12 mt-3 mb-2">
										<button type="button"  aria-disabled="true" class="btn btn-success btn-block btn-rounded z-depth-1">Veillez Verifier avant la validation!</button>
									</div>
									<!--Grid column-->
								</div>
								<!--Grid row-->



						<!--/Form without header-->








				
				</div>


			</section>








		</template>


		<template slot="footer">


			<button class=" btn btn-outline-primary btn-sm" data-dismiss="modal" data-target="#editRecord" @click="activation(record.slug)">Valider<i class="fa fa-edit"></i></button>




			<button type="button" class="btn btn-outline-primary btn-sm" data-dismiss="modal">Retour</button>
		</template>

	</modal-layouts>

</template>

<script>
	import ModalLayouts from './partials/ModalLayouts1';


	export default {
		props: ['viewRec'],

		components: { ModalLayouts },
		methods: {
			   activation (slug) {
                swal.fire({
                    title: 'Voulez vous Changer le status?',
                    text: "Vous en  avez la possibilité! ",
                    type: '',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui',
                    cancelButtonText:'Non, annuler'
                })
                    .then((result) => {
                        if (result.value) {
                                this.record.etat = 4;
                                axios.put(`/api/annonce/${slug}`, this.record)
                                    .then(response => {
                                        this.refreshRecord(response);

                                        swal.fire(
                                            'Activée avec succés!',
                                            'L\'annonce est accésible au public',
                                            'success'
                                        );
                                        this.list();
                                    })
                        }
                    })
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
	 .form-gradient .header {
		 border-top-left-radius: .3rem;
		 border-top-right-radius: .3rem; }

	 .form-gradient input[type=text]:focus:not([readonly]) {
		 border-bottom: 1px solid #fd9267;
		 box-shadow: 0 1px 0 0 #fd9267; }

	 .form-gradient input[type=text]:focus:not([readonly]) + label {
		 color: #4f4f4f; }

	 .form-gradient textarea.md-textarea:focus:not([readonly]) {
		 border-bottom: 1px solid #fd9267;
		 box-shadow: 0 1px 0 0 #fd9267; }


	 .form-dark .md-form label {
		 color: #fff; }

	 .form-dark input[type=text]:focus:not([readonly]) {
		 border-bottom: 1px solid #00C851;
		 -webkit-box-shadow: 0 1px 0 0 #00C851;
		 box-shadow: 0 1px 0 0 #00C851; }

	 .form-dark input[type=text]:focus:not([readonly]) + label {
		 color: #fff; }

	 .form-dark textarea.md-textarea:focus:not([readonly]) {
		 border-bottom: 1px solid #00C851;
		 box-shadow: 0 1px 0 0 #00C851;
		 color: #fff; }

	 .form-dark textarea.md-textarea  {
		 color: #fff;
	 }

	 .form-dark .form-control, .form-dark .form-control:focus {
		 color: #fff;
	 }
 </style>