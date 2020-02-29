<template>
    <v-btn
        :alt=altText
        icon
        large
        @click.stop="toggleLoginRegisterOverlay"
    >
        <v-icon
        :title=altText>
            mdi-account
        </v-icon>
    </v-btn>
</template>

<script>
    import store from "../store";

    export default {
        name: "LoginRegisterNavbarButtonComponent",
        props: {
            altText: null,
        },
        methods: {
            toggleLoginRegisterOverlay() {
                store.dispatch('toggleLoginRegisterOverlay')
            }
        }
    }
</script>

<style scoped>

</style>
