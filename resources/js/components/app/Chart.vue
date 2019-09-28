<script>
    import { Line, mixins } from 'vue-chartjs'

    export default {
        extends: Line,
        mixins: [mixins.reactiveData],
        data: () => ({
            chartData: '',
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        }),

        mounted () {
            this.renderChart(this.chartdata, this.options)
        },

        async created() {
            await axios.get('../api/projectsPerMonth')
                .then((response) => {
                    // JSON responses are automatically parsed.
                    const responseData = response.data;
                    this.chartData = {
                        labels: responseData.map(item => item.dates),
                        datasets: [
                            {
                                label: 'Projects per month',
                                backgroundColor: '#04d4ff',
                                data: responseData.map(item => item.total)
                            }
                        ]
                    }
                })
                .catch(e => {
                    this.errors.push(e)
                });
        }
    }

</script>