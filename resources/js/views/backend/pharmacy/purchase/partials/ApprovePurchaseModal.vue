<template>

    <div class="modal-content">
        <form @submit.prevent="do_stuff">
            <div class="modal-header">
                <h4 class="cl-grey"><i class="fa fa-info-circle"></i> {{modal_title}}</h4>
                <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
            </div>
            <div  class="modal-body">
                <p>Are you sure you want to approve this purchase?</p>
                <input type="hidden" v-model="form.action">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Processing...</span>
                    <span v-else><i class="fa fa-check" aria-hidden="true"></i> Yes </span>
                </button>
                <button data-dismiss="modal" class="btn btn-inventory">
                    Close
                </button>
            </div>
        </form>
    </div>
    
</template>

<script>
    import {post,get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";
    export default {
        name: "ApprovePurchaseModal",
        props: ['modal_title','confirm_message','item_url','use_type','purchase'],
        data(){
            return {
                processing: false,
                departments: [],
                practice_id: '',
                form: {
                    action: 'Approve',
                    department_id: '',
                }
            }
        },
        methods: {

            do_stuff(){
                this.processing = true;
                let url_ = AppInfo.app_data.server_domain+'/api/products/purchases/'+this.purchase.id;
                post(url_, this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            this.$emit('purchaseApproved');
                            this.processing = false;
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });

            },
        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
        }
    }
</script>

<style scoped>

</style>