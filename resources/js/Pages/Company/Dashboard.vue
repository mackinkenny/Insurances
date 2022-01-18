<template>
    <app-layout>
        <div class="w-full py-6 box-border">
            <div class="w-full flex justify-content-between mb-8">
                <div class="w-1/2 flex justify-start  items-center">
                    <p><img class="2xl:w-28 xl:w-24 lg:w-20 w-16 mr-2" :src="s3_storage + '/' + company.logo"
                            alt="company logo"></p>
                    <p class="flex flex-col justify-start items-start ">
                        <span class=" 2xl:text-3xl xl:text-2xl lg:text-xl text-lg text-left font-bold">{{company.title}}</span>
                        <span class="2xl:text-lg xl:text-base lg:text-sm text-left font-normal">{{company.tax_id}} (Tax ID)</span>
                    </p>
                </div>
                <div class="w-1/2 flex flex-col justify-center  items-end" v-if="company.parent">
                    <div class="2xl:text-3xl xl:text-2xl lg:text-xl text-base text-right font-bold">Associated with</div>

                    <div class="flex flex-row justify-between items-start ">
                        <img  class="2xl:w-10 xl:w-9 lg:w-8 w-7 mr-1" :src="s3_storage + '/' + company.parent.logo"
                              alt="company logo">
                        <p class="2xl:text-xs xl:text-xxs text-xxs text-right font-normal">{{company.parent.title}}</p>
                    </div>
                </div>
            </div>

            <div class="w-full flex flex-nowrap justify-content-between mb-6">
                <div class="w-5/12 new-box-shadow rounded-lg mr-6 2xl:p-10 xl:p-8 p-6 bg-white">
                    <p class="mb-5">
                        <label class="2xl:text-base xl:text-sm text-sm font-medium " for="phone">Phone for assistance</label>
                        <vue-tel-input v-model="company.phone" mode="international" class="w-full mt-1 overflow-hidden"
                            style="border: 1px solid #D8D6DE; border-radius: 0.5rem"
                            v-on:change="companyEdit = true"
                            onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 43'
                            placeholder=""
                        />
                    </p>
                    <p class="mb-5">
                        <label class="2xl:text-base xl:text-sm text-sm  font-medium " for="adress">Address</label>
                        <input class="2xl:p-2.5 xl:p-2 lg:p-1.5 p-1.5 2xl:text-base xl:text-sm text-xs  font-normal border w-full rounded-lg text-gray-600 focus:text-black placeholder-gray-300 focus:outline-none border-gray-300 focus:border-indigo-300 focus:border disabled-input" type="text"
                               name="adress" id="adress" :value="company.address" placeholder="" disabled>
                    </p>
                    <p class="mb-5">
                        <label class="2xl:text-base xl:text-sm text-sm  font-medium " for="number">Insurance Identification Number</label>
                        <input class="2xl:p-2.5 xl:p-2 lg:p-1.5 p-1.5 2xl:text-base xl:text-sm text-xs  font-normal border w-full rounded-lg text-gray-600 focus:text-black placeholder-gray-300 focus:outline-none border-gray-300 focus:border-indigo-300 focus:border disabled-input" type="text"
                               name="number" id="number" :value="company.tax_id" placeholder="" disabled>
                    </p>
                    <div v-if="companyEdit">
                        <button @click="saveCompany" type="submit" class="main-bg text-white rounded 2xl:text-base lg:text-sm md:text-xs sm:text-xxs px-8 py-2"
                                :disabled="isLoading" >Save changes
                        </button>
<!--                        <button class="bg-white rounded 2xl:text-base lg:text-sm md:text-xs sm:text-xxs px-8 py-2 ml-4"-->
<!--                                style="color: #7367F0; border: 1px solid #7367F0;"-->
<!--                                @click="resetCompany">Reset-->
<!--                        </button>-->
                    </div>
                </div>
                <div class="w-7/12 new-box-shadow rounded-lg   p-6 xl:p-8 2xl:p-10 bg-white">
                    <p class="2xl:text-xl xl:text-lg text-base  mb-5 font-bold w-full text-left">Statistics of the certified contracts</p>
<!--                    <MonthlyChart :data="data" class="text-xs" />-->
                    <div>
                        <vue3-chart-js
                            :id="barChart.id"
                            :type="barChart.type"
                            :data="barChart.data"
                            @before-render="beforeRenderLogic"
                        ></vue3-chart-js>
                    </div>
                </div>
            </div>

            <div class="w-full  mb-6" v-if="!$page.props.user.company_id">
                <div class="new-box-shadow rounded-lg bg-white  p-6 xl:p-8 2xl:p-10 w-full flex flex-nowrap flex-col">
                    <p class="2xl:text-xl xl:text-lg text-base mb-5 font-bold w-full text-left">Responsible</p>
                    <div class="flex justify-start items-center w-full">
                        <div class="mb-5 w-5/12 mr-4 pr-3 xl:pr-5 2xl:pr-10" >
                            <p class="mb-5">
                                <label class="2xl:text-base xl:text-sm text-sm font-medium " for="name">Name</label>
                                <input class="2xl:p-2.5 xl:p-2 lg:p-1.5 p-1.5 2xl:text-base xl:text-sm text-xs font-normal border w-full rounded-lg text-gray-600 focus:text-black opacity-75 focus:outline-none border-gray-300 focus:border-indigo-300 focus:border"
                                       type="text" name="name" id="name" @change="responsiveEdit = true" v-model="responsive.name" placeholder="Jax Teller">
                            </p>
                            <p class="mb-5">
                                <label class="2xl:text-base xl:text-sm text-sm font-medium " for="position">Position</label>
                                <input class="2xl:p-2.5 xl:p-2 lg:p-1.5 p-1.5 2xl:text-base xl:text-sm text-xs font-normal border w-full rounded-lg text-gray-600 focus:text-black opacity-75 focus:outline-none border-gray-300 focus:border-indigo-300 focus:border"
                                       type="text" name="position" id="position" @change="responsiveEdit = true" v-model="responsive.position" placeholder="Director">
                            </p>
                        </div>
                        <div class="mb-5 w-5/12">
                            <p class="mb-5">
                                <label class="2xl:text-base xl:text-sm text-sm font-medium " for="user-phone">Phone</label>
                                <input class="2xl:p-2.5 xl:p-2 lg:p-1.5 p-1.5 2xl:text-base xl:text-sm text-xs font-normal border w-full rounded-lg text-gray-600 focus:text-black opacity-75 focus:outline-none border-gray-300 focus:border-indigo-300 focus:border"
                                       type="text" name="user-phone" id="user-phone" @change="responsiveEdit = true" v-model="responsive.phone" placeholder="+7 (902) 750-98-00">
                            </p>
                            <p class="mb-5">
                                <label class="2xl:text-base xl:text-sm text-sm font-medium " for="email">Email</label>
                                <input class="2xl:p-2.5 xl:p-2 lg:p-1.5 p-1.5 2xl:text-base xl:text-sm text-xs font-normal border w-full rounded-lg text-gray-600 focus:text-black opacity-75 focus:outline-none border-gray-300 focus:border-indigo-300 focus:border"
                                       type="email" name="email" id="email" @change="responsiveEdit = true" v-model="responsive.email" placeholder="1@1.com">
                            </p>
                        </div>
                    </div>
                    <div v-if="responsiveEdit">
                        <button @click="saveResponsive" type="submit" class="main-bg text-white rounded 2xl:text-base lg:text-sm md:text-xs sm:text-xxs px-12 py-2"
                                :disabled="isLoading" >Save changes
                        </button>
<!--                        <button class="bg-white rounded 2xl:text-base lg:text-sm md:text-xs sm:text-xxs px-10 py-2 ml-4"-->
<!--                                style="color: #7367F0; border: 1px solid #7367F0;"-->
<!--                                @click="resetResponsive">Reset-->
<!--                        </button>-->
                    </div>

                </div>
            </div>

        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import MonthlyChart from '@/Pages/Company/Components/MonthlyChart.vue'
    import Vue3ChartJs from '@j-t-mcc/vue3-chartjs'
    import {VueTelInput} from 'vue-tel-input';
    import 'vue-tel-input/dist/vue-tel-input.css';
    import Swal from "sweetalert2";

    export default {
        name: "List",
        components: {
            AppLayout,
            VueTelInput,
            MonthlyChart,
            Vue3ChartJs,
        },
        props: {
            company: Object,
            options: Object
        },
        data: function () {
            return {
                storage: window.location.origin,
                s3_storage: process.env.MIX_AWS_PUBLIC_STORAGE,
                companyDate: '',
                responsive: {
                    name: '',
                    position: '',
                    email: '',
                    phone: ''
                },
                responsiveEdit: false,
                companyEdit: false,
                isLoading: false,
            }
        },
        mounted () {
            this.resetCompany();
            this.resetResponsive();
        },
        setup (props) {
            const barChart = {
                id: 'bar',
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: [
                        {
                            data: props.options,
                            barPercentage: 1,
                            barThickness: 10,
                            maxBarThickness: 12,
                            label: 'Certified contracts',
                            backgroundColor: '#7367F0',
                            borderRadius: 10,
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
                barChart,
                beforeRenderLogic
            }
        },
        methods: {
            resetCompany() {
                this.companyDate = this.company.phone;
                this.companyEdit = false;
            },
            resetResponsive() {
                this.responsive.name = this.company.owner.name;
                this.responsive.position = this.company.owner.position;
                this.responsive.phone = this.company.owner.phone;
                this.responsive.email = this.company.owner.email;
                this.responsiveEdit = false;
            },
            saveResponsive() {
                this.isLoading = true;
                axios.post('/company/updateResponsive', {
                    name: this.responsive.name,
                    phone: this.responsive.phone,
                    position: this.responsive.position,
                    email: this.responsive.email,
                }).then(response => {
                    if (response) {
                        this.responsiveEdit = false;
                        this.isLoading = false;
                        Swal.fire({
                            text: 'Information was successfully updated',
                            backdrop: false,
                            showConfirmButton: false,
                            timer: 1500,
                            position: 'top-end',
                            background: '#87DDA0'
                        });
                    }
                })
            },

            saveCompany() {
                this.isLoading = true;
                axios.post('/company/updatePhone', {
                    phone: this.company.phone,
                }).then(response => {
                    if (response) {
                        this.companyEdit = false;
                        this.isLoading = false;
                        Swal.fire({
                            text: 'Information was successfully updated',
                            backdrop: false,
                            showConfirmButton: false,
                            timer: 1500,
                            position: 'top-end',
                            background: '#87DDA0'
                        });
                    }
                })
            }
        }

    }
</script>

<style scoped>

</style>
