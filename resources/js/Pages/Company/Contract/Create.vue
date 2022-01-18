<template>
    <app-layout>
        <div class="py-6">
            <div class="max-w-7xl">
                <div class="w-full box-border" v-if="company">
                    <div class="w-full  mb-4 contracts-block ">
                        <ContractItem
                            :company="company"
                            :contract="item"
                            :contract-index="itemIndex"
                            :countries="countries"
                            :formatDisable="formatDisable"
                            :is-removable="items.length > 1"
                            :key="itemIndex"
                            :masks="masks"
                            :ref="'contractItem'+itemIndex"
                            :selectedMask="selectedMask"
                            @errorsCount="errors"
                            @removeItem="removeItem"
                            @updateContractData="item = $event"
                            v-for="(item, itemIndex) in items"
                        />
                    </div>
                    <!-- button ADD new contracts -->
                    <button
                        @click="addItem"
                        class="mb-4 relative left-1/2 items-center justify-center py-2 px-12 bg-indigo-600 bg-opacity-75 text-white 2xl:text-xs text-xxs rounded-md hover:shadow-lg focus:outline-none  focus:border-indigo-600"
                        v-if="!codeVerified"
                    >
                        + Add more contracts
                    </button>
                    <!-- button ADD new contracts -->
                    <div class="w-full flex flex-wrap justify-content-start mb-6">
                        <div class="w-5/12 new-box-shadow rounded-lg bg-white mr-6  mb-5 p-3 xl:p-5 2xl:p-10 "
                             v-if="!verifyCodeSent">
                            <p class="2xl:text-xl xl:text-lg text-base mb-5 font-bold w-full text-left">
                                Fill the telephone number
                            </p>
                            <p class="mb-2">
                                <label class="2xl:text-base xl:text-sm text-xs font-medium " for="phone">Phone</label>
                                <!--                                border-red-500-->
                                <vue-tel-input :inputOptions="inputOptions"
                                               onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 43'
                                               placeholder=""
                                               style="border: 1px solid rgb(185, 185, 195); border-radius: 0.25rem"
                                               v-model="phone"
                                />
                                <button
                                    @click="sendVerifyCode"
                                    class="mt-4 relative py-2 px-12 bg-indigo-600 bg-opacity-75 text-white 2xl:text-xs text-xxs rounded-md hover:shadow-lg focus:outline-none  focus:border-indigo-600">Check
                                </button>
                            </p>
                            <p class="2xl:text-xs text-xss" v-if="isTrustedPhone === true || isTrustedPhone === null">
                                The confirmation code will be sent to this number</p>
                            <!--                            Not Related Phone Number-->
                            <p class=" text-xs text-red-500" v-else-if="isTrustedPhone === false">The telephone number
                                is not related</p>
                        </div>
                        <div class="w-5/12 new-box-shadow rounded-lg mr-6 mb-5  p-3 xl:p-5 2xl:p-10 " v-else>
                            <p class="text-xl mb-5 font-bold w-full text-left">Fill the confirmation code</p>
                            <p class="mb-2">
                                <label class="text-base font-medium " for="code">Code</label>
                                <input
                                    :class="{'border-green-400': codeVerified}" :disabled="codeVerified"
                                    class="rounded w-full mt-1"
                                    id="code"
                                    name="code"
                                    placeholder=""
                                    style="border: 1px solid #B9B9C3;"
                                    type="number"
                                    v-model.trim.lazy="code"
                                >
                                <button @click="verifyCode" class="mt-4 relative py-2 px-12 bg-indigo-600 bg-opacity-75 text-white 2xl:text-xs text-xxs rounded-md hover:shadow-lg focus:outline-none  focus:border-indigo-600"
                                        v-if="!codeVerified">
                                    Confirm
                                </button>
                            </p>
                            <div class=" text-xs text-green-400 flex items-start " v-if="codeVerified">
                                <img alt="done" class="w-3 mr-1" src="/img/Check.png">
                                <p>Done</p>
                            </div>
                            <div v-if="codeVerified">
                                <button @click="storeContracts"
                                        class="mb-4 relative left-1/2 items-center justify-center py-2 px-12 bg-indigo-600 bg-opacity-75 text-white 2xl:text-xs text-xxs rounded-md hover:shadow-lg focus:outline-none  focus:border-indigo-600">
                                    Upload
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="new-box-shadow rounded-lg bg-white p-6 xl:p-8 2xl:p-10 w-full justify-start mt-4" v-else>
                    <p class="2xl:text-3xl xl:text-2xl lg:text-xl text-base mb-4 font-bold w-full text-left">Upload contracts</p>
                    <p class="2xl:text-xl xl:text-lg text-base mb-4 font-normal w-full text-left">Please select a company </p>
                    <select @change="setCompany" class="rounded w-52 mt-1" id="" name="" style="border: 1px solid #B9B9C3;" v-model="company">
                        <option :value="null">select...</option>
                        <option :value="item" v-for="item in comp">{{item.title}}</option>
                    </select>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import {VueTelInput} from 'vue-tel-input';
    import 'vue-tel-input/dist/vue-tel-input.css';
    import ContractItem from "./components/ContractItem";

    export default {
        name: "Create",
        props: {
            comp: [Object, Array],
            countries: [Object, Array],
            type: Boolean,
            phones: {
                type: [Object, Array],
                default: null
            },
        },
        data: function () {
            return {
                items: [
                    {
                        policy_number: null,
                        start_date: null,
                        end_date: null,
                        tax_id: null,
                        country: null
                    }
                ],
                itemExample: {
                    policy_number: null,
                    start_date: null,
                    end_date: null,
                    tax_id: null,
                    country: null
                },
                company: this.type === true ? null : this.comp,
                phone: null,
                isTrustedPhone: null,
                incorrectCode: true,
                verifyCodeSent: false,
                codeVerified: false,
                formatDisable: false,
                selectedMask: null,
                masks: null,
                code: null,
                inputOptions: {
                    id: 'phone',
                    styleClasses: 'h-10 w-full rounded  ',
                    placeholder: '+1 657 238 4028'
                },
                errorsCount: 0,
                hasError: false,
            }
        },
        mounted() {
            if (this.company) {
                this.setMasks();
            }
        },
        watch: {
            phone() {
                if (!_.isEmpty(this.phone)) {
                    const phoneFound = this.phones.find(phone => {
                        console.log(phone);
                        return this.phone.replace(/[^\d]/g, '') === phone.replace(/[^\d]/g, '')
                    });
                    this.isTrustedPhone = typeof phoneFound !== 'undefined';
                } else {
                    this.isTrustedPhone = null;
                }
            }
        },
        components: {
            AppLayout,
            VueTelInput,
            ContractItem
        },
        methods: {
            sendVerifyCode() {
                if (this.isTrustedPhone === true) {
                    this.verifyCodeSent = true;
                    axios.post('/contract/get-code', {
                        phone: this.phone
                    }).then(response => {
                    })
                }
                this.isTrustedPhone = this.isTrustedPhone === null ? false : null;
            },
            verifyCode() {
                if (!_.isEmpty(this.code)) {
                    axios.post('/contract/verify-code', {
                        phone: this.phone,
                        code: this.code
                    }).then(response => {
                        if (response.data === true) {
                            this.codeVerified = true;
                            this.incorrectCode = false;
                            this.storeContracts();
                        }
                        else {
                            this.incorrectCode = true;
                        }
                    })
                }
            },
            storeContracts() {
                this.hasError = false;
                _.forEach(this.items, async (item, itemIndex) => {
                    const isValid = await this.$refs['contractItem' + itemIndex].v$.$validate();
                    if (!isValid) {
                        this.hasError = !isValid;
                    }
                    if (itemIndex === this.items.length - 1 && !this.hasError) {
                        this.$inertia.post('/contract/store', {
                            'items': this.items,
                            'company': this.company.id,
                        });
                    }
                });
            },
            removeItem(itemIndex) {
                this.items.splice(itemIndex, 1);
            },
            addItem() {
                this.items.push(_.cloneDeep(this.itemExample));
            },
            errors(count) {
                if (count !== 0) {
                    this.errorsCount = count;
                } else {
                    if (this.errorsCount !== 0) {
                        this.errorsCount = 0;
                    }
                }
            },
            setMasks() {
                let masks = this.company.masks;
                if (masks.length > 1) {
                    const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
                    masks.forEach(function (item, index) {
                        let numbers = 1;
                        let letters = 0;
                        item.show = item.mask;
                        for (let i = 0; i < item.mask.length; i++) {
                            if (item.mask[i] === 'A') {
                                item.show = item.show.substring(0, i) + alphabet[letters] + item.show.substring(i + 1);
                                letters++;
                            } else if (item.mask[i] === '#') {
                                item.show = item.show.substring(0, i) + numbers + item.show.substring(i + 1);
                                numbers++;
                            }
                        }
                    });
                    this.masks = masks;
                } else {
                    this.formatDisable = true;
                    this.selectedMask = masks[0].mask;
                }
            },
            setCompany() {
                this.setMasks();
            },
        },
    }
</script>

<style>
</style>
