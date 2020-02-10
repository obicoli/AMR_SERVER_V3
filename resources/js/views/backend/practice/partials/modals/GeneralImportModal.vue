<template>

    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content" v-bind:style="{minWidth:modal_min_width+'px'}">
                <div class="modal-header bg-f4 width-100-pc text-left">
                    <h4 class="float-left width-100-pc text-left">{{title}}</h4>
                </div>
                <div class="modal-body padding-top-0 bg-f4 padding-bottom-0">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 padding-left-0 padding-right-0">
                            <div class="width-100-pc padding-left-20 padding-right-20 padding-top-10 padding-bottom-10">
                                <div class="row fullName margin-5">
                                    <div class="inlineBlock padding-right-5 mg-right-10">
                                        <span class="fs-13 fw-600">Select a CSV file to upload: 
                                        <a v-if="sample_file==='categories'" href="/assets/samples/category_sample.csv" class="btn-link" download>Download a sample file</a></span>
                                        <a v-if="sample_file==='subcategory'" href="/assets/samples/sub_category_sample.csv" class="btn-link" download>Download a sample file</a></span>
                                        <a v-if="sample_file==='ordercategories'" href="/assets/samples/order_category_sample.csv" class="btn-link" download>Download a sample file</a></span>
                                        <a v-if="sample_file==='brands'" href="/assets/samples/brand_sample.csv" class="btn-link" download>Download a sample file</a></span>
                                        <a v-if="sample_file==='brand_sector'" href="/assets/samples/brand_sector_sample.csv" class="btn-link" download>Download a sample file</a></span>
                                        <a v-if="sample_file==='suppliers'" href="/assets/samples/supplier_sample_file.csv" class="btn-link" download>Download a sample file</a></span>
                                        <a v-if="sample_file==='invetory_items'" href="/assets/samples/List_of_Inventory_Items.csv" class="btn-link" download>Download a sample file</a></span>
                                    </div>
                                    <div class="inlineBlock padding-right-5 mg-right-10 width-100-pc">
                                        <label class="check-container small element-inlined fs-13 cl-888 min-width-100 mg-right-10">Includes column header
                                            <input type="checkbox" disabled @click="setDataz($event)" v-model="column_header">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="inlineBlock padding-right-5 mg-right-10">
                                        <div class="dijitInline firstName dijitTextBox mg-top-20 width-400-px">
                                            <input type="file" ref="file" id="file" v-on:change="handleFileUpload('Items')"  class="width-70-pc float-left rounded-item mg-right-10" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                            <button type="button" @click="upload_item" :disabled="save_btn" v-bind:class="{'btn':true,'banking-process-amref':!processing,'banking-process':processing}">
                                                <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> This may take few minutes. Please wait...</span>
                                                <span v-else>Upload</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div v-if="save_btn" class="alert alert-success fs-12"><strong>Upload Report</strong> Please click "Save" button below to continue</div>
                            <div v-if="save_btn" class="box border-top-0 border-bottom-0 border-radius-0 mg-left-10 mg-right-10">
                                <div class="box-body bg-white padding-0 max-height-300 overflow-y-scrollable">
                                    <table class="table table-bordered table-hover import-table">
                                        <thead v-if="column_header">
                                            <tr>
                                                <th style="width:5%;">#No</th>
                                                <th style="width:45%;">Item</th>
                                                <th style="width:10%;" class="txt-uppercase">Status</th>
                                                <th style="width:40;" class="txt-uppercase">Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item_list, index) in temp_items_list" :key="'items_list_'+index">
                                                <td class="padding-left-10">{{index + 1}}</td>
                                                <td class="padding-left-10">{{item_list.name}}</td>
                                                <td class="padding-left-10">
                                                    <span v-if="item_list.status" class="lbl-approved">Success</span>
                                                    <span v-if="!item_list.status" class="lbl-declined">Failed</span>
                                                </td>
                                                <td class="padding-10">{{item_list.description}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer bg-f4">
                    <a @click="reset_all" class="btn banking-process pointer-cursor">
                        Reset
                    </a>
                    <a data-dismiss="modal" @click="reset_all" class="btn banking-process pointer-cursor">
                        Close
                    </a>
                </div>

            </form>
        </div>

    </div>
    
</template>

<script>

    import {get,post,postFile} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import {createHtmlErrorString,create_item} from "../../../../../helpers/functionmixin";
    import {UPLOADS_API,UPLOAD_SAVE_API} from '../../../../../router/api_routes';

    export default {
        name: "GeneralImportModal",
        props: ['modal_id','item_url','title','modal_min_width','sample_file','upload_type'],
        components: {},
        data(){
            return {
                processing: false,
                file: '',
                imageData: '',
                items_list: [],
                temp_items_list: [],
                temp_items_list_header: [],
                save_btn: false,
                column_header: true,
            }
        },
        methods: {

            reset_all(){
                this.file = '';
                this.save_btn = false;
                this.temp_items_list = [];
                this.temp_items_list_header = [];
                this.items_list = [];
                $("#file").val("");
            },
            
            upload_item(){
                this.processing = true;
                let formData = new FormData();
                formData.append('file',this.file);
                formData.append('upload_type',this.upload_type);
                postFile(UPLOADS_API, formData)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.processing = false;
                        this.items_list = res.data.results;
                        //console.info(this.items_list);
                        this.temp_items_list_header = [];
                        this.temp_items_list = [];
                        for( let k=0; k < this.items_list.length; k++){
                            let itema = create_item(this.items_list[k]);
                            if( this.column_header && k===0 ){
                                this.temp_items_list_header.push(itema);
                            }else if(this.column_header && k>0){
                                this.temp_items_list.push(itema);
                            }else{
                                this.temp_items_list.push(itema);
                            }
                        }
                        this.save_btn = true;
                        this.$awn.success(res.data.description);
                        this.$emit("imported");
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

            setDataz(event){
                if(event.target.checked){
                    this.temp_items_list_header = [];
                    this.temp_items_list = [];
                    for( let k=0; k < this.items_list.length; k++){
                        let itema = create_item(this.items_list[k]);
                        if( k===0 ){
                            this.temp_items_list_header.push(itema);
                        }else{
                            this.temp_items_list.push(itema);
                        }
                    }
                }else{
                    this.temp_items_list_header = [];
                    this.temp_items_list = [];
                    for( let k=0; k < this.items_list.length; k++){
                        let itema = create_item(this.items_list[k]);
                        this.temp_items_list.push(itema);
                    }
                }
            },

            handleFileUpload(target){
                /*
                  Set the local file variable to what the user has selected.
                */
                switch (target) {
                    case 'Items':
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
        mounted(){

        }
    }
</script>

<style scoped="css">
    table.import-table thead tr th{
        text-transform: uppercase!important;
        padding: 5px 10px!important;
    }
    table.import-table tbody tr td{
        padding: 5px 10px!important;
        font-size: 12px!important;
    }
</style>