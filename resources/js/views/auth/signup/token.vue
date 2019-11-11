<template>

</template>

<script type="text/javascript">
    import PageHeader from '../../front/partials/Header'
    import PageFooter from '../../front/partials/Footer'
    import Loading from '../../../components/loads/ProgRess'
    import app_info from '../../../helpers/config'
    import {get} from "../../../helpers/api";
    import {createHtmlErrorString} from "../../../helpers/functionmixin";

    export default {
        components: {
            PageHeader,
            PageFooter,
            Loading,
        },
        data() {
            return {
                app_info: app_info,
                processing: false,
            }
        },
        created(){
            this.activateUser()
        },
        methods: {
            activateUser(){
                this.processing = true;
                get('/api/oauth/activate/'+this.$route.params.token)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.processing = false;
                        switch (res.data.results.activation_module) {
                            case 'Practice':
                                this.$awn.success('Activation successful');
                                this.$router.push('/partners/facility/'+res.data.results.uuid+'/practice_details');
                                break;
                            case 'User':
                                this.$awn.success('Activation successful');
                                this.$router.push('/login');
                                break;
                        }
                    }
                })
                .catch((err) => {
                    if(err.response.status === 422) {
                        this.processing = false;
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                        //this.$router.push('/login')
                        this.$router.push('/login');
                    }else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                        this.$router.push('/login');
                    }
                })
            }
        },
    }
</script>

<style lang="scss">
    @import '~vue-awesome-notifications/dist/styles/style.scss';
</style>
