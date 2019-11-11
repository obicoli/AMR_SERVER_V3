import { Line} from 'vue-chartjs'

export default {
    extends: Line,
    props: ['labels','datasets'],
    mounted () {
        this.renderChart({
            labels: this.labels,
            datasets: this.datasets,
        },
        {
            maintainAspectRatio:false,
            scales: {
                yAxes: [{
                    gridLines: {
                        display: true,
                        color: 'transparent',
                        zeroLineColor: 'transparent',
                        drawBorder: false,
                        lineWidth: 27,
                        zeroLineWidth: 1
                    },
                    ticks: {
                        beginAtZero: true,
                        display: true
                    }
                }]
            }
        })
    }
}