import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        drawer: false,
    },
    getters: {
        getDrawerState(state) {
            return state.drawer
        },
    },
    actions: {
        toggleDrawer(drawer) {
            drawer.commit('setDrawer')
        }
    },
    mutations: {
        setDrawer() {
            this.state.drawer = !this.state.drawer;
        }
    },
});
