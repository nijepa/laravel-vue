<template>
    <div class="container">
        <line-chart
                v-if="loaded"
                :chartdata="chartdata"
                :options="options"/>
    </div>
</template>

<script>
    import LineChart from './Chart.vue'

    export default {
        name: 'LineChartContainer',

        components: { LineChart },

        data: () => ({
            loaded: false,
            chartdata: null,
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        }),

        created() {
            //this.loaded = false;

                axios.get('../api/indexGrouped')
                    .then(response => {
                        // JSON responses are automatically parsed.
                        const responseData = response.data;
                        this.chartData = {
                            labels: responseData.map(item => item.day),
                            datasets: [
                                label: 'Daily Students',
                                backgroundColor: '#f87979',
                                data: responseData.map(item => item.total)
                            ]
                        }
                    })
                    .catch(e => {
                        this.errors.push(e)
                    });
                console.log(this.chartdata);
                this.loaded = true
        }
    }
</script>
