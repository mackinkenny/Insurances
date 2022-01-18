<template>
    <app-layout>
        <div class="py-6">
            <div class="max-w-7xl">
                <div class="w-full flex flex-nowrap justify-content-between mb-6">
                    <div class="w-full new-box-shadow rounded-lg bg-white p-3 xl:p-5 2xl:p-10 ">
                        <div class="w-full flex justify-end mb-5">
                            <p class="w-3/12 mr-6">
                                <select v-model="company" v-on:change="getResult"
                                        class="2xl:py-2.5 xl:py-2 py-1.5 border rounded mr-8 2xl:text-sm xl:text-xs text-xxs ins-input w-full"
                                        style="background: #FBFBFB; border-color:#B9B9C3;"
                                >
                                    <option :value="null">All companies</option>
                                    <option :value="company.id" v-for="company in companies">{{company.title}}</option>
                                </select>
                            </p>
                            <p class="w-3/12"><input
                                class="2xl:py-2.5 xl:py-2 py-1.5 border rounded mr-8 2xl:text-sm lg:text-xs text-xxs ins-input w-full"
                                style="background: #FBFBFB; border-color:#B9B9C3;"
                                type="search" name="search" v-model="search" v-on:input="onSearch" placeholder="Search"></p>

                        </div>
                        <div
                            class=" grid grid-cols-6 gap-y-2 gap-x-5 justify-items-start items-center new-bg-purple-100 w-full px-6 py-3 bg-gray-200 2xl:text-xs text-xxs tracking-wide font-bold uppercase rounded"  style="color: #5E5873; letter-spacing: 1px;">
                            <p class="col-start-1 col-end-3">Insurance Company</p>
                            <p>Policy Number</p>
                            <p>Start date</p>
                            <p>End Date</p>
<!--                            <p class="date-select h-4 w-14 cursor-pointer" @click="setSort">-->
<!--                                    <span class="relative ">Date-->
<!--&lt;!&ndash;                                    <img class="absolute -mt-6 ml-10" v-bind:class="{'filter brightness-200': sortDate == 'desc'}"&ndash;&gt;-->
<!--&lt;!&ndash;                                         src="/img/arrow-top-list.png" alt="top">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <img class="absolute -mt-3 ml-10" v-bind:class="{'filter brightness-200': sortDate == 'asc'}"&ndash;&gt;-->
<!--&lt;!&ndash;                                         src="/img/arrow-bottom-list.png"&ndash;&gt;-->
<!--&lt;!&ndash;                                         alt="top">&ndash;&gt;-->
<!--                                    </span>-->
<!--                            </p>-->
                            <p>Country</p>
                        </div>
                        <div v-if="!isLoading && contracts.data">
                        <div v-for="(contract, index) in contracts.data">
                            <div class="details  block-close mt-2 " v-bind:class="{'border border-details rounded': showContr === contract.id}">
                                <div
                                    class="cursor-pointer relative  grid grid-cols-12 gap-y-2 gap-x-5 justify-items-start items-center bg-gray-50 w-full px-6 py-4  text-xs  2xl:text-sm  font-normal rounded-xs"
                                    v-bind:class="{'rounded': showContr === contract.id}"
                                    @click="showContr = showContr === contract.id ? null : contract.id">
                                    <img class="max-h-10 max-w-16  col-start-1 col-end-2 justify-self-center"
                                         :src="s3_storage + '/' + contract.company.logo" alt="">
                                    <p class=" col-start-2 col-end-5 font-bold"  style="color: #5E5873; letter-spacing: 1px;">
                                        {{contract.company.title}}
                                    </p>
                                    <p class=" col-start-5 col-end-7 font-normal">{{contract.policy_number}}</p>
                                    <p class=" col-start-7 col-end-9 font-normal">{{moment(contract.start_date).format("MMM DD, YYYY - HH:mm a")}}</p>
                                    <p class=" col-start-9 col-end-11 font-normal">{{moment(contract.end_date).format("MMM DD, YYYY - HH:mm a")}}</p>
                                    <p class=" col-start-11 col-end-13 font-normal">{{contract.country ? contract.country.name : ''}}</p>
                                </div>
                                <!-- details block start-->
                                <div class="grid grid-cols-1 w-full"
                                     v-bind:class="{'hidden': showContr !== contract.id, 'rounded': showContr === contract.id}">
                                    <div
                                        class="grid grid-cols-6 gap-x-5 justify-items-start items-center new-bg-purple-100 w-full px-6 py-4  2xl:text-xs text-xxs  font-bold uppercase rounded-xs" style="color: #5E5873; letter-spacing: 1px;">
                                        <p class="col-start-1 col-end-3">Uploaded by</p>
                                        <p>Contract ID</p>
                                        <p>IP address</p>
                                        <p>Date</p>
                                        <p>Time</p>
                                    </div>
                                    <div v-bind:class="{'rounded': showContr === contract.id}"
                                        class="relative   grid grid-cols-6  gap-x-5 justify-items-start items-center bg-gray-50 w-full px-6 py-4  text-xs  2xl:text-sm  font-normal rounded-xs" style="color: #5E5873;">
                                        <div class="font-bold col-start-1 col-end-3 flex justify-between items-center">
                                            <p class="mr-2"><img class="max-h-10 max-w-16 pr-4" :src="s3_storage + '/' + (contract.uploader ? contract.uploader.logo : contract.company.logo)"
                                                                 alt="company logo"></p>
                                            <p class="flex flex-col items-start" style="color: #5E5873; letter-spacing: 1px;"><span class="text-md">{{contract.uploader ? contract.uploader.title : contract.company.title}}</span>
                                            </p>
                                        </div>
                                        <p class="font-normal">{{contract.id}}</p>
                                        <p class="font-normal">{{contract.ip_address}}</p>
                                        <p class="font-normal">{{moment(contract.created_at).format("MMM DD, YYYY")}}</p>
                                        <p class="font-normal">{{moment(contract.created_at).format("HH:mm a")}}</p>

                                    </div>
                                </div>
                                <!-- details block end-->
                            </div>
                        </div>
                            <div class="mt-8" v-if="contracts.links.length > 3">
                                <div class="flex flex-wrap -mb-1">
                                    <template v-for="(link, p) in contracts.links" :key="p">
                                        <div v-if="parseInt(link.label) && !link.active" class="mr-1 mb-1 px-3 py-2 text-xs h-full leading-4 border-transparent border hover:border-gray-300 hover:bg-white focus:border-indigo-500 focus:text-indigo-500 cursor-pointer"
                                             style="font-size: .85rem;" @click="getResult(link.label)" v-html="link.label"></div>
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
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>import AppLayout from '@/Layouts/AppLayout'
import moment from 'moment'

export default {
    name: "Main",
    components: {
        AppLayout
    },
    props: {
        contrs: Object,
        companies: Object,
        // pagination: [Array, Object]
    },
    created: function () {
        this.moment = moment;
    },
    data: function () {
        return {
            company: null,
            storage: window.location.origin,
            s3_storage: process.env.MIX_AWS_PUBLIC_STORAGE,
            search: null,
            typing: null,
            searchTimer: 1000,
            isLoading: false,
            contracts: this.contrs,
            sortDate: 'desc',
            showContr: null,
        }
    },
    methods: {
        onSearch() {
            clearTimeout(this.typing);
            this.typing = setTimeout(this.getResult, this.searchTimer);
        },
        setSort() {
            this.sortDate = this.sortDate === 'desc' ? 'asc' : 'desc';
            this.getResult();
        },
        getResult(page) {
            this.isLoading = true;
            let active = page === undefined ? 1 : page;
            axios.post('/contract/search?page=' + active, {value: this.search, company: this.company, date: this.sortDate}).then(response => {
                this.contracts = response.data;
                this.isLoading = false;
            });
        }
    }
}
</script>

<style scoped>

</style>
