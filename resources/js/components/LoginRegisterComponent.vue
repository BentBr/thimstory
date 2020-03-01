<template>
    <div id="LoginRegisterOverlay">
        <v-dialog
            v-model="dialogLoginRegister"
            max-width="600"
            v-on:click:outside="toggleLoginRegister"
        >
            <v-form :action="route" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">

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
                                            id="email-input"
                                            name="email"
                                            v-model="email"
                                            :rules="emailRules"
                                            :label="emailName"
                                            required
                                        ></v-text-field>
                                        <v-snackbar
                                            v-model="snackbar"
                                            bottom
                                            :timeout="2000"
                                            color="success"
                                            vertical
                                        >
                                            {{ message }}
                                        </v-snackbar>
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
                            color="secondary"
                            @click="toggleLoginRegister(); clearInput();"
                        >{{ cancel }}</v-btn>
                        <v-btn
                            :loading="loading"
                            :disabled="loading"
                            text
                            color="primary"
                            @click="sendLoginRequest(); loader = 'loading';"
                        >{{ login }}</v-btn>
                    </v-card-actions>

                </v-card>
            </v-form>
        </v-dialog>
    </div>
</template>

<script>
    import store from '../store';
    import axios from 'axios';

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
            loginRoute: null,
            oldInput: null,
            error: null,
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
                loader: null,
                loading: false,
                message: null,
                snackbar: false,
            }
        },
        methods: {
            toggleLoginRegister() {
                store.dispatch('toggleLoginRegisterOverlay')
            },
            clearInput() {
                this.email = ''
            },
            sendLoginRequest() {
                axios.put('/login', {email: this.email, _token: this.CSRFToken, axiosLogin: true})
                .then(response => {
                    this.message = response.data.message;
                    this.snackbar = true;
                });
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
        watch: {
            loader () {
                const l = this.loader
                this[l] = !this[l]
                setTimeout(() => (this[l] = false), 2000)
                this.loader = null
            },
        },
    }
</script>

<style scoped>
</style>
