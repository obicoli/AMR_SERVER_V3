<template>
    <div class=" width-100-pc">
        <img class="print-logo-size" src="/assets/img/amref-white.png">
        <h2 class="invoice-title fs-12">
            <span class="fw-600 cl-amref-dark fs-12 txt-uppercase">AMREF ENTERPRISE</span> | <span class="fw-600 cl-444 fs-12">AMREF HEALTH AFRICA</span><br>
            <!-- <span class="fs-12 txt-uppercase">{{local_company.name}}</span><br>
            <span class="fs-12">{{local_company.address}}</span><br>
            <span class="fs-12">{{local_company.postal_code+' '+local_company.city+' '+local_company.country}}</span><br>
            <span class="fs-12">{{local_company.email}}</span><br>
            <span class="fs-12">{{local_company.mobile}}</span><br>
            <span class="fs-12">{{local_company.web}}</span><br> -->
        </h2>
        <span class="fs-12 txt-uppercase">{{local_company.name}}</span><br>
    </div>
</template>
<script>
export default {
    name: "CompanyLogo",
    props: ['logo_url','company','company_branch'],
    data(){
        return{
            local_company: {
                name: '',
                logo: '',
                address: '',
                mobile: '',
                web: '',
            }
        }
    },
    mounted(){
        if(this.company){
            this.local_company.name = this.company.name;
        }
    }
}
</script>