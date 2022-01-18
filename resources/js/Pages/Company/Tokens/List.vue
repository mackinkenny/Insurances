<template>
    <app-layout>
        <div class="w-full py-6 flex flex-nowrap justify-content-between">
            <div class="w-8/12 new-box-shadow rounded-lg bg-white mr-6   p-6 xl:p-8 2xl:p-10 ">
                <p class="mb-5 2xl:text-lg xl:text-base lg:text-sm text-sm">Tokens left: <span class="text-purple-500 text-base">{{Intl.NumberFormat('ru-RU').format(company.tokens_count)}}</span></p>
                <div class="mb-2 grid grid-cols-4 gap-y-2 gap-x-5 justify-items-start items-center new-bg-purple-100 w-full px-6 py-2 bg-gray-200 2xl:text-xs text-xxs tracking-wide font-bold uppercase rounded-md">
                    <p class="2xl:text-base xl:text-sm lg:text-xs normal-case leading-4">Number of tokens</p>
                    <p class="2xl:text-base xl:text-sm lg:text-xs normal-case leading-4">IP address</p>
                    <p class="2xl:text-base xl:text-sm lg:text-xs normal-case leading-4">Date</p>
                    <p class="2xl:text-base xl:text-sm lg:text-xs normal-case leading-4">Time</p>
                </div>
                <div v-if="tokens.data.length !== 0 && !isLoading">
                    <div
                        class="mb-2  grid grid-cols-4 gap-y-2 gap-x-5 justify-items-start items-center bg-gray-50 w-full px-6 py-4  text-xs  2xl:text-sm  font-normal rounded-xs"
                        v-for="(token, tokenIndex) in tokens.data">
                        <p class="text-indigo-600" v-if="token.amount > 0">{{Intl.NumberFormat('ru-RU').format(token.amount)}}</p>
                        <p class="text-red-600" v-else>{{Intl.NumberFormat('ru-RU').format(token.amount)}}</p>
                        <p>{{token.ip_address}}</p>
                        <p>{{moment(token.created_at).format("MMM DD, YYYY")}}</p>
                        <p>{{moment(token.created_at).format("HH:mm a")}}</p>
                    </div>
                    <div class="mt-8" v-if="tokens.links.length > 3">
                        <div class="flex flex-wrap -mb-1">
                            <template v-for="(link, p) in tokens.links" :key="p">
                                <div v-if="parseInt(link.label) && !link.active" class="mr-1 mb-1 px-3 py-2 text-xs h-full leading-4 border-transparent border hover:border-gray-300 hover:bg-white focus:border-indigo-500 focus:text-indigo-500 cursor-pointer"
                                     style="font-size: .85rem;" @click="datePick(link.label)" v-html="link.label"></div>
                                <div v-if="parseInt(link.label) && link.active" class="mr-1 mb-1 px-3 py-2 text-xs h-full leading-4 border-transparent border bg-ins-2"
                                     style="font-size: .85rem;" v-html="link.label">
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center py-4" v-if="isLoading">
                    <p class="2xl:text-sm lg:text-sm md:text-xs sm:text-xxs main-text tracking-wider">
                        Loading...
                    </p>
                </div>
                <div class="flex items-center justify-center py-4" v-if="tokens.data.length === 0">
                    <p class="2xl:text-sm lg:text-sm md:text-xs sm:text-xxs uppercase main-text tracking-wider">
                        No transactions
                    </p>
                </div>
            </div>
            <div class="w-4/12 flex flex-col self-start">
                <div class="w-full new-box-shadow rounded-lg bg-white p-4 self-start">
                    <p class="2xl:text-lg xl:text-base lg:text-sm text-sm mb-5 font-bold w-full text-left ">Buy tokens now</p>
                    <p class="mb-3" v-for="pack in packs"><button @click="form.tokensAmount = pack"
                            class="text-left new-bg-purple-100 hover:bg-purple-200 focus:bg-purple-300 p-2.5 2xl:text-sm xl:text-xs text-xs font-sm border w-full rounded-lg placeholder-gray-600 placeholder-opacity-75 focus:outline-none  focus:border-indigo-300 focus:border"
                            name="token1">{{Intl.NumberFormat('ru-RU').format(pack)}} pics</button></p>
                    <form @submit.prevent="submit">
                        <p class="mb-3"><input v-maska="'#########'"
                                               class=" p-2.5 2xl:text-sm xl:text-xs border-gray-300 text-xs font-normal border w-full rounded-lg placeholder-gray-400 placeholder-opacity-75 focus:outline-none  focus:border-indigo-300 focus:border"
                                               type="number" v-model="form.tokensAmount" name="token4" placeholder="Enter your quantity" required></p>
                        <p>
                            <button
                                class="w-full 2xl:text-base xl:text-sm lg:text-xs text-xs text-white bg-indigo-600  rounded-lg p-2 bg-opacity-75 hover:shadow-lg focus:outline-none  focus:border-indigo-600 focus:border focus:bg-opacity-100 ">
                                Buy
                            </button>
                        </p>
                    </form>
                </div>
                <!-- alert block start  -->
<!--                <div class="w-full new-box-shadow rounded-lg   p-4 self-start bg-indigo-600 bg-opacity-50 text-base text-white h-full flex flex-col text-center justify-center items-center" v-if="$page.props.user.role_id === 3">-->
<!--                    <p class="w-3/4  pt-12 2xl:text-base xl:text-sm lg:text-xs text-xs">You’re not allowed to purchase Tokens.</p>-->
<!--                    <p class="w-3/4 pt-4 pb-12 2xl:text-base xl:text-sm lg:text-xs text-xs"> Please, contact your associated Company, if you need to replenish your tokens.</p>-->
<!--                </div>-->
                <!-- alert block end  -->
                <div v-if="amount">
                <div class="my-5 2xl:text-base xl:text-sm lg:text-xs text-xs pl-2">The number of uploaded tokens in the time interval</div>
                <p class="p-2.5 2xl:text-sm xl:text-xs text-xs text-indigo-600 font-normal bg-white border w-full rounded-lg ">{{Intl.NumberFormat('ru-RU').format(amount)}} tokens</p>
                </div>
                <p class="my-3">
                    <v-date-picker style="width: 100%" v-model="calendar" is-range></v-date-picker>
                </p>
                <div class="w-full new-box-shadow rounded-lg bg-white p-4 self-start" v-if="company.agencies.length">
                    <p class="2xl:text-lg xl:text-base lg:text-sm text-sm mb-5 font-bold w-full text-left">Share tokens to agencies</p>
                    <div class="border-b py-2 flex" v-for="agency in company.agencies">
                        <div class="w-80">
                            {{agency.title}}
                        </div>
                        <div class="w-20 text-right">
                            <jet-checkbox :checked="agency.pivot.share === true || agency.pivot.share === 1" @change="shareTokens(agency.id, $event.target)"/>
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
    import Button from "@/Jetstream/Button";
    import Swal from 'sweetalert2'
    import Pagination from "../../Components/pagination";
    import JetCheckbox from '@/Jetstream/Checkbox'

    export default {
        name: "Dashboard",
        components: {
            Button,
            AppLayout,
            Pagination,
            JetCheckbox,
        },
        props: {
            company: Object,
            toks: Object,
        },
        created: function () {
            this.moment = moment;
        },
        data:function () {
            return {
                tokens: this.toks,
                packs: [10000, 50000, 100000],
                form: this.$inertia.form({
                    tokensAmount: '',
                }),
                isLoading: false,
                amount: null,
                calendar: {
                    start: new Date(),
                    end: new Date(),
                },
            }
        },
        mounted() {

        },
        watch: {
            calendar() {
                this.datePick();
            }
        },
        methods: {
            datePick(page){
                this.isLoading = true;
                let active = page === undefined ? 1 : page;
                axios.post(`/tokens/history-by-date/${this.company.id}?page=` + active, {
                    'dates': this.calendar,
                }).then(response => {
                    this.tokens = response.data.tokens;
                    this.isLoading = false;
                    this.amount = response.data.sum;
                }).catch(
                    function(error) {
                        this.isLoading = false;
                        Swal.fire({
                            text: 'Whoops! Something went wrong.',
                            backdrop: false,
                            showConfirmButton: false,
                            timer: 1500,
                            position: 'top-end',
                            background: '#e04e53'
                        });
                        return Promise.reject(error)
                    }
                );
            },
            shareTokens(id, value) {
                // console.log(id, value.checked);
                axios.post('/company/shareTokens', {
                    'id': id,
                    'status': value.checked,
                });
            },
            submit() {
                if (this.form.tokensAmount > 0){
                // this.form.post(this.route('tokens/store', this.company.id));
                axios.post('/company/checkout', {
                    quantity: this.form.tokensAmount,
                    company_id: this.company.id,
                }).then(response => {
                    window.location = response.data;
                })
                }
            },
        }
    }
</script>

<style scoped>

</style>
