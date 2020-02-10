<template>
    <div data-component="sidebar">
        <div class="sidebar">
            <ul class="list-group flex-column d-inline-block first-menu scrollable-menu padding-bottom-100">
                <li v-if="has_permission(true,'Calendar')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-calendar-o" aria-hidden="true"><span class="ml-2 align-middle">Calendar</span></i></a>
                    <ul class="list-group flex-column d-inline-block submenu submenu-custom">
                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Calendar</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Add Schedule</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Schedule List</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Add Appointment</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Appointment List</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Add Teleconsult</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Teleconsult List</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Calendar</a>
                        </li>
                    </ul>
                </li>

                <li v-if="has_permission(true,'Patient')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-wheelchair" aria-hidden="true"><span class="ml-2 align-middle">Patients</span></i></a>
                    <ul class="list-group flex-column d-inline-block submenu submenu-custom">
                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Patients</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Add Patient</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Patient List</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Add Document</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Document List</a>
                        </li>
                    </ul>
                </li>

                <li v-if="has_permission(true,'Doctors')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-user-md" aria-hidden="true"><span class="ml-2 align-middle">Doctors</span></i></a>
                    <ul class="list-group flex-column d-inline-block submenu submenu-custom">
                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Doctors</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Add Doctor</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Doctor List</a>
                        </li>
                    </ul>
                </li>

                <li v-if="has_permission(true,'Department')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-user-md" aria-hidden="true"><span class="ml-2 align-middle">Departments</span></i></a>
                    <ul class="list-group flex-column d-inline-block submenu submenu-custom">
                        <li class="list-group-item items-lists pl-4">
                            <router-link :to="DEPARTMENTS_WEB_ROUTES.DEPARTMENTS" class="">Add Department</router-link>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <router-link :to="DEPARTMENTS_WEB_ROUTES.DEPARTMENTS" class="">Department List</router-link>
                        </li>
                    </ul>
                </li>

                <li v-if="has_permission(true,'Medical Records')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-laptop" aria-hidden="true"><span class="ml-2 align-middle">EMR</span></i></a>
                    <ul class="list-group flex-column d-inline-block submenu submenu-custom">
                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Medical Records</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Prescriptions</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Clinical Notes</a>
                        </li>
                    </ul>
                </li>

                <li v-if="has_permission(true,'Inventory')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-database" aria-hidden="true"><span class="ml-2 align-middle">Inventory</span></i></a>
                    <side-bar-inventory :customer="true" :product="true" :supplier="true" :scrollable="true" :width="false"></side-bar-inventory>
                </li>

                <li v-if="has_permission(true,'Accounting')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-briefcase" aria-hidden="true"><span class="ml-2 align-middle">Accounting</span></i></a>
                    <side-bar-accounting :scrollable="true" :width="false"></side-bar-accounting>
                </li>

                <li v-if="has_permission(true,'Insurance')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-shield" aria-hidden="true"><span class="ml-2 align-middle">Insurance</span></i></a>
                    <ul class="list-group flex-column d-inline-block submenu submenu-custom">
                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Insurance</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Add Insurance</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Insurance List</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="menu-title">Add Limit Approval</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="menu-title">Limit Approval List</a>
                        </li>
                    </ul>
                </li>

                <li v-if="has_permission(true,'Billing')" class="list-group-item pl-3 py-2">
                    <a href=""><i class="fa fa-calculator" aria-hidden="true"><span class="ml-2 align-middle">Billing</span></i></a>
                    <side-bar-bill></side-bar-bill>
                </li>

                <li v-if="has_permission(true,'Calendar')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-users" aria-hidden="true"><span class="ml-2 align-middle">Human Resource</span></i></a>
                    <side-bar-hr></side-bar-hr>
                </li>

                <li v-if="has_permission(true,'Bed Manager')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-bed" aria-hidden="true"><span class="ml-2 align-middle">Bed Manager</span></i></a>
                    <ul class="list-group flex-column d-inline-block submenu submenu-custom">
                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Bed Manager</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Add Bed</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Bed List</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Bed Assign</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="menu-title">Bed Assign List</a>
                        </li>

                    </ul>
                </li>

                <li v-if="has_permission(true,'Noticeboard')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-bell-o" aria-hidden="true"><span class="ml-2 align-middle">Noticeboard</span></i></a>
                    <ul class="list-group flex-column d-inline-block submenu submenu-custom">
                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Noticeboard</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Add Notice</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Notice List</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Bed Assign</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="menu-title">Bed Assign List</a>
                        </li>

                    </ul>
                </li>

                <li v-if="has_permission(true,'Case Manager')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-heart-o" aria-hidden="true"><span class="ml-2 align-middle">Case manager</span></i></a>
                    <ul class="list-group flex-column d-inline-block submenu submenu-custom">
                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Case manager</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Add Patient</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Patient List</a>
                        </li>

                    </ul>
                </li>

                <li v-if="has_permission(true,'Hospital Activity')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-hospital-o" aria-hidden="true"><span class="ml-2 align-middle">Facility Activities</span></i></a>
                    <ul class="list-group flex-column d-inline-block submenu submenu-custom">

                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Birth</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Add Birth Report</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Birth Report</a>
                        </li>

                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Death</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Add Death Report</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Death Report</a>
                        </li>

                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Operation</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Add Operation Report</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Operation Report</a>
                        </li>

                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Investigation</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Add Report</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Investigation Report</a>
                        </li>

                    </ul>
                </li>

                <li v-if="has_permission(true,'Inquiry')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-question-circle-o" aria-hidden="true"><span class="ml-2 align-middle">Inquiry</span></i></a>
                    <ul class="list-group flex-column d-inline-block submenu submenu-custom">
                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Inquiry</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Inquiry</a>
                        </li>
                    </ul>
                </li>

                <li v-if="has_permission(true,'Treatment Communication')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-bell" aria-hidden="true"><span class="ml-2 align-middle">Treatment Communication</span></i></a>
                    <ul class="list-group flex-column d-inline-block submenu submenu-custom">
                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Notification</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Overview</a>
                        </li>
                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">SMS</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">SMS Template</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Auto SMS Report</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">User SMS List</a>
                        </li>
                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Mail</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Send mail</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Inbox</a>
                        </li>
                    </ul>
                </li>

                <li v-if="has_permission(true,'Administrative')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-cog" aria-hidden="true"><span class="ml-2 align-middle">Adminstrative</span></i></a>
                    <side-bar-settings :scrollable="true" :width="false"></side-bar-settings>
                </li>

                <li v-if="has_permission(true,'Reports')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-balance-scale" aria-hidden="true"><span class="ml-2 align-middle">Reports</span></i></a>
                    <ul class="list-group flex-column d-inline-block submenu submenu-custom">
                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Reports</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Sales Report</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Return Report</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Brand Report</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="menu-title">Section Report</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Storewise Report</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Company wise</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">SKU wise</a>
                        </li>
                    </ul>
                </li>

                <li v-if="has_permission(true,'Reports')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-book" aria-hidden="true"><span class="ml-2 align-middle">Documentation</span></i></a>
                    <ul class="list-group flex-column d-inline-block submenu submenu-custom">
                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Reports</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Sales Report</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Return Report</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Brand Report</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="menu-title">Section Report</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Storewise Report</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Company wise</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">SKU wise</a>
                        </li>
                    </ul>
                </li>

            </ul> <!-- /.first-menu -->
        </div> <!-- /.sidebar -->
    </div>
</template>

<script>
    import SideBarSettings from "./SideBarSettings";
    import SideBarHr from "./SideBarHr";
    import SideBarBill from "./SideBarBill";
    import SideBarAccounting from "./SideBarAccounting";
    
    //Inventory Based side bars starts here
    import SideBarInventory from "./inventory/SideBarInventory";
    //Inventory Based side bars ends here

    import Auth from '../../../../../store/auth';
    import {INVENTORY_WEB_ROUTES,DEPARTMENTS_WEB_ROUTES} from '../../../../../router/web_routes';
    export default {
        name: "SideBar",
        components:{
            SideBarInventory,
            SideBarSettings,
            SideBarHr,
            SideBarBill,
            SideBarAccounting
        },
        data(){
            return{
                INVENTORY_WEB_ROUTES:INVENTORY_WEB_ROUTES,
                DEPARTMENTS_WEB_ROUTES: DEPARTMENTS_WEB_ROUTES,
            }
        },
        methods: {
            has_permission(outer_level, inner_level){
                return Auth.setMenu(outer_level,inner_level);
            },
            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },
        mounted(){
        }
    }
</script>

<style scoped>
    [data-component='sidebar'] .first-menu {
        background-color: #c00e2d!important;
    }
    [data-component='sidebar'] .first-menu .list-group-item:hover {
        background-color: #f0f0f5;
    }
    [data-component='sidebar'] .first-menu .list-group-item:hover a {
        color: #444!important;
    }
</style>
