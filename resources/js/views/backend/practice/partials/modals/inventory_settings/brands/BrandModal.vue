<template>
    <div class="modal fade" :id="modal_id">
        <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">

            <form @submit.prevent="save_brand">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 v-if="user_mode==='Create'" class="cl-grey">New Brand</h4>
                        <h4 v-if="user_mode==='Edit'" class="cl-grey"><i class="fa fa-edit"></i> Edit Brand:</h4>
                        <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
                    </div>

                    <div class="modal-body">

                        <div class="row form-group mg-bottom-10">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Company:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="text" v-model="form.company_name" list="company_list" required class="form-control product-entry-input-field">
                                <datalist id="company_list">
                                    <option v-for="(company, index) in companies" :value="company.name" :key="'company'+index">{{company.name}}</option>
                                </datalist>
                            </div>
                        </div>
                        <div class="row form-group mg-bottom-10">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Brand name:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="text" v-model="form.name" placeholder="" required class="form-control product-entry-input-field">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Status:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <select required v-model="form.status" class="form-control product-entry-input-field height-32" data-live-search="true" style="width: 100%;">
                                    <option value="" disabled selected>-select-</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button data-dismiss="modal" @click="resets" class="btn btn-inventory">
                            <i class="fa fa-close" aria-hidden="true"></i> Close
                        </button>
                        <button v-if="user_mode==='Create'" type="button" @click="resets" class="btn btn-inventory">
                            <i class="fa fa-refresh" aria-hidden="true"></i> Reset
                        </button>
                        <button v-if="user_mode==='Edit'" type="submit" class="btn btn-inventory primary">
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i>Save Changes</span>
                        </button>
                        <button v-if="user_mode==='Create'" type="submit" class="btn btn-inventory primary">
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {post} from "../../../../../../../helpers/api";
    // import Loading from "../../../../../../components/loads/ProgRess";
    import Auth from "../../../../../../../store/auth";
    // import AppInfo from "../../../../../../helpers/config";
    import {PRODUCT_CATEGORIES_URL} from '../../../../../../../router/api_routes';
    import {createHtmlErrorString,reset_forms} from "../../../../../../../helpers/functionmixin";
    export default {
        name: "CategoryModal",
        props: ['practice_id','user_mode','form_data','item_id','modal_id','title','INITIAL_URL','companies'],
        //components: {Loading},
        data(){
            return {
                //initial_url: PRODUCT_CATEGORIES_URL,
                processing: false,
                form: {
                    company_name: '',
                    name: '',
                    description: '',
                    practice_id: this.practice_id,
                    status: '',
                }
            }
        },
        methods: {
            save_brand: function () {
                this.processing = true;
                post(this.INITIAL_URL,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            if (this.user_mode === 'Edit') {
                                $("#"+this.modal_id).modal('hide');
                                this.$emit('brandEdited',this.form);
                            }else {
                                this.form = reset_forms(this.form);
                                this.processing = false;
                                this.$emit('brandAdded');
                            }
                        }
                        this.processing = false;
                    }).catch((err) => {
                        if(err.response.status === 422) {
                            this.processing = false;
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
            resets(){
                this.form = reset_forms(this.form);
                this.processing = false;
            }
        },
        mounted() {
            if (this.user_mode === 'Edit') {
                this.form.id = this.form_data.id;
                this.form.name = this.form_data.name;
                this.form.description = this.form_data.description;
                this.form.status = this.form_data.status;
                this.form.company_name = this.form_data.company_name;
            }
        }
    }
</script>

<style scoped>

</style>