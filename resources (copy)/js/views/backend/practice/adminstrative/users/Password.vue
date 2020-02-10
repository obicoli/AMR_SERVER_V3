<template>
    <div>

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
                                            <div class="col-md-6 col-lg-6 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left text-center mg-top-30">
                                                    <a class="fw-600 cl-444 fs-20">
                                                        Change Password
                                                    </a>
                                                </div>
                                                <div class="width-100-pc float-left mg-top-30">
                                                    <form @submit.prevent="changePassword" class="width-100-pc float-left mg-top-10">
                                                        <div class="row fullName mg-bottom-5 mg-left-30">
                                                            <div class="inlineBlock width-30-pc text-right">
                                                                <label class="company-label text-right fs-12 width-100-pc">Old Password:&nbsp;&nbsp;</label>
                                                            </div>
                                                            <div class="inlineBlock width-70-pc">
                                                                <div class="dijitInline firstName dijitTextBox width-40-pc">
                                                                    <input type="password" :disabled="processing" required v-model="form.old_password">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row fullName mg-bottom-5 mg-left-30">
                                                            <div class="inlineBlock width-30-pc text-right">
                                                                <label class="company-label text-right fs-12 width-100-pc">New Password:&nbsp;&nbsp;</label>
                                                            </div>
                                                            <div class="inlineBlock width-70-pc">
                                                                <div class="dijitInline firstName dijitTextBox width-40-pc">
                                                                    <input type="password" :disabled="processing" required v-model="form.password">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row fullName mg-bottom-5 mg-left-30">
                                                            <div class="inlineBlock width-30-pc text-right">
                                                                <label class="company-label text-right fs-12 width-100-pc">Confirm New Password:&nbsp;&nbsp;</label>
                                                            </div>
                                                            <div class="inlineBlock width-70-pc">
                                                                <div class="dijitInline firstName dijitTextBox width-40-pc">
                                                                    <input type="password" :disabled="processing" required v-model="form.password_confirmation">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row fullName mg-bottom-5 mg-left-30">
                                                            <div class="inlineBlock width-100-pc text-center mg-top-15">
                                                                <button :disabled="processing" type="submit" class="btn btn-secondary banking-process-amref">
                                                                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                                                                    <span v-else>Change Password</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
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
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">
                    <copy-right></copy-right>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import DeleteModal from "../../partials/modals/DeleteModal";
    import BankAccountModal from "../../partials/modals/accounting/BankAccountModal";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import CopyRight from "../../partials/CopyRight";
    import AccountModal from "../../partials/modals/accounting/AccountModal";
    import SalesPurchaseModal from "../../partials/modals/accounting/SalesPurchaseModal";
    import AccountOpeningBalance from "../../partials/modals/accounting/AccountOpeningBalance";
    import {get, post} from "../../../../../helpers/api";
    import {CHANGE_PASSWORD, PRACTICES_API} from "../../../../../router/api_routes";
    import {createHtmlErrorString, reset_forms} from "../../../../../helpers/functionmixin";
    export default {
        name: "Password",
        components: {TopNavBar,PaginateTemplate,SideBar,CopyRight},
        data(){
            return {
                form: {
                    old_password: null,
                    password: null,
                    password_confirmation: null,
                },
                page_ready: false,
            }
        },
        methods: {
            changePassword(){
                this.processing = true;
                post(CHANGE_PASSWORD,this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.$awn.success(res.data.description);
                        this.form = reset_forms(this.form);
                    }
                    this.processing = false;
                }).catch((err) => {
                    if(err.response.status === 422) {
                        //console.info(err.response.data.errors);
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });
            }
        }
    }
</script>

<style scoped>

</style>