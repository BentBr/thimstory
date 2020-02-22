<template>
    <div id="AddStoryDetailButton">
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
                                <v-select
                                    prepend-icon="mdi-image-area"
                                    name="story_id"
                                    :label="selectlabel"
                                    :items="selectitems"
                                    solo
                                >
                                </v-select>

                                <v-file-input
                                    prepend-icon="mdi-image-area"
                                    :label="filelabel"
                                    loading="true"
                                    id="story_detail"
                                    accept="image/*"
                                    solo
                                    @change="onFileChange($event.target.name, $event.target.files)"
                                ></v-file-input>
                        </v-col>

                    </v-container>
                    <v-card-actions>
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" :value="csrftoken">
                        <v-btn
                            text
                            color="primary"
                            @click="dialogStoryDetail = false"
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
    export default {
        name: "AddStoryDetailComponent",
        props: {
            value: Object,
            selectlabel: null,
            filelabel: null,
            csrftoken: null,
            route: null,
            selectitems: {
            },
        },
        data: () => ({
            dialogStoryDetail: false,
            errorDialog: null,
            errorText: '',
            uploadFieldName: 'file',
            maxSize: 1024
        }),
        methods: {
            onFileChange(fieldName, file) {
                const {maxSize} = this
                let imageFile = file[0]

                //check if user actually selected a file
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
            }
        }
    }
</script>

<style scoped>

</style>
