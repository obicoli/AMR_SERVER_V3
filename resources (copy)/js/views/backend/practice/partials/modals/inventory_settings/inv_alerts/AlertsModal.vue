<template>

    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="save_alert" class="modal-content">

                <div class="modal-header bg-eee">
                    <h4 class="float-left dijitDialogTitle" id="myModalLabel2">{{modal_title}}</h4>
                    <a class="close float-right" data-dismiss="modal" aria-label="Close"><span class="fs-16" aria-hidden="true">&times;</span></a>
                </div>

                <div class="modal-body padding-top-0 padding-bottom-0 padding-right-20 padding-left-20">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="row">
                            
                                <div class="col-lg-12 col-md-12">

                                    <div class="width-60-pc float-left padding-top-10 padding-bottom-10">

                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-2">
                                                <label class="width-100-pc fs-13 fw-600">Select product</label>
                                            </div>
                                            <div class="inlineBlock width-30-pc mg-bottom-2">
                                                <label class="radio-container small width-100-pc element-inlined fs-14 cl-888">All products
                                                    <input type="radio" v-model="form.products" value="all">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="inlineBlock width-40-pc mg-bottom-2">
                                                <label class="radio-container small width-100-pc element-inlined fs-14 cl-888">Some products
                                                    <input type="radio" v-model="form.products" value="some">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-2">
                                                <label class="width-100-pc fs-13 fw-600">Select warehouse/store</label>
                                            </div>
                                            <div class="inlineBlock width-30-pc mg-bottom-2">
                                                <label class="radio-container small width-100-pc element-inlined fs-14 cl-888">All stores
                                                    <input type="radio" v-model="form.stores" value="all">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="inlineBlock width-40-pc mg-bottom-2">
                                                <label class="radio-container small width-100-pc element-inlined fs-14 cl-888">Some stores
                                                    <input type="radio" v-model="form.stores" value="some">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc">
                                                <label class="fs-13 fw-600 width-100-pc">Name this alert:</label>
                                            </div>
                                            <div class="inlineBlock width-100-pc mg-bottom-5">
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <input type="text" class="height-32" v-model="form.name" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-2">
                                                <label class="width-100-pc fs-13 fw-600">Alert me:</label>
                                            </div>
                                            <div class="inlineBlock width-100-pc mg-bottom-2">
                                                <label class="radio-container small width-100-pc element-inlined fs-14 cl-888">When quantity at hand is less than re-order level
                                                    <input type="radio" v-model="form.frequency" value="all">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="inlineBlock width-100-pc mg-bottom-2">
                                                <label class="radio-container small width-100-pc element-inlined fs-14 cl-888">When amount requested is more than quantity at hand
                                                    <input type="radio" v-model="form.frequency" value="some">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="inlineBlock width-100-pc mg-bottom-2">
                                                <label class="radio-container small width-100-pc element-inlined fs-14 cl-888">When detect error during stock taking
                                                    <input type="radio" v-model="form.frequency" value="some">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="inlineBlock width-100-pc mg-bottom-2">
                                                <label class="radio-container small width-100-pc element-inlined fs-14 cl-888">When goods received awaiting parts
                                                    <input type="radio" v-model="form.frequency" value="some">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-2">
                                                <label class="width-100-pc fs-13 fw-600">Inventory count options</label>
                                            </div>
                                            <div class="inlineBlock width-100-pc mg-bottom-2">
                                                <label class="check-container small width-100-pc element-inlined fs-14 cl-888">Ignore pending inventory to be received at warehouse as on hand
                                                    <input type="checkbox" v-model="form.count_option" value="all">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="inlineBlock width-100-pc mg-bottom-2">
                                                <label class="check-container small width-100-pc element-inlined fs-14 cl-888">Ignore products never received at any warehouse
                                                    <input type="checkbox" v-model="form.count_option" value="some">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-2">
                                                <label class="width-100-pc fs-13 fw-600">Email notification</label>
                                            </div>
                                            <div class="inlineBlock width-10-pc mg-bottom-2  mg-right-10">
                                                <label class="radio-container small width-100-pc element-inlined fs-14 cl-888">On
                                                    <input type="radio" v-model="form.email_enabled" :value="true">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="inlineBlock width-10-pc mg-bottom-2">
                                                <label class="radio-container small width-100-pc element-inlined fs-14 cl-888">Off
                                                    <input type="radio" v-model="form.email_enabled" :value="false">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-2">
                                                <label class="width-100-pc fs-13 fw-600">SMS notification</label>
                                            </div>
                                            <div class="inlineBlock width-10-pc mg-bottom-2 mg-right-10">
                                                <label class="radio-container small width-100-pc element-inlined fs-14 cl-888">On
                                                    <input type="radio" v-model="form.sms_enabled" :value="true">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="inlineBlock width-10-pc mg-bottom-2">
                                                <label class="radio-container small width-100-pc element-inlined fs-14 cl-888">Off
                                                    <input type="radio" v-model="form.sms_enabled" :value="false">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn combo-button combo-default">
                        <span v-if="!processing">Save</span>
                        <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> Processing...</span>
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
    import {createHtmlErrorString,create_item,removeElement,formatMoney,add_search_item,amend_totals,reset_forms,location_obj_setter} from '../../../../../../../helpers/functionmixin';
    import AppInfo from '../../../../../../../helpers/config';
    import {post} from '../../../../../../../helpers/api';
    import {PURCHASES_PO_URL} from '../../../../../../../router/api_routes';
    import Auth from '../../../../../../../store/auth'
    export default {
        props: ['modal_id','modal_title','practice_id','initial_url','initializations','organ_data'],
        components: {},
        data(){
            return {
                current_branch: {},
                processing: false,
                initialization: {},
                supplier_str: '',
                facility_str: '',
                form: {
                    products: 'all',
                    stores: 'all',
                    name: '',
                    frequency: '',
                    practice_id: this.practice_id,
                    email_enabled: false,
                    sms_enabled: false,
                }
            }
        },
        watch: {
            initializations: function(new_in,old_in){
                this.initializations = new_in;
            }
        },
        methods: {
            
            save_alert(){
                this.processing = true;
                post(this.initial_url,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            if (this.user_mode === 'Edit') {
                                this.$emit('alertEdited');
                            }else {
                                this.$emit('alertAdded');
                            }
                        }
                        this.processing = false;
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        console.info(err.response.data.errors);
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
        },

        mounted(){
            this.initialization = location_obj_setter(this.initializations,null);
            this.current_branch = Auth.getCurrentAccount('work_place');
            this.purchase.staff_id = Auth.getCurrentAccount('staff_id');
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../../../../../../sass/transaction_docs.scss';
    .modal.left .modal-content,
    .modal-lg {
        max-width: 800px!important;
        min-width: 800px!important;
    }
    .modal-header h4 {
        font-size: 20px!important;
    }
</style>


