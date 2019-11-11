<template>
    <header class="main-header sticky">
        <loading :is-loading="processing"></loading>
        <nav  class="navbar navbar-default">

            <div class="stellarnav">
                <ul>

                    <li v-for="user_permission in user_permissions">

                        <a v-if="user_permission.category==='Inventory'" href="" v-bind:class="{'active':inventory}">
                            <i class="fa fa-calculator icon-settings" aria-hidden="true" ></i>
                            <span class="text-center link-settting">
								Inventory
                            </span>
                        </a>
                        <ul v-if="user_permission.category==='Inventory'">

                            <li>
                                <a v-bind:href="'/inventory/items'">Medicines & Products</a>
                            </li>
                            <li>
                                <a v-bind:href="'/inventory/items'">Pending approval stock</a>
                            </li>
                            <li>
                                <a v-bind:href="'/inventory/items'">Pending stock</a>
                            </li>
                            <li>
                                <a href="">
                                    Out of stock
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Recent expired
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Stock
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Expired Stock
                                </a>
                            </li>

                        </ul>

                        <a v-if="user_permission.category==='POS'" href="">
                            <i class="fa fa-clipboard icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting">
								Pharmacy
                            </span>
                        </a>
                        <ul v-if="user_permission.category==='POS'">
                            <li>
                                <a href="">
                                    Prescriptions
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Dispense
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Create invoice
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Return items
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    View Invoice
                                </a>
                            </li>
                        </ul>

                        <a v-if="user_permission.category==='Bank'" href="">
                            <i class="fa fa-bank icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
								Bank
                            </span>
                        </a>
                        <ul v-if="user_permission.category==='Bank'">
                            <li>
                                <a href="">
                                    Cheques
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Banks
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Bank Deposits
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Bank Book
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Bank Collection
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Bank Expenses
                                </a>
                            </li>
                        </ul>

                        <a v-if="user_permission.category==='Purchase'" href="" v-bind:class="{'active':purchases}">
                            <i class="fa fa-briefcase icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
								Purchase
                            </span>
                        </a>
                        <ul v-if="user_permission.category==='Purchase'">
                            <li>
                                <a v-bind:href="'/purchases'">
                                    Purchases
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/purchases/create'">
                                    Create purchase
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Purchase return
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Purchase Order
                                </a>
                            </li>
                        </ul>

                        <a v-if="user_permission.category==='Supply'" href="">
                            <i class="fa fa-flask icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
							Supply
                            </span>
                        </a>
                        <ul v-if="user_permission.category==='Supply'">
                            <li>
                                <a href="">
                                    Supply List
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Drivers
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Vehicles
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Salesman
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Order List
                                </a>
                            </li>

                        </ul>

                        <a v-if="user_permission.category==='Expense'" href="">
                            <i class="fa fa-flask icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
							Supply
                            </span>
                        </a>
                        <ul v-if="user_permission.category==='Expense'">
                            <li>
                                <a href="">
                                    Supply List
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Drivers
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Vehicles
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Salesman
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Order List
                                </a>
                            </li>

                        </ul>

                        <a v-if="user_permission.category==='Settings'" href="" v-bind:class="{'active':settings}">
                            <i class="fa fa-cog icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
								Settings
                            </span>
                        </a>
                        <ul v-if="user_permission.category==='Settings'">
                            <li>
                                <a v-bind:href="'/settings/category'">
                                    Medicine category
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/settings/brands'">
                                    Brands
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/settings/brand_sector'">
                                    Brand Sector
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/settings/measure_units'">
                                    Units
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/settings/currency'">
                                    Currency
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/settings/branches'">
                                    Branches/Facilities
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/settings/facility_types'">
                                    Facility types
                                </a>
                            </li>
<!--                            <li>-->
<!--                                <a v-bind:href="'/initialization/branches'">-->
<!--                                    Department-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a v-bind:href="'/initialization/branches'">-->
<!--                                    Stores-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a v-bind:href="'/initialization/branches'">-->
<!--                                    Sub stores-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a v-bind:href="'/initialization/branches'">-->
<!--                                    Printer-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a v-bind:href="'/initialization/branches'">-->
<!--                                    Services-->
<!--                                </a>-->
<!--                            </li>-->

                        </ul>

                        <a v-if="user_permission.category==='Accounts'" href="" v-bind:class="{'active':accounts}">
                            <i class="fa fa-calculator icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
								Accounts
                            </span>
                        </a>
                        <ul v-if="user_permission.category==='Accounts'">
                            <li>
                                <a :href="'/accounts'">
                                    Chart of accounts
                                </a>
                            </li>
<!--                            <li>-->
<!--                                <a href="">-->
<!--                                    <i class="sub-icon-settings fa fa-circle-o"></i>-->
<!--                                    Opening Account Heads-->
<!--                                </a>-->
<!--                            </li>-->
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Credit Voucher
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Debit Voucher
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Journal voucher
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/payee'">
                                    Account Holders
                                </a>
                            </li>
<!--                            <li>-->
<!--                                <a href="">-->
<!--                                    <i class="sub-icon-settings fa fa-circle-o"></i>-->
<!--                                    Opening Balances-->
<!--                                </a>-->
<!--                            </li>-->
                        </ul>

                        <a v-if="user_permission.category==='Statements'" href="" v-bind:class="{'active':statements}">
                            <i class="fa fa-line-chart icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
								Statements
                            </span>
                        </a>
                        <ul v-if="user_permission.category==='Statements'">
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    General Journal
                                </a>
                            </li>

                            <li>
                                <a v-bind:href="'/statements/ledger_accounts'">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Ledger Account
                                </a>
                            </li>

                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Trail Balance
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Income
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Balance Sheet
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Bank Reconciliation
                                </a>
                            </li>

                        </ul>

                        <a v-if="user_permission.category==='Administrative'" href="">
                            <i class="fa fa-shopping-bag icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
								Administrative
                            </span>
                        </a>
                        <ul v-if="user_permission.category==='Administrative'">
                            <li>
                                <a href="">
                                    Personal Profile
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    System Settings
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/human_resources/index/users'">
                                    Users/Human Resource
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/human_resources/index/users'">
                                    Roles
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/human_resources/index/users'">
                                    Permissions
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Activities
                                </a>
                            </li>
                        </ul>

                        <a v-if="user_permission.category==='Extra'" href="">
                            <i class="fa fa-plus-circle icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
							Extra
                            </span>
                        </a>
                        <ul v-if="user_permission.category==='Extra'">
                            <li>
                                <a href="">
                                    Take Backup
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Restore Backup
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Company
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Requested Items
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Quotations/Estimates
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Sales receipt
                                </a>
                            </li>
                        </ul>

                        <a v-if="user_permission.category==='Reports'" href="">
                            <i class="fa fa-balance-scale icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
								Reports
                            </span>
                        </a>
                        <ul v-if="user_permission.category==='Reports'">
                            <li>
                                <a href="">
                                    Sales Report
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Return report
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Top Salesman
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Brands report
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Section report
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Company Wise
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Storewise report
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    SKU Wise
                                </a>
                            </li>
                        </ul>

                    </li>

                </ul>
            </div>

            <div style="background-color: #fff!important;" class="row header_row min-height-45">
                <div class="col-md-7 col-xs-12 welcome-msg">
                    <a v-if="head_loaded">
                        <i class="fa fa-hospital-o"> </i> {{org_name}}
                    </a>
                </div>
                <div class="col-md-5 col-xs-12 ">
		    	<span class="pull-right">
                    <a class="fs-14" href="/" v-if="head_loaded"><i class="fa fa-dashboard"> </i> Dashboard</a> |
                    <a class="fs-14" v-if="head_loaded"><i class="fa fa-user-circle-o"> </i> Welcome <strong>{{user_first_name}}!</strong></a> |
			        <a class="pull-right link-setting-header fs-14 pointer-cursor" @click="logout">
                        <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
			        </a>
		        </span>
                </div>
            </div>

        </nav>
    </header>  <!-- Header ends-->
</template>

<script>
    import Loading from "../../../../components/loads/ProgRess";
    import {post,get} from "../../../../helpers/api";
    import Auth from "../../../../store/auth";
    import AppInfo from "../../../../helpers/config";
    export default {
        name: "Header",
        props: ['inventory','initialization','statements','purchases','settings','accounts'],
        components: {
            Loading
        },
        data(){
            return {
                pharmacy_name: '',
                hr_roles: [],
                account_type: '',
                user_permissions: [],
                user_first_name: '',
                org_name: '',
                head_loaded: false,
                processing: false,
            }
        },
        methods: {
            logout() {
                this.processing = true;
                post(AppInfo.app_data.server_domain+'/api/oauth/logout')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            Auth.remove();
                            this.$awn.success('You have successfully logged out!');
                            this.processing = false;
                            //this.$router.push('/login')
                            window.location.href = "/";
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.processing = false;
                        this.$awn.warning('Whoops! Something went wrong.');
                        this.$router.push('/login')
                    }else{
                        this.$awn.warning('Whoops! Something went wrong.');
                        this.$router.push('/login')
                    }
                    this.processing = false;
                });
                Auth.remove();
                window.location.href = "/";
            },

            redirect_to(hr_role){
                Auth.setHr(hr_role);
            }
        },
        mounted(){
            this.user_first_name = Auth.getFname();
            this.org_name = Auth.jobData('org_name');
            this.work_place_name = Auth.jobData('work_place_name');
            this.work_department = Auth.jobData('work_department');
            this.user_permissions = Auth.jobData('user_permissions');
            this.head_loaded = true;
        }
    }
</script>

<style scoped>

</style>