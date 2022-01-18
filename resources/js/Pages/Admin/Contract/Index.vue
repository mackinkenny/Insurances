<template>
    <app-layout>
        <div class="py-6">
            <div class="max-w-7xl">
                <div class="w-full flex flex-nowrap justify-content-between mb-6">

                    <div class="w-full new-box-shadow rounded-lg bg-white p-6 xl:p-8 2xl:p-10 ">
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

                            <p class="w-3/12"><input v-model="search" v-on:input="onSearch"
                                                     class="2xl:py-2.5 xl:py-2 py-1.5 border rounded mr-8 2xl:text-sm lg:text-xs text-xxs ins-input w-full"
                                                     style="background: #FBFBFB; border-color:#B9B9C3;"
                                                     type="search" name="search" placeholder="Search"></p>

                        </div>
                        <div
                            class=" grid grid-cols-6 gap-y-2 gap-x-5 justify-items-start items-center new-bg-purple-100 w-full px-6 py-3 bg-gray-200 2xl:text-xs text-xxs  tracking-wide font-bold uppercase rounded" style="color: #5E5873; letter-spacing: 1px;">
                            <p>Contract ID</p>
                            <p>Policy Number</p>
                            <p>Insurance Company</p>
                            <p>IP address</p>
                            <p class="date-select h-4 w-14 cursor-pointer" @click="setSort">
                                    <span class="relative ">Date
                                    <img class="absolute -mt-6 ml-10" v-bind:class="{'filter brightness-200': sortDate == 'desc'}"
                                         src="/img/arrow-top-list.png" alt="top">
                                    <img class="absolute -mt-3 ml-10" v-bind:class="{'filter brightness-200': sortDate == 'asc'}"
                                         src="/img/arrow-bottom-list.png"
                                         alt="top">
                                    </span>
                            </p>
                            <p class="time-select">
                                <span class="relative">Time</span>
                            </p>
                        </div>
                        <div v-if="!isLoading && contracts != []">
                            <div class="details relative block-close" v-for="(contract, contractIndex) in contracts.data">
                                <div
                                    class="mt-2  grid grid-cols-6 gap-y-2 gap-x-5 justify-items-start items-center bg-gray-50 w-full px-6 py-4  2xl:text-sm text-xs  font-normal rounded-xs"
                                    @click="contractDetailIndex = contractDetailIndex !== contractIndex ? contractIndex : null" style="color: #5E5873;"
                                >
                                    <p>{{ contract.id }}</p>
                                    <p>{{ contract.policy_number }}</p>
                                    <p>{{ contract.company.title }}</p>
                                    <p>{{ contract.ip_address }}</p>
                                    <p>{{ moment(contract.created_at).format("MMM DD, YYYY") }}</p>
                                    <p>{{ moment(contract.created_at).format("HH:mm a") }}</p>
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

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import moment from 'moment'

    export default {
        name: "Index",
        components: {
            AppLayout
        },
        props: {
            companies: Object,
            contrs: Object,

        },
        data: function () {
            return {
                company: null,
                search: null,
                typing: null,
                searchTimer: 1000,
                isLoading: false,
                contracts: this.contrs,
                storage: window.location.origin,
                sortDate: 'desc',
                contractDetailIndex: null,
            }
        },
        created: function () {
            this.moment = moment;
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
