<template>

    <div>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <moduled-side-bar></moduled-side-bar>

        <div class="wp-content mg-top-0">
            
            <div class="row">

                <div class="col-lg-12">


                    <section class="content bg-greyish min-height-100-vh">

                        <div class="mg-top-50 width-100-pc">

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <router-link :to="INVENTORY_WEB_ROUTES.SCM_WORKSPACE" class="text-center">
                                        <img src="/assets/icons/dashboard/supply.png">
                                    </router-link>
                                </div>
                                <p class="text-center">Supply Chain</p>
                            </div>

                            <!-- <div v-if="has_permission(true,'Calendar')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/calendar.png">
                                    </a>
                                </div>
                                <p class="text-center">Appointment</p>
                            </div>

                            <div v-if="has_permission(true,'Department')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/calendar.png">
                                    </a>
                                </div>
                                <p class="text-center">Proceedure Room</p>
                            </div>

                            <div v-if="has_permission(true,'Patient')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/patient_reg_480.png">
                                    </a>
                                </div>
                                <p class="text-center">Patient Registration</p>
                            </div>

                            <div v-if="has_permission(true,'Accounting')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <router-link :to="ACCOUNTING_WEB_ROUTES.DASHBOARD" class="text-center">
                                        <img src="/assets/icons/dashboard/accounting-512.png">
                                    </router-link>
                                </div>
                                <p class="text-center">Accounting Integration</p>
                            </div>

                            <div v-if="has_permission(true,'Patient')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/hospital-bed-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Outpatient Management</p>
                            </div>

                            <div v-if="has_permission(true,'Patient')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/stethoscope-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Health Checkup</p>
                            </div>

                            <div v-if="has_permission(true,'Department')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/siren-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Emergency</p>
                            </div>

                            <div v-if="has_permission(true,'Department')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/test-tube-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Laboratory</p>
                            </div>

                            <div v-if="has_permission(true,'Department')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/skeleton-filled-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Radiodology</p>
                            </div>

                            <div v-if="has_permission(true,'Patient')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/hospital-bed-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Inpatient Management</p>
                            </div>

                            <div v-if="has_permission(true,'Billing')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/billing-machine-400.png">
                                    </a>
                                </div>
                                <p class="text-center">Inpatient Billing</p>
                            </div>

                            <div v-if="has_permission(true,'Department')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/nurse-female-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Nurse Station</p>
                            </div>

                            <div v-if="has_permission(true,'Department')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/theatre-curtain-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Operation Theatre</p>
                            </div>

                            <div v-if="has_permission(true,'Department')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/drop-of-blood-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Blood Bank</p>
                            </div>

                            <div v-if="has_permission(true,'Department')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/organ-transplantation-400.png">
                                    </a>
                                </div>
                                <p class="text-center">Doctor Review</p>
                            </div>

                            <div v-if="has_permission(true,'Department')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/pie-chart-480.png">
                                    </a>
                                </div>
                                <p class="text-center">MIS Reports</p>
                            </div>

                            <div v-if="has_permission(true,'Doctor')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/medical-doctor-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Doctor Management</p>
                            </div>

                            <div v-if="has_permission(true,'Department')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="/pharmacy" class="text-center">
                                        <img src="/assets/icons/dashboard/hand-with-a-pill-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Pharmacy</p>
                            </div>

                            <div v-if="has_permission(true,'Department')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/warehouse-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Store Management</p>
                            </div>

                            <div v-if="has_permission(true,'Department')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/clinic-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Practice Management</p>
                            </div>

                            <div v-if="has_permission(true,'Inventory')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a :href="INVENTORY_WEB_ROUTES.INV_REPORTS" class="text-center">
                                        <img src="/assets/icons/dashboard/erp-system-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Inventory Report</p>
                            </div>

                            <div v-if="has_permission(true,'Inventory') && current_facility.category==='Main'" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a :href="INVENTORY_WEB_ROUTES.INV_INVENTORY" class="text-center">
                                        <img src="/assets/icons/dashboard/settings-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Inventory</p>
                            </div>
                            <div v-if="has_permission(true,'Inventory') && current_facility.category==='Branch'" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a :href="INVENTORY_WEB_ROUTES.INV_STOCK" class="text-center">
                                        <img src="/assets/icons/dashboard/settings-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Inventory</p>
                            </div>

                            <div v-if="has_permission(true,'Department')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/calendar.svg">
                                    </a>
                                </div>
                                <p class="text-center">OP Clinical Management</p>
                            </div>

                            <div v-if="has_permission(true,'Department')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/mortar-and-pestle-480.png">
                                    </a>
                                </div>
                                <p class="text-center">CSSD</p>
                            </div>

                            <div v-if="has_permission(true,'Department')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/poor-quality-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Feedback Management</p>
                            </div>

                            <div v-if="has_permission(true,'Insurance')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/treatment-list-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Insurance & Claims</p>
                            </div>

                            <div v-if="has_permission(true,'Human Resource')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/crowd-480.png">
                                    </a>
                                </div>
                                <p class="text-center">HR Management</p>
                            </div>

                            <div v-if="has_permission(true,'Department')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/survey-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Discharge Summary</p>
                            </div>

                            <div v-if="has_permission(true,'Department')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/ambulance-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Ambulance Management</p>
                            </div>

                            <div v-if="has_permission(true,'Hospital Activity')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/lifecycle-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Birth Management</p>
                            </div>

                            <div v-if="has_permission(true,'Hospital Activity')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/die-in-bed-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Mortuary Management</p>
                            </div>

                            <div v-if="has_permission(true,'Hospital Activity')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/doctors-folder-480.png">
                                    </a>
                                </div>
                                <p class="text-center">EMR</p>
                            </div>

                            <div v-if="has_permission(true,'Hospital Activity')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/video-message-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Telemedicine Management</p>
                            </div>

                            <div v-if="has_permission(true,'Hospital Activity')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/overtime-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Schedule</p>
                            </div>

                            <div v-if="has_permission(true,'Hospital Activity')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/calendar-22-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Calendar</p>
                            </div>

                            <div v-if="has_permission(true,'Hospital Activity')" class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/topic-push-notification-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Treatment Notification</p>
                            </div> -->

                        </div>

                    </section>

                </div>

            </div>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <copy-right></copy-right>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import ModuledSideBar from "../partials/sidebars/ModuledSideBar";
    import TopNavBar from "../partials/topbars/TopNavBar";
    import CopyRight from "../partials/CopyRight";
    //import SideBarHr from "../partials/sidebars/SideBarHr";
    //import ProcessingOverlay from "../../../progress/ProcessingOverlay";
    import DeleteModal from '../../practice/partials/modals/DeleteModal';
    import ViewProductItemModal from '../../pharmacy/product/partials/ViewProductItemModal';
    import ProductModal from '../../practice/partials/modals/product/ProductModal';
    import {get} from "../../../../helpers/api";
    // import AppInfo from "../../../../helpers/config";
    import Auth from "../../../../store/auth";
    import {formatMoney,removeElement} from "../../../../helpers/functionmixin";
    import {INVENTORY_WEB_ROUTES,ACCOUNTING_WEB_ROUTES} from "../../../../router/web_routes";
    import {PURCHASES_ATTRIBUTES_URL} from "../../../../router/api_routes";

    export default {
        name: "Home",
        components: {TopNavBar,ProductModal,DeleteModal,
        ViewProductItemModal,ModuledSideBar,CopyRight},
        data(){
            return {
                initialUrl: '/api/practices/products/items',
                initializations: {},
                practice_product_items: [],
                prod_loaded: false,
                practice_id: '',
                is_page_ready: false,
                progress_overlay: 'hide',
                product_list_filters: [],
                active_filter: 0,
                current_facility: {},
                search_message: 'You dont have any product item in your inventory',
                INVENTORY_WEB_ROUTES:INVENTORY_WEB_ROUTES,
                ACCOUNTING_WEB_ROUTES:ACCOUNTING_WEB_ROUTES
            }
        },
        created(){
            //console.info(Auth.setMenu());
            //Auth.remove();
        },
        methods: {

            loadProducts(load_type){
                this.progress_overlay = "show";
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/'+load_type)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        //this.practice_product_items = res.data.results;
                        //this.loadProductType();
                        this.initializations.product_items = res.data.results;
                        this.practice_product_items = this.initializations.product_items;
                        this.progress_overlay = "hide";
                        if( this.practice_product_items.length < 1 ){
                            this.search_message = 'You dont have any '+load_type+' in your inventory';
                        }
                        //console.info(res.data.results);
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            has_permission(outer_level, inner_level){
                return Auth.setMenu(outer_level,inner_level);
            },

            filter_method(index_to,item_type_id,item_type_name){
                this.active_filter = index_to;
                switch(item_type_name){
                    case "All":
                        this.loadInitializations();
                        break;
                    default:
                        this.loadProducts(item_type_name);
                        break;
                }
            },

            loadInitializations(){
                this.progress_overlay = "show";
                get(PURCHASES_ATTRIBUTES_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.initializations = res.data.results;
                        //this.loadProductType();
                        //console.info(this.initializations);
                        this.practice_product_items = this.initializations.product_items;
                        this.product_list_filters = this.initializations.product_types;
                        this.is_page_ready = true;
                        this.prod_loaded = true;
                        this.progress_overlay = "hide";
                        //this.loadProducts();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },
            
            format_money(money_to){
                return formatMoney(money_to);
            },

            delete_item(item_to){
                this.initializations.product_items = removeElement(this.initializations.product_items,item_to);
                this.practice_product_items = this.initializations.product_items;
            }

        },
        mounted(){
            this.current_facility = Auth.getCurrentAccount('clinic');
            if(this.current_facility.category==="Branch"){
                window.location.href = "/inventory/stock";
            }
            this.practice_id = Auth.getCurrentAccount('id');
            //this.loadInitializations();
        }
    }
</script>

<style scoped>

</style>