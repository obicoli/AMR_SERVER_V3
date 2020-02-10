<template>

    <div>

        <processing-overlay :message="msg" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true" :bg_f7="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content mg-top-50 content-calculated-height-wc">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo content-calculated-height-wc">
                            <sidebar-banking v-if="page_ready" :supplier="true" :scrollable="true" :width="true" :transparent="true" :active_num="'banks'" :title="'Banking'"></sidebar-banking>
                        </div>
                        <div class="col-md-9 col-lg-9 col-sm-9 padding-right-0 padding-left-0 bg-white content-calculated-height-wc">
                            <div class="settings-header shadowed main-heading bg-white min-height-68 bottom-border top-border">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div v-if="selected_banks.length>0" class="pull pull-left mg-top-10">
                                            <div class="padding-right-10 min-height-30 width-100-pc">
                                                <a class="fs-14 cl-ccc">{{selected_banks.length}} Bank(s) selected</a>
                                            </div>
                                        </div>
                                        <div v-else class="btn-group" role="group" aria-label="Button group">
                                            <div class="btn-group" role="group">
                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle fs-14 pointer-cursor fw-600 txt-uppercase" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    List of Bank Institutions
                                                </a>
                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                    <a class="dropdown-item txt-uppercase cl-777 fs-12">Default Filters</a>
                                                    <a class="dropdown-item pointer-cursor">All Payments</a>
                                                    <a class="dropdown-item separator"></a>
                                                    <a class="dropdown-item pointer-cursor">New Custom view</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed padding-right-20 content-calculated-height-110 top-68">
                                
                                <div class="page-content bg-white padding-0 mg-right-0 mg-left-0">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-12 bg-white border-bottom padding-right-11">
                                                
                                                <div class="width-100-pc float-left mg-top-20 mg-bottom-10">
                                                    <div class="width-40-pc float-left">
                                                    </div>
                                                    <div class="width-40-pc float-right text-right">
                                                        <a data-toggle="modal" data-target="#create_new_bank_modal" class="btn btn-inventory btn-amref cl-white float-right">
                                                            Add a Bank
                                                        </a>
                                                    </div>
                                                </div>
                                                <table class="table banking table-hover mg-left-5 mg-bottom-20">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:2%;">
                                                                <input type="checkbox" class="pointer-cursor" @click="check_all($event)">
                                                            </th>
                                                            <th style="width:19%;">Name</th>
                                                            <th style="width:15%;">Code</th>
                                                            <th style="width:30%;">Description</th>
                                                            <th style="width:14%;">Phone</th>
                                                            <th style="width:14%;">Email</th>
                                                            <th style="width:6%;">
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr v-if="banks.length===0">
                                                            <td colspan="7" class="cl-amref text-center fs-14">No bank to display! <a data-toggle="modal" data-target="#create_new_bank_modal" class="cl-blue-link pointer-cursor txt-deco-underline">Create Here</a></td>
                                                        </tr>
                                                        <tr v-for="(bank,index) in banks" :key="'element_key_'+index">
                                                            <td>
                                                                <input type="checkbox" class="pointer-cursor" v-model="selected_banks" :value="bank.id">
                                                            </td>
                                                            <td>
                                                                <a data-toggle="modal" :data-target="'#edit_bank_'+index" class="cl-blue-link fw-600 pointer-cursor txt-deco-underline">{{bank.name}}</a>
                                                            </td>
                                                            <td>{{bank.code}}</td>
                                                            <td>{{bank.description}}</td>
                                                            <td>{{bank.phone}}</td>
                                                            <td>{{bank.email}}</td>
                                                            <td>
                                                                <a data-toggle="modal" :data-target="'#edit_bank_'+index" class="showOnHover pointer-cursor" title="Edit"><i class="fa fa-pencil-square-o"></i></a>&nbsp;&nbsp;
                                                                <a data-toggle="modal" :data-target="'#delete_bank_'+index" class="showOnHover cl-amref pointer-cursor" title="Delete"><i class="fa fa-trash-o"></i></a>
                                                            </td>
                                                            <delete-modal v-on:deletionSuccessful="loadBanks(false)" :modal_id="'delete_bank_'+index" :item_url="bank_api+'/'+bank.id" :confirm_message="'Are you sure?'" :modal_title="'Delete Bank'"></delete-modal>
                                                            <bank-modal :modal_id="'edit_bank_'+index" :form_data="bank" :user_mode="'Edit'" :bank_api="bank_api+'/'+bank.id" v-on:bankEdited="loadBanks" :title="'Edit Bank Institution'"></bank-modal>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <bank-modal :modal_id="'create_new_bank_modal'" :user_mode="'Create'" :bank_api="bank_api" v-on:bankCreated="loadBanks" :title="'New Bank Institution'"></bank-modal>
                                            
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    import SideBarInventory from "../../partials/sidebars/inventory/SideBarInventory";
    import SidebarBanking from "../../partials/sidebars/supplychain/SidebarBanking";
    import EditUserModal from "../../partials/modals/users/EditUserModal";
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import DeleteModal from "../../partials/modals/DeleteModal";
    import BankModal from "../../partials/modals/accounting/BankModal";
    import BankBranchModal from "../../partials/modals/accounting/BankBranchModal";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import {removeElement,paginator,formatMoney} from "../../../../../helpers/functionmixin";
    import {PROCESS_STATUS} from "../../../../../helpers/process_status";
    import {BANKING_BANKS_URL} from '../../../../../router/api_routes';
    export default {
        name: "Index",
        components: {TopNavBar,CommonLinks,SideBar,BankBranchModal,
        DeleteModal,DeleteModal,PaginateTemplate,BankModal,SidebarBanking,
        ProcessingOverlay,SideBarInventory},
        data(){
            return {
                PROCESS_STATUS: PROCESS_STATUS,
                banks: [],
                selected_banks: [],
                msg: 'Loading. Please wait...',
                progress_overlay: 'hide',
                page_ready: false,
                pagination: paginator(),
                bank_api: BANKING_BANKS_URL,
            }
        },
        methods: {

            format_Money(money_to){
                return formatMoney(money_to);
            },

            check_status(array_to,pin_to){
                let result = null;
                for (let index = 0; index < array_to.length; index++) {
                    const element = array_to[index];
                    if(element.status === pin_to){
                        result = element.date;
                        break;
                    }
                }
                return result;
            },

            check_all(event){
                this.selected_banks = [];
                if(event.target.checked){
                    for (let index = 0; index < this.banks.length; index++) {
                        const element = this.banks[index];
                        this.selected_banks.push(element.id);
                    }
                }else{
                    this.selected_banks = [];
                }
            },

            reload_suppliers(supplier){
                this.suppliers.concat(supplier);
            },

            loadBanks(show_progress){
                this.progress_overlay = "hide";
                if(show_progress){this.progress_overlay = "show";}
                get(this.bank_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.banks = res.data.results;
                        this.progress_overlay = "hide";
                        this.page_ready = true;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                });
            },

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }

        },
        mounted() {
            this.loadBanks(true);
            //this.page_ready = true;
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>