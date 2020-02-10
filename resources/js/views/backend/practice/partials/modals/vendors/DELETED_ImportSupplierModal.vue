<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">

            <form @submit.prevent="upload_supplier" class="modal-content">

                <div class="modal-header">
                    <h4 class="float-left dijitDialogTitle" id="myModalLabel2">{{title}}</h4>
                    <a class="close float-right" data-dismiss="modal" aria-label="Close"><span class="fs-16" aria-hidden="true">&times;</span></a>
                </div>

                <div class="modal-body pd-l-55 pd-r-55 padding-bottom-29">

                    <div class="inlineBlock padding-right-5 mg-right-10">
                        <span class="fs-13 fw-600">Select a CSV file to upload: <a href="/assets/icons/supplier_sample_file.csv" class="btn-link" download>Download a sample file</a></span>
                    </div>
                    <div class="inlineBlock padding-right-5 mg-right-10 width-100-pc">
                        <label class="check-container small element-inlined fs-13 cl-888 min-width-100 mg-right-10">Includes column header
                            <input type="checkbox" disabled v-model="column_header">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="inlineBlock padding-right-5 mg-right-10">
                        <div class="dijitInline firstName dijitTextBox mg-top-20 width-400-px">
                            <input type="file" ref="file" id="file" v-on:change="handleFileUpload('Supplier')" class="width-70-pc float-left" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            <!-- <button type="submit" :disabled="save_btn" class="btn btn-amref width-20-pc float-right height-32 fs-15">
                                <span v-if="processing"><i class="fa fa-spinner fa-spin"></i></span>
                                <span v-else>Upload</span>
                            </button> -->
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-amref fs-15">
                        <span v-if="user_mode==='Create'">
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                            <span v-else>Upload</span>
                        </span>
                        <span v-else>
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Updating...</span>
                            <span v-else> Update</span>
                        </span>
                    </button>
                    <button data-dismiss="modal" class="btn btn-inventory">
                        Close
                    </button>
                </div>


            </form>

        </div>
    </div>
    
</template>

<script>
    import {get,post,postFile} from '../../../../../../helpers/api';
    import {createHtmlErrorString,reset_forms} from '../../../../../../helpers/functionmixin';
    import {PRODUCT_UPLOAD_URL} from '../../../../../../router/api_routes';
    export default {
        name: "Employee",
        props:['practice_id','form_data','initial_url','user_mode','hr_role','modal_id','title','initializations'],
        data(){
            return {
                processing: false,
                column_header: true,
                file: '',
            }
        },

        methods: {

            upload_supplier: function () {
                this.processing = true;
                let formData = new FormData();
                formData.append('practice_id',this.practice_id);
                formData.append('file',this.file);
                formData.append('upload_type','Suppliers');
                formData.append('vendor_type','supplier');
                postFile(PRODUCT_UPLOAD_URL,formData)
                    .then((res) => {
                        
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            if ( this.user_mode === 'Create' ) {
                                this.form = reset_forms(this.form);
                                this.$emit('supplierImported');
                                this.processing = false;
                            }else {
                                this.$emit('supplierEdited');
                                this.processing = false;
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
                            this.$awn.warning(err.response.data.description)
                        }
                        this.processing = false;
                    });
            },

            handleFileUpload(target){

                switch (target) {
                    case 'Supplier':
                        this.file = this.$refs.file.files[0];
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
        },
        mounted() {
            //this.form.practice_id = this.practice_id;
        }
    }
</script>

<style scoped>
    .modal {
        background: rgba(0, 0, 0, 0.62);
        z-index: 9999;
    }
    .modal-lg {
        max-width: 800px!important;
        min-width: 800px!important;
    }
    .modal-header{
        border-bottom: 1px solid #fff!important;
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
        font-size: 14px!important;
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
    .attended_fiel{
        background-color: #f4f4f4!important;
        font-weight: 600!important;
    }
</style>