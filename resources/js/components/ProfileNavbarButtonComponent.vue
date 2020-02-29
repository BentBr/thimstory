<template>
    <v-btn
        icon
        large
        @click.stop="toggleProfileOverlay"
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

<script>
    import store from "../store";

    export default {
        name: "ProfileNavbarButtonComponent",
        props: {
            avatarUrl: null,
            altText: null,
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
