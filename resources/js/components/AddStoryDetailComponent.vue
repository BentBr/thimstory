<template>
    <div id="AddStoryDetailOverlay">
        <v-btn
            bottom
            color="pink"
            dark
            fab
            fixed
            right
            riple
            :max-height="$vuetify.breakpoint.mdAndUp ? '56px' : '48px'"
            :max-width="$vuetify.breakpoint.mdAndUp ? '56px' : '48px'"
            @click="dialogStoryDetail = !dialogStoryDetail"
        >
            <v-icon>mdi-plus</v-icon>
        </v-btn>
        <v-dialog
            v-model="dialogStoryDetail"
            max-width="600"
            v-on:click:outside="dialogStoryDetail = !dialogStoryDetail"
        >
            <v-form method="post" :action="route" enctype="multipart/form-data">

                <v-card>
                    <v-card-title class="grey darken-2">
                        Add Story Detail
                    </v-card-title>
                    <v-container class="align-center">
                        <v-col
                            class="align-center justify-space-between"
                            :cols="$vuetify.breakpoint.mdAndUp ? 8 : 12"
                        >
                                <v-select
                                    prepend-icon="mdi-image-area"
                                    name="story_id"
                                    v-model="storySelect"
                                    :label="selectLabel"
                                    :items="selectItems"
                                    solo
                                    @change="onStorySelect($event)"
                                >
                                </v-select>

                                <v-file-input
                                    prepend-icon="mdi-image-area"
                                    :label="fileLabel"
                                    v-model="imageUpload"
                                    loading="true"
                                    id="story_detail"
                                    accept="image/*"
                                    solo
                                    @change="onFileChange($event)"
                                ></v-file-input>
                        </v-col>

                    </v-container>
                    <v-card-actions>
                        <v-btn
                            text
                            color="secondary"
                            @click="clearInput"
                        >{{ cancelName }}</v-btn>
                        <v-btn
                            :loading="loading"
                            :disabled="loading"
                            text
                            color="primary"
                            @click="sendStoryDetail(); loader = 'loading';"
                        >{{ sendName }}</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
        <v-snackbar
            v-model="snackbar"
            bottom
            :timeout="2000"
            color="success"
            vertical
        >
            {{ message }}
        </v-snackbar>
    </div>
</template>

<script>
    import store from "../store";
    import axios from "axios";

    export default {
        name: "AddStoryDetailComponent",
        props: {
            value: Object,
            selectLabel: null,
            fileLabel: null,
            csrfToken: null,
            route: null,
            selectItems: {
            },
            sendName: null,
            cancelName: null,
        },
        data: () => ({
            dialogStoryDetail: false,
            errorDialog: null,
            errorText: '',
            uploadFileName: null,
            maxSize: 1024,
            storyId: null,
            loader: null,
            loading: false,
            message: null,
            snackbar: false,
            storySelect: '',
            imageUpload: null,
        }),
        methods: {
            //adding story on changing select input
            onStorySelect(storyId) {
                this.storyId = storyId
            },
            onFileChange(event) {
                let fieldName = event.name
                let file = event
                const {maxSize} = this
                let imageFile = file[0]

                //check if user actually selected a file //todo: not yet being used
                if (file.length > 0) {
                    let size = imageFile.size / maxSize / maxSize
                    if (!imageFile.type.match('image.*')) {

                        // check whether the upload is an image
                        this.errorDialog = true
                        this.errorText = 'Please choose an image file'
                    } else if (size > 1) {

                        // check whether the size is greater than the size limit
                        this.errorDialog = true
                        this.errorText = 'Your file is too big! Please select an image under 1MB'
                    } else {
                        // Append file into FormData & turn file into image URL
                        let formData = new FormData()
                        let imageURL = URL.createObjectURL(imageFile)
                        formData.append(fieldName, imageFile)

                    }
                }
                this.uploadFileName = URL.createObjectURL(event)
            },
            //send via axios
            sendStoryDetail() {
                let formData = new FormData();
                let imageFile = document.querySelector('#story_detail');
                formData.append("story_id", this.storyId);
                formData.append("_token", this.csrfToken);
                formData.append("_method", 'put');
                formData.append("story_detail", imageFile.files[0]);

                axios.post(this.route, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'
                    }
                })
                    .then(response => {
                        this.message = response.data.message;
                        this.snackbar = true;
                    });
            },
            //killing all input and closing overlay
            clearInput() {
                this.imageUpload = null;
                this.storySelect = '';
                this.dialogStoryDetail = false;
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
