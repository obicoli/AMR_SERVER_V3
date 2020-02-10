<template>
    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="process_bank" class="modal-content">
                <div class="modal-header bg-ced">
                    <h4 class="width-100-pc text-left">{{title}}</h4>
                </div>
                <div class="modal-body padding-bottom-29 bg-ced">

                    <div class="width-100-pc float-left">

                        <div v-if="attachment.length" class="width-100-pc float-left bg-white padding-10">
                            <table class="table banking-transaction table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:10%">Type</th>
                                        <th style="width:60%">Name</th>
                                        <th style="width:20%">Size</th>
                                        <th style="width:10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(attached,index) in attachment" :key="'attachment'+index">
                                        <td class="somepad">
                                            <i v-if="attached.file_mime===FILE_MIMES.PDF" class="fa fa-file-pdf-o cl-amref"></i>
                                            <i v-else class="fa fa-file-text-o"></i>
                                        </td>
                                        <td class="somepad"><a class="cl-blue-link" :href="attached.file_path" download>{{attached.file_name+' '+attached.file_size}}</a></td>
                                        <td class="somepad">{{attached.file_size}}</td>
                                        <td class="somepad">
                                            <span v-if="deleting===index"><i class="fa fa-spinner fa-spin"></i> wait...</span>
                                            <a v-else @click="delete_file(attached.id,index)" class="showOnHover cl-amref">Delete</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- <div v-for="(attached,index) in attachment" class="width-100-pc float-left mg-top-20" :key="'attachment'+index">
                            <div class="width-20-pc float-left">
                                <a class="fs-20"><i class="fa fa-file-pdf-o"></i></a>
                            </div>
                            <div class="width-40-pc float-left">
                                <a class="fs-13 cl-blue-link">File Sample.pdf</a>
                            </div>
                            <div class="float-left width-15-pc">
                                <a class=" fs-13 cl-blue-link">5.67MB</a>
                            </div>
                            <div class="width-15-pc float-right text-right">
                                <button type="button" class="btn btn-secondary btn-actions">Delete</button>
                            </div>
                        </div> -->

                        <!-- <div class="width-100-pc float-left mg-top-20">
                            <div class="width-20-pc float-left">
                                <a class="fs-20"><i class="fa fa-file-image-o"></i></a>
                            </div>
                            <div class="width-40-pc float-left">
                                <a class="fs-13 cl-blue-link">File Sample.png</a>
                            </div>
                            <div class="float-left width-15-pc">
                                <a class=" fs-13 cl-blue-link">5.67MB</a>
                            </div>
                            <div class="width-15-pc float-right text-right">
                                <button type="button" class="btn btn-secondary btn-actions">Delete</button>
                            </div>
                        </div>

                        <div class="width-100-pc float-left mg-top-20">
                            <div class="width-20-pc float-left">
                                <a class="fs-20"><i class="fa fa-file-excel-o"></i></a>
                            </div>
                            <div class="width-40-pc float-left">
                                <a class="fs-13 cl-blue-link">File Sample.xcls</a>
                            </div>
                            <div class="float-left width-15-pc">
                                <a class=" fs-13 cl-blue-link">5.67MB</a>
                            </div>
                            <div class="width-15-pc float-right text-right">
                                <button type="button" class="btn btn-secondary btn-actions">Delete</button>
                            </div>
                        </div>

                        <div class="width-100-pc float-left mg-top-20">
                            <div class="width-20-pc float-left">
                                <a class="fs-20"><i class="fa fa-file-word-o"></i></a>
                            </div>
                            <div class="width-40-pc float-left">
                                <a class="fs-13 cl-blue-link">File Sample.doc</a>
                            </div>
                            <div class="float-left width-15-pc">
                                <a class=" fs-13 cl-blue-link">5.67MB</a>
                            </div>
                            <div class="width-15-pc float-right text-right">
                                <button type="button" class="btn btn-secondary btn-actions">Delete</button>
                            </div>
                        </div> -->

                        <div class="width-100-pc float-left mg-top-20">
                            <div class="width-100-pc float-left bg-white padding-10 bd-silver">
                                <a class="fs-12">{{info}}</a>
                            </div>
                        </div>

                        <div class="width-100-pc mg-top-10 float-left">
                            <div class="image-preview float-left width-60-pc">
                                <input type="file" :disabled="attachment.length===5" ref="temp_file" id="temp_file" v-on:change="handleFileUploader()" class="fs-12 height-30">
                            </div>
                        </div>

                        <div class="width-100-pc float-left padding-left-25 mg-top-45">
                            <button @click="uploadFile" :disabled="processing || attachment.length===5" class="btn btn-secondary banking-process-amref float-left mg-right-5">
                                <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                                <span v-else>Add Attachment</span>
                            </button>
                            <button :disabled="processing" type="button" data-dismiss="modal" class="btn btn-secondary banking-process float-right">
                                Close
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import { post, del } from '../../../../../../helpers/api';
import { createHtmlErrorString } from '../../../../../../helpers/functionmixin';
import { FILE_MIMES } from '../../../../../../helpers/process_status';
export default {
    props: ['modal_id','info','title','attachable','upload_api'],
    data(){
        return {
            file: null,
            modal_title: null,
            attachment: [],
            processing: false,
            deleting: -1,
            form: {
                name: null,
                code: null,
                comments: null,
                address: null,
                email: null,
                phone: null,
                description: null,
            },
            FILE_MIMES:FILE_MIMES
        }
    },
    watch: {

        attachable: function(){
            this.setFiles();
        },
        title: function(new_data,old_data){
            this.modal_title = new_data;
        }

    },
    methods: {

        uploadFile(){
            this.processing = true;
            let formData = new FormData();
            formData.append('file',this.file);
            formData.append('attachable_id',this.form.attachable_id);
            post(this.upload_api, formData)
            .then((res) => {
                if(res.data.status_code === 200) {
                    this.processing = false;
                    this.$awn.success(res.data.description);
                    this.$emit("upload-success-event");
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
        delete_file(file_id,index){
            this.deleting = index;
            let item_url = this.upload_api+'/'+file_id
            del(item_url)
            .then((res) => {
                if(res.data.status_code === 200) {
                    this.deleting = -1;
                    this.$awn.success(res.data.description);
                    this.$emit('delete-file-event');
                    this.processing = false;
                }
            }).catch((err) => {
                if(err.response.status === 422) {
                    this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                }else if (err.response.status === 500){
                    this.$awn.warning(err.response.data.description);
                }
                else{
                    this.$awn.warning(err.response.data.description)
                }
                this.processing = false;
                this.deleting = -1;
            });
        },
        setFiles(){
            this.attachment = this.attachable.attachments;
            this.form.attachable_id = this.attachable.id;
            this.modal_title = this.title;
        },
        handleFileUploader(){

            this.file = this.$refs.temp_file.files[0];
            // switch (target) {
            //     case 'Logo':
            //         this.temp_file = this.$refs.temp_file.files[0];
            //         //this.$emit("uploadedFile",this.file);
            //         // this.is_file_uploaded = true;
            //         break;
            // }
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
                this.imagePrev = reader.result;
                this.is_file_uploaded = true;
                //this.$emit("uploadedFile",this.file);
                //this.show_save = true;
            }.bind(this), false);

            /*
                Check to see if the file is not empty.
            */
            if( this.temp_file ){
                /*
                    Ensure the file is an image file.
                */
                if ( /\.(jpe?g|png|gif)$/i.test( this.temp_file.name ) ) {
                    /*
                        Fire the readAsDataURL method which will read the file in and
                        upon completion fire a 'load' event which we will listen to and
                        display the image in the preview.
                    */
                    reader.readAsDataURL( this.temp_file );
                }
            }
        },
    },
    mounted(){
        if(this.attachable){
            this.setFiles();
        }
        //if(this.user_mode === "Edit" || this.user_mode==="View" ){ this.form = this.form_data}
    }
}
</script>

<style scoped>
    .modal {
        background: rgba(0, 0, 0, 0.62);
        z-index: 9999;
    }
    .modal-header{
        border-bottom: 1px solid #ccc!important;
    }
    .modal-content{
        top: 30px!important;
    }
    .modal-lg {
        max-width: 600px!important;
        min-width: 600px!important;
    }
    .pd-l-55{padding-left: 55px!important;}
    .pd-r-55{padding-right: 55px!important;}
    .dijitDialogTitle {
        font-weight: 600;
        color: #000000;
        font-size: 2.2rem!important;
        /* line-height: 70px; */
        line-height: 50px!important;
        max-width: calc(100% - 40px);
    }
    .fullAdd.employeeForm .row {
        padding-bottom: 4px;
    }
    .inlineBlock {
        display: inline-block;
    }
    .inlineBlock label {
        font-weight: 600!important;
        color: #404040!important;
        display: block!important;
        margin-bottom: 4px!important;
        font-size: 14px;
    }
    .dijitInline {
        display: inline-block;
        border: 0;
        padding: 0;
        vertical-align: middle;
    }
    .dijitTextBox input, .dijitTextBox textarea, .dijitTextBox select{
        outline: none!important;
        /* height: 32px!important; */
        border: 1px solid #BABEC5!important;
        padding: 0 8px!important;
        border-radius: 2px!important;
        transition-property: border!important;
        transition-duration: 0.35s!important;
        font-size: 13px!important;
        background-color: #FFFFFF;
        box-sizing: border-box!important;
        -webkit-appearance: none!important;
        width: 100%;
        vertical-align: middle!important;
    }

    input::placeholder, textarea::placeholder  {
        color: #babec5!important;
        font-size: 12px!important;
        font-style: italic;
        font-weight: 400!important;
    }
    .checkboxInline {
        margin-left: 5px;
    }
    input[type=checkbox]:not(.dijitCheckBoxInput):not(.idsCheckbox__input) {
        width: 20px;
        height: 20px;
        vertical-align: middle;
        background-color: transparent;
        border: 1px solid #8D9096;
        border-radius: 2px;
        background-repeat: no-repeat;
        background-size: 124px;
        background-position: -28px -3px;
        user-select: none;
        -webkit-appearance: none;
    }
</style>