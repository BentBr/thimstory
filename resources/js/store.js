import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        drawer: false,
        loginRegisterOverlay: false,
        userIsLoggedIn: false,
        profileOverlay: false,
    },
    getters: {
        getDrawerState(state) {
            return state.drawer
        },
        getLoginRegisterState(state) {
            return state.loginRegisterOverlay
        },
        getUserLoginState(state) {
            return state.userIsLoggedIn
        },
        getProfileOverlay(state) {
            return state.profileOverlay
        }
    },
    actions: {
        toggleDrawer(drawer) {
            drawer.commit('setDrawer')
        },
        toggleLoginRegisterOverlay(loginRegister) {
            loginRegister.commit('setLoginRegisterOverlay')
        },
        logUserIn(userIsLoggedIn) {
            userIsLoggedIn.commit('setUserToLoggedIn')
        },
        logUserOut(userIsLoggedIn) {
            userIsLoggedIn.commit('setUserToLoggedOut')
        },
        toggleProfileOverlay(profileOverlay) {
            profileOverlay.commit('setProfileOverlay')
        }
    },
    mutations: {
        setDrawer() {
            this.state.drawer = !this.state.drawer;
        },
        setLoginRegisterOverlay() {
            this.state.loginRegisterOverlay = !this.state.loginRegisterOverlay;
        },
        setUserToLoggedIn() {
            this.state.userIsLoggedIn = true;
        },
        setUserToLoggedOut() {
            this.state.userIsLoggedIn = false;
        },
        setProfileOverlay() {
            this.state.profileOverlay = !this.state.profileOverlay;
        }
    },
});
