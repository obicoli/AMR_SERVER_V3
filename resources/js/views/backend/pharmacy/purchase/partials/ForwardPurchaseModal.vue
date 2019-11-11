<template>
    <div class="modal-content">
        <form @submit.prevent="do_stuff">
            <div class="modal-header">
                <h4 class="cl-grey"><i class="fa fa-info-circle"></i> {{modal_title}}</h4>
                <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
            </div>
            <div  class="modal-body">
                <div v-if="use_type ==='Forward'">
                    <div class="row form-group mg-bottom-10">
                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                            <label class="fs-14 cl-888">Department:</label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <input type="text" v-model="form.department_id" list="department_list" @change="set_auto_complete('department')" class="form-control product-entry-input-field" id="selected_department">
                            <datalist id="department_list">
                                <option v-for="departmen in departments" :data-value="departmen.id" :value="departmen.name"></option>
                            </datalist>
                        </div>
                    </div>
                    <input type="hidden" v-model="form.action">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Processing...</span>
                    <span v-else><i class="fa fa-check" aria-hidden="true"></i> Done </span>
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
        props: ['modal_title','confirm_message','item_url','use_type','purchase'],
        data(){
            return {
                processing: false,
                departments: [],
                practice_id: '',
                form: {
                    action: 'Forward',
                    department_id: '',
                }
            }
        },
        methods: {
            loadBranches: function () {

                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.departments = res.data.results.departments;
                            this.processing = false;
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
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
            do_stuff(){
                this.processing = true;
                let url_ = AppInfo.app_data.server_domain+'/api/products/purchases/'+this.purchase.id;
                post(url_, this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            this.$emit('purchaseForwarded');
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
            set_auto_complete(type_){

                switch (type_) {
                    case "supplier":
                        let value = $('#selected_supplier').val();
                        let supplier_id = $('#supplier_list [value="' + value + '"]').data('value');
                        if (supplier_id !== "") {
                            this.purchase_form.supplier_id = supplier_id;
                        }
                        break;
                    case "branch":
                        let value1 = $('#selected_branch').val();
                        let branch_id = $('#branch_list [value="' + value1 + '"]').data('value');
                        if (branch_id !== "") {
                            this.purchase_form.practice_id = branch_id;
                            this.loadBranch(branch_id);
                        }
                        break;
                    case "department": //department_list
                        let value2 = $('#selected_department').val();
                        let department_id = $('#department_list [value="' + value2 + '"]').data('value');
                        if (department_id !== "") {
                            this.form.department_id = department_id;
                        }
                        break;
                    case "store":
                        let value3 = $('#selected_store').val();
                        let store_id = $('#store_list [value="' + value3 + '"]').data('value');
                        if (store_id !== "") {
                            this.purchase_form.store_id = store_id;
                        }
                        break;
                }
            },
        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            this.loadBranches();
        }
    }
</script>

<style scoped>

</style>