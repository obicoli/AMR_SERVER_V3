<template>
    <div class="graph-container bg-hero">
        <div class="hello" ref="chartdiv"></div>
    </div>
</template>

<script>
    import * as am4core from "@amcharts/amcharts4/core";
    import * as am4charts from "@amcharts/amcharts4/charts";
    import am4themes_animated from "@amcharts/amcharts4/themes/animated";
    am4core.useTheme(am4themes_animated);
    export default {
        name: "AmDrawLine",
        props: ['chart_value'],
        data(){
            return {
                chart_data: [],
            }
        },
        mounted() {

            this.chart_data = this.chart_value;

            // Create chart instance
            let chart = am4core.create(this.$refs.chartdiv, am4charts.XYChart);
            //let chart = am4core.create("chartdiv", am4charts.XYChart);

            chart.paddingRight = 20;

            chart.data = this.chart_data;

            // Create axes
            let dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            //dateAxis.renderer.grid.template.location = 0;
            //dateAxis.renderer.minGridDistance = 30; #242424

            let valueAxis1 = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis1.title.text = "Sales";
            valueAxis1.color = am4core.color("#ffffff");
            //valueAxis1.title.color = "#ffffff";
            //valueAxis1.renderer.grid.template.stroke = am4core.color("#fff");
            valueAxis1.renderer.grid.template.stroke = am4core.color("#242424");

            let valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis2.title.text = "Stock units held";

            //valueAxis2.title.text.color = am4core.color("#ffffff");
            valueAxis2.renderer.opposite = true;
            //valueAxis2.renderer.grid.template.stroke = am4core.color("#fff");
            valueAxis2.renderer.grid.template.stroke = am4core.color("#242424");
            valueAxis2.renderer.grid.template.disabled = true;

            // Create series
            // let series1 = chart.series.push(new am4charts.ColumnSeries());
            // series1.dataFields.valueY = "purchased";
            // series1.dataFields.dateX = "date";
            // series1.yAxis = valueAxis1;
            // series1.name = "Purchases";
            // series1.tooltipText = "{name}\n[bold font-size: 20]${valueY}M[/]";
            // //series1.fill = chart.colors.getIndex(0);
            // //series1.fill = am4core.color("#3d48ac");
            // series1.fill = am4core.color("#242424");
            // series1.stroke = am4core.color("#fbbd32");
            // series1.strokeWidth = 1;
            // series1.clustered = false;
            // series1.columns.template.width = am4core.percent(30);

            let series2 = chart.series.push(new am4charts.ColumnSeries());
            series2.dataFields.valueY = "sold";
            series2.dataFields.dateX = "date";
            series2.yAxis = valueAxis1;
            series2.name = "Sales";
            series2.tooltipText = "{name}\n[bold font-size: 20]KES {valueY}[/]";
            //series2.fill = chart.colors.getIndex(0).lighten(0.5);
            series2.fill = am4core.color("#242424");
            series2.stroke = am4core.color("#f7f7f7");
            series2.strokeWidth = 1;
            series2.clustered = false;
            series2.columns.template.width = am4core.percent(30);
            series2.toBack();

            let series3 = chart.series.push(new am4charts.LineSeries());
            series3.dataFields.valueY = "stock_level";
            series3.dataFields.dateX = "date";
            series3.name = "Stock Units";
            series3.strokeWidth = 2;
            series3.stroke = am4core.color("#3d48ac");
            series3.fillOpacity = 0.1;
            series3.strokeOpacity = 0.7;
            series3.tensionX = 0.7;
            series3.yAxis = valueAxis2;
            series3.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
            let bullet3 = series3.bullets.push(new am4charts.CircleBullet());
            bullet3.circle.radius = 3;
            bullet3.circle.strokeWidth = 2;
            bullet3.circle.fill = am4core.color("#fff");
            let range3 = valueAxis2.createSeriesRange(series3);
            range3.value = 0;
            range3.endValue = this.chart_data[0].reorder_level;
            //range3.contents.stroke = am4core.color("#f10");
            range3.contents.stroke = am4core.color("#b34d6b");
            range3.contents.fill = range3.contents.stroke;
            range3.contents.strokeOpacity = 0.7;
            range3.contents.fillOpacity = 0.1;

            let series4 = chart.series.push(new am4charts.LineSeries());
            series4.dataFields.valueY = "buffer_level";
            series4.dataFields.dateX = "date";
            series4.name = "Out of Stock";
            series4.strokeWidth = 2;
            series4.tensionX = 0.7;
            series4.yAxis = valueAxis2;
            series4.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
            //series4.stroke = chart.colors.getIndex(0).lighten(0.5);
            series4.stroke = am4core.color("#787887");
            series4.strokeDasharray = "2,2";
            //
            let bullet4 = series4.bullets.push(new am4charts.CircleBullet());
            bullet4.circle.radius = 0;
            bullet4.circle.strokeWidth = 0;
            bullet4.circle.fill = am4core.color("#fff");

            let series5 = chart.series.push(new am4charts.LineSeries());
            series5.dataFields.valueY = "reorder_level";
            series5.dataFields.dateX = "date";
            series5.name = "Reorder Level";
            series5.strokeWidth = 2;
            series5.tensionX = 0.7;
            series5.yAxis = valueAxis2;
            series5.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
            //series5.stroke = chart.colors.getIndex(0).lighten(0.5);
            series5.stroke = am4core.color("#f10");
            series5.strokeDasharray = "2,2";
            //
            let bullet5 = series5.bullets.push(new am4charts.CircleBullet());
            bullet5.circle.radius = 0;
            bullet5.circle.strokeWidth = 0;
            bullet5.circle.fill = am4core.color("#fff");

            let series6 = chart.series.push(new am4charts.LineSeries());
            series6.dataFields.valueY = "max_level";
            series6.dataFields.dateX = "date";
            series6.name = "Enough Stock";
            series6.strokeWidth = 2;
            series6.tensionX = 0.7;
            series6.yAxis = valueAxis2;
            series6.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
            //series6.stroke = chart.colors.getIndex(0).lighten(0.5);
            series6.stroke = am4core.color("#2ca01c");
            // 
            series6.strokeDasharray = "2,2";
            let bullet6 = series6.bullets.push(new am4charts.CircleBullet());
            bullet6.circle.radius = 0;
            bullet6.circle.strokeWidth = 0;
            // bullet6.circle.fill = am4core.color("#fff");

            // Add cursor
            chart.cursor = new am4charts.XYCursor();

            // Add legend
            // chart.legend = new am4charts.Legend();
            // chart.legend.position = "bottom";

            // Add scrollbar
            //chart.scrollbarX = new am4charts.XYChartScrollbar();
            chart.scrollbarX = new am4core.Scrollbar();
            // chart.scrollbarX.series.push(series1);
            // chart.scrollbarX.series.push(series3);
            chart.scrollbarX.thumb.minWidth = 50;
            chart.scrollbarX.disabled = true;
            //chart.scrollbarX.parent = chart.bottomAxesContainer;
            //chart.chartScrollbarSettings.enabled = false;

            // // Create axes
            // let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            // categoryAxis.dataFields.category = "day";
            // categoryAxis.renderer.minGridDistance = 50;
            // categoryAxis.renderer.grid.template.location = 0.5;
            // categoryAxis.startLocation = 0.5;
            // categoryAxis.endLocation = 0.5;
            //
            // // Pre zoom
            // chart.events.on("datavalidated", function () {
            //     categoryAxis.zoomToIndexes(Math.round(chart.data.length * 0.4), Math.round(chart.data.length * 0.55));
            // });
            //
            // // Create value axis
            // let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            // valueAxis.baseValue = 0;
            // valueAxis.renderer.grid.template.strokeOpacity = 1;
            // valueAxis.renderer.grid.template.stroke = am4core.color("#242424");
            // valueAxis.renderer.grid.template.strokeWidth = 1;
            //
            // // let valueAxisy = chart.xAxes.push(new am4charts.ValueAxis());
            // // valueAxisy.baseValue = 0;
            // // valueAxisy.renderer.grid.template.strokeOpacity = 1;
            // // valueAxisy.renderer.grid.template.stroke = am4core.color("#eee");
            // // valueAxisy.renderer.grid.template.strokeWidth = 1;
            //
            // // Create series
            // let series = chart.series.push(new am4charts.LineSeries());
            // series.dataFields.valueY = "value";
            // series.dataFields.categoryX = "day";
            // series.strokeWidth = 2;
            // series.tensionX = 0.77;
            // series.fillOpacity = 0.1;
            // //
            // let range = valueAxis.createSeriesRange(series);
            // range.value = 0;
            // range.endValue = this.buffer_stock;
            // range.contents.stroke = am4core.color("#b34d6b");
            // range.contents.fill = range.contents.stroke;
            // range.contents.strokeOpacity = 0.7;
            // range.contents.fillOpacity = 0.1;
            //
            // // Create series
            // let series1 = chart.series.push(new am4charts.LineSeries());
            // series1.dataFields.valueY = "buffer_stock";
            // series1.dataFields.categoryX = "day";
            // series1.strokeWidth = 1;
            // // series1.tensionX = 0.77;
            // // series1.fillOpacity = 0.1;
            // // series1.stroke = am4core.color("#f10");
            // // let range1 = valueAxis.createSeriesRange(series1);
            // // range1.value = 0;
            // // range1.endValue = 400000;
            // // range1.contents.stroke = am4core.color("#f10");
            // // range1.contents.fill = range1.contents.stroke;
            // // range1.contents.strokeOpacity = 0.7;
            // // range1.contents.fillOpacity = 0.1;
            //
            //
            //
            //
            // // let range = valueAxis.createSeriesRange(series);
            // // range.value = 0;
            // // range.endValue = -1000;
            // // range.contents.stroke = chart.colors.getIndex(4);
            // // range.contents.fill = range.contents.stroke;
            // // range.contents.strokeOpacity = 0.7;
            // // range.contents.fillOpacity = 0.1;
            //

            // // Add scrollbar
            chart.legend = new am4charts.Legend();
            chart.legend.useDefaultMarker = true;
            let marker = chart.legend.markers.template.children.getIndex(0);
            marker.cornerRadius(2, 2, 2, 2);
            marker.strokeWidth = 1;
            marker.strokeOpacity = 1;
            marker.width = 20;
            marker.height = 20;
            //
            // chart.cursor = new am4charts.XYCursor();
            // chart.scrollbarX = new am4core.Scrollbar();
            // chart.scrollbarX.thumb.minWidth = 50;
            // chart.scrollbarX.parent = chart.bottomAxesContainer;
            //
            // chart.cursor = new am4charts.XYCursor();

        },
        beforeDestroy() {
            if (this.chart) {
                this.chart.dispose();
            }
        }
    }
</script>

<style scoped>
    .hello {
        width: 100%;
        /* height: 360px; */
        height: 250px;
    }
</style>