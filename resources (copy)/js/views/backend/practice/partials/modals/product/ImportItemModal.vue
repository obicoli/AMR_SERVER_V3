<template>

    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content">

                <div class="modal-header bg-foo">
                    <h4 class="float-left dijitDialogTitle" id="myModalLabel2">{{modal_title}}</h4>
                    <a class="close float-right" data-dismiss="modal" aria-label="Close"><span class="fs-16" aria-hidden="true">&times;</span></a>
                </div>

                <div class="modal-body padding-top-0 padding-bottom-0">

                    <div class="row">
                        <div class="col-lg-5 col-md-5 padding-left-0 padding-right-0">
                            <div class="width-100-pc padding-left-20 padding-right-20 padding-top-10 padding-bottom-10">
                                <form @submit.prevent="upload_item" class="row fullName margin-5">
                                    
                                    <div class="inlineBlock padding-right-5 mg-right-10">
                                        <span class="fs-13 fw-600">Select a CSV file to upload: <a href="/assets/samples/inventory_item.csv" class="btn-link" download>Download a sample file</a></span>
                                    </div>
                                    <div class="inlineBlock padding-right-5 mg-right-10 width-100-pc">
                                        <label class="check-container small element-inlined fs-13 cl-888 min-width-100 mg-right-10">Includes column header
                                            <input type="checkbox" disabled @click="setDataz($event)" v-model="column_header">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="inlineBlock padding-right-5 mg-right-10">
                                        <div class="dijitInline firstName dijitTextBox mg-top-20 width-400-px">
                                            <input type="file" ref="file" id="file" v-on:change="handleFileUpload('Items')"  class="width-70-pc float-left" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                            <button type="submit" :disabled="save_btn" class="btn btn-amref width-20-pc float-right height-32 fs-15">
                                                <span v-if="processing"><i class="fa fa-spinner fa-spin"></i></span>
                                                <span v-else>Upload</span>
                                            </button>
                                        </div>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div v-if="save_btn" class="alert alert-success"><strong>Confirmation!</strong> Please click "Save" button below to continue</div>
                            <div v-if="save_btn" class="box border-top-0 border-bottom-0 border-radius-0 mg-left-10 mg-right-10">
                                <div class="box-body bg-white padding-0">
                                    <table class="table table-bordered table-hover import-table">
                                        <thead v-if="column_header">
                                            <tr v-for="(head_item,indexh) in temp_items_list_header" :key="'head_item_'+indexh">
                                                <th>{{temp_items_list_header[indexh].item_name}}</th>
                                                <th>{{temp_items_list_header[indexh].generic_name}}</th>
                                                <th>{{temp_items_list_header[indexh].sku_code}}</th>
                                                <th>{{temp_items_list_header[indexh].barcode}}</th>
                                                <th>{{temp_items_list_header[indexh].manufacturer}}</th>
                                                <th>{{temp_items_list_header[indexh].profile_name}}</th>
                                                <th>{{temp_items_list_header[indexh].brand}}</th>
                                                <th>{{temp_items_list_header[indexh].brand_sector}}</th>
                                                <th>{{temp_items_list_header[indexh].measure_unit_name}}</th>
                                                <th>{{temp_items_list_header[indexh].measure_unit_symbol}}</th>
                                                <th>{{temp_items_list_header[indexh].unit_weight}}</th>
                                                <th>{{temp_items_list_header[indexh].pack_qty}}</th>
                                                <th>{{temp_items_list_header[indexh].reorder_level}}</th>
                                                <th>{{temp_items_list_header[indexh].unit_cost}}</th>
                                                <th>{{temp_items_list_header[indexh].unit_retail}}</th>
                                                <th>{{temp_items_list_header[indexh].pack_cost}}</th>
                                                <th>{{temp_items_list_header[indexh].pack_retail}}</th>
                                                <th>{{temp_items_list_header[indexh].tax_name}}</th>
                                                <th>{{temp_items_list_header[indexh].tax_value}}</th>
                                                <th>{{temp_items_list_header[indexh].note}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item_list, index) in temp_items_list" :key="'items_list_'+index">
                                                <td><input v-model="temp_items_list[index].item_name" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].generic_name" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].sku_code" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].barcode" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].manufacturer" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].profile_name" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].brand" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].brand_sector" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].measure_unit_name" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].measure_unit_symbol" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].unit_weight" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].pack_qty" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].reorder_level" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].unit_cost" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].unit_retail" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].pack_cost" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].pack_retail" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].tax_name" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].tax_value" class="form-control product-entry-input-field height-27"></td>
                                                <td><input v-model="temp_items_list[index].note" class="form-control product-entry-input-field height-27"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button v-if="save_btn" type="button" @click="save_item" class="btn btn-inventory btn-amref">
                        <span>
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                        </span>
                    </button>
                    <button data-dismiss="modal" class="btn btn-inventory cancel">
                        Close
                    </button>
                </div>

            </form>
        </div>

    </div>
    
</template>

<script>

    import {get,post,postFile} from "../../../../../../helpers/api";
    import Auth from "../../../../../../store/auth";
    import AppInfo from "../../../../../../helpers/config";
    import {createHtmlErrorString,create_item} from "../../../../../../helpers/functionmixin";
    import {PRODUCT_URL,PRODUCT_UPLOAD_URL,PRODUCT_ITEM_URL} from '../../../../../../router/api_routes';

    export default {
        name: "ImportItemModal",
        props: ['modal_id','item_url','modal_title','practice_id'],
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
            upload_item(){
                this.processing = true;
                
                let formData = new FormData();
                formData.append('practice_id',this.practice_id);
                formData.append('file',this.file);
                formData.append('upload_type','Products');
                postFile(PRODUCT_UPLOAD_URL, formData)
                .then((res) => {
                    
                    if(res.data.status_code === 200) {
                        this.processing = false;
                        this.items_list = res.data.results;
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
            save_item(){
                this.processing = true;
                let formData = new FormData();
                formData.append('practice_id',this.practice_id);
                formData.append('items',JSON.stringify(this.temp_items_list));
                formData.append('upload_type','Bulk');
                post(PRODUCT_ITEM_URL, formData)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.processing = false;
                        this.temp_items_list_header = [];
                        this.temp_items_list = [];
                        this.file = "";
                        this.save_btn = false;
                        this.$emit('uploaded');
                        this.$awn.success(res.data.description);
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

<style lang="scss" scoped>
    @import '../../../../../../../sass/fulllengthmodals.scss';
    @import '../../../../../../../sass/transaction_docs.scss';
</style>