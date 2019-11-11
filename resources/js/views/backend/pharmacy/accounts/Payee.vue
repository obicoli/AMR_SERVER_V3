<template>
    <div class="hold-transition skin-yellow sidebar-collapse">

        <loading :is-loading="processing"></loading>

        <page-header :accounts="true"></page-header>

        <div class="content-wrapper mg-bottom-50">

            <sub-header :payee="true" :sub_title="'Account Holders :'"></sub-header>

            <section class="content bg-white">

                <div class="row">

                    <div v-if="account_loaded && account_holders.length < 1" class="col-xs-12 col-md-12 col-sm-12 mg-top-50">
                        <div class="box border-top-0 border-bottom-0 border-radius-0">
                            <div class="box-body bg-white padding-0">
                            </div>
                        </div>
                        <div class="text-center mg-top-30">
                            <p>You dont have any account holder</p>
                            <a data-toggle="modal" data-target="#new_account_holder_modal" class="btn btn-inventory primary">
                                <i class="fa fa-id-card-o" aria-hidden="true"></i> Add Account
                            </a>
                        </div>
                    </div>

                    <div v-if="account_loaded && account_holders.length > 0" class="col-xs-12 col-md-9 col-sm-9 col-lg-9">

                        <div class="box border-top-0 border-bottom-0 border-radius-0" id="print-section">

                            <div class="box-header box-header-custom">

                                <div class="pull-left pull width-30-pc">
                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" data-live-search="true">
                                        <option value="">Chart of accounts</option>
                                    </select>
                                </div>

                                <div class="pull pull-right width-70-pc">
                                    <div class="filters width-100-pc">
                                        <div class="filter-block form-inline pull-right text-right">
                                            <div class="filter-group input-group">
                                                <span data-toggle="modal" data-target="#new_account_holder_modal" class="filter"><i class="fa fa-plus"></i> Add Account</span>
                                                <span data-toggle="modal" data-target="#upload_brand_modal" class="filter"><i class="fa fa-upload"></i> Upload CSV</span>
                                                <span @click="export_to_csv" class="filter"><i class="fa fa-file-excel-o"></i> Export</span>
                                                <span @click="printThis('category_box_body')" class="filter"><i class="fa fa-print"></i> Print</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body bg-white padding-0" id="category_box_body">
                                <table class="items table table-bordered table-hover table-td-5">
                                    <thead>
                                    <tr>
                                        <th style="width: 5%">#ID</th>
                                        <th style="width: 25%">Name</th>
                                        <th style="width: 25%">Email</th>
                                        <th style="width: 15%">Created At</th>
                                        <th style="width: 20%">Created By</th>
                                        <th style="width: 10%"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="noprintclass">
                                    <tr v-for="(account_hold, index) in account_holders">
                                        <td>{{index + 1}}</td>
                                        <td>{{account_hold.title}}</td>
                                        <td>{{account_hold.email}}</td>
                                        <td>{{account_hold.created_at}}</td>
                                        <td>{{account_hold.created_by}}</td>
                                        <td>
                                            <div class="btn-group pull no-print pull-right showOnHover">
                                                <button type="button" class="btn btn-inventory small dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-ctm" role="menu">
                                                    <li onclick="">
                                                        <a data-toggle="modal" :data-target="'#edit_holder_modal_'+index"><i class="fa fa-edit"></i> View details</a>
                                                    </li>
                                                    <li>
                                                        <a href=""><i class="fa fa-bar-chart"></i>
                                                            Account statement
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a data-toggle="modal" :data-target="'#delete_holder_modal_'+index"><i class="fa fa-trash-o cl-red"></i> Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="modal fade" :id="'delete_holder_modal_'+index">
                                                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                                                    <delete-stuff-modal :modal_title="'Delete Account Holder'" :confirm_message="'Are you sure?'" :item_url="initial_url+'/'+account_hold.id" v-on:deletionSuccessful="loadAccountHolders"></delete-stuff-modal>
                                                </div>
                                            </div>
                                            <div class="modal fade" :id="'edit_holder_modal_'+index">
                                                <div class="modal-dialog modal-lg modal-dialog-centered zoomInUp flipOutX">
                                                    <form @submit.prevent="add_account_holder">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="cl-grey"><i class="fa fa-id-card-o"></i> Edit Account Holder:</h4>
                                                                <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row box box-default mg-left-0">
                                                                    <div class="col-md-12">
                                                                        <h4>
                                                                            <label class="box-label fs-16 fw-600">Account Holder Basic Info</label>
                                                                        </h4>
                                                                        <div class="col-md-5 field-agjust">
                                                                            <div class="form-group">
                                                                                <label class="fs-14 cl-888">Account Title:</label>
                                                                                <input v-model="account_hold.title" required type="text" class="form-control product-entry-input-field" placeholder="Enter account holder Full Name">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5 field-agjust">
                                                                            <div class="form-group">
                                                                                <label class="fs-14 cl-888">Email:</label>
                                                                                <input type="email" v-model="account_hold.email" required class="form-control product-entry-input-field">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5 field-agjust">
                                                                            <div class="form-group">
                                                                                <label class="fs-14 cl-888">National ID No:</label>
                                                                                <input type="text" v-model="account_hold.national_id" required class="form-control product-entry-input-field">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5 field-agjust">
                                                                            <div class="form-group">
                                                                                <label class="fs-14 cl-888">Mobile:</label>
                                                                                <input type="number" v-model="account_hold.mobile" class="form-control product-entry-input-field" placeholder="e.g 00659855487">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="row box box-default mg-left-0">
                                                                    <div class="col-md-12">
                                                                        <h4>
                                                                            <label class="box-label fs-16 fw-600">Account Holder Address Details</label>
                                                                        </h4>
                                                                        <div class="col-md-5 field-agjust">
                                                                            <div class="form-group">
                                                                                <label class="fs-14 cl-888">Address:</label>
                                                                                <input type="text" v-model="account_holder_form.address" required class="form-control product-entry-input-field" placeholder="e.g 11th Commercial Street DHA ,Karachi" reqiured="">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-5 field-agjust">
                                                                            <div class="form-group">
                                                                                <label class="fs-14 cl-888">Company:</label>
                                                                                <input type="text" v-model="account_hold.company_name" required class="form-control product-entry-input-field" placeholder="e.g Abc Hospital">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5 field-agjust">
                                                                            <div class="form-group">
                                                                                <label class="fs-14 cl-888">Country:</label>
                                                                                <select v-model="account_hold.country" required class="form-control product-entry-input-field">
                                                                                    <option v-for="countr in countries" :value="countr.name">{{countr.name}}</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-5 field-agjust">
                                                                            <div class="form-group">
                                                                                <label class="fs-14 cl-888">Town:</label>
                                                                                <select v-model="account_hold.town" required class="form-control product-entry-input-field">
                                                                                    <option v-for="towny in towns" :value="towny.name">{{towny.name}}</option>
                                                                                </select>
<!--                                                                                <vue-single-select-->
<!--                                                                                        name="maybe"-->
<!--                                                                                        :required="true"-->
<!--                                                                                        you-want-to-select-a-post="ok"-->
<!--                                                                                        v-model="town_item"-->
<!--                                                                                        out-of-all-these-posts="makes sense"-->
<!--                                                                                        :options="towns"-->
<!--                                                                                        a-post-has-an-id="good for search and display"-->
<!--                                                                                        option-key=""-->
<!--                                                                                        the-post-has-a-title="make sure to show these"-->
<!--                                                                                        option-label="name"-->
<!--                                                                                ></vue-single-select>-->
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-5 field-agjust">
                                                                            <div class="form-group">
                                                                                <label class="fs-14 cl-888">Upload Picture (Optional)</label>
                                                                                <input type="file" class="form-control product-entry-input-field">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button data-dismiss="modal" class="btn btn-inventory">
                                                                    <i class="fa fa-close" aria-hidden="true"></i> Close
                                                                </button>
                                                                <button type="submit" class="btn btn-inventory primary">
                                                                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                                                                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </section>

            <!-- (Ajax Modal)-->
            <div class="modal fade" id="new_account_holder_modal">
                <div class="modal-dialog modal-lg modal-dialog-centered zoomInUp flipOutX">
                    <form @submit.prevent="add_account_holder">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="cl-grey"><i class="fa fa-id-card-o"></i> New Account Holder:</h4>
                                <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
                            </div>
                            <div class="modal-body">
                                <div class="row box box-default mg-left-0">
                                    <div class="col-md-12">
                                        <h4>
                                            <label class="box-label fs-16 fw-600">Account Holder Basic Info</label>
                                        </h4>
                                        <div class="col-md-5 field-agjust">
                                            <div class="form-group">
                                                <label class="fs-14 cl-888">Account Title:</label>
                                                <input v-model="account_holder_form.title" required type="text" class="form-control product-entry-input-field" placeholder="Enter account holder Full Name">
                                            </div>
                                        </div>
                                        <div class="col-md-5 field-agjust">
                                            <div class="form-group">
                                                <label class="fs-14 cl-888">Email:</label>
                                                <input type="email" v-model="account_holder_form.email" required class="form-control product-entry-input-field">
                                            </div>
                                        </div>
                                        <div class="col-md-5 field-agjust">
                                            <div class="form-group">
                                                <label class="fs-14 cl-888">National ID No:</label>
                                                <input type="text" v-model="account_holder_form.national_id" required class="form-control product-entry-input-field">
                                            </div>
                                        </div>
                                        <div class="col-md-5 field-agjust">
                                            <div class="form-group">
                                                <label class="fs-14 cl-888">Mobile:</label>
                                                <input type="number" v-model="account_holder_form.mobile" class="form-control product-entry-input-field" placeholder="e.g 00659855487">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row box box-default mg-left-0">
                                    <div class="col-md-12">
                                        <h4>
                                            <label class="box-label fs-16 fw-600">Account Holder Address Details</label>
                                        </h4>
                                        <div class="col-md-5 field-agjust">
                                            <div class="form-group">
                                                <label class="fs-14 cl-888">Address:</label>
                                                <input type="text" v-model="account_holder_form.address" required class="form-control product-entry-input-field" placeholder="e.g 11th Commercial Street DHA ,Karachi" reqiured="">
                                            </div>
                                        </div>

                                        <div class="col-md-5 field-agjust">
                                            <div class="form-group">
                                                <label class="fs-14 cl-888">Company:</label>
                                                <input type="text" v-model="account_holder_form.company_name" required class="form-control product-entry-input-field" placeholder="e.g Abc Hospital">
                                            </div>
                                        </div>
                                        <div class="col-md-5 field-agjust">
                                            <div class="form-group">
                                                <label class="fs-14 cl-888">Country:</label>
                                                <vue-single-select
                                                        name="maybe"
                                                        :required="true"
                                                        you-want-to-select-a-post="ok"
                                                        v-model="country_item"
                                                        :get-option-value="loadCity"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="countries"
                                                        a-post-has-an-id="good for search and display"
                                                        option-key=""
                                                        the-post-has-a-title="make sure to show these"
                                                        option-label="name"
                                                ></vue-single-select>
                                            </div>
                                        </div>

                                        <div class="col-md-5 field-agjust">
                                            <div class="form-group">
                                                <label class="fs-14 cl-888">Town:</label>
                                                <vue-single-select
                                                        name="maybe"
                                                        :required="true"
                                                        you-want-to-select-a-post="ok"
                                                        v-model="town_item"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="towns"
                                                        a-post-has-an-id="good for search and display"
                                                        option-key=""
                                                        the-post-has-a-title="make sure to show these"
                                                        option-label="name"
                                                ></vue-single-select>
                                            </div>
                                        </div>

                                        <div class="col-md-5 field-agjust">
                                            <div class="form-group">
                                                <label class="fs-14 cl-888">Upload Picture (Optional)</label>
                                                <input type="file" class="form-control product-entry-input-field">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-inventory">
                                    <i class="fa fa-close" aria-hidden="true"></i> Close
                                </button>
                                <button type="submit" class="btn btn-inventory primary">
                                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> <!-- Bootstrap model  ends-->
            <!-- /.content -->

        </div>

        <page-footer></page-footer>
    </div>
</template>

<script>
    import VueSingleSelect from "vue-single-select";
    import Loading from '../../../../components/loads/ProgRess'
    import PageHeader from '../patials/Header'
    import PageFooter from '../patials/Footer'
    import SubHeader from './partials/SubHeader'
    import {get,post} from "../../../../helpers/api";
    import Auth from "../../../../store/auth";
    import AppInfo from "../../../../helpers/config";
    import {print_divs,exportToCsv} from "../../../../helpers/functionmixin";
    import {createHtmlErrorString} from "../../../../helpers/functionmixin";
    import DeleteStuffModal from '../patials/DeleteStuffModal'
    export default {
        name: "Payee",
        components: {
            PageFooter,PageHeader,Loading,SubHeader,VueSingleSelect,DeleteStuffModal
        },
        data(){
            return {
                practice_id: '',
                initial_url: '/api/practices/products/accounts/holders',
                processing: false,
                account_loaded: false,
                account_holders: [],
                towns: [],
                countries: [],
                country_item: {},
                town_item: {},
                account_holder_form: {
                    title: '',
                    email: '',
                    address: '',
                    mobile: '',
                    company_name: '',
                    country: '',
                    town: '',
                    national_id: '',
                    practice_id: '',
                },
            }
        },
        methods: {
            add_account_holder(){
                this.processing = true;
                this.account_holder_form.practice_id = this.practice_id;
                this.account_holder_form.country = this.country_item.name;
                this.account_holder_form.town = this.town_item.name;
                post(AppInfo.app_data.server_domain+this.initial_url,this.account_holder_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.refresh_form();
                            this.loadAccountHolders();
                            this.processing = true;
                            this.$awn.success(res.data.description);
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
                    this.refresh_form();
                    this.processing = false;
                });
            },
            edit_head(account,subject_){
                this.processing = true;
                let url_ = this.initial_url+'/'+subject_;
                post(AppInfo.app_data.server_domain+url_,account)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.loadAccountHolders();
                            this.$awn.success(res.data.description);
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
                this.account_holder_form.title = "";
                this.account_holder_form.email = "";
                this.account_holder_form.address = "";
                this.account_holder_form.mobile = "";
                this.account_holder_form.company_name = "";
                this.account_holder_form.country = "";
                this.account_holder_form.town = "";
                this.account_holder_form.national_id = "";
                this.account_holder_form.practice_id = "";
                this.town_item = {};
                this.country_item = {};
            },

            printThis(ele_id){
                print_divs(ele_id)
            },
            export_to_csv(){
                exportToCsv(this.categories,'Brand List')
            },
            loadAccountHolders(){
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Account Holders')
                    .then((res) => {
                        //this.accounts = [];
                        if(res.data.status_code === 200) {
                            this.account_holders = res.data.results;
                            console.info(this.account_holders);
                            this.account_loaded = true;
                        }
                    }).catch((err) => {
                });
                this.processing = false;
            },
            loadCountry: function () {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/localization/countries')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.countries = res.data.results;
                            this.processing = false;
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
            loadCity: function(value_is){
                //console.info(value_is);
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/localization/cities/country/'+value_is.name)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.towns = res.data.results;
                            this.processing = false;
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

        },
        mounted(){
            this.practice_id = Auth.getCurrentAccount('id');
            this.loadAccountHolders();
            this.loadCountry();
            this.account_loaded = true;
        }
    }
</script>

<style scoped>

</style>