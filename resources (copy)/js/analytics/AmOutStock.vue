<template>

    <div class="graph-container bg-white padding-top-20">
        <div class="graph-header"><h3>{{title}}</h3></div>
        <div class="ui fitted divider"></div>
        <div class="row">
            <div class="col-lg-5">
                <div class="delivery-summary">
                    <table class="items-analytic-table1 table-hover">
                        <tr>
                            <th style="width: 60%">Item</th>
                            <th style="width: 20%">Facilities</th>
                            <th style="width: 20%">Alternatives</th>
                        </tr>
                        <tr class="table-hover-tr" v-for="(item,index) in stock_out_items" :key="'item'+index">
                            <td>{{item.name}}</td>
                            <td>{{item.total_facility}}</td>
                            <td>{{item.alternatives}}%</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="delivery-summary">
                    <!-- <div class="hello" ref="chartdiv1"></div> -->
                    <div class="hello" ref="chartdiv2"></div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
    import * as am4core from "@amcharts/amcharts4/core";
    import * as am4charts from "@amcharts/amcharts4/charts";
    import am4themes_animated from "@amcharts/amcharts4/themes/animated";
    am4core.useTheme(am4themes_animated);
    
    export default {
        name: "AmOutStock",
        props: ['title','chart_value','stock_out_item'],
        data(){
            return{
                chart_dat: [],
                stock_out_items: [],
            }
        },
        mounted() {

            //let chart = am4core.create(this.$refs.chartdiv1, am4charts.XYChart);
            let chart = am4core.create(this.$refs.chartdiv2, am4charts.PieChart);
            // Create chart instance
            //var chart = am4core.create("chartdiv", am4charts.XYChart);
            // Add data
            this.chart_dat = this.chart_value;
            this.stock_out_items = this.stock_out_item;
            chart.data = this.chart_dat;

            // Create chart instance
            //let chart = am4core.create("chartdiv", am4charts.PieChart);
            // Add data
            chart.data = [{
            "country": "Lithuania",
            "value": 501.9
            }, {
            "country": "Czechia",
            "value": 301.9
            }, {
            "country": "Ireland",
            "value": 201.1
            }, {
            "country": "Germany",
            "value": 165.8
            }, {
            "country": "Australia",
            "value": 139.9
            }, {
            "country": "Austria",
            "value": 128.3
            }];
            // Add and configure Series
            let pieSeries = chart.series.push(new am4charts.PieSeries());
            pieSeries.dataFields.value = "value";
            pieSeries.dataFields.category = "country";
            pieSeries.labels.template.disabled = true;
            pieSeries.ticks.template.disabled = true;
            chart.legend = new am4charts.Legend();
            chart.legend.position = "right";
            //
            chart.innerRadius = am4core.percent(90);
            chart.outerWidth = 120;
            chart.outerHeight = 120;
        
            //
            let label = pieSeries.createChild(am4core.Label);
            label.text = "${values.value.sum}";
            label.horizontalCenter = "middle";
            label.verticalCenter = "middle";
            label.fontSize = 40;

            //commented but useful

            // let categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            // categoryAxis.dataFields.category = "facility";
            // categoryAxis.renderer.grid.template.location = 0;
            // categoryAxis.renderer.labels.template.disabled = true;
            // //categoryAxis.stroke = am4core.color("#a94442");
            // categoryAxis.renderer.grid.template.stroke = am4core.color("#fff");

            // let valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
            // valueAxis.min = 0;
            // valueAxis.renderer.grid.template.stroke = am4core.color("#fff");

            // let series = chart.series.push(new am4charts.ColumnSeries());
            // series.dataFields.valueX = "percentage_amount";
            // series.dataFields.categoryY = "facility";
            // series.name = "Reporting Facility";
            // series.fill = am4core.color("#f2dede");
            // series.stroke = am4core.color("#ebcccc");
            // series.strokeWidth = 1;
            // series.tooltipText = "{facility}: {amount}";

            // // let valueLabel = series.bullets.push(new am4charts.LabelBullet());
            // // valueLabel.label.text = "{amount}";
            // // valueLabel.label.fontSize = 25;
            // // valueLabel.label.horizontalCenter = "left";
            // // valueLabel.label.dx = 10;

            // let categoryLabel = series.bullets.push(new am4charts.LabelBullet());
            // categoryLabel.label.text = "{facility}: {percentage_amount}%";
            // categoryLabel.label.fontSize = 20;
            // categoryLabel.label.horizontalCenter = "right";
            // categoryLabel.label.dx = -10;
            // categoryLabel.label.fill = am4core.color("#a94442");
            // //categoryLabel.label.fill = am4core.color("#f2dede");

            // chart.maskBullets = false;
            // chart.paddingRight = 30;

            // //add legend
            // chart.legend = new am4charts.Legend();
            // chart.legend.position = "top";
            
        }
    }
</script>

<style scoped>
    .hello {
        width: 100%;
        height: 360px;
    }
</style>