<template>

    <header class="main-header sticky">
        <nav  class="navbar navbar-default">
            <div style="background-color: #fff!important;" class="row header_row">
                <div class="col-md-6 col-xs-12">
                    <a v-bind:href="'/'">
                        <i class="fa fa-globe"> </i> {{pharmacy_name}} | {{description}}
                    </a>
                </div>
                <div class="col-md-6 col-xs-12 ">
		    	<span class="pull-right">
			        <a class="pull-right link-setting-header" @click="logout">
                        <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
			        </a>
		        </span>
                </div>
            </div>
            <div class="stellarnav">

                <ul>
                    <li>
                        <a v-bind:href="'/dashboard'">
                            <i class="fa fa-dashboard icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting">
								Dashboard
                            </span>
                        </a>
                    </li>

                    <li>

                        <a href="" v-bind:class="{'active':inventory}">
                            <i class="fa fa-calculator icon-settings" aria-hidden="true" ></i>
                            <span class="text-center link-settting">
                                Inventory
                            </span>
                        </a>
                        <ul>
                            <li>
                                <a v-bind:href="'/inventory/items'">Medicines & Products</a>
                            </li>
                            <li>
                                <a v-bind:href="'/inventory/category'">
                                    Categories
                                </a>
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
                    </li>

                    <li>
                        <a href="">
                            <i class="fa fa-clipboard icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
								Pharmacy
                            </span>
                        </a>
                        <ul>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Dispense
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Create invoice
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Return items
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    View Invoice
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="">
                            <i class="fa fa-bank icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
								Bank
                            </span>
                        </a>
                        <ul>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Cheques
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Banks
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Bank Deposits
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Bank Book
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Bank Collection
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="" v-bind:class="{'active':purchases}">
                            <i class="fa fa-briefcase icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
								Purchase
                            </span>
                        </a>
                        <ul>
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
                    </li>

                    <li>
                        <a href="" v-bind:class="{'active':purchases}">
                            <i class="fa fa-briefcase icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
								Expense
                            </span>
                        </a>
                        <ul>
                            <li>
                                <a href="">
                                    Expenses
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Create Expense
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Bank Expenses
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="">
                            <i class="fa fa-flask icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
								Transfers
                            </span>
                        </a>
                        <ul>
                            <li>
                                <a href="">
                                    Transfer List
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Create Transfer
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Requested items
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="" v-bind:class="{'active':initialization}">
                            <i class="fa fa-anchor icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
								Settings
                            </span>
                        </a>
                        <ul>
                            <li>
                                <a v-bind:href="'/initialization/brands'">
                                    Regions
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/initialization/brands'">
                                    Towns
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/initialization/brands'">
                                    Brands
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/initialization/brand_sector'">
                                    Brand Sector
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/initialization/measure_units'">
                                    Units
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/initialization/currency'">
                                    Currency
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/initialization/branches'">
                                    Branches
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/initialization/branches'">
                                    Departments
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/initialization/branches'">
                                    Stores
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/initialization/branches'">
                                    Sub stores
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="">
                            <i class="fa fa-calculator icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
								Accounts
                            </span>
                        </a>
                        <ul>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Chart of accounts
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Opening Account Heads
                                </a>
                            </li>
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
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Account Holders
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="sub-icon-settings fa fa-circle-o"></i>
                                    Opening Balances
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="" v-bind:class="{'active':statements}">
                            <i class="fa fa-line-chart icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
								Statements
                            </span>
                        </a>
                        <ul>

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
                    </li>

                    <li>
                        <a href="">
                            <i class="fa fa-shopping-bag icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
								Administrative
                            </span>
                        </a>
                        <ul>
                            <li>
                                <a href="">
                                    Personal Profile
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    App Settings
                                </a>
                            </li>
                            <li>
                                <a v-bind:href="'/human_resources/index/users'">
                                    Users/HR
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Services
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Activities
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="">
                            <i class="fa fa-balance-scale icon-settings" aria-hidden="true" >
                            </i>
                            <span class="text-center link-settting" >
								Reports
                            </span>
                        </a>
                        <ul>
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
        </nav>
    </header>  <!-- Header ends-->
    
</template>

<script>
    import {post,get} from "../../../../helpers/api";
    import Auth from "../../../../store/auth";
    import AppInfo from "../../../../helpers/config";
    export default {
        name: "AdminHeader",
        props: ['inventory','initialization','statements','purchases'],
        data(){
            return {
                pharmacy_name: '',
                hr_roles: [],
                description: AppInfo.app_data.app_description,
            }
        },
        methods: {
            logout() {
                post(AppInfo.app_data.server_domain+'/api/oauth/logout')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            Auth.remove();
                            this.$awn.success('You have successfully logged out!');
                            //this.$router.push('/login')
                            window.location.href = "/";
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning('Whoops! Something went wrong.');
                        this.$router.push('/login')
                    }else{
                        this.$awn.warning('Whoops! Something went wrong.');
                        this.$router.push('/login')
                    }
                });
            },

            redirect_to(hr_role){
                Auth.setHr(hr_role)
                window.location.href = "/human_resources/employee/index/"+hr_role.url_slug;
            }
        },
        mounted(){
            // let account = Auth.getCurrentAccount();
            // this.account_type = account.account_type;
            // this.user_permissions = account.data[0].practice_user.permissions
            // console.info(account.data[0].practice_user.permissions);
        }
    }
</script>

<style scoped>

</style>