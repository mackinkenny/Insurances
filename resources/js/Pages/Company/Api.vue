<template>
    <app-layout>
        <div class="py-6">
            <div class="max-w-7xl">
                <div class="w-full  contracts-block" v-if="confirm">
                    <p class="2xl:text-3xl xl:text-2xl lg:text-xl text-base mb-4 font-bold w-full text-left">API Information</p>

                    <div class=" pt-5 xl:pt-8 2xl:pt-10 w-full flex flex-wrap justify-center items-start">
                        <div class="w-3/5 pr-4">

                        <p class="2xl:text-xl xl:text-lg text-base mb-4 font-normal w-full text-left">Request url:</p>
                        <p class="relative w-full bg-purple-300 bg-opacity-75 rounded p-3 mb-6 2xl:text-base xl:text-sm lg:text-xs">
                            <span>{{ urlExample }}</span>
                            <img @click="copyUrl" alt="save" class="w-4 absolute top-2 right-2 z-50 cursor-pointer" src="/img/save.png">
                        </p>

                        <p class="2xl:text-xl xl:text-lg text-base mb-4 font-normal w-full text-left">Your personal API key:</p>
                        <p class="relative w-full bg-purple-300 bg-opacity-75 rounded p-3 mb-6 2xl:text-base xl:text-sm lg:text-xs overflow-hidden">
                            <span>{{apiKey}} </span>
                            <img @click="copyApiKey" alt="save" class="w-4 absolute top-2 right-2 z-50 cursor-pointer" src="/img/save.png">
                        </p>
                            <div v-if="companies">
                                <p class="2xl:text-xl xl:text-lg text-base mb-4 font-normal w-full text-left">Company ID ({{comp.title}})</p>
                                <p class="relative w-full bg-purple-300 bg-opacity-75 rounded p-3 mb-6 2xl:text-base xl:text-sm lg:text-xs overflow-hidden">
                                    <span>{{comp.id}} </span>
                                    <img @click="copyCompanyId" alt="save" class="w-4 absolute top-2 right-2 z-50 cursor-pointer" src="/img/save.png">
                                </p>
                            </div>
                            <p class="2xl:text-xl xl:text-lg text-base mb-4 font-normal w-full text-left">Bearer Token Authorization:</p>
                            <div
                                class="relative w-full bg-purple-300 bg-opacity-75 rounded p-3 mb-6 2xl:text-base xl:text-sm lg:text-xs overflow-hidden">
                                <pre class="content-for-button 2xl:text-base xl:text-sm text-xs leading-tight overflow-x-auto" ref="headerContainer">
'headers' => [
    'Authorization' => 'Bearer '.$token,
],</pre>
                                <img @click="copyHeader" alt="save" class="w-4 absolute top-2 right-2 z-50 cursor-pointer" src="/img/save.png">
                            </div>
                        <p class="2xl:text-xl xl:text-lg text-base mb-4 font-normal w-full text-left">Examples of JSON and XML responses:</p>

                        <div class="relative w-full bg-purple-300  bg-opacity-75 rounded p-3 mb-6 text-base">
                            <p class="double-buttons">
                                <button @click="type = 1"
                                        class="button-left mb-5  items-center justify-center py-2 px-4 bg-indigo-600 text-white text-xs rounded-l-md"
                                        v-bind:class="{'bg-opacity-100': type == 1, 'bg-opacity-50': type != 1}">
                                    XML
                                </button>
                                <button @click="type = 2"
                                        class="button-right mb-5 relative -left-1 items-center justify-center py-2 px-4 bg-indigo-600 text-white text-xs rounded-r-md"
                                        v-bind:class="{'bg-opacity-100': type == 2, 'bg-opacity-50': type != 2}">
                                    JSON
                                </button>
                            </p>
                            <!-- content for XML button start -->
                            <pre class="content-for-button 2xl:text-base xl:text-sm text-xs leading-tight overflow-x-auto" ref="xmlContainer"
                                 v-bind:class="{'show': type == 1, 'hidden': type != 1}">
&lt;?xml version=&quot;1.0&quot; encoding=&quot;UTF-8&quot;?&gt;
&lt;root&gt;
      &lt;contracts&gt;
         &lt;country_id>1&lt;/country_id>
         &lt;end_date&gt;UNIX TIMESTAMP&lt;/end_date&gt;
         &lt;policy_number&gt;1231236123&lt;/policy_number&gt;
         &lt;start_date&gt;UNIX TIMESTAMP&lt;/start_date&gt;
         &lt;tax_id&gt;123123123123&lt;/tax_id&gt;
      &lt;/contracts&gt;
      &lt;contracts&gt;
         &lt;country_id>1&lt;/country_id>
         &lt;end_date&gt;UNIX TIMESTAMP&lt;/end_date&gt;
         &lt;policy_number&gt;1231236123&lt;/policy_number&gt;
         &lt;start_date&gt;UNIX TIMESTAMP&lt;/start_date&gt;
         &lt;tax_id&gt;123123123123&lt;/tax_id&gt;
      &lt;/contracts&gt;
      &lt;contracts&gt;
         &lt;country_id>1&lt;/country_id>
         &lt;end_date&gt;UNIX TIMESTAMP&lt;/end_date&gt;
         &lt;policy_number&gt;1231236123&lt;/policy_number&gt;
         &lt;start_date&gt;UNIX TIMESTAMP&lt;/start_date&gt;
         &lt;tax_id&gt;123123123123&lt;/tax_id&gt;
      &lt;/contracts&gt;
   &lt;phone&gt;+1 657 238 4028&lt;/phone&gt;
   <span v-if="companies">&lt;company_id&gt;123&lt;/company_id&gt;</span>
&lt;/root&gt;
                            </pre>
                            <!-- content for XML button end -->

                            <!-- content for JSON button start -->
                            <pre class="content-for-button 2xl:text-base xl:text-sm text-xs leading-tight overflow-x-auto" ref="jsonContainer"
                                 v-bind:class="{'show': type == 2, 'hidden': type != 2}">
{
    "phone": "+1 657 238 4028",
    <span v-if="companies">"company_id": 123,</span>
    "contracts": [
        {
            "policy_number": 1231236123,
            "start_date": UNIX TIMESTAMP,
            "end_date": UNIX TIMESTAMP,
            "tax_id": 123123123123,
            "country_id": 1
        },
        {
            "policy_number": 1231236123,
            "start_date": UNIX TIMESTAMP,
            "end_date": UNIX TIMESTAMP,
            "tax_id": 123123123123,
            "country_id": 1
        },
        {
            "policy_number": 1231236123,
            "start_date": UNIX TIMESTAMP,
            "end_date": UNIX TIMESTAMP,
            "tax_id": 123123123123,
            "country_id": 1
        }
    ]
}
                            </pre>
                            <!-- content for JSON button end -->

                            <img @click="copyExample" alt="save" class="w-4 absolute top-2 right-2 cursor-pointer" src="/img/save.png">
                        </div>
                    </div>
                        <div class="w-2/5">
                            <p class="2xl:text-xl xl:text-lg text-base mb-4 font-normal w-full text-left">Countries ID:</p>
                            <div class="relative w-full bg-purple-300 pl-4 bg-opacity-75 rounded p-3 mb-6 h-80 text-base overflow-y-auto">
                                <div class="flex justify-between" v-for="country in countries">
                                    <p class="font-bold pr-4">{{country.id}}</p>
                                    <p class="text-right">{{country.name}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full  contracts-block" v-else>
                    <div class=" pt-5 xl:pt-8 2xl:pt-10 w-full flex flex-wrap flex-col justify-center items-start">
                        <p class="2xl:text-3xl xl:text-2xl lg:text-xl text-base mb-4 font-bold w-full text-left">API Information</p>

                        <div v-if="!verifyCodeSent">
                            <p class="2xl:text-xl xl:text-lg text-base mb-4 font-normal w-full text-left" v-if="!companies">Please confirm your
                                trusted phone number</p>
                            <p class="2xl:text-xl xl:text-lg text-base mb-4 font-normal w-full text-left" v-if="companies">Please select a company and
                                confirm trusted phone number</p>
                            <select class="rounded w-80 mt-1" id="" name="" style="border: 1px solid #B9B9C3;"
                                    v-if="companies" v-model="comp">
                                <option :value="null">select...</option>
                                <option :value="item" v-for="item in companies">{{item.title}}</option>
                            </select>
                            <div class="mt-4 w-80 " v-bind:class="{'disabled-input': !comp}">
                                <vue-tel-input v-model="trustedPhone" mode="international" :inputOptions="{
                                                            id: 'trustedphone',
                                                            styleClasses: 'h-10 ml-1 w-full rounded border',
                                                            placeholder: '+1 657 238 4028'
                                                          }"
                                               onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 43'
                                />
                            </div>
                            <p class="2xl:text-xs text-xss" v-if="isTrustedPhone === true || isTrustedPhone === null">
                                The confirmation code will be sent to this number</p>
                            <!--                            Not Related Phone Number-->
                            <p class=" text-xs text-red-500" v-else-if="isTrustedPhone === false">The telephone number
                                is not related</p>
                            <button
                                @click="sendVerifyCode"
                                class="mt-4 relative py-2 px-12 bg-indigo-600 bg-opacity-75 text-white 2xl:text-xs text-xxs rounded-md hover:shadow-lg focus:outline-none  focus:border-indigo-600">Check
                            </button>
                        </div>
                        <div v-else>
                            <p class="2xl:text-xl xl:text-lg text-base mb-4 font-normal w-full text-left">Fill the confirmation code</p>
                            <div class="mb-2">
                                <p class="text-base font-medium " for="code">Code</p>
                                <div class="w-80 mt-1">
                                    <input
                                        :class="{'border-green-400': codeVerified, 'border-red-400' : incorrectCode}" :disabled="codeVerified"
                                        class="rounded w-full"
                                        id="code"
                                        name="code"
                                        placeholder=""
                                        style="border: 1px solid #B9B9C3;"
                                        type="number"
                                        v-model.trim.lazy="code"
                                    >
                                </div>
                                <button @click="verifyCode" class="mt-4 relative py-2 px-12 bg-indigo-600 bg-opacity-75 text-white 2xl:text-xs text-xxs rounded-md hover:shadow-lg focus:outline-none  focus:border-indigo-600"
                                        v-if="!codeVerified">
                                    Confirm
                                </button>
                            </div>
                            <div class=" text-xs text-green-400 flex items-start " v-if="codeVerified">
                                <img alt="done" class="w-3 mr-1" src="/img/Check.png">
                                <p>Done</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Swal from "sweetalert2";
    import {copyText} from 'vue3-clipboard'
    import {VueTelInput} from 'vue-tel-input';
    import 'vue-tel-input/dist/vue-tel-input.css';

    export default {
        name: "Api",
        components: {
            AppLayout,
            VueTelInput,
        },
        props: {
            companies: Object,
            company: Object,
            countries: Object,
            phones: {
                type: [Object, Array],
                default: null
            },
        },
        data: function () {
            return {
                type: 1,
                apiKey: null,
                confirm: false,
                isTrustedPhone: null,
                verifyCodeSent: false,
                codeVerified: false,
                incorrectCode: true,
                code: null,
                comp: this.companies ? null : this.company,
                trustedPhone: '',
                urlExample: window.location.origin + "/api/contracts/upload",
            }
        },
        watch: {
            trustedPhone() {
                if (!_.isEmpty(this.trustedPhone)) {
                    const phoneFound = this.phones.find(phone => {
                        return this.trustedPhone.replace(/[^\d]/g, '') === phone.replace(/[^\d]/g, '')
                    });

                    this.isTrustedPhone = typeof phoneFound !== 'undefined';
                } else {
                    this.isTrustedPhone = null;
                }
            }
        },
        methods: {
            copyUrl() {
                copyText(this.urlExample, undefined, (error, event) => {
                    Swal.fire({
                        text: 'Url copied successfully',
                        backdrop: false,
                        showConfirmButton: false,
                        timer: 1500,
                        position: 'top-end',
                        background: '#87DDA0'
                    });
                });
            },
            copyApiKey() {
                copyText(this.apiKey, undefined, (error, event) => {
                    Swal.fire({
                        text: 'API copied successfully',
                        backdrop: false,
                        showConfirmButton: false,
                        timer: 1500,
                        position: 'top-end',
                        background: '#87DDA0'
                    });
                });
            },
            copyCompanyId() {
                copyText(this.comp.id, undefined, (error, event) => {
                    Swal.fire({
                        text: 'Company ID copied successfully',
                        backdrop: false,
                        showConfirmButton: false,
                        timer: 1500,
                        position: 'top-end',
                        background: '#87DDA0'
                    });
                });
            },
            copyXmlExample() {
                const xmlContainer = this.$refs.xmlContainer;
                copyText(xmlContainer.textContent, undefined, (error, event) => {
                    Swal.fire({
                        text: 'XML Example copied successfully',
                        backdrop: false,
                        showConfirmButton: false,
                        timer: 1500,
                        position: 'top-end',
                        background: '#87DDA0'
                    });
                });
            },
            copyExample() {
                if (this.type === 1) {
                    this.copyXmlExample();
                } else {
                    this.copyJsonExample();
                }
            },
            copyJsonExample() {
                const jsonContainer = this.$refs.jsonContainer;
                copyText(jsonContainer.textContent, undefined, (error, event) => {
                    Swal.fire({
                        text: 'JSON Example copied successfully',
                        backdrop: false,
                        showConfirmButton: false,
                        timer: 1500,
                        position: 'top-end',
                        background: '#87DDA0'
                    });
                });
            },
            copyHeader() {
                const headerContainer = this.$refs.headerContainer;
                copyText(headerContainer.textContent, undefined, (error, event) => {
                    Swal.fire({
                        text: 'Header Example copied successfully',
                        backdrop: false,
                        showConfirmButton: false,
                        timer: 1500,
                        position: 'top-end',
                        background: '#87DDA0'
                    });
                });
            },
            sendVerifyCode() {
                if (this.isTrustedPhone === true) {
                    this.verifyCodeSent = true;
                    axios.post('/contract/get-code', {
                        phone: this.trustedPhone
                    }).then(response => {
                    })
                }
                this.isTrustedPhone = this.isTrustedPhone === null ? false : null;
            },
            verifyCode() {
                if (!_.isEmpty(this.code)) {
                    axios.post('/contract/verify-code', {
                        phone: this.trustedPhone,
                        code: this.code
                    }).then(response => {
                        if (response.data === true) {
                            this.codeVerified = true;
                            this.incorrectCode = false;
                            this.getApikey();
                        } else {
                            this.incorrectCode = true;
                        }

                    })
                }
            },
            getApikey() {
                axios.get('/company/getApi').then(response => {
                    if (response) {
                        this.apiKey = response.data;
                        this.confirm = true;
                    }
                })
            },
        }
    }
</script>

<style scoped>

</style>
