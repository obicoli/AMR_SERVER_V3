<template>

    <div class="hold-transition skin-yellow sidebar-collapse">

        <loading :is-loading="processing"></loading>

        <page-header :settings="true"></page-header>

        <div class="content-wrapper">

            <sub-header :facility="true" :sub_title="'Branch/Facility List:'"></sub-header>

            <section class="content bg-white">

                <div class="row">

                    <div v-if="prod_loaded && pharmacy_branches.length < 1" class="col-xs-12 col-md-12 col-sm-12 mg-top-50">
                        <div class="box border-top-0 border-bottom-0 border-radius-0">
                            <div class="box-body bg-white padding-0">
                            </div>
                        </div>
                        <div class="text-center mg-top-30">
                            <p>You dont have any branch</p>
                            <a data-toggle="modal" data-target="#new_branch_modal" class="btn btn-inventory primary">
                                <i class="fa fa-plus" aria-hidden="true"></i> Create new
                            </a>
                        </div>
                    </div>

                    <div v-if="prod_loaded && pharmacy_branches.length > 0" class="col-xs-12 col-md-11 col-sm-11 col-lg-11">

                        <div class="box border-top-0 border-bottom-0 border-radius-0" id="print-section">

                            <div class="box-header box-header-custom">

                                <div class="pull-left pull width-30-pc">
                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" data-live-search="true">
                                        <option value="">switch to branch</option>
                                    </select>
                                </div>

                                <div class="pull pull-right width-70-pc">
                                    <div class="filters width-100-pc">
                                        <div class="filter-block form-inline pull-right text-right">
                                            <div class="filter-group input-group">
                                                <span data-toggle="modal" data-target="#new_branch_modal" class="filter"><i class="fa fa-plus"></i> Add</span>
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
                                        <th style="width: 20%">Name</th>
                                        <th style="width: 13%">Email</th>
                                        <th style="width: 13%">Mobile</th>
                                        <th style="width: 12%">Created At</th>
                                        <th style="width: 12%">Created By</th>
                                        <th style="width: 10%"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="noprintclass">
                                    <tr v-for="(pharmacy_branch, index) in pharmacy_branches">
                                        <td>{{index + 1}}</td>
                                        <td>{{pharmacy_branch.name}}({{pharmacy_branch.category}})</td>
                                        <td>{{pharmacy_branch.email}}</td>
                                        <td>{{pharmacy_branch.mobile}}</td>
                                        <td>{{pharmacy_branch.created_at}}</td>
                                        <td>{{pharmacy_branch.created_by}}</td>
                                        <td>
                                            <div class="btn-group pull no-print pull-right showOnHover">
                                                <button type="button" class="btn btn-inventory small dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-ctm" role="menu">
                                                    <li onclick="">
                                                        <a data-toggle="modal" :data-target="'#edit_branch_modal_'+index"><i class="fa fa-edit"></i> View details</a>
                                                    </li>
                                                    <li>
                                                        <a @click="switch_to_branch(pharmacy_branch)" ><i class="fa fa-refresh"></i>Switch to branch</a>
                                                    </li>
                                                    <li v-if="pharmacy_branch.category==='Branch'">
                                                        <a data-toggle="modal" :data-target="'#delete_branch_modal_'+index" ><i class="fa fa-trash-o cl-red"></i> Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div v-if="pharmacy_branch.category==='Branch'" class="modal fade" :id="'delete_branch_modal_'+index">
                                                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                                                    <delete-stuff-modal :modal_title="'Delete Branch'" :confirm_message="'Are you sure?'" :item_url="initial_url+'/'+pharmacy_branch.id" v-on:deletionSuccessful="load_Branches"></delete-stuff-modal>
                                                </div>
                                            </div>
                                            <div class="modal fade" :id="'edit_branch_modal_'+index">
                                                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                                                    <branch-modal :form_data="pharmacy_branch" :item_id="pharmacy_branch.id" :initial_ur="initial_url" :branch_id="practice_id" :user_mode="'Edit'"></branch-modal>
                                                </div>
                                            </div> <!-- Bootstrap model  ends-->
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
            <div class="modal fade" id="new_branch_modal">
                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                    <branch-modal v-if="prod_loaded" :form_data="form" :practice_id="practice_id"  :initial_ur="initial_url" :user_mode="'Create'" v-on:branchAdded="load_Branches"></branch-modal>
                </div>
            </div> <!-- Bootstrap model  ends-->
            <!-- /.content -->

        </div>

        <page-footer></page-footer>

    </div>

</template>

<script>
    import PageHeader from '../../patials/Header'
    import PageFooter from '../../patials/Footer'
    import Loading from '../../../../../components/loads/ProgRess'
    import DepartmentModal from './partials/DepartmentModal'
    import BranchModal from './partials/BranchModal'
    import StoreModal from './partials/StoreModal'
    import SubHeader from '../partials/SubHeader'
    import {get} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import Auth from "../../../../../store/auth";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";
    import {print_divs,exportToCsv} from "../../../../../helpers/functionmixin";
    import DeleteStuffModal from '../../patials/DeleteStuffModal'

    export default {
        name: "Index",
        components: {
            PageFooter,PageHeader,Loading,DepartmentModal,StoreModal,BranchModal,SubHeader,DeleteStuffModal
        },
        data(){
            return {
                processing: false,
                prod_loaded: false,
                pharmacy: {},
                pharmacy_branches: [],
                selected_branches: [],
                total_stores: 0,
                total_departments: 0,
                total_users: 0,
                form: {
                    status: '',
                    user_id: '',
                    name: '',
                    type: '',
                    address: '',
                    city: '',
                    country: '',
                    website: '',
                    email: '',
                    mobile: '',
                    registration_number: '',
                    practice_id: '',
                },
                depart_form: {
                    name: '',
                    description: '',
                    branch_id: [],
                    status: '',
                },
                practice_id: '',
                initial_url: '/api/practices',
            }
        },
        methods: {

            printThis(ele_id){
                print_divs(ele_id)
            },
            export_to_csv(){
                exportToCsv(this.categories,'Brand List')
            },
            load_Branches: function () {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Branches')
                    .then((res) => {
                        this.brands = [];
                        if(res.data.status_code === 200) {
                            this.pharmacy_branches = res.data.results.resources;
                            this.prod_loaded = true;
                            console.info(pharmacy_branches);
                        }
                    }).catch((err) => {
                });
                this.processing = false;
            },
            switch_to_branch: function(branch){
                Auth.setCurrentBranch(branch);
                window.location.href = Auth.redirect_to_branch();
            }
        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            console.info(this.practice_id);
            this.form.practice_id = this.practice_id;
            this.load_Branches();
            this.prod_loaded = true;
        }
    }
</script>

<style lang="scss">
    @import '../../../../../../../node_modules/vue-awesome-notifications/dist/styles/style';
</style>