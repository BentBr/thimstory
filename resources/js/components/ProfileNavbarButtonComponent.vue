<template>
    <div class="text-center">
        <v-menu
            offset-y
            origin="center center"
            transition="scale-transition"
        >
            <template v-slot:activator="{ on }">
                <v-btn
                    icon
                    large
                    v-on="on"
                >
                    <v-avatar
                        size="32px"
                        item
                    >
                        <v-img
                            :src=avatarUrl
                            :alt=altText
                            :title=altText
                        >
                        </v-img>
                    </v-avatar>
                </v-btn>
            </template>
            <v-list>
                <v-list-item
                    v-for="(item, index) in this.items"
                    :key="index"
                    :href="item.link"
                >
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
</template>

<script>
    import store from "../store";

    export default {
        name: "ProfileNavbarButtonComponent",
        props: {
            avatarUrl: null,
            altText: null,
            profileUrl: null,
            logoutUrl: null,
            profileName: null,
            logoutName: null,
        },
        data() {
            return {
                items: [
                    { title: this.profileName, link: this.profileUrl },
                    { title: this.logoutName, link: this.logoutUrl },
                ],
            }
        },
        methods: {
            toggleProfileOverlay() {
                store.dispatch('toggleProfileOverlay')
            },
        }
    }
</script>

<style scoped>

</style>
