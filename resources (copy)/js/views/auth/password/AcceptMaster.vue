<template>

    <div>

        <loading :is-loading="processing"></loading>

        <section>

            <div class="section_content">

                <page-header :classes_1="true"></page-header>

                <div class="container">
                    <div class="row justify-content-center">

                        <form class="banner-info">

                            <div v-if="expired_link && loaded_page" class="alert alert-danger fs-14">Expired Link!</div>
                            <div v-if="!expired_link && loaded_page" class="fs-14 alert alert-success" v-else>{{message_title}}</div>

                            <div class="row form-group mg-bottom-10 mg-top-20">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <button @click="exit_to('close')" type="button" class="btn ha-button height-36">
                                        <span>Close</span>
                                    </button>
                                    <button @click="exit_to('logout')" type="button" class="btn ha-button primary height-36 ">
                                        <span>Logout</span>
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </section>
        <!--/ banner-->
        <page-footer :classes_1="true"></page-footer>

    </div>

</template>

<script>
    import Loading  from '../../../components/loads/ProgRess'
    import PageHeader  from '../../front/partials/Header'
    import PageFooter  from '../../front/partials/Footer'
    import SwitchAccountModal  from '../partials/SwitchAccountModal'
    import AppInfo from '../../../helpers/config'
    import Auth from '../../../store/auth'
    import {post,get} from "../../../helpers/api";
    import {createHtmlErrorString} from "../../../helpers/functionmixin";
    export default {
        name: "AcceptMaster",
        components: {
            PageHeader,
            PageFooter,
            SwitchAccountModal,
            Loading
        },
        data() {
            return {
                app_info: AppInfo,
                processing: false,
                loaded_page: false,
                expired_link: false,
                accept_form: {
                    token: '',
                    action_type: ''
                },
                message_title: ''
            }
        },
        methods: {
            exit_to(action_to){
                if (action_to === "close"){
                    Auth.delEntry();
                    window.location.href = Auth.redirect_route();
                } else {
                    Auth.remove();
                    window.location.href = "/login";
                }
            },
            check_token() {
                this.processing = true;
                post(AppInfo.app_data.server_domain+'/api/oauth/privileges', this.accept_form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.processing = false;
                        this.$awn.success("Successful!");
                        this.message_title = res.data.description;
                        this.loaded_page = true;
                    }
                })
                .catch((err) => {
                    if(err.response.status === 422) {
                        this.expired_link = true;
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                        this.$router.push('/500');
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                    this.loaded_page = true;
                });
            }
        },
        mounted() {
            this.accept_form.token = this.$route.params.token;
            this.accept_form.action_type = this.$route.params.action;
            this.check_token();
        }
    }
</script>

<style scoped>

</style>