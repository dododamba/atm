 <template>
	
	<modal-layouts name="viewRecord">
		
		<template slot="heading">
			<div class=""><h5>
				<label class ="text-primary">
					Details de :
					<strong><i>
						{{viewRec.libelle}}</i>
					</strong>
				</label>
			</h5>
			</div>
			
			</template>

		<template slot="main">
				<div class="text-dark form-group">
									<h5><label class="text-dark" for="form103">Description Du Type l'annonce</label>
									</h5>

									<textarea id="form103" class="md-textarea form-control z-depth-1 form-control text-primary" disabled rows="12">{{viewRec.description}}</textarea>
								</div>
						<hr>

			<div class="card-body">
				<h5 class="card-title">
					<label  class="text-dark form-control-label"><strong>Titre :</strong></label>

					<label class=" form-control-label text-primary">
						<strong>
							{{viewRec.libelle}}
						</strong>
					</label></h5>
				<p class="card-text"></p>
			</div>
			<div class="row form-group">
							<h5>
								<label  class="form-control-label text-dark label-medium"><strong>Crée le :</strong></label>
								<label class="text-primary form-control-label text-primary">
									<strong>
										&nbsp {{viewRec.created_at}}
									</strong>
								</label>
							</h5>



						</div>
			
		</template>

		<template slot="footer">
			<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Fermer</button>
		</template>

	</modal-layouts>

</template>

<script>
    import ModalLayouts from '../partials/ModalLayouts'

    export default {
		props: ['viewRec'],

		components: { ModalLayouts }
	};
</script>