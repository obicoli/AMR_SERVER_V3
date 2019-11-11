<template>
    <div data-component="sidebar">
        <div class="sidebar">
            <ul class="list-group flex-column d-inline-block first-menu scrollable-menu padding-bottom-100">

                <li class="list-group-item pl-3 py-2" :key="'permissions_'+index">
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

                <li class="list-group-item pl-3 py-2">
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

                <li class="list-group-item pl-3 py-2">
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

                <li class="list-group-item pl-3 py-2">
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

                <li class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-database" aria-hidden="true"><span class="ml-2 align-middle">Inventory</span></i></a>
                    <ul class="list-group flex-column d-inline-block submenu submenu-custom scrollable-menu">
                        <li class="list-group-item items-lists pl-4">
                            <a href="/svs/dashboard" class="">SVS Dashboard</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="/inventory/items" class="">Product item</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="/inventory/stock" class="menu-title">Stock</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="/inventory/purchases" class="menu-title">Purchases</a>
                        </li>
                        <!-- <li class="list-group-item items-lists pl-4">
                            <a href="/inventory/requests" class="">Requests</a>
                        </li> -->
                        <li class="list-group-item items-lists pl-4">
                            <a href="/inventory/sales" class="">Sales</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="/inventory/sales" class="">Supply</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="/inventory/sales" class="">Vendors</a>
                        </li>
                        <!-- <li class="list-group-item items-lists pl-4">
                            <a href="/inventory/requests" class="">Estimates</a>
                        </li> -->
                        <li class="list-group-item items-lists pl-4">
                            <a href="/inventory/reports" class="">Reports</a>
                        </li>
                        <!-- <li class="list-group-item items-lists pl-4">
                            <a href="/inventory/settings" class="menu-title">Settings</a>
                        </li> -->
                    </ul>
                </li>

                <li class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-briefcase" aria-hidden="true"><span class="ml-2 align-middle">Accounting</span></i></a>
                    <side-bar-accounting></side-bar-accounting>
                </li>

                <li class="list-group-item pl-3 py-2">
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

                <li class="list-group-item pl-3 py-2">
                    <a href=""><i class="fa fa-calculator" aria-hidden="true"><span class="ml-2 align-middle">Billing</span></i></a>
                    <side-bar-bill></side-bar-bill>
                </li>

                <li class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-users" aria-hidden="true"><span class="ml-2 align-middle">Human Resource</span></i></a>
                    <side-bar-hr></side-bar-hr>
                </li>

                <li class="list-group-item pl-3 py-2">
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

                <li class="list-group-item pl-3 py-2">
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

                <li class="list-group-item pl-3 py-2">
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

                <li class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-hospital-o" aria-hidden="true"><span class="ml-2 align-middle">Facility Activities</span></i></a>
                    <ul class="list-group flex-column d-inline-block submenu submenu-custom">
                        
                        <!-- <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Inventory</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="/inventory/items" class="">Medicines & Products</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Stock</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Pending Stock</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Out of Stock</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Expired Stock</a>
                        </li>

                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Purchase</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Create Purchase</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Place Order</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Purchase Return</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="/inventory/purchase" class="">Purchase List</a>
                        </li>

                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Expense</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Add Expense</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Expense List</a>
                        </li> -->

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

                <li class="list-group-item pl-3 py-2">
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

                <li class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-bell" aria-hidden="true"><span class="ml-2 align-middle">Treatment Notification</span></i></a>
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

                <li class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-cog" aria-hidden="true"><span class="ml-2 align-middle">Adminstrative</span></i></a>
                    <side-bar-settings :scrollable="true" :width="false"></side-bar-settings>
                </li>

                <!-- <li class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-plus-circle" aria-hidden="true"><span class="ml-2 align-middle">Extra</span></i></a>
                    <ul class="list-group flex-column d-inline-block submenu submenu-custom">
                        <li class="list-group-item menu-title-li pl-4">
                            <a href="#" class="menu-title">Extra</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Take Backup</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Company</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Requested Item</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="menu-title">Quotation/Estimates</a>
                        </li>
                        <li class="list-group-item items-lists pl-4">
                            <a href="#" class="">Sales Receipts</a>
                        </li>
                    </ul>
                </li> -->

                <li class="list-group-item pl-3 py-2">
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

            </ul> <!-- /.first-menu -->
        </div> <!-- /.sidebar -->
    </div>
</template>

<script>
    import SideBarSettings from "./SideBarSettings";
    import SideBarHr from "./SideBarHr";
    import SideBarBill from "./SideBarBill";
    import SideBarAccounting from "./SideBarAccounting";
    import Auth from '../../../../../store/auth';
    export default {
        name: "SideBar",
        components:{SideBarSettings,SideBarHr,SideBarBill,SideBarAccounting},
        data(){
            return{
                permissions: [],
            }
        },
        mounted(){
            this.permissions = Auth.getCurrentPracticePermission();
            console.info(this.permissions);
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