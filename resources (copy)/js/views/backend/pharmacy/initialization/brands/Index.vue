<template>

    <div class="hold-transition skin-yellow sidebar-collapse">

        <loading :is-loading="processing"></loading>

        <page-header :initialization="true"></page-header>

        <div class="content-wrapper">

            <!-- pages navigates here -->
            <section class="content-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull pull-left app-header width-70-pc">
                            <h5>
                                Initialization |
                                <small>Brands, Brand Sector, Units, Currency</small>&nbsp;&nbsp;&nbsp;
                            </h5>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content bg-white">

                <div class="row">
                    <div class="col-xs-12 col-md-8 col-sm-12">

                        <div class="box border-top-0 border-bottom-0 border-radius-0" id="print-section">
                            <div class="box-header box-header-custom">
                                <div class="pull pull-left width-20-pc">
                                    <h3 class="box-title fs-15 fw-600 txt-uppercase">Brand List :</h3>
                                </div>
                                <div class="pull pull-right width-80-pc">

                                    <div class="pull pull-left width-60-pc">
                                        <button :disabled="pharmacy_branches.length < 1" class="btn btn-inventory">
                                            <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                            Csv
                                        </button>
                                        <button :disabled="pharmacy_branches.length < 1" class="btn btn-inventory">
                                            <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                            Excel
                                        </button>
                                        <button :disabled="pharmacy_branches.length < 1" class="btn btn-inventory">
                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            PDF
                                        </button>
                                        <button :disabled="pharmacy_branches.length < 1" class="btn btn-inventory">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                            Print
                                        </button>
                                    </div>
                                    <div class="pull-right pull width-40-pc">
                                        <select class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" data-live-search="true" style="width: 100%;">
                                            <option value="">Search branch</option>
                                            <option v-for="pstore in pharmacy_branches" :value="pstore.id">{{pstore.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body bg-white padding-0">
                                <table class="items table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th style="width: 5%"><input type="checkbox" @click="selectAllBranches($event)"></th>
                                        <th style="width: 30%">Name</th>
                                        <th style="width: 15%">Code</th>
                                        <th style="width: 40%">Address</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="noprintclass">
                                    <tr v-if="pharmacy_branches.length > 0" v-for="pstore in pharmacy_branches">
                                        <td><input :disabled="pstore.status===0" type="checkbox" v-model="selected_branches" :value="pstore.id"></td>
                                        <td>{{pstore.name}}</td>
                                        <td>{{pstore.reg_no}}</td>
                                        <td>{{pstore.address}}</td>
                                        <td class="text-right">
                                            <a @click="view_branch(pstore)" title="View details" class="cl-444 showOnHover"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;
                                            <a title="Delete" class="cl-red showOnHover"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                    <tr v-else>
                                        <td colspan="4" class="text-center cl-red">
                                            No store to display
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="button" :disabled="selected_branches.length < 1" data-toggle="modal" data-target="#add_store_modal" class="btn btn-inventory">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add Store
                            </button>
                            <button type="button" data-toggle="modal" data-target="#add_department_modal" :disabled="selected_branches.length < 1" class="btn btn-inventory">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add Department
                            </button>
                            <button type="button" :disabled="selected_branches.length < 1" data-toggle="modal" data-target="#import_menu_modal" class="btn btn-inventory">
                                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                Import
                            </button>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-sm-12">
                        <div class="box border-top-0 border-bottom-0 border-radius-0">
                            <div class="box-header box-header-custom">
                                <h3 class="box-title fs-15"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Branch summary :</h3>
                            </div>
                            <div class="box-body bg-white padding-0">
                                <table class="items table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th style="width: 25%">Branches</th>
                                        <th style="width: 25%">Stores</th>
                                        <th style="width: 25%">Departments</th>
                                        <th style="width: 25%">Employees</th>
                                    </tr>
                                    </thead>
                                    <tbody class="noprintclass">
                                    <tr>
                                        <td>{{pharmacy_branches.length}}</td>
                                        <td>{{total_stores}}</td>
                                        <td>{{total_departments}}</td>
                                        <td>{{total_users}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- (Ajax Modal)-->
                <div class="modal fade" id="add_department_modal">
                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX" >

                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->
                <!-- (Ajax Modal)-->
                <div class="modal fade" id="add_store_modal">
                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">

                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->
                <!-- (Ajax Modal)-->
                <div class="modal fade" id="add_new_branch_modal">
                    <div class="modal-dialog modal-lg modal-lg-custom modal-dialog-centered zoomInUp flipOutX">

                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->

            </section>

        </div>

        <page-footer></page-footer>

    </div>

</template>

<script>
    import PageHeader from '../../patials/Header'
    import PageFooter from '../../patials/Footer'
    import Loading from '../../../../../components/loads/ProgRess'
    import {get} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import Auth from "../../../../../store/auth";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "Index",
        components: {
            PageFooter,PageHeader,Loading
        },
        data(){
            return {
                processing: false,
                pharmacy_branches: [],
                selected_branches: [],
                total_stores: 0,
                total_departments: 0,
                total_users: 0,
                form: {
                    status: '',
                    user_id: Auth.getKey(),
                    name: '',
                    type: '',
                    address: '',
                    city: '',
                    country: '',
                    website: '',
                    email: '',
                    mobile: '',
                    registration_number: '',
                },
            }
        },
        methods: {

            loadBranches: function () {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/branches')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.pharmacy_branches = res.data.results;
                            console.info(this.pharmacy_branches);
                            this.initializers();
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
            selectAllBranches: function (event) {
                if (event.target.checked){
                    for ( let l = 0; l < this.pharmacy_branches.length; l++ ){
                        if ( this.pharmacy_branches[l].status ) {
                            this.selected_branches.push(this.pharmacy_branches[l].id);
                        }
                    }
                } else {
                    this.selected_branches = [];
                }
                console.info(this.selected_branches)
            },
            initializers: function () {
                this.total_departments = 0;
                this.total_users = 0;
                this.total_stores = 0;
                for ( let r=0; r < this.pharmacy_branches.length; r++ ){
                    this.total_departments += this.pharmacy_branches[r].departments.length;
                    this.total_users += this.pharmacy_branches[r].users.length;
                    this.total_stores += this.pharmacy_branches[r].stores.length;
                }
            },
            view_branch: function(pstore){
                Auth.setCurrentBranch(pstore);
                window.location.href = "/initialization/branch/view";
            }
        },
        mounted() {
            this.loadBranches();
        }
    }
</script>

<style lang="scss">
    @import '../../../../../../../node_modules/vue-awesome-notifications/dist/styles/style';
</style>