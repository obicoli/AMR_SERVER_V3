<template>
    <div class="width-100-pc float-left">
        <fusioncharts
            :type="type"
            :width="width"
            :height="height"
            :dataformat="dataFormat"
            :dataSource="dataSource"
            >
      </fusioncharts>
    </div>
</template>
<script>
export default {
    name: "ApexBar",
    data(){
        return {
            type: "column2d",
            renderAt: "chart-container",
            width: "100%",
            height: "350",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Sales vs Purchases",
                    subcaption: "Item Sales against Purchases for the year 2020",
                    xaxisname: "Month(s)",
                    yaxisname: "Sales & Purchase (KES)",
                    numbersuffix: "",
                    theme: "fusion"
                },
                data: [
                    {
                        label: "Jan",
                        value: "290"
                    },
                    {
                        label: "Feb",
                        value: "260"
                    },
                    {
                        label: "Mar",
                        value: "180"
                    },
                    {
                        label: "Apr",
                        value: "140"
                    },
                    {
                        label: "May",
                        value: "115"
                    },
                    {
                        label: "Jun",
                        value: "100"
                    },
                    {
                        label: "Jul",
                        value: "30"
                    },
                    {
                        label: "Aug",
                        value: "30"
                    },
                    {
                        label: "Sep",
                        value: "30"
                    },
                    {
                        label: "Oct",
                        value: "30"
                    },
                    {
                        label: "Nov",
                        value: "30"
                    },
                    {
                        label: "Dec",
                        value: "30"
                    }
                ]
            }
        }
    }
}
</script>