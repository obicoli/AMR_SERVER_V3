<template>
    <div v-bind:class="{'graph-container':bg_hero,'bg-hero':bg_hero}">
        <div :style="'width:90%;height:200px;'" class="hello" ref="chartdiv"></div>
    </div>
</template>

<script>
    import * as am4core from "@amcharts/amcharts4/core";
    import * as am4charts from "@amcharts/amcharts4/charts";
    import am4themes_animated from "@amcharts/amcharts4/themes/animated";
    am4core.useTheme(am4themes_animated);
    export default {
        name: "AmDoughnut",
        props: ['chart_value','bg_hero'],
        data(){
            return {
                chart_data: {},
            }
        },
        mounted() {

            this.chart_data = this.chart_value;
            console.info('-------------------')
            console.info(this.chart_data);
            console.info('-------------------')
            // Create chart instance
            let chart = am4core.create(this.$refs.chartdiv, am4charts.PieChart);
            // Add data
            chart.data = this.chart_data.data;
            chart.innerRadius = am4core.percent(60);
            // Add and configure Series
            let pieSeries = chart.series.push(new am4charts.PieSeries());
            pieSeries.dataFields.value = this.chart_data.category_value;
            pieSeries.dataFields.category = this.chart_data.category;
            pieSeries.slices.template.stroke = am4core.color("#fff");
            pieSeries.slices.template.strokeWidth = 1;
            pieSeries.slices.template.strokeOpacity = 1;
            let colored = [];
            for (let index = 0; index < this.chart_data.colors.length; index++) {
                const element = this.chart_data.colors[index];
                colored.push(am4core.color(element))
            }
            pieSeries.colors.list = colored;

        },
        beforeDestroy() {
            if (this.chart) {
                this.chart.dispose();
            }
        }
    }
</script>

<style scoped>
    /* .hello {
        width: 100%;
        height: 100%;
    } */
</style>