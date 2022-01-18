<template>
    <app-layout>
        <div class="py-6">
            <div class="max-w-7xl">
                <div class="rounded-lg bg-white p-6 xl:p-8 2xl:p-10" style="box-shadow: 0px 4px 24px rgba(0, 0, 0, 0.06);">
                    <div class="flex justify-between mb-5">
                        <div class="flex items-center">
                            <p class="2xl:text-sm lg:text-xs uppercase main-text font-bold tracking-wider cursor-pointer" v-bind:class="{'opacity-50': !tab}" @click="setTab(true)">
                                Companies
                            </p>
                            <p class="2xl:text-sm lg:text-xs uppercase main-text font-bold tracking-wider cursor-pointer ml-3" v-bind:class="{'opacity-50': tab}" @click="setTab(false)">
                                Agencies
                            </p>
                        </div>
                        <div>
                        <input type="search" class="2xl:py-2.5 xl:py-2 py-1.5  border rounded mr-6 2xl:text-sm xl:text-xs text-xxs ins-input"
                               style="background: #FBFBFB; border-color:#B9B9C3;" placeholder="Search" v-on:input="onSearch" v-model="search"
                               v-if="comps != []">
                        <inertia-link :href="route('company/create')">
                            <button class="main-bg text-white rounded 2xl:text-base lg:text-sm md:text-xs sm:text-xxs px-16 h-full">Add new</button>
                        </inertia-link>
                        </div>
                    </div>
                    <div class="grid grid-cols-9 rounded bg-ins-2 px-1 2xl:text-xs lg:text-xxs uppercase main-text font-bold tracking-wider" style="color: #5E5873; letter-spacing: 1px;" v-if="comps != []">
                        <div class="col-span-4 pl-4 py-3">
                            <p>
                                Company
                            </p>
                        </div>
                        <div class="col-span-3 py-3 px-1">
                            <p>
                                Tax ID
                            </p>
                        </div>
                        <div class="col-span-2 py-3 px-1">
                            <p>
                                Country
                            </p>
                        </div>
                    </div>
                    <div class="mt-4" v-if="comps != [] && !isLoading">
                        <div class="rounded regular-bg py-2 mb-1" v-for="company in comps.data">
                            <inertia-link :href="route('company/edit', company.id)">
                                <div class="grid grid-cols-9">
                                    <div class="col-span-2 pl-4 flex items-center px-1">
                                        <img class="w-auto 2xl:h-16 xl:h-14 lg:h-12 md:h-11" :src="s3_storage + '/' + company.logo" alt="">
                                    </div>
                                    <div class="col-span-2 flex items-center px-1">
                                        <p class="2xl:text-base lg:text-sm md:text-xs sm:text-xxs font-bold main-text"  style="color: #5E5873; letter-spacing: 1px;">
                                            {{company.title}}
                                        </p>
                                    </div>
                                    <div class="col-span-3 flex items-center px-1">
                                        <p class="2xl:text-base lg:text-sm md:text-xs sm:text-xxs main-text">
                                            {{company.tax_id}}
                                        </p>
                                    </div>
                                    <div class="col-span-2 flex items-center px-1">
                                        <p class="2xl:text-base lg:text-sm md:text-xs sm:text-xxs main-text">
                                            {{company.country ? company.country.name : ''}}
                                        </p>
                                    </div>
                                </div>
                            </inertia-link>
                        </div>

                        <div class="mt-8" v-if="comps.links.length > 3">
                            <div class="flex flex-wrap -mb-1">
                                <template v-for="(link, p) in comps.links" :key="p">
                                    <div v-if="parseInt(link.label) && !link.active" class="mr-1 mb-1 px-3 py-2 text-xs h-full leading-4 border-transparent border hover:border-gray-300 hover:bg-white focus:border-indigo-500 focus:text-indigo-500 cursor-pointer"
                                         style="font-size: .85rem;" @click="getResult(link.label)" v-html="link.label"></div>
                                    <div v-if="parseInt(link.label) && link.active" class="mr-1 mb-1 px-3 py-2 text-xs h-full leading-4 border-transparent border bg-ins-2"
                                         style="font-size: .85rem;" v-html="link.label">
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center py-4" v-if="comps.data.length === 0">
                        <p class="2xl:text-sm lg:text-sm md:text-xs sm:text-xxs uppercase main-text tracking-wider">
                            Companies list is empty
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
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Swal from 'sweetalert2'

    export default {
        components: {
            AppLayout
        },
        props: {
            companies: Object,
            status: Boolean
        },
        data: function () {
            return {
                storage: window.location.origin,
                s3_storage: process.env.MIX_AWS_PUBLIC_STORAGE,
                search: null,
                searchTimer: 1000,
                typing: null,
                isLoading: false,
                comps: this.companies,
                filtered: false,
                tab: true,
            }
        },
        mounted() {
            this.load();
        },
        methods: {
            load() {
                if (this.status == 1) {
                    Swal.fire({
                        text: 'Company was successfully created',
                        backdrop: false,
                        showConfirmButton: false,
                        timer: 1500,
                        position: 'top-end',
                        background: '#87DDA0'
                    });
                } else if (this.status == 2) {
                    Swal.fire({
                        text: 'Company was successfully updated',
                        backdrop: false,
                        showConfirmButton: false,
                        timer: 1500,
                        position: 'top-end',
                        background: '#87DDA0'
                    });
                }
            },
            onSearch() {
                clearTimeout(this.typing);
                this.typing = setTimeout(this.getResult, this.searchTimer);
            },
            setTab(tab) {
                if (this.tab !== tab) {
                    this.tab = tab;
                    this.getResult();
                }
            },
            getResult(page) {
                this.isLoading = true;
                let active = page === undefined ? 1 : page;
                axios.post('/company/search?page=' + active, {value: this.search, tab: this.tab}).then(response => {
                    this.comps = response.data;
                    this.isLoading = false;
                });
            }
        }
    }
</script>

<style scoped>

</style>
