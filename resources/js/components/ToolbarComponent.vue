<template>
    <v-app-bar
        :clipped-right="$vuetify.breakpoint.lgAndUp"
        app
        dense
        dark
        flat
        hide-on-scroll
    >
        <v-toolbar-title
            style="width: 300px"
            class="ml-0 pl-4"
        >
            <v-app-bar-nav-icon @click.stop="toggleDrawer"></v-app-bar-nav-icon>
            <span class="hidden-sm-and-down">{{ company }}</span>
        </v-toolbar-title>
        <v-text-field
            flat
            solo-inverted
            hide-details
            prepend-inner-icon="search"
            label="Search"
            class="hidden-sm-and-down"
        ></v-text-field>
        <div class="flex-grow-1"></div>
        <v-btn icon>
            <v-icon>mdi-apps</v-icon>
        </v-btn>
        <v-btn icon>
            <v-icon>mdi-bell</v-icon>
        </v-btn>
        <v-btn
            icon
            large
        >
            <v-avatar
                size="32px"
                item
            >
                <v-img
                    src="https://cdn.vuetifyjs.com/images/logos/logo.svg"
                    alt="Vuetify"
                >
                </v-img></v-avatar>
        </v-btn>
    </v-app-bar>
</template>

<script>
    import NavigationDrawerComponent from "./NavigationDrawerComponent.vue"
    import store from "../store";

    export default {
        name: "ToolbarComponent",

        props: {
            company: null,
        },

        methods: {
            toggleDrawer() {
                store.dispatch('toggleDrawer')
            }
        }
    };
</script>

<style scoped>

</style>
