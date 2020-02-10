import { Pie} from 'vue-chartjs'

export default {
    extends: Pie,
    props: ['server_data'],
    data(){
        return {
            datasets: [40,70]
        }
    },
    mounted () {
        //'labels','datasets',
        // this.renderChart({
        //     labels: this.labels,
        //     datasets: this.datasets,
        // }, {maintainAspectRatio:false})
        // for (let index = 0; index < this.server_data.length; index++) {
        //     const element = this.server_data[index];
        //     this.datasets.push(element.category_value);
        // }
        this.renderChart(this.datasets, {maintainAspectRatio:false});
    }
}