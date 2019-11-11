<template>

    <div class="hold-transition skin-yellow sidebar-collapse">

        <loading :is-loading="processing"></loading>

        <page-header :accounts="true"></page-header>

        <div class="content-wrapper mg-bottom-50">

            <sub-header :accounts="true" :sub_title="'Chart of accounts :'"></sub-header>

            <section class="content bg-white">

                <div class="row">

                    <div v-if="account_loaded && accounts.length < 1" class="col-xs-12 col-md-12 col-sm-12 mg-top-50">
                        <div class="box border-top-0 border-bottom-0 border-radius-0">
                            <div class="box-body bg-white padding-0">
                            </div>
                        </div>
                        <div class="text-center mg-top-30">
                            <p>You dont have any chart of account</p>
                            <a data-toggle="modal" data-target="#new_account_modal" class="btn btn-inventory primary">
                                <i class="fa fa-briefcase" aria-hidden="true"></i> Create Head
                            </a>
                        </div>
                    </div>

                    <div v-if="account_loaded && accounts.length > 0" class="col-xs-12 col-md-9 col-sm-9 col-lg-9">

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
                                                <span data-toggle="modal" data-target="#new_account_modal" class="filter"><i class="fa fa-plus"></i> Add</span>
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
                                        <th style="width: 15%">Nature</th>
                                        <th style="width: 15%">Type</th>
                                        <th style="width: 15%">Created At</th>
                                        <th style="width: 15%">Created By</th>
                                        <th style="width: 10%"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="noprintclass">
                                        <tr v-for="(account, index) in accounts">
                                            <td>{{index + 1}}</td>
                                            <td>{{account.name}}</td>
                                            <td>{{account.nature}}</td>
                                            <td>{{account.type}}</td>
                                            <td>{{account.created_at}}</td>
                                            <td>{{account.created_by}}</td>
                                            <td>
                                                <a data-toggle="modal" :data-target="'#edit_account_modal_'+index" class="cl-444 showOnHover"><i class="fa fa-edit"></i></a>
                                                <div class="modal fade" :id="'edit_account_modal_'+index">
                                                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                                                        <div class="modal-content">
                                                            <form @submit.prevent="edit_head(account,account.id)">
                                                                <div class="modal-header">
                                                                    <h4 class="cl-grey"> Edit Head</h4>
                                                                    <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
                                                                </div>
                                                                <div  class="modal-body">
                                                                    <div class="row form-group mg-bottom-10">
                                                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                                            <label class="fs-14 cl-888">Name:</label>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                                            <input type="text" v-model="account.name" class="form-control product-entry-input-field">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group mg-bottom-10">
                                                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                                            <label class="fs-14 cl-888">Nature:</label>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                                            <select v-model="account.nature_id" class="form-control product-entry-input-field">
                                                                                <option v-for="nats in account_natures" :value="nats.id">{{nats.name}}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form-group mg-bottom-10">
                                                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                                            <label class="fs-14 cl-888">Type:</label>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                                            <select v-model="account.type_id" class="form-control product-entry-input-field">
                                                                                <option v-for="typey in account_types" :value="typey.id">{{typey.name}}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-inventory primary">
                                                                        <span><i class="fa fa-trash-o" aria-hidden="true"></i> Save changes</span>
                                                                    </button>
                                                                    <button data-dismiss="modal" class="btn btn-inventory">
                                                                        Close
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Bootstrap model  ends-->
                                                <a data-toggle="modal" :data-target="'#delete_brand_modal_'+index" class="cl-red showOnHover"><i class="fa fa-trash-o"></i></a>
                                                <div class="modal fade" :id="'delete_brand_modal_'+index">
                                                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                                                        <delete-stuff-modal v-if="accounts.length>0" :modal_title="'Delete Head'" :confirm_message="'Are you sure?'" :item_url="initial_url+'/'+account.id" v-on:deletionSuccessful="loadAccounts"></delete-stuff-modal>
                                                    </div>
                                                </div> <!-- Bootstrap model  ends-->
                                                <!-- /.content -->
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
            <div class="modal fade" id="new_account_modal">
                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                    <form @submit.prevent="add_head">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h4 class="cl-grey"><i class="fa fa-briefcase"></i> Add New Head:</h4>
                                <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
                            </div>

                            <div class="modal-body">

                                <div class="row form-group mg-bottom-10">
                                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                        <label class="fs-14 cl-888">Account Name:<span class="cl-red">*</span></label>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-7">
                                        <input v-model="account_form.name" type="text" placeholder="e.g Accounts payable" required class="form-control product-entry-input-field">
                                    </div>
                                </div>

                                <div class="row form-group mg-bottom-10">
                                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                        <label class="fs-14 cl-888">Nature:<span class="cl-red">*</span></label>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-7">
                                        <vue-single-select
                                                name="maybe"
                                                :required="true"
                                                :placeholder="'Search here'"
                                                you-want-to-select-a-post="ok"
                                                v-model="nature_item"
                                                out-of-all-these-posts="makes sense"
                                                :options="account_natures"
                                                a-post-has-an-id="good for search and display"
                                                option-key=""
                                                the-post-has-a-title="make sure to show these"
                                                option-label="name"
                                        ></vue-single-select>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                        <label class="fs-14 cl-888">Type :<span class="cl-red">*</span></label>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-7">
                                        <vue-single-select
                                                name="maybe"
                                                :required="true"
                                                :placeholder="'Search here'"
                                                you-want-to-select-a-post="ok"
                                                v-model="type_item"
                                                out-of-all-these-posts="makes sense"
                                                :options="account_types"
                                                a-post-has-an-id="good for search and display"
                                                option-key=""
                                                the-post-has-a-title="make sure to show these"
                                                option-label="name"
                                        ></vue-single-select>
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
        name: "AccountIndex",
        components: {
            PageFooter,PageHeader,Loading,SubHeader,VueSingleSelect,DeleteStuffModal
        },
        data(){
            return {
                practice_id: '',
                initial_url: '/api/practices/products/accounts',
                processing: false,
                account_loaded: false,
                accounts: [],
                account_natures: [],
                account_types: [],
                nature_item: {},
                type_item: {},
                account_form: {
                    name: '',
                    nature_id: '',
                    type_id: '',
                    practice_id: '',
                },
            }
        },
        methods: {
            add_head(){
                this.processing = true;
                this.account_form.nature_id = this.nature_item.id;
                this.account_form.type_id = this.type_item.id;
                this.account_form.practice_id = this.practice_id;
                post(AppInfo.app_data.server_domain+this.initial_url,this.account_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.refresh_form();
                            this.loadAccounts();
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
                            this.loadAccounts();
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
                this.account_form.name = "";
                this.account_form.type_id = "";
                this.account_form.nature_id = "";
                this.account_form.practice_id = "";
                this.type_item = {};
                this.nature_item = {};
            },

            printThis(ele_id){
                print_divs(ele_id)
            },
            export_to_csv(){
                exportToCsv(this.categories,'Brand List')
            },
            loadAccounts(){
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Accounts')
                    .then((res) => {
                        //this.accounts = [];
                        if(res.data.status_code === 200) {
                            this.accounts = res.data.results.resources;
                            console.info(this.accounts);
                            this.account_loaded = true;
                        }
                    }).catch((err) => {
                });
                this.processing = false;
            },
            loadAccountNature(){
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Account Nature')
                    .then((res) => {
                        //this.accounts = [];
                        if(res.data.status_code === 200) {
                            this.account_natures = res.data.results.resources;
                            //console.info(this.account_natures);
                        }
                    }).catch((err) => {
                });
                this.processing = false;
            },
            loadAccountType(){
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Account Type')
                    .then((res) => {
                        //this.accounts = [];
                        if(res.data.status_code === 200) {
                            this.account_types = res.data.results.resources;
                            //console.info(this.account_types);
                        }
                    }).catch((err) => {
                });
                this.processing = false;
            },
        },
        mounted(){
            this.practice_id = Auth.getCurrentAccount('id');
            this.loadAccounts();
            this.loadAccountNature();
            this.loadAccountType();
            this.account_loaded = true;
        }

    }
</script>

<style lang="scss">
    @import '../../../../../../node_modules/vue-awesome-notifications/dist/styles/style';
</style>