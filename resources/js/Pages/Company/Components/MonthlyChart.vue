<script>
    import { defineComponent } from 'vue'
    import { Bar } from 'vue3-chart-v2'

    export default defineComponent({
        name: 'MonthlyChart',
        extends: Bar,
        props: {
            data: Object,
        },
        mounted () {
            // Overwriting base render method with actual data.
            this.renderChart({
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [
                    {
                        barPercentage: 1,
                        barThickness: 10,
                        maxBarThickness: 12,
                        label: 'Certified contracts',
                        data: this.data,
                        backgroundColor: '#7367F0',
                        borderRadius: 10,
                    }
                ],
                scales: {
                    xAxes: [{
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        }
                    }]
                }
            })
        }
    })
</script>
