<template>
    <div id="LoginRegisterOverlay">
        <v-dialog
            v-model="dialogLoginRegister"
            max-width="600"
            v-on:click:outside="toggleLoginRegister"
        >
            <v-form :action="route" enctype="multipart/form-data">

                <v-card>
                    <v-card-title class="grey darken-2">
                        Add Story Detail
                    </v-card-title>
                    <v-container class="align-center">
                        <v-col
                            class="align-center justify-space-between"
                            :cols="$vuetify.breakpoint.mdAndUp ? 8 : 12"
                        >

                        </v-col>

                    </v-container>
                    <v-card-actions>
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" :value="CSRFToken">
                        <v-btn
                            text
                            color="primary"
                        >Cancel</v-btn>
                        <v-btn
                            text
                            type="submit"
                        >Save</v-btn>
                    </v-card-actions>

                </v-card>
            </v-form>
        </v-dialog>
    </div>
</template>

<script>
    import store from "../store";

    export default {
        name: "LoginRegisterComponent",
        props: {
            value: Object,
            selectLabel: null,
            CSRFToken: null,
            route: null
        },
        data: () => ({
            errorDialog: null,
            errorText: '',
        }),
        methods: {
            toggleLoginRegister() {
                store.dispatch('toggleLoginRegister')
            }
        },
        computed: {
            dialogLoginRegister: {
                get: function() {
                    return store.getters.getLoginRegisterState
                },
                set: function() {
                }
            },
        },
    }
</script>

<style scoped>

</style>
