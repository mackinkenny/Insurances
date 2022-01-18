<template>
    <app-layout>
        <div class="py-6">
            <div class="max-w-7xl">
                <div class="w-full flex flex-nowrap justify-content-between mb-6">
                    <div class="w-full new-box-shadow rounded-lg bg-white p-3 xl:p-5 2xl:p-10 ">
                        <div class="w-full flex justify-end mb-5">
                            <p class="w-6/12 mb-3 mr-6 flex">
                                <select name="" id="" v-model="reportType" class="bg-white  p-2.5 2xl:text-base xl:text-sm text-xs font-sm border w-full rounded-lg placeholder-gray-300 placeholder-opacity-75 focus:outline-none  focus:border-indigo-300 focus:border mr-6">
                                    <option value="1">For today</option>
                                    <option value="2">Weekly</option>
                                    <option value="3">Monthly</option>
                                </select>
                                <button class="main-bg text-white rounded 2xl:text-base lg:text-sm md:text-xs sm:text-xxs px-10 h-full" @click="toExcel">Send </button>
                            </p>
                        </div>
                        <div class="w-full flex justify-end">
                            <p class="w-4/12 mb-3 mr-6">
                                <input
                                    class="bg-white  p-2.5 2xl:text-base xl:text-sm text-xs font-sm border w-full rounded-lg placeholder-gray-300 placeholder-opacity-75 focus:outline-none  focus:border-indigo-300 focus:border"
                                    type="date"
                                    name="date"
                                    placeholder="14.7.2021"
                                    @change="searchContracts"
                                    v-model="startDateFilter"
                                >
                            </p>
                            <p class="w-3/12 mb-3">
                                <input
                                    class="bg-white  p-2.5 2xl:text-base xl:text-sm text-xs    font-xs font-normal border w-full rounded-lg placeholder-gray-400 placeholder-opacity-75 focus:outline-none  focus:border-indigo-300 focus:border"
                                    type="search"
                                    name="search"
                                    placeholder="Search"
                                    v-model="searchQuery"
                                    v-on:input="onSearch"
                                >
                            </p>

                        </div>
                        <div v-if="contracts.data.length !== 0 && !isLoading">
                            <div
                                class=" grid grid-cols-6 gap-y-2 gap-x-5 justify-items-start items-center new-bg-purple-100 w-full px-6 py-3 bg-gray-200 2xl:text-xs text-xxs tracking-wide font-bold uppercase rounded">
                                <p class="col-start-1 col-end-3">Policy Number</p>
                                <p>Start date</p>
                                <p>End Date</p>
                                <p>Country</p>
                                <p>Details</p>
                            </div>
                            <div v-for="(contract, contractIndex) in contracts.data">
                                <div class="details mt-2" v-bind:class="{'open-details-block': detail === index, 'border border-black rounded': detail === contractIndex}">

                                    <div
                                        class="relative  grid grid-cols-6 gap-y-2 gap-x-5 justify-items-start items-center bg-gray-50 w-full px-6 py-4  text-xs  2xl:text-sm  font-normal rounded">
                                        <p class="font-bold col-start-1 col-end-3">{{ contract.policy_number }}</p>
                                        <p class="font-normal">{{
                                            moment(contract.start_date).format("MMM DD, YYYY - HH:mm a")
                                            }}</p>
                                        <!--                                <p>{{ moment(contract.start_date).format("MMM DD, YYYY") }}</p>-->
                                        <!--                                <p>{{ moment(contract.start_date).format("HH:mm a") }}</p>-->
                                        <p class="font-normal">{{
                                            moment(contract.end_date).format("MMM DD, YYYY - HH:mm a")
                                            }}</p>
                                        <p class="font-normal">{{ contract.country.name }}</p>
                                        <p
                                            class="text-indigo-600 font-normal cursor-pointer"
                                            :class="{'block-close': detail !== contractIndex, 'block-open': detail === contractIndex}"
                                            @click="detail = detail !== contractIndex ? contractIndex : null"
                                        >
                                            <span
                                                v-if="detail !== contractIndex"
                                            >
                                                details
                                            </span>
                                            <span
                                                v-else
                                            >
                                                Close
                                            </span>
                                        </p>
                                    </div>
                                    <!-- details block start-->
                                    <div class="grid grid-cols-1 w-full" v-bind:class="{'hidden': detail !== contractIndex, 'rounded': detail === contractIndex}">
                                        <div
                                            class="grid grid-cols-6 gap-x-5 justify-items-start items-center new-bg-purple-100 w-full px-6 py-4  text-xs  2xl:text-sm  font-normal uppercase rounded-xs">
                                            <p class="col-start-1 col-end-3">Uploaded by</p>
                                            <p>IP address</p>
                                            <p>Date</p>
                                            <p>Time</p>
                                            <p></p>
                                        </div>
                                        <div
                                            class="relative   grid grid-cols-6  gap-x-5 justify-items-start items-center bg-gray-50 w-full px-6 py-4  text-xs  2xl:text-sm  font-normal rounded">
                                            <div
                                                class="font-bold col-start-1 col-end-3 flex justify-between items-center">
                                                <p class="mr-2"><img class="max-h-10 max-w-16 pr-4" :src="s3_storage + '/' + (contract.uploader ? contract.uploader.logo : contract.company.logo)"
                                                                     alt="company logo"></p>
                                                <p class="flex flex-col items-start"><span class="text-md">{{
                                                        contract.uploader ? contract.uploader.title : contract.company.title
                                                    }}</span></p>
                                            </div>
                                            <p class="font-normal">{{ contract.ip_address }}</p>
                                            <p class="font-normal">{{
                                                moment(contract.created_at).format("MMM DD, YYYY")
                                                }}</p>
                                            <p class="font-normal">{{ moment(contract.created_at).format("HH:mm a") }}</p>
                                            <p></p>
                                        </div>
                                    </div>
                                    <!-- details block end-->
                                </div>
                            </div>
                            <div class="mt-8" v-if="contracts.links.length > 3">
                                <div class="flex flex-wrap -mb-1">
                                    <template v-for="(link, p) in contracts.links" :key="p">
                                        <div v-if="parseInt(link.label) && !link.active" class="mr-1 mb-1 px-3 py-2 text-xs h-full leading-4 border-transparent border hover:border-gray-300 hover:bg-white focus:border-indigo-500 focus:text-indigo-500 cursor-pointer"
                                             style="font-size: .85rem;" @click="searchContracts(link.label)" v-html="link.label"></div>
                                        <div v-if="parseInt(link.label) && link.active" class="mr-1 mb-1 px-3 py-2 text-xs h-full leading-4 border-transparent border bg-ins-2"
                                             style="font-size: .85rem;" v-html="link.label">
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-center py-4" v-if="contracts.data.length === 0">
                            <p class="2xl:text-sm lg:text-sm md:text-xs sm:text-xxs uppercase main-text tracking-wider">
                                Contracts list is empty
                            </p>
                        </div>
                        <div class="flex items-center justify-center py-4" v-if="isLoading">
                            <p class="2xl:text-sm lg:text-sm md:text-xs sm:text-xxs main-text tracking-wider">
                                Loading...
                            </p>
                        </div>
                    </div>
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center" v-if="reportLoading === true" style="z-index: 1000; background-color: rgba(229, 231, 235, 0.5);">
                        <p class="text-black text-load">Loading ...</p>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import moment from "moment";
    import Swal from 'sweetalert2'


    export default {
        name: "Index",
        props: ['company', 'contrs'],
        components: {
            AppLayout
        },
        data() {
            return {
                storage: window.location.origin,
                s3_storage: process.env.MIX_AWS_PUBLIC_STORAGE,
                detail: null,
                contracts: this.contrs,
                typing: null,
                searchTimer: 1000,
                searchQuery: null,
                startDateFilter: null,
                isLoading: false,
                reportType: 1,
                reportLoading: false,
            }
        },
        computed: {
            moment() {
                return moment;
            }
        },
        methods: {
            onSearch() {
                clearTimeout(this.typing);
                this.typing = setTimeout(this.searchContracts, this.searchTimer);
            },
            searchContracts(page) {
                this.isLoading = true;
                let active = page === undefined ? 1 : page;
                axios.post(`/company/${this.company.id}/contracts/search?page=` + active, {
                    keyword: this.searchQuery,
                    date: this.startDateFilter
                }).then(response => {
                    this.detail = null;
                    this.contracts = response.data;
                    this.isLoading = false;
                })
            },
            toExcel() {
                this.reportLoading = true;
                axios.get(`/toExcel/${this.reportType}/${this.company.id}` ).then(response => {
                    Swal.fire({
                        text: 'Report was successfully sent',
                        backdrop: false,
                        showConfirmButton: false,
                        timer: 1500,
                        position: 'top-end',
                        background: '#87DDA0'
                    });
                    this.reportLoading = false;
                }).catch(function (error) {
                    // handle error
                    Swal.fire({
                        text: 'something went wrong',
                        backdrop: false,
                        showConfirmButton: false,
                        timer: 1500,
                        position: 'top-end',
                        background: '#ff1010'
                    });
                    this.reportLoading = false;
                });
                // const url = '/toExcel/' + this.reportType;
                // window.open(this.route().t.url + url, '_blank');
            }
        }
    }
</script>

<style scoped>

</style>
