<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="cl-grey">Make {{practice_user.first_name}} {{practice_user.other_name}} master admin</h4>
                    <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
                </div>
                <div  class="modal-body">
                    <p class="fs-14">Just so you know, only 1 person can be the master admin. By making {{practice_user.first_name}} {{practice_user.other_name}} the new master admin, your access changes to admin-only.</p>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn ha-button btn-rounded float-left">
                        Close
                    </button>
                    <button type="button" @click="master_user" class="btn ha-button primary btn-rounded float-right">
                        <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Sending...</span>
                        <span v-else>Make master admin</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
    
</template>

<script>
    import {post} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";
    export default {
        name: "MasterModal",
        props:['practice_user','practice_id','modal_id','initial_url'],
        data(){
            return {
                processing: false,
                master_form:{
                    practice_id: '',
                    practice_user_uuid: '',
                },
            }
        },
        methods: {
            master_user(){
                this.processing = true;
                post(AppInfo.app_data.server_domain+this.initial_url,this.master_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            $('#'+this.modal_id).modal('hide');
                        }
                        this.processing = false;
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        console.info(err.response.data.errors);
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
            },
        },
        mounted() {
            this.master_form.practice_id = this.practice_id;
            this.master_form.practice_user_uuid = this.practice_user.id;
        }
    }
</script>

<style scoped>

</style>