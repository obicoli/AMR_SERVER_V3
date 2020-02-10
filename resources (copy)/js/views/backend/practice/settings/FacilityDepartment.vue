<template>

    <div>

        <loading :is-loading="processing"></loading>

        <top-nav-bar></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">
            <div class="row">
                <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                    <side-bar-settings :scrollable="false" :width="true" :transparent="true" :active_num="3"></side-bar-settings>
                </div>
                <div class="col-md-10 col-lg-10 col-sm-10 padding-left-0">
                    <div class="settings-header main-heading">Facility Departments</div>
                    <div class="ui fitted divider"></div>
                    <div class="row justify-content-center mg-top-30">
                        <div class="col-lg-11 col-md-11">
                            <div class="box border-top-0 border-bottom-0 border-radius-0" id="print-section">
                                <div class="box-header box-header-custom">
                                    <div class="pull-left pull width-30-pc">
                                        <select required v-bind:class="{'form-control selectpicker bg-white height-36 border-radius-2 border-ccc':true}" data-live-search="true" style="width: 100%;">
                                            <option value="">search department</option>
                                        </select>
                                    </div>
                                    <div class="pull pull-right width-70-pc">
                                        <div class="filters width-100-pc">
                                            <div class="filter-block form-inline pull-right text-right">
                                                <div class="filter-group input-group">
                                                    <span data-toggle="modal" data-target="#new_department_modal" class="filter"><i class="fa fa-plus"></i> Add</span>
                                                    <span data-toggle="modal" data-target="#upload_brand_modal" class="filter"><i class="fa fa-upload"></i> Upload CSV</span>
                                                    <span @click="export_to_csv" class="filter"><i class="fa fa-file-excel-o"></i> Export</span>
                                                    <span @click="printThis('category_box_body')" class="filter"><i class="fa fa-print"></i> Print</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body bg-white padding-0">
                                    <table class="items table table-bordered table-hover table-p-5">
                                        <thead>
                                        <tr>
                                            <th style="width: 10%">#ID</th>
                                            <th style="width: 20%">Department</th>
                                            <th style="width: 40%">Description</th>
                                            <th style="width: 15%">Status</th>
                                            <th style="width: 15%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="noprintclass">
                                        <tr v-if="pharmacy_departments.length > 0" v-for="(pstore,index) in pharmacy_departments">
                                            <td>{{index + 1}}</td>
                                            <td>{{pstore.name}}</td>
                                            <td>{{pstore.description}}</td>
                                            <td>
                                                <span v-if="pstore.status==='1'"><i class="sub-icon-settings fa fa-circle-o cl-success"></i>&nbsp; &nbsp; Active</span>
                                                <span v-if="pstore.status==='0'"><i class="sub-icon-settings fa fa-circle-o cl-danger"></i>&nbsp;&nbsp; Inactive</span>
                                            </td>
                                            <td class="text-right">
                                                <a data-toggle="modal" :data-target="'#edit_department_modal_'+index" data-easein="slideUpIn" title="View details" class="cl-444 showOnHover"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp
                                                <div class="modal fade" :id="'edit_department_modal_'+index">
                                                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                                                        <department-modal v-if="page_loaded" :form_data="pstore" :item_id="pstore.id" :initial_ur="initial_url" :branch_id="branch_id" v-on:departmentAdded="load_department" :user_mode="'Edit'"></department-modal>
                                                    </div>
                                                </div> <!-- Bootstrap model  ends-->
                                                <a data-toggle="modal" :data-target="'#delete_department_modal_'+index" data-easein="slideUpIn" title="View details" class="cl-red showOnHover"><i class="fa fa-trash-o"></i></a>&nbsp;&nbsp;&nbsp
                                                <div class="modal fade" :id="'delete_department_modal_'+index">
                                                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                                                        <delete-stuff-modal :modal_title="'Delete Department'" :confirm_message="'Are you sure?'" :item_url="initial_url+'/'+pstore.id" v-on:deletionSuccessful="load_department"></delete-stuff-modal>
                                                    </div>
                                                </div> <!-- Bootstrap model  ends-->
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
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal fade" data-easein="slideUpIn" id="new_department_modal">
                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                    <department-modal v-if="page_loaded" :form_data="department_form" :initial_ur="initial_url" :branch_id="branch_id" v-on:departmentAdded="load_department" :user_mode="'Create'"></department-modal>
                </div>
            </div> <!-- Bootstrap model  ends-->
        </div>

    </div>
    
</template>

<script>
    import SideBar from "../partials/sidebars/SideBar"
    import TopNavBar from "../partials/topbars/TopNavBar"
    import SideBarSettings from "../partials/sidebars/SideBarSettings"
    import DepartmentModal from "../../pharmacy/initialization/branches/partials/DepartmentModal"
    import {get} from "../../../../helpers/api";
    import AppInfo from "../../../../helpers/config";
    import Loading from "../../../../components/loads/ProgRess";
    import Auth from "../../../../store/auth";
    import DeleteStuffModal from '../../pharmacy/patials/DeleteStuffModal'
    import {createHtmlErrorString} from "../../../../helpers/functionmixin";
    export default {
        name: "FacilityDepartment",
        components: {TopNavBar, SideBar,SideBarSettings,DepartmentModal,Loading,DeleteStuffModal},
        data(){
            return {
                pharmacy_departments: [],
                initial_url: '/api/practices/departments',
                branch_id: '',
                processing: false,
                page_loaded: false,
                department_form: {
                    name: '',
                    description: '',
                    branch_id: '',
                    status: '',
                }
            }
        },
        methods: {
            load_department(){
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.branch_id+'/Departments')
                    .then((res) => {
                        this.brands = [];
                        if(res.data.status_code === 200) {
                            this.pharmacy_departments = res.data.results.resources;
                            //console.info(this.pharmacy_departments);
                            this.prod_loaded = true;
                        }
                        this.processing = false;
                    }).catch((err) => {
                    this.processing = false;
                });
            },
            printThis(ele_id){
                //print_divs(ele_id)
            },
            export_to_csv(){
                //exportToCsv(this.categories,'Brand List')
            },
        },
        mounted() {
            this.current_branch = Auth.getCurrentBranch();
            this.branch_id = this.current_branch.id;
            this.load_department();
            this.page_loaded = true;
        }
    }
</script>

<style lang="scss">
    @import '../../../../../../node_modules/vue-awesome-notifications/dist/styles/style';
</style>