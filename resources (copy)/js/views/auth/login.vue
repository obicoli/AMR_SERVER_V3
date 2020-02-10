<template>

    <div class="wrap">
        <section id="home" class="p-0">
            <div class="owl-carousel owl-theme main-slider">
                <div class=" item">
                    <div class="item-content">
                        <section class="parallax-fixed main-banner" data-stellar-background-ratio="0.5">
                            <div class="content-table">
                                <div class="content-middle">
                                    <div class="container main-slider-container">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-md-7 col-lg-7 text-center text-md-left animate_slide landing-content">
                                                <p class="text-center">
                                                    <strong class="cl-white txt-uppercase">Sign in to your account</strong>
                                                </p>
                                                <form @submit.prevent="login" class="login-container">

                                                    <div class="form-group">
                                                        <label>Enter your email</label>
                                                        <input v-model="form.email" type="email" required v-bind:class="{'form-control':true,'ctm-attended-field':form.email}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Enter your password</label>
                                                        <input type="password" v-model="form.password" required v-bind:class="{'form-control':true,'ctm-attended-field':form.password}">
                                                    </div>

                                                    <div class="form-group text-right">
                                                        <router-link to="/forgot/password">Forgot password?</router-link>
                                                    </div>

                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary btn-xl">
                                                            <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> Please wait...</span>
                                                            <span v-else>Continue</span>
                                                        </button>
                                                    </div>
                                                </form>
                                                <p class="text-center cl-white login-logo-s">
                                                    <router-link to="/"><img src="/assets/front/images/amref-logo.png"></router-link><br>
                                                    Electronic Dispensing & Inventory Tracking Tool<br>
                                                    <strong>EDITT V1</strong>
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

            </div>
        </section>
        
        <div class="footer">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <span class="copyright text-center" style="color:#fff;font-size:14px;">
                            © Copyright Amref 2019 All Rights Reserved. Designed by <a href="https://virtualglobal.net" target="_blank">Virtual Global</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script type="text/javascript">

    import PageHeader  from '../front/partials/Header'
    import PageFooter  from '../front/partials/Footer'
    import SwitchAccountModal  from './partials/SwitchAccountModal'
    import AppInfo from '../../helpers/config'
    import Auth from '../../store/auth'
    import {post,get} from "../../helpers/api";
    import {createHtmlErrorString} from "../../helpers/functionmixin";
    import {LOGIN_URL,ACCOUNTS_INITIALS,PRODUCT_ATTRIBUTES_URL} from "../../router/api_routes";

    export default {
        components: {
            PageHeader,
            PageFooter,
            SwitchAccountModal
        },
        data() {
            return {
                app_info: AppInfo,
                processing: false,
                profile: {},
                role: {},
                log_response: {},
                account: [],
                //accounting_initials: [],
                form: {
                    email: '',
                    password: ''
                }
            }
        },
        created(){
            //Auth.remove();
        },
        methods: {
            switch_account(account_data){
                Auth.set(this.log_response.data.access_token,this.log_response.data.token_type,this.log_response.data.expires_at,this.log_response.data.results,account_data);
                window.location.href = Auth.redirect_route();
            },
            login() {
                this.processing = true;
                post(LOGIN_URL, this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        console.info(res.data.results);
                        if ( res.data.results.length === 1 ){
                            if (res.data.results[0].account_type === 'Pharmacy') {
                                //Auth.set(res.data.access_token,res.data.token_type,res.data.expires_at,res.data.results,res.data.results[0])
                            }else if(res.data.results[0].account_type === 'Facility Staff'){
                                this.$awn.success('Welcome '+res.data.results[0].data.first_name+' '+res.data.results[0].data.other_name);
                                Auth.set(res.data.access_token,res.data.token_type,res.data.expires_at,res.data.results,res.data.results[0]);
                            }
                            window.location.href = Auth.redirect_route();
                        }else {
                            this.log_response = res;
                            this.account = res.data.results;
                            this.$awn.success('Welcome!');
                            let entry_po = Auth.checkEntry();
                            if (entry_po) {
                                this.switch_account();
                            }else {
                                $("#switchAccountModal").modal('show');
                            }
                        }
                    }
                })
                .catch((err) => {
                    this.processing = false;
                    this.$awn.warning('An error occurred! Try again');
                    if(err.response.status === 422) {
                        this.form.password = "";
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.form.password = "";
                        this.$awn.warning(err.response.data.description);
                        this.$router.push('/500');
                    }
                    else{
                        this.processing = false;
                        this.form.password = "";
                        this.$awn.warning(err.response.data.description)
                    }
                });
            },

            // initializeSystem(){
            //     this.progress_overlay = "show";
            //     get(PRODUCT_ITEMS_URL+'/practice/'+this.practice_id+'?page='+this.pagination.current_page)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             this.product_items = res.data.results;
            //             // this.practice_product_items = res.data.results.data;
            //             // this.pagination = res.data.results.pagination;
            //             // this.is_page_ready = true;
            //             // this.prod_loaded = true;
            //             // console.info(this.practice_product_items);
            //             // this.progress_overlay = "hide";
            //         }
            //     }).catch((err) => {
            //         this.progress_overlay = "hide";
            //     });
            // },

            loadAccounting(load_progress="show"){
                this.progress_overlay = load_progress;
                get(ACCOUNTS_INITIALS)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        //this.accounting_initials = res.data.results;
                        localStorage.setItem("accountings",JSON.stringify(res.data.results));
                        //window.location.href = Auth.redirect_route();
                        this.loadProductInitials();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    window.location.href = Auth.redirect_route();
                });
            },

            loadProductInitials(load_progress="show"){
                this.progress_overlay = load_progress;
                get(PRODUCT_ATTRIBUTES_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        //this.accounting_initials = res.data.results;
                        this.processing = false;
                        localStorage.setItem("products",JSON.stringify(res.data.results));
                        window.location.href = Auth.redirect_route();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.processing = false;
                    //window.location.href = Auth.redirect_route();
                });
            },

        },
        mounted() {

        }
    }
</script>


