<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="save_employee" class="modal-content">

                <div class="modal-header">
                    <h4 class="float-left dijitDialogTitle" id="myModalLabel2">{{title}}</h4>
                    <a class="close float-right" data-dismiss="modal" aria-label="Close"><span class="fs-16" aria-hidden="true">&times;</span></a>
                </div>

                <div class="modal-body pd-l-55 pd-r-55 padding-bottom-29">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="padding-right-10">
                                <div class="row fullName">
                                    <div class="inlineBlock width-40-pc mr-1">
                                        <label class="fullname" for="firstName">First name</label>
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <input type="text" v-model="form.first_name" v-bind:class="{'attended_fiel':form.first_name}">
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-40-pc">
                                        <label class="fullname" for="firstName">Other name</label>
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <input v-model="form.other_name" type="text" v-bind:class="{'attended_fiel':form.other_name}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName">
                                    <div class="inlineBlock width-100-pc">
                                        <label class="fullname"><span class="cl-red fs-14 fw-600">*</span> Display name as</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <select v-model="form.title_id" v-bind:class="{'height-32':true,'attended_fiel':form.title_id}">
                                                <option disabled selected>select</option>
                                                <option v-for="(item,index) in hr_roles" :key="index" :value="item.id">{{item.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName">
                                    <div class="inlineBlock width-100-pc">
                                        <label class="fullname">Address</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <textarea v-model="form.address" placeholder="Street" v-bind:class="{'min-height-45':true,'attended_fiel':form.address}"></textarea>
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-50-pc mg-top-4 padding-right-3">
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <input v-model="form.city" v-bind:class="{'height-32':true,'attended_fiel':form.city}" placeholder="City/Town/County" name="firstName" required type="text">
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-50-pc mg-top-4">
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <input v-model="form.region" v-bind:class="{'height-32':true,'attended_fiel':form.region}" placeholder="Region/Province" type="text" required>
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-100-pc">
                                        <label class="fullname">Notes</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <textarea v-model="form.notes" required placeholder="Street" v-bind:class="{'min-height-60':true,'attended_fiel':form.notes}"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="padding-left-10">
                                <div class="row fullName">
                                    <div class="inlineBlock width-100-pc">
                                        <label class="fullname">Email</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.email" v-bind:class="{'height-32':true,'attended_fiel':form.email}" type="email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName">
                                    <div class="inlineBlock width-50-pc padding-right-3">
                                        <label class="fullname">Tel</label>
                                        <div class="dijitInline dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <input v-model="form.phone" v-bind:class="{'height-32':true,'attended_fiel':form.phone}" type="text">
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-50-pc">
                                        <label class="fullname">Mobile</label>
                                        <div class="dijitInline dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <input v-model="form.mobile" v-bind:class="{'height-32':true,'attended_fiel':form.mobile}" type="number" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName">
                                    <div class="inlineBlock width-30-pc padding-right-3">
                                        <label class="fullname">Bill rate(/hr)</label>
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <input v-model="form.bill_rate" v-bind:class="{'height-32':true,'attended_fiel':form.bill_rate}" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-70-pc padding-top-25">
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <label class="check-container element-inlined">Billable by default
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName">
                                    <div class="inlineBlock width-40-pc">
                                        <label class="fullname">National/Alien ID No.</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.national_id" v-bind:class="{'height-32':true,'attended_fiel':form.national_id}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName">
                                    <div class="inlineBlock width-40-pc padding-right-3">
                                        <label class="fullname">Employee ID.</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.employee_id" v-bind:class="{'height-32':true,'attended_fiel':form.employee_id}" type="text">
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-30-pc">
                                        <label class="fullname">Gender</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <select v-model="form.gender" v-bind:class="{'height-32':true,'attended_fiel':form.gender}">
                                                <option></option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName">
                                    <div class="inlineBlock width-35-pc padding-right-3">
                                        <label class="fullname" for="firstName">Hired Date</label>
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <input v-model="form.hired_date" v-bind:class="{'height-32':true,'attended_fiel':form.hired_date}" type="date">
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-35-pc">
                                        <label class="fullname" for="firstName">Released Date</label>
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <input v-model="form.release_date" v-bind:class="{'height-32':true,'attended_fiel':form.release_date}" type="date">
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName">
                                    <div class="inlineBlock width-35-pc padding-right-3">
                                        <label class="fullname" for="firstName">Date of Birth</label>
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <input v-model="form.dob" v-bind:class="{'height-32':true,'attended_fiel':form.dob}" type="date">
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
    export default {
        name: "Employee",
        props:['practice_id','form_data','initial_url','user_mode','hr_role','modal_id','title'],
        data(){
            return {
                processing: false,
                form: {
                    title_id: '',
                    notes: '',
                    first_name: '',
                    other_name: '',
                    email: '',
                    mobile: '',
                    phone: '',
                    gender: '',
                    city: '',
                    region: '',
                    status: '',
                    address: '',
                    bill_rate: '',
                    dob: '',
                    release_date: '',
                    hired_date: '',
                    employee_id: '',
                    national_id: '',
                    branch_id: this.branch_id,
                },
                hr_roles: [],
            }
        },
        methods: {
            add_employee: function () {

                this.processing = true;
                let url_ = "";
                if ( this.user_mode === 'Create' ) {
                    url_ = AppInfo.app_data.server_domain+'/api/practices/users';
                }else {
                    url_ = AppInfo.app_data.server_domain+'/api/practices/users/';
                }
                post(url_,this.form)
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
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });
            },
            refresh_page(){
                this.form.status = "";
                this.form.role_name = "";
                this.form.address = "";
                this.form.first_name = "";
                this.form.other_name = "";
                this.form.email = "";
                this.form.mobile = "";
                this.form.gender = "";
                this.form.password = "";
                this.$emit('userAdded')
            },
        },
        mounted() {
            this.hr_roles = this.hr_role;
            this.form.mobile = this.form_data.mobile;
            this.form.email = this.form_data.email;
            this.form.password = this.form_data.password;
            this.form.role_name = this.form_data.role_name;
            this.form.first_name = this.form_data.first_name;
            this.form.other_name = this.form_data.other_name;
            this.form.gender = this.form_data.gender;
            this.form.password = this.form_data.password;
            this.form.status = this.form_data.status;
            this.form.address = this.form_data.address;
            this.form.branch_id = this.branch_id;
        }
    }
</script>

<style scoped>
    .modal {
        background: rgba(0, 0, 0, 0.62);
        z-index: 9999;
    }
    .modal-lg {
        max-width: 800px!important;
        min-width: 800px!important;
    }
    .modal-header{
        border-bottom: 1px solid #fff!important;
    }
    .pd-l-55{padding-left: 55px!important;}
    .pd-r-55{padding-right: 55px!important;}
    .dijitDialogTitle {
        font-weight: 600;
        color: #000000;
        font-size: 2.2rem!important;
        /* line-height: 70px; */
        line-height: 50px!important;
        max-width: calc(100% - 40px);
    }
    .fullAdd.employeeForm .row {
        padding-bottom: 4px;
    }
    .inlineBlock {
        display: inline-block;
    }
    .inlineBlock label {
        font-weight: 600!important;
        color: #404040!important;
        display: block!important;
        margin-bottom: 4px!important;
        font-size: 14px!important;
    }
    .dijitInline {
        display: inline-block;
        border: 0;
        padding: 0;
        vertical-align: middle;
    }
    .dijitTextBox input, .dijitTextBox textarea, .dijitTextBox select{
        outline: none!important;
        /* height: 32px!important; */
        border: 1px solid #BABEC5!important;
        padding: 0 8px!important;
        border-radius: 2px!important;
        transition-property: border!important;
        transition-duration: 0.35s!important;
        font-size: 13px!important;
        background-color: #FFFFFF;
        box-sizing: border-box!important;
        -webkit-appearance: none!important;
        width: 100%;
        vertical-align: middle!important;
    }

    input::placeholder, textarea::placeholder  {
        color: #babec5!important;
        font-size: 12px!important;
        font-style: italic;
        font-weight: 400!important;
    }
    .checkboxInline {
        margin-left: 5px;
    }
    input[type=checkbox]:not(.dijitCheckBoxInput):not(.idsCheckbox__input) {
        width: 20px;
        height: 20px;
        vertical-align: middle;
        background-color: transparent;
        border: 1px solid #8D9096;
        border-radius: 2px;
        background-repeat: no-repeat;
        background-size: 124px;
        background-position: -28px -3px;
        user-select: none;
        -webkit-appearance: none;
    }
    .attended_fiel{
        background-color: #f4f4f4!important;
        font-weight: 600!important;
    }
</style>


