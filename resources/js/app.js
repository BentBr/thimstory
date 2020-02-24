/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Axios from "axios";

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('toolbar-component', require('./components/ToolbarComponent.vue').default);
Vue.component('navigation-drawer-component', require('./components/NavigationDrawerComponent.vue').default);
Vue.component('footer-component', require('./components/FooterComponent.vue').default);
Vue.component('add-story-detail-component', require('./components/AddStoryDetailComponent.vue').default);
Vue.component('login-register-component', require('./components/LoginRegisterComponent.vue').default);


import Vuetify, {
    VApp,
    VList,
    VListItem,
    VListItemTitle,
    VForm,
    VContainer,
    VRow,
    VCol,
    VTextField,
    VImg,
    VNavigationDrawer,
    VBtn,
    VAppBar,
    VToolbar,
    VIcon,
    VAvatar,
    VAppBarNavIcon,
    VToolbarTitle,
    VListItemAction,
    VListItemContent,
    VListItemGroup,
    VListGroup,
    VContent,
    VCard,
    VCardText,
    VCardTitle,
    VCardActions,
    VDialog,
    VTooltip,
    VSelect,
    VFooter,
    VDivider,
    VFileInput,
    VProgressCircular,
} from 'vuetify/lib'
import Vuex from 'vuex'
import store from './store'
import { Ripple } from 'vuetify/lib/directives'
import VueAxios from 'vue-axios'
import axios from 'axios'

Vue.use(Vuetify, {
    components: {
        VApp,
        VList,
        VListItem,
        VListItemTitle,
        VForm,
        VContainer,
        VRow,
        VCol,
        VTextField,
        VImg,
        VNavigationDrawer,
        VBtn,
        VAppBar,
        VToolbar,
        VIcon,
        VAvatar,
        VAppBarNavIcon,
        VToolbarTitle,
        VListItemAction,
        VListItemContent,
        VListItemGroup,
        VListGroup,
        VContent,
        VCard,
        VCardText,
        VCardTitle,
        VCardActions,
        VDialog,
        VTooltip,
        VSelect,
        VFooter,
        VDivider,
        VFileInput,
        VProgressCircular,
    },
    directives: {
        Ripple,
    },
})

Vue.use(Vuex, VueAxios, axios)

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    store,
    axios,
});
