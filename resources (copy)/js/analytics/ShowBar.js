import { Bar} from 'vue-chartjs'

export default {
    extends: Bar,
    props: ['labels','datasets'],
    mounted () {
        this.renderChart({
            labels: this.labels,
            datasets: this.datasets,
        }, {maintainAspectRatio:false})
    }
}