<template>
    <app-layout>
        <div class="py-6">
            <div class="max-w-7xl">
                <div class="grid grid-cols-3">
                    <div class="pr-4">
                        <div class="rounded bg-white p-5 text-center" style="box-shadow: 0px 4px 24px rgba(0, 0, 0, 0.06);">

                            <img :src="storage + '/images/admin-icon1.png'" alt="" class="mx-auto" style="width: 75px; height: 75px;">

                            <div class="pt-4 text-center">
                                <p class="main-text 2xl:text-2xl xl:text-xl lg:text-base md:text-sm font-bold">
                                    {{Intl.NumberFormat('ru-RU').format(total_contracts)}}
                                </p>
                                <p class="main-text 2xl:text-base xl:text-sm lg:text-xs font-normal">
                                    Total Certified Policies
                                </p>
                            </div>
                        </div>
                        <div class="rounded bg-white p-5 text-center mt-4" style="box-shadow: 0px 4px 24px rgba(0, 0, 0, 0.06);">
                            <img :src="storage + '/images/admin-icon3.png'" alt="" class="mx-auto" style="width: 75px; height: 75px;">
                            <div class="pt-4 text-center">
                                <p class="main-text 2xl:text-2xl xl:text-xl lg:text-base md:text-sm font-bold">
                                    {{Intl.NumberFormat('ru-RU').format(ly_contracts)}}
                                </p>
                                <p class="main-text 2xl:text-base xl:text-sm lg:text-xs font-normal">
                                    LY Certified Policies
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="pr-4">
                        <div class="rounded bg-white p-5 text-center" style="box-shadow: 0px 4px 24px rgba(0, 0, 0, 0.06);">
                            <img :src="storage + '/images/admin-icon2.png'" alt="" class="mx-auto" style="width: 75px; height: 75px;">
                            <div class="pt-4 text-center">
                                <p class="main-text 2xl:text-2xl xl:text-xl lg:text-base md:text-sm font-bold">
                                    {{Intl.NumberFormat('ru-RU').format(total_tokens)}}
                                </p>
                                <p class="main-text 2xl:text-base xl:text-sm lg:text-xs font-normal">
                                    Total Tokens Sold
                                </p>
                            </div>
                        </div>
                        <div class="rounded bg-white p-5 text-center mt-4" style="box-shadow: 0px 4px 24px rgba(0, 0, 0, 0.06);">
                            <img :src="storage + '/images/admin-icon4.png'" alt="" class="mx-auto" style="width: 75px; height: 75px;">

                            <div class="pt-4 text-center">
                                <p class="main-text 2xl:text-2xl xl:text-xl lg:text-base md:text-sm font-bold">
                                    {{Intl.NumberFormat('ru-RU').format(ly_tokens)}}
                                </p>
                                <p class="main-text 2xl:text-base xl:text-sm lg:text-xs font-normal">
                                    LY Token Sold
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded bg-white p-5 text-left" style="box-shadow: 0px 4px 24px rgba(0, 0, 0, 0.06);">
                        <div>
                            <p class="main-text 2xl:text-base xl:text-sm lg:text-xs font-bold">
                                Searches Analytics
                            </p>
                            <div class="2xl:px-6 xl:px-4 px-0">
                                <vue3-chart-js
                                    :data="doughnutChart.data"
                                    :id="doughnutChart.id"
                                    :type="doughnutChart.type"
                                    @before-render="beforeRenderLogic"
                                ></vue3-chart-js>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="rounded bg-white p-5 text-center" style="box-shadow: 0px 4px 24px rgba(0, 0, 0, 0.06);">
                        <div>
                            <vue3-chart-js
                                :data="lineChart.data"
                                :id="lineChart.id"
                                :options="lineChart.options"
                                :type="lineChart.type"
                                @before-render="beforeRenderLogic"
                            ></vue3-chart-js>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Vue3ChartJs from '@j-t-mcc/vue3-chartjs'

    export default {
        components: {
            AppLayout,
            Vue3ChartJs,
        },
        props: {
            total_contracts: Number,
            total_tokens: Number,
            ly_contracts: Number,
            ly_tokens: Number,
            dataTokens: Array,
            dataContracts: Array,
            searchesDone: Number,
            searchesMatched: Number
        },
        data() {
            return {
                storage: window.location.origin,
            }
        },
        setup(props) {
            const lineChart = {
                id: 'line',
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: [
                        {
                            data: props.dataContracts,
                            label: 'Certified policies',
                            backgroundColor: '#FF9F43',
                            borderColor: '#FF9F43',
                            tension: 0.5,
                            pointBorderWidth: 0,
                            pointHitRadius: 0,
                            pointBackgroundColor: 'transparent',
                        },
                        {
                            data: props.dataTokens,
                            label: 'Tokens',
                            backgroundColor: '#7367F0',
                            borderColor: '#7367F0',
                            tension: 0.5,
                            pointBorderWidth: 0,
                            pointHitRadius: 0,
                            pointBackgroundColor: 'transparent'
                        },
                    ]
                },
                options: {
                    responsive: true,
                    bezierCurve: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Revenue'
                        },
                    },
                    interaction: {
                        intersect: false,
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                            }
                        },
                        y: {
                            grid: {
                                drawBorder: false,
                                color: function (context) {
                                    if (context.tick.value > 0) {
                                        return 'rgb(239,239,239)';
                                    } else if (context.tick.value < 0) {
                                        return 'rgb(239,239,239)';
                                    }
                                    return '#fefefe';
                                },
                            },
                        }
                    }
                },
            }

            const doughnutChart = {
                id: 'doughnut',
                type: 'doughnut',
                data: {
                    labels: ['Searches matched', 'Searches done'],
                    datasets: [
                        {
                            backgroundColor: [
                                '#28C76F',
                                'rgba(186, 191, 199, 0.12)',
                            ],
                            data: [props.searchesDone, props.searchesMatched],
                            barThickness: 1,
                        }
                    ]
                }
            }

            const beforeRenderLogic = (event) => {
                //...
                //if(a === b) {
                //  event.preventDefault()
                //}
            }

            return {
                doughnutChart,
                lineChart,
                beforeRenderLogic
            }
        },

    }
</script>

<style scoped>

</style>
