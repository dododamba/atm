<template>
     <b-card >
        <hr  class="mnhr">
            <form @submit.prevent="onSubmit" enctype="multipart/form-data">
                <template>

                    <ul class="nav  nav-tabs" id="myTab" role="tablist">


                        <li class="baccouleur nav-item">
                            <a class="nav-link count text-dark" v-bind:class="{active : etape===1} " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"> Forfait  &  Contacts</a>
                        </li>
                        <li class="baccouleur nav-item">
                            <a class="nav-link count text-dark" v-bind:class="{active : etape===2} " id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Images</a>
                        </li>
                        <li class="baccouleur nav-item">
                            <a class="baccouleur nav-link count text-dark" v-bind:class="{active : etape===3} " id="contact-tab" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact2" aria-selected="false">Contenue   &  Detail</a>
                        </li>
                        <li class="baccouleur nav-item count">
                            <a class="nav-link count text-dark" v-bind:class="{active : etape===4} " id="contact-tab1" data-toggle="tab" href="#contact11" role="tab" aria-controls="contact11" aria-selected="false">Validation</a>
                        </li>
                        <li class="baccouleur nav-item count">
                            <a class="nav-link count text-dark" v-bind:class="{active : etape===5} " id="contact-tab2" data-toggle="tab" href="#contact3" role="tab" aria-controls="contact3" aria-selected="false">BiLaN</a>
                        </li>


                    </ul>
                    <hr  class="mnhr">

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade" v-bind:class="{active : etape===1,show : etape===1} " id="home" role="tabpanel" aria-labelledby="home-tab">
                             <hr>
                            <div class="row ">

                                <div class="form-group col-6">
                                    <h6 class='text-default'><span class="important">Demandeur </span> <em class="text-light">(saisir)</em></h6>
                                    <input type="text"  @keypress=" empechsaisiebizare($event)" class=" form-control form-control-lg"  id="annonceur" v-model="annonceur" name="annonceur" placeholder="nom complet de l'annonceur " />


                                </div>
                                
                                             <div class="form-group col-3">
                                    <h6 class='text-default'><span class="important">Contact 1 Du Demandeur</span> <em class="text-light">(saisir)</em></h6>


                                                <input type="text" @keypress="numerotel($event)" id="contact" v-model="contact" name="contact" placeholder="Contact" class="form-control"><small class="form-text text-muted">saisir le contact</small>
                                             </div>

                                            <div class=" form-group col-3">
                                    <h6 class='text-default'><span class="important">Contact 2 Du Demandeur</span> <em class="text-light">(saisir)</em></h6>


                                                <input type="text" @keypress="numerotel($event)" id="contact1" v-model="contact1" name="contact1" placeholder="contact" class="form-control"><small class="form-text text-muted">saisir le contact</small>
                                            </div>

                               
                            </div>
                            <div class="row ">
                                <div class="form-group col-6">
                                    <h6 class='text-default'><span  class="important">Choix Publicité </span> <em class="text-light">(saisir)</em></h6>

                                    <select class="browser-default custom-select custom-select-lg mb-3  text-primary form-control-sm"
                                            id="type" name="type" v-model="type" v-on:change="charger_position2">
                                        <option disabled selected>Selectionner</option>


                                        <option v-for="record in records.content.data" v-bind:value="record.id">
                                            {{ record.libelle }}
                                        </option>
                                    </select>

                                    <span>Sélectionné : {{ selected1 }}</span>


                                </div>

                                <div  class="form-group col-6">
                                    <h6 class='text-default'><span  class="important">Position du Pub sur Ecran</span> <em class="text-light">(saisir)</em></h6>

                                    <select v-if="type != '' "  class="browser-default custom-select custom-select-lg mb-3
                                            text-primary form-control-sm" id="position" name="position" v-model="position"
                                            v-on:change="charger_position1">
                                        <option disabled selected>Selectionner</option>

                                        <option v-for="option in records2" v-bind:value="option.id">
                                            {{ option.libelle }}
                                        </option>
                                    </select>


                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div v-if="type != ''" style="color: midnightblue" class="form-group col-6">
                                    <h6 class='text-default'><span class=""></span> <em class="text-light">(selection)</em></h6>
                                    <h6 class='text-default'><span class="important">Choix Forfait</span> <em class="text-light">(selectionner)</em></h6>
                                    <select class="browser-default custom-select custom-select-lg mb-3  text-primary form-control-sm" id="max" name="max" v-model="max" >
                                        <option value="200">200 Caractéres</option>
                                        <option value="300">300 Caractéres</option>
                                        <option value="400">400 Caractéres</option>
                                        <option value="500">500 Caractéres</option>
                                        <option value="600">600 Caractéres</option>
                                        <option value="700">700 Caractéres</option>
                                        <option value="800">800 Caractéres</option>
                                        <option value="1000">1000 Caractéres</option>
                                        <!--option v-for="option in partenaires" v-bind:value="option.value">
                                            {{ option.text }}
                                        </option-->
                                    </select>
                                </div>
                                <div v-if="max!=0 && position!=0" style="color: midnightblue" class="form-group col-6">




                                    <div class="row text-center">
                                        <div class="col-lg-12 col-md-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="stat-widget-five">
                                                        <div class="text-left text-primary stat-icon dib flat-color-1">

                                                            <h6 class='text-default'> <i class="fa fa-btc fa-3x" aria-hidden="true"></i>  <span class="">Cout Correspondant au Forfait par Jour</span> <em class="text-light">(Calculer)</em></h6>

                                                        </div>
                                                        <div class="stat-content">
                                                            <div class="text-center dib">
                                                                <div  v-if="records4.nbre_caractere!=0"  class=" text-primary stat-text">
                                                                    <div style="color: midnightblue" class=" stat-heading"><b>{{max}} &nbsp Caractére Coutent :</b>
                                                                        <b class="count">{{max*records4.prix_caractere/records4.nbre_caractere}} {{records4.devise}}
                                                                        </b>
                                                                    </div>
                                                                    <div style="color: midnightblue" class=" stat-heading"><b>Une Image Coute :</b>
                                                                        <b class="count">{{records4.prix_image}} {{records4.devise}}
                                                                        </b>
                                                                    </div>
                                                                </div>
                                                                <div v-else class=" stat-heading">{{max}} &nbsp Caractéres Coutent :

                                                                    <span class="count text-danger">Erreur  de calacul On ne peut pas diviser par 0
                                                    </span>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <hr>
                        </div>
                        <div class="tab-pane fade"  v-bind:class="{active : etape===2,show : etape===2} " id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <template>
                                <hr>
                                <div id="my-strictly-unique-vue-upload-multiple-image"
                                        style="display: flex; justify-content: center;">
                                    <vue-upload-multiple-image2

                                            @before-remove="beforeRemove"
                                            @data-change="dataChange"
                                            @edit-image="editImage"
                                            @upload-success="uploadImageSuccess"
                                            idUpload="images"
                                            editUpload="image"

                                    ></vue-upload-multiple-image2>
                                </div>
                            </template>
                            <!--div class="row ">
                                <div class="form-group col-6">
                                    <h6 class=''><span></span> <em class="text-light"></em></h6></div>
                                <div  class="form-group col-6">
                                    <h6 class='text-default'><span></span> <em class="text-light"></em></h6>
                                </div>
                            </div-->
                           
                        </div>
                        <div class="tab-pane fade"  v-bind:class="{active : etape===3,show : etape===3} "id="contact2" role="tabpanel" aria-labelledby="contact-tab">
 <div class="row">
                                <div class="form-group col-6">
                                    
                                    <h6 class='text-default'><span class="important">Date de Debut De La publicité</span> <em class="text-light">(saisir)</em></h6>
                                    <date-picker
                                            width="100%"

                                            v-model="dateDebut"
                                            minimum-view="'week'"
                                            type="date" lang="fr" valueType="format" format="YYYY/MM/DD"
                                            :first-day-of-week="1" :not-before="new Date()" :open-date="new Date()">
                                    </date-picker>
                                    <p v-if="errors.date_depart" style="color: red">
                                        {{errors.date_depart[0]}}
                                    </p>
                                </div>
                                <div class="form-group col-6">
                                    <h6 class='text-default'><span class="important">Date de Fin de la publicité</span> <em class="text-light">(saisir)</em></h6>
                                    <date-picker

                                            width="100%"
                                            :minimumView="'month'"
                                            v-model="dateFin"
                                            type="date" lang="fr" valueType="format" format="YYYY/MM/DD"
                                            :first-day-of-week="1" :not-before="dateDebut" :open-date="this.dateDebut<this.dateFin">
                                    </date-picker>
                                    <div v-if="this.dateFin<this.dateDebut" style="color: darkgreen">
                                        La date de fin doit etre superieur au debut!!
                                    </div>
                                    <p v-if="errors.date_depart" style="color: red">
                                        {{errors.date_depart[0]}}
                                    </p>
                                </div>

                            </div>
                           

                            <hr>
                          <div class="row">
                                <div class=" col-12">
                                    <h6 class='text-default'><span class="important">Titre</span> <em class="text-light">(saisir)</em></h6>

                                    <input type="text"  @keypress="empechsaisiebizare($event)" class=" form-control "  v-on:keyup="countdown" id="titre" v-model="titre" name="titre" placeholder="entête de l'publicité" />
                                    <p class='text-right text-small' style="color: midnightblue" v-bind:class="{'text-danger': hasError }">{{this.titre.length}} mots entregistrer| max  30</p>

                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">

                                    <hr>

                                            <h6 class='text-default'><span>Le Contenue de la publicite</span> <em class="text-light">(saisir)</em></h6>
                                            <VueTrix inputId="contenue" v-model="contenue"/>
                                            <p class='text-right text-small'   style="color: midnightblue" v-bind:class="{'text-danger': hasError }">{{max-this.contenue.length}} caracteres restantes| {{ max }}</p>





                                    <!--textarea class="form-control" @keypress="empechsaisiebizare($event)" v-model="contenue" v-on:keyup="countdown" id="contenue" placeholder="Contenue de l'annonce" rows="12"></textarea>
                                    <p class='text-right text-small'   style="color: midnightblue" v-bind:class="{'text-danger': hasError }">{{max-this.contenue.length}} caracteres restantes| {{ max }}</p-->

                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12 col-md-9"><textarea class="form-control"  style="display:none;"  id="contenue"
                                                                        placeholder="Contenue de l'publicite"
                                                                        @keypress="empechsaisiebizare($event)"   v-on:keyup="countdown" v-model="contenue"  rows="9"></textarea></div>
                            </div>
                            <hr>
                           
                            

                        </div>
                        <div class="tab-pane fade"  v-bind:class="{active : etape===4,show : etape===4} " id="contact11" role="tabpanel" aria-labelledby="contact-tab1">
                            <hr>
                            <h2>Information Saisie</h2> <br>
                            <div class=" row">
                                <div class="form-group col-6">
                                    <h6 class=''><span class="count important">Forfait Choisi : </span> <em class="text-light">(i)</em>{{this.max}} Caractére</h6><br/>
                                    <h6 class=''><span class="count important">Titre : </span> <em class="text-light">(i)</em>{{this.titre}}</h6><br/>
                                    <h6 class='text-default'><span class="count important">Contenue : </span> <em class="text-light">(i)</em>   <label class="">
                                        <div v-html="this.contenue"></div>
                                    </label></h6><br/>                                    <h6 class=''><span class="count important">Date De Debut : </span> <em class="text-light">(i)</em>{{this.dateDebut}}</h6><br/>
                                    <h6 class=''><span class="count important">Date de Fin : </span> <em class="text-light">(i)</em>{{this.dateFin}} </h6><br/>

                                </div>
                                <div class="form-group col-6">
                                    <h6 class=''><span class="count important">Demandeur : </span> <em class="text-light">(i)</em>{{this.annonceur}} </h6><br/>
                                    <h6 class=''><span class="count important">Contact Demandeur : </span> <em class="text-light">(i)</em>{{this.contact}}</h6><br/>
                                    <h6 class=''><span class="count important">Contact2 Demandeur : </span> <em class="text-light">(i)</em>{{this.contact1}}</h6><br/>
                                    <h6 class=''><span class="count important">Nombre Images: </span> <em class="text-light">(i)</em>{{this.images.length}}Images </h6><br/>
                                    <h6 class=''><span class="count important">Net A payer: </span> <em class="text-light">(i)</em>
                                        {{this.images.length }} Images et {{max-remainingCount}} Caractéres saisies    Vous Coutent :
                                        <b class="count">{{prix=(max-remainingCount)*records4.prix_caractere/records4.nbre_caractere + this.images.length*records4.prix_image}} {{devise=records4.devise}}
                                        </b>


                                    </h6><br/>
                                </div>

                            </div>


                            <template>
                                <hr>
                                <div id="my-strictly-unique-vue-upload-multiple-imag"
                                     style="display: flex; justify-content: center;">
                                    <vue-upload-multiple-image0

                                            @before-remove="beforeRemove"
                                            @data-change="dataChange"
                                            @edit-image="editImage"
                                            @upload-success="uploadImageSuccess"
                                            editUpload="image"
                                            :data-images="this.images"

                                    ></vue-upload-multiple-image0>
                                </div>
                            </template>





                            <hr>
                            <div class=" d-flex align-items-center">

                                <!--Grid column-->
                                <div class="text-center col-md-12 mt-3 mb-2">
                                    <button type="button"  aria-disabled="true" class="btn btn-success btn-block btn-rounded z-depth-1">Veillez Verifier avant la validation!</button>
                                </div>
                                <!--Grid column-->
                            </div>
                            <hr>

                        </div>
                        <div class="tab-pane fade"  v-bind:class="{active : etape===5,show : etape===5} " id="contact3" role="tabpanel" aria-labelledby="contact-tab2">
                            <hr>
                            <h2>Information Génerale</h2> <br>
                            <div class="row">
                                <table class="center-block  table table-bordered table-striped">
                                    <thead class="thead-primary">
                                    <tr class="table-primary">
                                        <th scope="col" >Nombres Caractéres</th>
                                        <th scope="col">Nombres Images</th>
                                        <th scope="col">Prix Caracteres</th>
                                        <th scope="col">Prix Images</th>
                                        <th scope="col">Net a Payer</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr >
                                        <th  scope="row">

                                            <!-- Widgets  -->
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="stat-widget-five">
                                                                <div class="stat-icon dib flat-color-1">
                                                                    <i class="fa  fa-apple fa-2x"></i>
                                                                </div>
                                                                <div class="stat-content">
                                                                    <div class="text-left dib">
                                                                        <div class="stat-text text-primary"><span class="count">{{remainingCount}}</span></div>
                                                                        <div class="stat-heading">Caractéres Restantes</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </th>
                                        <td class="bg-info " rowspan="3">

                                            <div class="stat-content">
                                                <div class="text-center dib">
                                                    <div style="color: midnightblue" class=" stat-heading"><b>Images Chargées</b>
                                                        <b class="count">{{this.images.length}}
                                                        </b>
                                                    </div>

                                                </div>
                                            </div>
                                        </td>
                                        <td ></td>
                                        <td class="table-primary" rowspan="2">
                                            <div class="stat-content">
                                                <div class="text-center dib">
                                                    <div class="stat-text"><span class="count"></span>Prix des Images inserer</div>
                                                    <div class=" text-warning stat-heading">{{this.images.length*records4.prix_image}} {{records4.devise}}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="bg-info" rowspan="3">
                                            <div class="stat-content">
                                                <div class="text-center dib">
                                                    <div style="color: midnightblue" class=" stat-heading"><b>{{this.images.length }} Images et {{max-remainingCount}} <br/> Caractéres saisies <br/>   Vous Coutent :</b><br/>
                                                        <b class="count">{{(max-remainingCount)*records4.prix_caractere/records4.nbre_caractere + this.images.length*records4.prix_image}} {{records4.devise}}
                                                        </b>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-primary" scope="row">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="stat-widget-five">
                                                                <div class="stat-icon dib flat-color-1">
                                                                    <i class="fa fa-apple fa-3x"></i>
                                                                </div>
                                                                <div class="stat-content">
                                                                    <div class="text-left dib">
                                                                        <div class="stat-text"><span class="count">{{max-remainingCount}}</span></div>
                                                                        <div class="stat-heading">Caractéres Saisie</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <td>

                                            <div class="stat-content">
                                                <div class="text-center dib">
                                                    <div style="color: midnightblue" class=" stat-heading"><b>{{max-remainingCount}} &nbsp <br/>Caractéres saisies<br/> Coutent :</b>
                                                        <b class="count">{{(max-remainingCount)*records4.prix_caractere/records4.nbre_caractere}} {{records4.devise}}
                                                        </b>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="stat-widget-five">
                                                                <div class="stat-icon text-primary dib flat-color-1">
                                                                    <i class="fa fa-pause fa-3x"   aria-hidden="true"></i>

                                                                </div>
                                                                <div class="stat-content">
                                                                    <div class="text-left dib">
                                                                        <div class="stat-text"><span class="count">{{max}} Caractéres </span></div>
                                                                        <div class="stat-heading"> Maxi du Forfait Choisi</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <td>
                                            <div style="color: midnightblue" class=" stat-heading"><b>{{max}} &nbsp <br/>Caractére Coutent :</b>
                                                <b class="count">{{max*records4.prix_caractere/records4.nbre_caractere}} {{records4.devise}}
                                                </b>
                                            </div>
                                        </td>
                                        <td>

                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="stat-widget-five">
                                                                <div class="stat-icon text-primary dib flat-color-1">
                                                                    <i class="fa fa-fast-forward  fa-3x " aria-hidden="true"></i>

                                                                </div>
                                                                <div style="color: midnightblue" class=" stat-heading"><b>Une Image Coute :</b><br>
                                                                    <b class="count">{{records4.prix_image}} {{records4.devise}}
                                                                    </b>
                                                                    <br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr>

                        </div>
                    </div>
                </template>
                <div class="card-footer">
                    <div class="row " v-if="etape==4">
                        <div class="col-3" v-if="etape>1">
                            <button type="button"  class="btn btn-block btn-outline-success pull-left"  v-on:click="etape--"  >
                                <i class="fa fa-fast-backward fa-1x"></i>
                                Retour
                            </button>
                        </div>

                        <div  class="col-3" >
                            <button type="reset" class="btn btn-block btn-outline-danger ">
                                <i class="fa fa-ban"></i> <strong>Annuler</strong>
                            </button>
                        </div>

                        <div class="col-3"  v-if="etape==4">
                            <div>
                                 <b-button class="btn btn-outline-success btn-block " type="submit">
                                <i class="fa fa-dot-circle-o"></i> <strong> <b>Soumettre</b></strong>
                            </b-button>
                            </div>
                           

                        </div>
                        <div class="col-3"  v-if="etape < 4">
                            <button type="button" class="btn btn-block pull-center btn-outline-primary" @click="etape++">
                                Suivant<i class="fa fa-fast-forward fa-1x" aria-hidden="true"></i>
                            </button>
                        </div>






                    </div>
                    <div class="row " v-else>
                        <div class="col-4" v-if="etape>1">
                            <button type="button"  class="btn btn-block btn-outline-success pull-left"  v-on:click="etape--"  >
                                <i class="fa fa-fast-backward fa-1x"></i>
                                Retour
                            </button>
                        </div>

                        <div  class="col-4"  >
                            <button type="reset" class="btn btn-block btn-outline-danger ">
                                <i class="fa fa-ban"></i> <strong>Annuler</strong>
                            </button>
                        </div>


                        <div class="col-4"  v-if="etape < 5">
                            <button type="button" class="btn btn-block pull-center btn-outline-primary" @click="etape++">
                                Suivant<i class="fa fa-fast-forward fa-1x" aria-hidden="true"></i>
                            </button>
                        </div>





                    </div>







                </div>

            </form>
      </b-card>


    <!--div class="container m-lg-auto">
        <div class="row justify-content-center">
            <div class="col-md-auto">
                <div class="card card-default"><h1>
                    <div class="card-header bg-transparent text-primary">Gvoyage
                        <button class="btn btn-link btn-sm pull-right" data-target="#addRecord" data-toggle="modal">
                            <i class="fa  fa-sign-language" aria-hidden="true"></i></button>
                    </div>
                </h1>
                    <div class="card-body">
            <form @submit.prevent="onSubmit" enctype="multipart/form-data">


                <div class="row form-group">
                    <div class="col col-md-3"><label for="titre" class=" form-control-label"><strong>Titre</strong> </label></div>
                    <div class="col-12 col-md-9"><input type="text" id="titre" v-model="titre" name="titre" placeholder="entête de l'publicite" class="form-control"><small class="form-text text-muted">saisir le titre</small></div>
                </div>
                <hr>
                <hr>
                <div class="row">
                    <div class="col-auto">
                        <h6 class='text-default'><span>Le Conenue de l'publicite</span> <em class="text-light">(saisir)</em></h6>
                        <VueTrix inputId="contenue" v-model="contenue"/>
                        <p class='text-right text-small' v-bind:class="{'text-danger': hasError }">{{remainingCount}} mots restantes| 1000</p>
                    </div>
                </div>




                <div class="row form-group">
                    <div class="col col-md-3"><label class=" form-control-label"
                                                     for="contenue"><strong>Contenue</strong></label></div>
                    <div class="col-12 col-md-9"><textarea class="form-control"  style="display:none;"  id="contenue"
                                                           placeholder="Contenue de l'publicite"
                                                           rows="9"></textarea></div>
                </div>

                <div class="row">
                    <div class="form-group col-6">
                        <label class=" form-control-label" for="dateDebut"><strong>Date du Debut</strong> </label>
                        <input class="form-control" id="dateDebut" name="dateDebut" placeholder="début d'publicite"
                               type="date" v-model="dateDebut">
                        <small class="form-text text-muted">début d'publicite</small>

                    </div>


                    <div class="form-group col-6">
                        <label class=" form-control-label" for="dateFin"><strong>Date Fin</strong> </label>
                        <input class="form-control" id="dateFin" name="dateFin" placeholder="date de fin de l'publicite"
                               type="date" v-model="dateFin">
                        <small class="form-text text-muted">fin d'publicite</small>

                    </div>
                </div>

                <hr>
                <div class="row ">

                    <div class="form-group col-6">
                        <label class=" form-control-label"><strong>Position sur Ecran</strong></label>
                        <select class="browser-default custom-select custom-select-lg mb-3  text-primary form-control-sm"
                                id="position" name="position" v-model="position">
                            <option selected>Selectionner</option>

                            <option value="2">laterale</option>
                            <option value="1">laterale</option>

                            <option v-bind:value="option.value" v-for="option in types">
                                {{ option.text }}
                            </option>
                        </select>
                        <span>Sélectionné : {{ selected }}</span>

                    </div>
                    <div class="form-group col-6">
                        <label class=" form-control-label"><strong>Type Annonce </strong></label>
                        <select class="browser-default custom-select custom-select-lg mb-3  text-primary form-control-sm"
                                id="type" name="type" v-model="type">
                            <option selected>Selectionner</option>

                            <option value="2">pub</option>
                            <option value="1">autre</option>
                            <option value="3">hebdomadaire</option>
                            <option v-bind:value="option.value" v-for="option in types">
                                {{ option.text }}
                            </option>
                        </select>
                        <span>Sélectionné : {{ selected }}</span>


                    </div>
                </div>
                <hr>


                <div class="row ">


                    <div class="form-group col-6">
                        <label class=" form-control-label"><strong>Créateur </strong></label>
                        <select class="browser-default custom-select custom-select-lg mb-3  text-primary form-control-sm"
                                id="partenaire" name="partenaire" v-model="partenaire">
                            <option selected>Selectionner</option>
                            <option v-bind:value="option.value" v-for="option in partenaires">
                                {{ option.text }}
                            </option>
                        </select>
                        <span>Sélectionné : {{ selected }}</span>


                    </div>
                </div>


                <div class="row from-group">
                    <imageComponent :image=null></imageComponent>
                    <p style="color: red" v-if="errors.image"> {{errors.image[0]}}</p>
                </div>

                <hr>
                <hr>
                <div class="row form-group">
                    <div class="col col-md-3"><label class=" form-control-label"><strong>Etat Annonce</strong></label>
                    </div>
                    <div class="col col-md-9">
                        <select :options="partenaires" class="form-control form-control-sm" id=""
                                v-model="partenaire"
                                v-on:input="load_partenaire"
                        >
                            <template slot="first">
                                <option :value="null" disabled> -- Choisir le partenaire --</option>
                            </template>
                        </select>
                    </div>
                </div>

                <h2>Information Génerale</h2> <br>





                <div class="card-footer">
                    <b-button class="btn btn-success btn-sm" type="submit" v-on:click="onlist()"
                              variant="outline-success">
                        <i class="fa fa-dot-circle-o"></i> <strong>Envoyer</strong>
                    </b-button>
                    <b-button class="btn btn-danger btn-sm" type="reset">
                        <i class="fa fa-ban"></i> <strong>Annuler</strong>
                    </b-button>

                </div>


            </form>


                    </div>

                </div>
            </div>
        </div>



    </div-->
</template>


<script>
    import VueTrix from 'vue-trix';
    import axios from 'axios';
    import Datepicker from 'vuejs-datepicker';


    export default {
        components: {
            VueTrix,
            Datepicker
        },

        data() {
            return {
                etape: 1,
                devise: '',
                tabIndex: 0,
                record : {},
                records : {},
                records2 : {},
                records1 : {},
                records3 : {},
                records4 : {},
                max: 0,
                annonceur : '',

                maxCount: 1000,
                remainingCount: 0,
                message: '',
                hasError: false,
                titre: '',
                contenue: '',
                contact: '',
                contact1: '',
                dateDebut: '',
                dateFin:'',
                prix:'',
                nombreCaratere:'',

                etat: '',
                date_validation:'',
                utilisateur:'',
                transaction:'',
                images: [],
                image: this.images,
                type_annonce:'',
                date_creation:'',
                partenaire:'',
                partenaires:[],
                selected: 'un partenaire',
                selected1: 'Un Type D\'publicité',
                selected2: 'Une POSITION ',
                valider_par:'',
                position:'',
                positions: [],
                types:[],
                type:'',
                errors: [],
                today: new Date(),
                tomorrow : new Date(),


            }
        },
        mounted() {
            // On écoute le composant image
            this.$root.$on('image', (image_loaded) => {
                this.put_image(image_loaded);
            });

            this.load_partenaire();
            this.load_position();
            this.load_type();
        },


        methods: {
            charger_position2(){
                console.log(this.records);
                this.records.content.data.forEach((t)=>{
                    if(t.id===this.type){
                        this.records2=t.positions;
                        return;
                    }
                });
                console.log(this.records2);
            },
            charger_position1(){

                console.log(this.records2);
                this.records2.forEach((t)=>{
                    console.log(this.type);
                    if(t.id===this.position){

                        this.records4=t.pivot;
                        return;

                    }
                });
                console.log(this.records4);

            },
            linkClass(idx) {
                if (this.tabIndex === idx) {
                    return ['bg-primary', 'text-light']
                } else {
                    return ['bg-light', 'text-info']
                }
            },

            restrictChars1: function(e) {
                if(e.which == 97 || e.which == 98 || e.which == 99 || e.which == 110 || e.which == 111 || e.which == 65 || e.which == 66 || e.which == 67 || e.which == 78 || e.which == 79 || e.which == 49 || e.which == 50 || e.which == 51 || e.which == 52 || e.which == 53){
                } else {
                    return false;
                }
            },
            restrictChars: function($event) {

                const regex = RegExp('[0-9a-zA-Z]');

                if (!regex.test($event.key) && $event.key != 'backspace') {
                    e.preventDefault();
                }

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
            //EMPECHE SAISIE DES CARACTRERE BIZARE
            empechsaisiebizare: function($event) {
                let specials=/[*|\":<>[\]{}`\\()';@&$]/;
                if((($event.keyCode >= 60) && ($event.keyCode <= 64) || ($event.keyCode >= 123) && ($event.keyCode <= 125) || ($event.keyCode >= 35) && ($event.keyCode <= 38))){
                    $event.returnValue = false;
                    return;
                }
                $event.returnValue = true;
            },



            put_image(image) {
                this.image = image;
            },
            onResetForm() {
                this.name = '',
                    this.titre = '',
                    this.contenue = '',
                    this.contact = '',
                    this.contact1 = '',
                    this.dateDebut = '',
                    this.dateFin = '',
                    this.etape = 5,


                    this.image = null
            },

            // compte des mots
            countdown: function() {
                this.remainingCount = this.max - this.contenue.length;
                this.hasError = this.remainingCount < 0;
            },

            load_partenaire() {

                axios.get('/partenaire')
                    .then((response) =>{
                        response.data.content.forEach( (partenaire) => {
                            this.partenaires.push({
                                value: partenaire.id,
                                text: partenaire.libelle,
                            });
                        });
                        //console.log(this.partenaires);
                        console.log(response);


                    }).catch((response) => {
                        console.log(response);
                    }
                );
            },
            load_position() {

                let ar = this;
                axios.get('/positionannonce?page=${page}')
                    .then(function(response){
                        ar.records3 = response.data;
                        console.log(ar.records3)
                    }).catch(
                    function(response){
                        console.log(response)

                    }
                );
            },
            // En fonction du pays de depart
            charger_position() {
                this.records1 = [];
                this.records2.forEach( (position) => {
                    if (type.id === this.type) {
                        this.records1.push({
                            value: position.id,
                            text: position.libelle,
                        });
                    }
                });
            },
            load_type() {
                let ar = this;
                axios.get('/typeannonce?page=${page}')
                    .then(function(response){
                        ar.records = response.data;
                        console.log(ar.records)
                    }).catch(
                    function(response){
                        console.log(response)

                    }
                );


            },

            onSubmit() {
                var new_publicité = {
                    'titre': this.titre,
                    'contenue': this.contenue,
                    'annonceur': this.annonceur,
                    'contact': this.contact,
                    'contact1': this.contact1,
                    'dateDebut': this.dateDebut,
                    'dateFin': this.dateFin,
                    'prix': this.prix+this.devise,
                    'nombreCaratere': this.nombreCaratere,
                    'position': this.position,
                    'etat': this.etat,
                    'date_validation': this.date_validation,
                    'utilisateur': this.utilisateur,
                    'transaction': this.transaction,
                    'images': this.images,
                    'type_annonce': this.type,
                    'partenaire': this.partenaire,
                    'valider_par': this.valider_par,
                };
                console.log(new_publicité);

                axios.post('/annonce', new_publicité)
                    .then((response) => {
                        if (response.data.status === 1) {
                            this.errors = [];
                            toast.fire({
                                type: 'success',
                                title: 'Succès',
                                html: 'Publicité créé avec succès'
                            });
                            this.onResetForm();
                        } else {
                            this.errors = response.data.errors;
                            toast.fire({
                                type: 'error',
                                title: 'Erreur !',
                                html: response.data.message
                            });
                        }


                    }).catch((response) => {
                    toast.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Eurreur d\'soummission!',
                        footer: '<a href>BESOIN D\'Aide?</a>'
                    })
                    console.log(response);
                });
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
                 swal.fire({
                    title: 'voullez vous   supprimer?',
                    text: " Supression Image pub",
                    type: '',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Supprimer!',
                    cancelButtonText:'Non, annuler'
                })
                    .then((result) => {
                        if (result.value) {
                             done()
                              swal.fire(
                                        'Supprimé!',
                                        'La pub a été supprimé.',
                                        'success'
                                    );
                        }
                    })
               
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

    }
</script>

<style scoped>


    #my-strictly-unique-vue-upload-multiple-image {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 90px;
    }

    span.important:after {
        content: " *";
        color: red;
        font-size: 15px;
    }
    h6.important:after {
        content: " *";
        color: red;
        font-size: 15px;
    }
    .count{
        font-size: 20px;
        color: green;
    }


    .mnhr{
        border: 3px solid green;
        border-radius: 1px;


    }

    .baccouleur{
        background-color: aqua;
        border: 0 none;
    }

</style>