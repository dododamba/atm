window.$ = window.jQuery = require('jquery');
window.Laravel = {csrfToken: $('meta[name=csrf-token]').attr("content")};

window.Vue = require('vue');
import Lightbox from 'vue-easy-lightbox';

Vue.use(Lightbox);

// Sweet Alert
window.swal = require('sweetalert2');

window.Event = new class {
    constructor() {
        this.vue = new Vue();
    }

    fire(event, data = null) {
        this.vue.$emit(event, data);
    }

    listen(event, callback) {
        this.vue.$on(event, callback);
    }
};

window.toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});


import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

import VueRouter from 'vue-router';

Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';


// import the styles


Vue.use(VueAxios, axios);
import * as VueGoogleMaps from 'vue2-google-maps'

Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyDofvaahu1WjraDwJEgv7hI_M0cSHWzMvY',
    },

});
/**
 * Dominique DAMBA
 */


Vue.component('dashboard', require('./components/dashboard/Dashboard.vue'));
Vue.component('clientlist', require('./components/client/Index.vue'));
Vue.component('client', require('./components/client/List.vue'));
Vue.component('client-update', require('./components/client/Update.vue'));

Vue.component('pays', require('./components/pays/Index.vue'));
Vue.component('list-pays', require('./components/pays/List'));
Vue.component('detail-pays', require('./components/pays/Detail.vue'));
Vue.component('update-pays', require('./components/pays/Update.vue'));

Vue.component('personnellist', require('./components/personnel/Index.vue'));
Vue.component('list-personnel', require('./components/personnel/List'));
Vue.component('create-personnel', require('./components/personnel/Create.vue'));
Vue.component('update-personnel', require('./components/personnel/Update.vue'));

Vue.component('mon-profile', require('./components/profile/Index.vue'));
Vue.component('mon-profile-edit', require('./components/profile/Edit.vue'));


Vue.component('log', require('./components/log/Log.vue'));

Vue.component('decoupageun', require('./components/decoupageun/Index.vue'));
Vue.component('decoupageun-list', require('./components/decoupageun/List.vue'));


Vue.component('decoupagedeux', require('./components/decoupagedeux/Index.vue'));
Vue.component('decoupagedeux-list', require('./components/decoupagedeux/List.vue'));


Vue.component('decoupagetrois', require('./components/decoupagetrois/Index.vue'));
Vue.component('decoupagetrois-list', require('./components/decoupagetrois/List.vue'));


Vue.component('hotel', require('./components/hotel/hotel/Index.vue'));
Vue.component('list-hotel', require('./components/hotel/hotel/List'));
Vue.component('create-hotel', require('./components/hotel/hotel/Create.vue'));
Vue.component('detail-hotel', require('./components/hotel/hotel/Detail.vue'));
Vue.component('update-hotel', require('./components/hotel/hotel/Update.vue'));


Vue.component('typechambre', require('./components/hotel/typechambre/Index.vue'));
Vue.component('list-typechambre', require('./components/hotel/typechambre/List'));
Vue.component('create-typechambre', require('./components/hotel/typechambre/Create.vue'));
Vue.component('detail-typechambre', require('./components/hotel/typechambre/Detail.vue'));
Vue.component('update-typechambre', require('./components/hotel/typechambre/Update.vue'));


Vue.component('ville', require('./components/ville/Index.vue'));
Vue.component('list-ville', require('./components/ville/List'));
Vue.component('create-ville', require('./components/ville/Create.vue'));
Vue.component('detail-ville', require('./components/ville/Detail.vue'));
Vue.component('update-ville', require('./components/ville/Update.vue'));


Vue.component('commentaire', require('./components/commentaire/Index.vue'));
Vue.component('classe', require('./components/classe/Index.vue'));


Vue.component('article-list', require('./components/articles/Index.vue'));
Vue.component('list-article', require('./components/articles/List'));
Vue.component('create-article', require('./components/articles/Create.vue'));
Vue.component('detail-article', require('./components/articles/Detail.vue'));
Vue.component('update-article', require('./components/articles/Update.vue'));


Vue.component('categorie-list', require('./components/categorie/Index.vue'));
Vue.component('list-categorie', require('./components/categorie/List'));
Vue.component('create-categorie', require('./components/categorie/Create.vue'));
Vue.component('detail-categorie', require('./components/categorie/Detail.vue'));
Vue.component('update-categorie', require('./components/categorie/Update.vue'));


Vue.component('commentaire-list', require('./components/commentaire/Index.vue'));
Vue.component('list-commentaire', require('./components/commentaire/List'));
Vue.component('detail-commentaire', require('./components/commentaire/Detail.vue'));


Vue.component('like-list', require('./components/like/Index.vue'));
Vue.component('list-like', require('./components/like/List'));
Vue.component('detail-like', require('./components/like/Detail.vue'));


Vue.component('note-list', require('./components/note/Index.vue'));
Vue.component('list-note', require('./components/note/List'));
Vue.component('detail-note', require('./components/note/Detail.vue'));


Vue.component('commentaire', require('./components/commentaire/Index'));
Vue.component('decoupage-deux', require('./components/decoupagedeux/Index'));
Vue.component('decoupage-trois', require('./components/decoupagetrois/Index'));
Vue.component('decoupage-un', require('./components/decoupageun/Index'));
Vue.component('images', require('./components/image/IndexComponent'));


Vue.component('facturation-list', require('./components/facturation/Index.vue'));
Vue.component('list-facturation', require('./components/facturation/List'));
Vue.component('create-facturation', require('./components/facturation/Create.vue'));
Vue.component('detail-facturation', require('./components/facturation/Detail.vue'));
Vue.component('update-facturation', require('./components/facturation/Update.vue'));


Vue.component('modefacturation-list', require('./components/modefacturation/Index.vue'));
Vue.component('list-modefacturation', require('./components/modefacturation/List'));
Vue.component('create-modefacturation', require('./components/modefacturation/Create.vue'));
Vue.component('detail-modefacturation', require('./components/modefacturation/Detail.vue'));
Vue.component('update-modefacturation', require('./components/modefacturation/Update.vue'));


Vue.component('site-list', require('./components/site/Index.vue'));
Vue.component('list-site', require('./components/site/List'));
Vue.component('create-site', require('./components/site/Create.vue'));
Vue.component('detail-site', require('./components/site/Detail.vue'));
Vue.component('update-site', require('./components/site/Update.vue'));



Vue.component('transaction-list', require('./components/transaction/Index.vue'));
Vue.component('list-transaction', require('./components/transaction/List'));
Vue.component('detail-transaction', require('./components/transaction/Detail.vue'));


/**
 *
 * Passport conf
 */
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);
/**
 * Ibrahima Bramah
 */
Vue.component('partenaire-list', require('./components/partenaire/PartenaireListComponent.vue'));
Vue.component('index-partenaire', require('./components/partenaire/indexComponent'));
Vue.component('create-partenaire', require('./components/partenaire/CreatePartenaireComponent'));
Vue.component('detail-partenaire', require('./components/partenaire/DetailPartenaireComponent'));
Vue.component('update-partenaire', require('./components/partenaire/UpdatePartenaireComponent'));
Vue.component('location-partenaire', require('./components/partenaire/locationPartenaire'));
Vue.component('voyage-partenaire', require('./components/partenaire/voyagePartenaire'));
Vue.component('map-component', require('./components/partenaire/MapComponent'));

Vue.component('index-voyage' , require('./components/voyage/indexComponent'));
Vue.component('update-voyage' , require('./components/voyage/updateComponent'));
Vue.component('create-voyage' , require('./components/voyage/createComponent'));
Vue.component('detail-voyage' , require('./components/voyage/detailComponent'));
Vue.component('liste-voyage' , require('./components/voyage/listeComponent'));
Vue.component('imageComponent' , require('./components/voyage/imageComponent'));

Vue.component('location', require('./components/location/IndexComponent'));
Vue.component('liste-location', require('./components/location/listComponent'));
Vue.component('create-location', require('./components/location/CreateComponent'));
Vue.component('detail-location', require('./components/location/detailComponent'));
Vue.component('multiple-image', require('./components/location/multipleImage'));


/**
 *
 * Ibrahim Mahadi
 */

Vue.component('annonce-list', require('./components/annonce/ListeComponent.vue'));
Vue.component('annonce', require('./components/annonce/IndexComponent.vue'));
Vue.component('liste2', require('./components/annonce/Liste.vue'));
Vue.component('createannonce', require('./components/annonce/CreateComponent.vue'));
Vue.component('detailannonce', require('./components/annonce/EditComponent.vue'));


Vue.component('pub-list', require('./components/annonce/publicite/ListeComponent.vue'));
Vue.component('publicite', require('./components/annonce/publicite/IndexComponent.vue'));
Vue.component('createpublicite', require('./components/annonce/publicite/CreateComponent.vue'));
Vue.component('detailpublicite', require('./components/annonce/publicite/EditComponent.vue'));
Vue.component('show-pub', require('./components/annonce/publicite/Show.vue'));
Vue.component('create-pub', require('./components/annonce/publicite/Create.vue'));
Vue.component('edit-pub', require('./components/annonce/publicite/Edit.vue'));


Vue.component('typeannonce', require('./components/annonce/TypeAnnonce/IndexComponent.vue'));
Vue.component('typeannonce-list', require('./components/annonce/TypeAnnonce/ListeComponent.vue'));
Vue.component('typecreateannonce', require('./components/annonce/TypeAnnonce/CreateComponent.vue'));
Vue.component('edit-typeannonce', require('./components/annonce/TypeAnnonce/Edit.vue'));
Vue.component('create-typeannonce', require('./components/annonce/TypeAnnonce/Create.vue'));
Vue.component('show-typeannonce', require('./components/annonce/TypeAnnonce/Show.vue'));


Vue.component('tarif', require('./components/annonce/tarifannonce/IndexComponent.vue'));
Vue.component('tarifannonce-list', require('./components/annonce/tarifannonce/ListeComponent.vue'));
Vue.component('tarifcreateannonce', require('./components/annonce/tarifannonce/CreateComponent.vue'));
Vue.component('edit-tarifannonce', require('./components/annonce/tarifannonce/Edit.vue'));
Vue.component('create-tarifannonce', require('./components/annonce/tarifannonce/Create.vue'));
Vue.component('show-tarifannonce', require('./components/annonce/tarifannonce/Show.vue'));



Vue.component('show-positon', require('./components/annonce/positionannonce/Show.vue'));
Vue.component('create-positon', require('./components/annonce/positionannonce/Create.vue'));
Vue.component('edit-positon', require('./components/annonce/positionannonce/Edit.vue'));
Vue.component('position-list', require('./components/annonce/positionannonce/ListeComponent.vue'));
Vue.component('positionannonce', require('./components/annonce/positionannonce/IndexComponent.vue'));
Vue.component('positioncreate', require('./components/annonce/positionannonce/CreateComponent.vue'));
//IMAGE
Vue.component('vue-upload-multiple-image', require('./components/annonce/image/VueUploadMultipleImage.vue'));
Vue.component('vue-upload-multiple-image0', require('./components/annonce/image/VueUploadMultipleImageVerif.vue'));
Vue.component('vue-upload-multiple-image3', require('./components/annonce/image/VueUploadMultipleImageMinview.vue'));
Vue.component('vue-upload-multiple-image1', require('./components/annonce/image/VueUploadMultipleImageMin.vue'));
Vue.component('vue-upload-multiple-image2', require('./components/annonce/image/VueUploadMultipleImagepub.vue'));
Vue.component('create', require('./components/annonce/Create.vue'));
Vue.component('edit', require('./components/annonce/Edit.vue'));
Vue.component('show', require('./components/annonce/Show.vue'));

const router = new VueRouter({mode: 'history'});
const app = new Vue(Vue.util.extend({router})).$mount('#app');