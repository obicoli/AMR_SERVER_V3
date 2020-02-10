<template>
    <div class="text-center mg-top-20 mg-bottom-20">
        <img src="/assets/img/amref-white.png" class="report-icon">
        <h4 class=" fs-13 txt-uppercase"> <span>AMREF ENTERPRISE</span> | <span class="cl-amref">AMREF HEALTH AFRICA</span></h4>
        <span class="fs-12">{{facility_name}}</span><br>
        <div class="reportName">{{report_name}}</div><br>
        <small class="fs-12">{{as_at}}</small>
    </div>
</template>
<script>
    export default {
        props: ['report_name','as_at','facility_name'],
    }
</script>