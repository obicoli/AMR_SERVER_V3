<template>
    <div data-component="sidebar">
        <div class="sidebar">
            <ul class="list-group flex-column d-inline-block first-menu scrollable-menu padding-bottom-100">
                <li v-if="has_permission(true,'Calendar')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-home" aria-hidden="true"><span class="ml-2 align-middle">Home</span></i></a>
                    <dashboards :title="'Inventory'" :reports="reports"></dashboards>
                </li>
                <li v-if="has_permission(true,'Calendar')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-database" aria-hidden="true"><span class="ml-2 align-middle">Inventory</span></i></a>
                    <sidebar-inventory :title="'Inventory'" :reports="reports"></sidebar-inventory>
                </li>
                <li v-if="has_permission(true,'Calendar')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-truck" aria-hidden="true"><span class="ml-2 align-middle">Suppliers</span></i></a>
                    <sidebar-supplier :title="'Suppliers'"></sidebar-supplier>
                </li>

                <li v-if="has_permission(true,'Calendar')" class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-cart-plus" aria-hidden="true"><span class="ml-2 align-middle">Customers</span></i></a>
                    <sidebar-customer :title="'Customers'"></sidebar-customer>
                </li>

                <li class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-university" aria-hidden="true"><span class="ml-2 align-middle">Banking</span></i></a>
                    <sidebar-banking :title="'Banking'"></sidebar-banking>
                </li>

                <li class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-briefcase" aria-hidden="true"><span class="ml-2 align-middle">Accounting</span></i></a>
                    <sidebar-accounting :title="'Banking'"></sidebar-accounting>
                </li>

                <li class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-bar-chart-o" aria-hidden="true"><span class="ml-2 align-middle">Reports</span></i></a>
                    <sidebar-reports :title="'Reports & Config'"></sidebar-reports>
                </li>
                <li class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-building-o" aria-hidden="true"><span class="ml-2 align-middle">Company</span></i></a>
                    <company-config :title="'Reports & Config'"></company-config>
                </li>
                <li class="list-group-item pl-3 py-2">
                    <a href="#"><i class="fa fa-user-o" aria-hidden="true"><span class="ml-2 align-middle">Adminstration</span></i></a>
                    <admin-menu :title="'Reports & Config'"></admin-menu>
                </li>

            </ul>
        </div>
    </div>
</template>

<script>
    import Dashboards from "./supplychain/Dashboards";
    import ReportConfig from "./supplychain/ReportConfig";
    import SidebarBanking from "./supplychain/SidebarBanking";
    import SidebarAccounting from "./supplychain/SidebarAccounting";
    import SidebarCustomer from "./supplychain/SidebarCustomer";
    import SidebarSupplier from "./supplychain/SidebarSupplier";
    import SidebarInventory from "./supplychain/SidebarInventory";
    import AdminMenu from "./admin/AdminMenu";
    import SidebarReports from "./reports/SidebarReports";
    import CompanyConfig from "./admin/CompanyConfig";

    import Auth from '../../../../../store/auth';
    import {INVENTORY_WEB_ROUTES,DEPARTMENTS_WEB_ROUTES} from '../../../../../router/web_routes';
    import {SIDEBARS} from "../../../../../helpers/process_status";
    export default {
        name: "SideBar",
        props: ['reports'],
        components:{
            ReportConfig,SidebarBanking,SidebarAccounting,SidebarCustomer,Dashboards,
            SidebarSupplier,AdminMenu,SidebarReports,CompanyConfig,SidebarInventory
        },
        data(){
            return{
                INVENTORY_WEB_ROUTES:INVENTORY_WEB_ROUTES,
                DEPARTMENTS_WEB_ROUTES: DEPARTMENTS_WEB_ROUTES,
                SIDEBARS: SIDEBARS,
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
