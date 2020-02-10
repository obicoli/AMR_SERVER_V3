<template>
    <div class="width-100-pc float-left">
        <div v-if="upload_mode" class="image-preview float-left width-100-pc">
            <input type="file" ref="file" id="file" v-on:change="handleFileUpload('Logo')" accept="image/png, image/jpeg" class="height-32 ctm-attended-field">
        </div>
        <div v-else class="image-preview float-left width-100-pc">
            <img v-if="imageData.length > 0" class="preview" :src="imageData">
        </div>

        <a v-if="upload_mode" @click="toggleUpload(false)" class="float-left fs-13 pointer-cursor cl-blue-link">Cancel</a>
        <a v-else @click="toggleUpload(true)" class="float-left fs-12 fw-600 txt-italic pointer-cursor cl-amref">Choose Image</a>

        <a v-if="processing" class="float-left fs-16 pointer-cursor cl-blue-link"><i class="fa fa-spinner fa-spin"></i> Saving...</a>
        <a v-if="show_save && user_mode==='Edit'" @click="upload_item" class="float-left fs-16 pointer-cursor cl-blue-link"><i class="fa fa-save"></i></a>
        
    </div>
</template>
<script>
import { UPLOADS_API } from '../../router/api_routes';
import { createHtmlErrorString } from '../../helpers/functionmixin';
import { postFile } from '../../helpers/api';
    export default {
        name: "ImagePreview",
        props: [
            'image_data','width_','height_','company_api','user_mode','initiate_upload_method','return_image_data'
        ],
        //Props: "initiate_upload_method" is of type 'Object' - will initiate upload function, and it will provide new api where to upload the image/file 
        data(){
            return {
                imageData: "/assets/icons/dashboard/logo_holder.png",
                upload_mode: false,
                show_save: false,
                file: null,
                processing: false,
                upload_api: this.company_api,
            }
        },
        watch: {
            image_data: function(new_img,old_img){
                this.imageData = new_img;
            },
            initiate_upload_method: function(new_data,old_data){
                this.upload_api = new_data.api;
                this.upload_item();
            }
        },
        methods: {
            toggleUpload(state_){
                this.upload_mode = state_;
            },
            handleFileUpload(target){
                switch (target) {
                    case 'Logo':
                        this.file = this.$refs.file.files[0];
                        if(this.return_image_data){
                            this.$emit("uploadedFile",this.file);
                        }
                        //this.$emit("uploadedFile",this.file);
                        break;
                }
                /*
                  Initialize a File Reader object
                */
                let reader  = new FileReader();
                /*
                  Add an event listener to the reader that when the file
                  has been loaded, we flag the show preview as true and set the
                  image to be what was read from the reader.
                */
                reader.addEventListener("load", function () {
                    //this.showPreview = true;
                    //this.imagePreview = reader.result;
                    this.imageData = reader.result;
                    this.upload_mode = false;
                    //this.$emit("uploadedFile",this.file);
                    this.show_save = true;
                }.bind(this), false);

                /*
                  Check to see if the file is not empty.
                */
                if( this.file ){
                    /*
                      Ensure the file is an image file.
                    */
                    if ( /\.(jpe?g|png|gif)$/i.test( this.file.name ) ) {
                        /*
                          Fire the readAsDataURL method which will read the file in and
                          upon completion fire a 'load' event which we will listen to and
                          display the image in the preview.
                        */
                        reader.readAsDataURL( this.file );
                    }
                }
            },

            upload_item(){
                if(this.return_image_data){
                    this.$emit("uploadedFile",this.file);
                    return;
                };
                this.processing = true;
                this.show_save = false;
                let formData = new FormData();
                formData.append('file',this.file);
                postFile(this.upload_api, formData)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.processing = false;
                        this.$awn.success(res.data.description);
                        if(this.user_mode==="Edit"){
                            this.$emit("uploadedFile");
                        }
                    }
                }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                });
            },
        },
        mounted(){
            if(this.image_data){
                this.imageData = this.image_data;
            }
        }
    }
</script>