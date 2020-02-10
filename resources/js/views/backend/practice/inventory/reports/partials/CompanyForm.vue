<template>
    <div class="width-100-pc float-left">
        <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
            <h3 class="fs-14 fw-600">Company Settings</h3>
        </div>
        <new-company-form v-on:companyChanged="companyUpdated" :form_data="company" :company_api="company_api+'/'+company.id" :user_mode="'Edit'"></new-company-form>
    </div>
</template>

<script>
    import ImagePreview from "../../../../../../components/images/ImagePreview";
    import NewCompanyForm from "./NewCompanyForm";
    export default {
        name: "CompanyForm",
        props: ['company','company_api'],
        components: {NewCompanyForm},
        data(){
            return {
                // form: {
                //     name: null,
                //     legal_name: null,
                //     propriator_name: null,
                // },
            }
        },
        watch: {
            company: function(new_data,old_data){
                this.form = new_data
            }
        },
        methods: {
            companyUpdated(){
                this.$emit("companyChanged");
            }
        }
        // mounted(){
        //     if(this.company_data){
        //         this.form = this.company_data;
        //     }
        // }
    }
</script>