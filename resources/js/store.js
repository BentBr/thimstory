import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        drawer: false,
        loginRegister: false
    },
    getters: {
        getDrawerState(state) {
            return state.drawer
        },
        getLoginRegisterState(state) {
            return state.loginRegister
        }
    },
    actions: {
        toggleDrawer(drawer) {
            drawer.commit('setDrawer')
        },
        toggleLoginRegister(loginRegister) {
            loginRegister.commit('setLoginRegister')
        }
    },
    mutations: {
        setDrawer() {
            this.state.drawer = !this.state.drawer;
        },
        setLoginRegister() {
            this.state.loginRegister = !this.state.loginRegister;
        }
    },
});
