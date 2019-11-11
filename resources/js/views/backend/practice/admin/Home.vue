<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content mg-top-0">
            
            <div class="row">

                <div class="col-lg-12">


                    <section class="content bg-greyish min-height-100-vh">

                        <div class="mg-top-50 width-100-pc">

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/calendar.png">
                                    </a>
                                </div>
                                <p class="text-center">Appointment</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/calendar.png">
                                    </a>
                                </div>
                                <p class="text-center">Proceedure Room</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/patient_reg_480.png">
                                    </a>
                                </div>
                                <p class="text-center">Patient Registration</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/accounting-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Accounting Integration</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/hospital-bed-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Outpatient Management</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/stethoscope-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Health Checkup</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/siren-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Emergency</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/test-tube-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Laboratory</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/skeleton-filled-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Radiodology</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/hospital-bed-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Inpatient Management</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/billing-machine-400.png">
                                    </a>
                                </div>
                                <p class="text-center">Inpatient Billing</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/nurse-female-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Nurse Station</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/theatre-curtain-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Operation Theatre</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/drop-of-blood-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Blood Bank</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/organ-transplantation-400.png">
                                    </a>
                                </div>
                                <p class="text-center">Doctor Review</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/pie-chart-480.png">
                                    </a>
                                </div>
                                <p class="text-center">MIS Reports</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/medical-doctor-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Doctor Management</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="/pharmacy" class="text-center">
                                        <img src="/assets/icons/dashboard/hand-with-a-pill-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Pharmacy</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/warehouse-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Store Management</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/clinic-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Practice Management</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="/svs/dashboard" class="text-center">
                                        <img src="/assets/icons/dashboard/erp-system-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Inventory SVS</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="/inventory/items" class="text-center">
                                        <img src="/assets/icons/dashboard/settings-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Inventory</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/calendar.svg">
                                    </a>
                                </div>
                                <p class="text-center">OP Clinical Management</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/mortar-and-pestle-480.png">
                                    </a>
                                </div>
                                <p class="text-center">CSSD</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/poor-quality-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Feedback Management</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/treatment-list-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Insurance & Claims</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/crowd-480.png">
                                    </a>
                                </div>
                                <p class="text-center">HR Management</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/survey-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Discharge Summary</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/ambulance-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Ambulance Management</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/lifecycle-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Birth Management</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/die-in-bed-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Mortuary Management</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/doctors-folder-480.png">
                                    </a>
                                </div>
                                <p class="text-center">EMR</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/video-message-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Telemedicine Management</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/overtime-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Schedule</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/calendar-22-512.png">
                                    </a>
                                </div>
                                <p class="text-center">Calendar</p>
                            </div>

                            <div class="dashboard-icons-content text-center">
                                <div class="dashboard-icons text-center">
                                    <a href="" class="text-center">
                                        <img src="/assets/icons/dashboard/topic-push-notification-480.png">
                                    </a>
                                </div>
                                <p class="text-center">Treatment Notification</p>
                            </div>

                        </div>

                    </section>

                </div>

            </div>
        </div>

    </div>
</template>

<script>
    import SideBar from "../partials/sidebars/SideBar"
    import TopNavBar from "../partials/topbars/TopNavBar"
    import SideBarHr from "../partials/sidebars/SideBarHr"
    import ProcessingOverlay from "../../../progress/ProcessingOverlay";
    import DeleteModal from '../../practice/partials/modals/DeleteModal'
    import ViewProductItemModal from '../../pharmacy/product/partials/ViewProductItemModal'
    import ProductModal from '../../practice/partials/modals/product/ProductModal'
    import {get} from "../../../../helpers/api";
    import AppInfo from "../../../../helpers/config";
    import Auth from "../../../../store/auth";
    import {formatMoney,removeElement} from "../../../../helpers/functionmixin";

    export default {
        name: "Home",
        components: {TopNavBar, SideBar,SideBarHr,ProductModal,ProcessingOverlay,DeleteModal,ViewProductItemModal},
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
                search_message: 'You dont have any product item in your inventory',
            }
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
                        console.info(res.data.results);
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
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
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Items Page Initialization')
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.initializations = res.data.results.resources;
                        //this.loadProductType();
                        console.info(this.initializations);
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
            this.practice_id = Auth.getCurrentAccount('id');
            this.loadInitializations();
        }
    }
</script>

<style scoped>

</style>