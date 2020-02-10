<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="save_bank" class="modal-content">

                <div class="modal-header">
                    <h4 class="float-left dijitDialogTitle" id="myModalLabel2">{{title}}</h4>
                    <a class="close float-right" data-dismiss="modal" aria-label="Close"><span class="fs-16" aria-hidden="true">&times;</span></a>
                </div>

                <div class="modal-body pd-l-55 pd-r-55 padding-bottom-29">
                    <div class="row">
                        
                        <div class="col-lg-6 col-md-6">
                            <div class="padding-right-10">

                                <div class="row fullName">
                                    <div class="inlineBlock width-100-pc padding-right-3">
                                        <label class="fullname">Account Title</label>
                                        <div class="dijitInline dijitTextBox width-100-pc">
                                            <input v-model="form.accounts_title" v-bind:class="{'height-32':true,'attended_fiel':form.accounts_title}" type="text">
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-100-pc mg-top-4">
                                        <label class="fullname">Account Number</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.accounts_number" v-bind:class="{'height-32':true,'attended_fiel':form.accounts_number}" placeholder="e.g 099996666777" required type="text">
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-100-pc">
                                        <label class="fullname">Account Type:</label>
                                        <div class="dijitInline dijitTextBox width-100-pc">
                                            <select v-model="form.accounts_type" v-bind:class="{'height-32':true,'attended_fiel':form.accounts_type}">
                                                <option value="">-select-</option>
                                                <option value="New account">New account</option>
                                                <option value="Existing account">Existing account</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="padding-left-10">
                                <div class="row fullName">
                                    <div class="inlineBlock width-100-pc">
                                        <label class="fullname">Bank name:<a class="float-right btn-link">+ New Bank</a> </label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <select v-model="form.name" v-bind:class="{'height-32':true,'attended_fiel':form.accounts_type}">
                                                <option disabled selected value="">-select-</option>
                                                <option v-for="(ban, index) in banks" :value="ban.id" :key="'ban_'+index">{{ban.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName">
                                    <div class="inlineBlock width-100-pc">
                                        <label class="fullname">Branch name:</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.branch_name" v-bind:class="{'height-32':true,'attended_fiel':form.branch_name}" type="text" placeholder="e.g KCB Upper Hill Branch" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName">
                                    <div class="inlineBlock width-100-pc mg-top-4">
                                        <label class="fullname">Branch Code</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.branch_code" v-bind:class="{'height-32':true,'attended_fiel':form.branch_code}" placeholder="e.g 0051" required type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-inventory primary">
                        <span v-if="user_mode==='Create'">
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                        </span>
                        <span v-else>
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Updating...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i> Update</span>
                        </span>
                    </button>
                    <button data-dismiss="modal" class="btn btn-inventory">
                        Close
                    </button>
                </div>

            </form>
        </div>
    </div>
    
</template>

<script>
    import {post} from '../../../../../../helpers/api';
    import AppInfo from '../../../../../../helpers/config';
    import {createHtmlErrorString,reset_forms} from '../../../../../../helpers/functionmixin';
    export default {
        name: "Employee",
        props:['practice_id','form_data','initial_url','user_mode',
        'modal_id','title','banks','branches'],
        data(){
            return {
                processing: false,
                form: {
                    name: '',
                    branch_name: '',
                    branch_code: '',
                    accounts_title: '',
                    accounts_type: '',
                    practice_id: '',
                },
            }
        },
        methods: {
            save_bank: function () {
                this.processing = true;
                post(AppInfo.app_data.server_domain+this.initial_url,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            if ( this.user_mode === 'Create' ) {
                                this.refresh_page();
                                this.$emit('userAdded');
                                this.processing = false;
                            }else {
                                this.$emit('userEdited');
                                this.processing = false;
                            }
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                });
            },
        },
        mounted() {
            // this.hr_roles = this.hr_role;
            // this.form.mobile = this.form_data.mobile;
            // this.form.email = this.form_data.email;
            // this.form.password = this.form_data.password;
            // this.form.role_name = this.form_data.role_name;
            // this.form.first_name = this.form_data.first_name;
            // this.form.other_name = this.form_data.other_name;
            // this.form.gender = this.form_data.gender;
            // this.form.password = this.form_data.password;
            // this.form.status = this.form_data.status;
            // this.form.address = this.form_data.address;
            // this.form.branch_id = this.branch_id;
        }
    }
</script>

<style lang="scss" scoped>
    @import "../../../../../../../sass/customized_modals.scss";
</style>



