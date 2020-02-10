<template>
    <div class="modal fade" :id="modal_id">
        <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
            <form @submit.prevent="add_category">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="cl-grey">{{title}}</h4>
                        <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
                    </div>
                    <div  class="modal-body">

                        <div class="row form-group mg-bottom-10">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Name:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="text" placeholder="" required v-model="form.name" class="form-control product-entry-input-field">
                            </div>
                        </div>

                        <div class="row form-group mg-bottom-10">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Value:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="number" min="0" step="any" placeholder="" required v-model="form.amount" class="form-control product-entry-input-field">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-inventory">
                            <i class="fa fa-close" aria-hidden="true"></i> Close
                        </button>
                        <button v-if="user_mode==='Create'" @click="resets" type="button" class="btn btn-inventory">
                            <i class="fa fa-refresh" aria-hidden="true"></i> Reset
                        </button>
                        <button v-if="user_mode==='Edit'" type="submit" class="btn btn-inventory primary">
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i>Save Changes</span>
                        </button>
                        <button v-if="user_mode==='Create'" type="submit" class="btn btn-inventory primary">
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {post} from "../../../../../../../helpers/api";
    // import Loading from "../../../../../../components/loads/ProgRess";
    import Auth from "../../../../../../../store/auth";
    // import AppInfo from "../../../../../../helpers/config";
    //import {PRODUCT_CATEGORIES_URL} from '../../../../../../../router/api_routes';
    import {createHtmlErrorString,reset_forms} from "../../../../../../../helpers/functionmixin";
    export default {
        name: "UomModal",
        props: ['practice_id','user_mode','form_data','item_id','modal_id','title','initial_url'],
        //components: {Loading},
        data(){
            return {
                //initial_url: PRODUCT_CATEGORIES_URL,
                processing: false,
                form: {
                    name: '',
                    amount: '',
                    practice_id: this.practice_id,
                }
            }
        },
        methods: {
            add_category: function () {
                this.processing = true;
                post(this.initial_url,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            if (this.user_mode === 'Edit') {
                                this.form_data.status = this.form.status;
                                this.$emit('taxEdited',this.form_data);
                            }else {
                                this.form = reset_forms(this.form);
                                this.processing = false;
                                this.$emit('taxAdded');
                            }
                        }
                        this.processing = false;
                    }).catch((err) => {
                        if(err.response.status === 422) {
                            this.processing = false;
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
            resets(){
                this.form = reset_forms(this.form);
                this.processing = false;
            }
        },
        mounted() {
            if (this.user_mode === 'Edit') {
                this.form = this.form_data;
                this.form.practice_id = this.practice_id;
            }
        }
    }
</script>

<style scoped>

</style>