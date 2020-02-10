<template>

    <div>

        <processing-overlay :message="msg" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true" :bg_f7="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content mg-top-50 content-calculated-height-wc">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="row">

                        <div class="col-md-12 col-lg-12 col-sm-12 padding-right-0 padding-left-0 bg-ced content-calculated-height-wc">

                            <div class="box box-primary bg-ced border-top-0 border-bottom-0 no-shadowed padding-right-20 content-calculated-height-110 top-20">
                                
                                <div class="page-content bg-ced padding-0 mg-right-0 mg-left-0 min-height-100-vh">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        <div class="row justify-content-center">
                                            <div class="col-md-10 col-lg-10 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left">
                                                    <a class="fw-600 cl-444 fs-20">
                                                        List of Bank Institutions
                                                    </a>
                                                </div>
                                                <div class="width-100-pc float-left mg-top-20">

                                                    <div class=" width-30-pc mg-bottom-10 float-left">
                                                        <input placeholder="Search by name" @keyup="searchAccount($event)" class="width-100-pc" type="text">
                                                    </div>

                                                    <div class=" width-40-pc mg-bottom-10 float-right text-right">
                                                        <div class="btn-group float-right" role="group">
                                                            <button :disabled="is_initializing || processing" :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Add a Bank
                                                            </button>
                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                <a data-toggle="modal" data-target="#create_new_bank_modal" class="dropdown-item pointer-cursor">Add a Bank</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="width-100-pc float-left mg-top-30">
                                                        <table class="table banking-transaction table-hover mg-bottom-20">
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
                                                            <tbody v-if="is_initializing">
                                                                <tr>
                                                                    <td class="somepad text-center" colspan="7">
                                                                        <img src="/assets/icons/dashboard/loader.gif">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody v-else>
                                                                <tr v-if="banks.length===0">
                                                                    <td colspan="7" class="cl-amref text-center fs-14">No bank to display! <a data-toggle="modal" data-target="#create_new_bank_modal" class="cl-blue-link pointer-cursor txt-deco-underline">Create Here</a></td>
                                                                </tr>
                                                                <tr v-for="(bank,index) in banks" :key="'element_key_'+index">
                                                                    <td class="somepad">
                                                                        <input type="checkbox" class="pointer-cursor" v-model="selected_banks" :value="bank.id">
                                                                    </td>
                                                                    <td class="somepad">
                                                                        <a data-toggle="modal" :data-target="'#edit_bank_'+index" class="cl-blue-link fw-600 pointer-cursor txt-deco-underline">{{bank.name}}</a>
                                                                    </td>
                                                                    <td class="somepad">{{bank.code}}</td>
                                                                    <td class="somepad">{{bank.description}}</td>
                                                                    <td class="somepad">{{bank.phone}}</td>
                                                                    <td class="somepad">{{bank.email}}</td>
                                                                    <td class="somepad">
                                                                        <a data-toggle="modal" :data-target="'#edit_bank_'+index" class="showOnHover pointer-cursor" title="Edit"><i class="fa fa-pencil-square-o"></i></a>&nbsp;&nbsp;
                                                                        <a data-toggle="modal" :data-target="'#delete_bank_'+index" class="showOnHover cl-amref pointer-cursor" title="Delete"><i class="fa fa-trash-o"></i></a>
                                                                    </td>
                                                                    <delete-modal v-on:deletionSuccessful="loadBanks(false)" :modal_id="'delete_bank_'+index" :item_url="bank_api+'/'+bank.id" :confirm_message="'Are you sure?'" :modal_title="'Delete Bank'"></delete-modal>
                                                                    <bank-modal :modal_id="'edit_bank_'+index" :form_data="bank" :user_mode="'Edit'" :bank_api="bank_api+'/'+bank.id" v-on:bankEdited="loadBanks" :title="'Edit Bank Institution'"></bank-modal>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <copy-right></copy-right>
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
    import CopyRight from "../../partials/CopyRight";
    import {removeElement,paginator,formatMoney} from "../../../../../helpers/functionmixin";
    import {PROCESS_STATUS} from "../../../../../helpers/process_status";
    import {BANKING_BANKS_URL} from '../../../../../router/api_routes';
    export default {
        name: "Index",
        components: {TopNavBar,CommonLinks,SideBar,BankBranchModal,CopyRight,
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