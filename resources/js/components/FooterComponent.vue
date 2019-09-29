<template>
    <v-footer
        v-bind="localAttrs"
        padless
        absolute
    >
        <v-card
            flat
            tile
            width="100%"
            class="text-center"
            dark
        >
            <v-card-text>
                <v-btn
                    v-for="element in navigation"
                    :key="element.name"
                    icon
                    :alt="element.text"
                    :title="element.text"
                    :href="element.target"
                >
                    <v-icon :size="$vuetify.breakpoint.lgAndUp ? '24px' : '18px'">{{ element.icon }}</v-icon>
                </v-btn>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-text class="white--text">
                {{ new Date().getFullYear() }} — <strong>{{ company }}</strong>
            </v-card-text>
        </v-card>
    </v-footer>
</template>

<script>
    export default {
        name: "FooterComponent",
        props: {
            navigation: {
                home: {
                    name: 'home', icon: 'mdi-home', text: null, target: null},
                imprint: {
                    name: 'imprint', icon: 'mdi-format-section', text: null, target: null},
                about: {
                    name: 'about', icon: 'mdi-cow', text: null, target: null},
                privacyPolicy: {
                    name: 'privacyPolicy', icon: 'mdi-fingerprint', text: null, target: null},
            },
            company: null,
        },

        computed: {
            localAttrs () {
                const attrs = {}

                if (this.variant === 'default') {
                    attrs.absolute = false
                    attrs.fixed = false
                } else {
                    attrs[this.variant] = true
                }
                return attrs
            },
        },
    }
</script>

<style scoped>

</style>
