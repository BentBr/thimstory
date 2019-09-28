/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

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

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login-form-component', require('./components/LoginFormComponent.vue').default);
Vue.component('toolbar-component', require('./components/ToolbarComponent.vue').default);


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
} from 'vuetify/lib'
import Vuex from 'vuex'
import store from './store'
import { Ripple } from 'vuetify/lib/directives'

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
    },
    directives: {
        Ripple,
    },
})

Vue.use(Vuex)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    store,
});
