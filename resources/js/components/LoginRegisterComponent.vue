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
                        {{ title }}
                    </v-card-title>
                    <v-container class="align-center">
                        <v-col
                            class="align-center justify-space-between"
                            :cols="$vuetify.breakpoint.mdAndUp ? 8 : 12"
                        >
                            <v-row>
                                <v-container>
                                    <p>{{ descriptionLogin }}</p>
                                    <p>{{ descriptionRegister }}</p>
                                </v-container>
                            </v-row>
                            <v-row>
                                <v-form v-model="valid">
                                    <v-container>
                                        <v-text-field
                                            v-model="email"
                                            :rules="emailRules"
                                            :label="emailName"
                                            required
                                        ></v-text-field>
                                    </v-container>
                                </v-form>
                            </v-row>

                        </v-col>

                    </v-container>
                    <v-card-actions>
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" :value="CSRFToken">
                        <v-btn
                            text
                            color="primary"
                        >{{ cancel }}</v-btn>
                        <v-btn
                            text
                            type="submit"
                        >{{ login }}</v-btn>
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
            route: null,
            title: null,
            descriptionLogin: null,
            descriptionRegister: null,
            emailName: null,
            emailRequiredValidation: null,
            emailValidValidation: null,
            cancel: null,
            login: null,
        },
        data () {
            return {
                errorDialog: null,
                errorText: '',
                valid: false,
                email: '',
                emailRules: [
                    v => !!v || this.emailRequiredValidation,
                    v => /.+@.+/.test(v) || this.emailValidValidation
                ],
            }
        },
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
