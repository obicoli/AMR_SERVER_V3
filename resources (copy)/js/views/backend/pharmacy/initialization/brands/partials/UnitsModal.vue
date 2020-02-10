<template>
    <form @submit.prevent="save_units">
        <div class="modal-content">
            <div class="modal-header">
                <h4 v-if="user_mode==='Create'" class="cl-grey"><i class="fa fa-plus-circle"></i> Add Unit:</h4>
                <h4 v-if="user_mode==='Edit'" class="cl-grey"><i class="fa fa-edit"></i> Edit Unit:</h4>
                <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
            </div>
            <div class="modal-body">
                <div class="row form-group mg-bottom-10">
                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                        <label class="fs-14 cl-888">Name:<span class="cl-red">*</span></label>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <input type="text" v-model="form.name" placeholder="e.g Kilogram" required v-bind:class="{'form-control product-entry-input-field':true,'attended_field':form.name}">
                    </div>
                </div>
                <div class="row form-group mg-bottom-10">
                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                        <label class="fs-14 cl-888">Symbol:<span class="cl-red">*</span></label>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <input type="text" v-model="form.slug" placeholder="e.g Kg" required v-bind:class="{'form-control product-entry-input-field':true,'attended_field':form.slug}">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                        <label class="fs-14 cl-888">Status:<span class="cl-red">*</span></label>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <select required v-model="form.status" v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':form.status}">
                            <option value="" disabled selected>-select-</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-inventory">
                    <i class="fa fa-close" aria-hidden="true"></i> Close
                </button>
                <button v-if="user_mode==='Create'" type="button" class="btn btn-inventory">
                    <i class="fa fa-refresh" aria-hidden="true"></i> Reset
                </button>
                <button v-if="user_mode==='Edit'" type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save Changes</span>
                </button>
                <button v-if="user_mode==='Create'" type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                </button>
            </div>
        </div>
    </form>
</template>

<script>
    import {post,get} from "../../../../../../helpers/api";
    import Loading from "../../../../../../components/loads/ProgRess";
    import Auth from "../../../../../../store/auth";
    import AppInfo from "../../../../../../helpers/config";
    import {createHtmlErrorString} from "../../../../../../helpers/functionmixin";
    export default {
        name: "UnitsModal",
        props: ['branch_id','user_mode','form_data','item_id','initial_ur'],
        components: {Loading},
        data(){
            return {
                initial_url: '',
                processing: false,
                companies: [],
                form: {
                    name: '',
                    practice_id: '',
                    status: '',
                    slug: '',
                }
            }
        },
        methods: {
            save_units: function () {
                this.processing = true;
                post(AppInfo.app_data.server_domain+this.initial_url,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            if (this.user_mode === 'Edit') {
                                this.$emit('unitEdited');
                            }else {
                                this.refresh_form();
                                this.$emit('unitAdded')
                            }
                        }
                        this.processing = false;
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
            refresh_form(){
                this.form.status = "";
                this.form.name = "";
                this.form.slug = "";
            },
            search_Product(event, search_type){
                let url_search = AppInfo.app_data.server_domain+'/api/search/'+search_type;
                let formData = new FormData();
                formData.append('name', event.target.value);
                formData.append('practice_id', this.practice_id);
                post(url_search, formData)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            switch (search_type) {
                                case "products":
                                    this.products_list = res.data.results;
                                    break;
                                case "generics":
                                    this.generics_lists = res.data.results;
                                    break;
                                case "item_code":
                                    this.item_code_taken = res.data.results;
                                    if(res.data.results){
                                        this.item_form.item_code = "";
                                    }
                                    break;
                                case "manufacturers":
                                    this.companies = res.data.results;
                                    break;
                                case "brands":
                                    this.brands_lists = res.data.results;
                                    break;
                                case "units":
                                    this.product_units = res.data.results;
                                    break;
                            }
                        }
                    }).catch((err) => {
                });
            },
        },
        mounted() {
            this.form.practice_id = this.branch_id;
            if (this.user_mode === 'Edit') {
                this.form.name = this.form_data.name;
                this.form.status = this.form_data.status;
                this.form.slug = this.form_data.slug;
                this.initial_url = this.initial_ur+'/'+this.item_id;
                console.info(this.company_item);
            }else {
                this.initial_url = this.initial_ur;
            }
        }
    }
</script>

<style scoped>

</style>