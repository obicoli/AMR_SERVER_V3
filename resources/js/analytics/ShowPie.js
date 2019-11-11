import { Pie} from 'vue-chartjs'

export default {
    extends: Pie,
    props: ['labels','datasets'],
    mounted () {
        // this.renderChart({
        //     labels: this.labels,
        //     datasets: this.datasets,
        // }, {maintainAspectRatio:false})
        this.renderChart(this.datasets, {maintainAspectRatio:false});
    }
}