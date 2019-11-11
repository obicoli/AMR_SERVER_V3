<template>

    <div id="page">
        <page-header></page-header>
        <loading :is-loading="processing"></loading>

        <main>
            <div class="bg_color_2">
                <div class="container margin_60_35">
                    <div id="login">
                        <h1>Create password</h1>
                        <div class="box_form border-radius-zero">
                            <div class="alert alert-warning">
                                Hi there we observed that you haven't created a password to login yet.
                                Please create one. This is a one time activity.
                            </div>
                            <form @submit.prevent="reset">
                                <div class="form-group a">
                                    <input type="password" v-model="form.password" required class="form-control form-controller-input no-shadowed border-radius-2 mg-lg-height-32" placeholder="New password">
                                </div>
                                <div class="form-group">
                                    <input type="password" v-model="form.password_confirmation" required class="form-control form-controller-input no-shadowed border-radius-2 mg-lg-height-32" placeholder="Confirm password">
                                </div>
                                <div class="form-group text-center add_top_20">
                                    <button class="btn btn-light-blue no-shadowed border-top-right-radius-2 btn-full-width">Create password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /login -->
                </div>
            </div>
        </main>
        <!-- /main -->

        <page-footer></page-footer>
    </div>

</template>

<script>
    import { post, get } from '../../../helpers/api'
    import PageHeader from '../../front/partials/Header'
    import PageFooter from '../../front/partials/Footer'
    import Loading from '../../../components/loads/ProgRess'
    import {createHtmlErrorString} from "../../../helpers/functionmixin";
    import app_info from '../../../helpers/config'
    export default {
        name: "AcceptInvite",
        components: {
            PageHeader,
            PageFooter,
            Loading
        },
        data() {
            return {
                app_info: app_info,
                form: {
                    password: '',
                    token: this.$route.params.token,
                    password_confirmation: '',
                },
                processing: false
            }
        },
    }
</script>

<style scoped>

</style>