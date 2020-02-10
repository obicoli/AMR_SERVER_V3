<template>
    <apexchart v-if="render_ready" type=pie width=380 :options="chartOptions" :series="series" />
</template>
<script>
export default {
    name: "ApexPie",
    props: ['wdt','hgt','chart_id','reported_data'],
    data(){
        return {
            render_ready: false,
            def_hgt: 250,
            def_wdt: 400,
            series: [],
            chartOptions: {
                labels: []
            }
        }
    },
    methods: {
    },
    mounted(){
        console.info(this.reported_data);
        this.series = this.reported_data.series;
        this.chartOptions = this.reported_data.chartOptions;
        this.render_ready = true;
    }
}
</script>