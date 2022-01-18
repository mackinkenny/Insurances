<template>
    <app-layout>
        <div class="py-6">
            <div class="max-w-7xl">
                <div class="rounded-lg bg-white px-5 py-6" style="box-shadow: 0px 4px 24px rgba(0, 0, 0, 0.06);">
                    <form @submit.prevent="submit">
                        <div class="flex justify-between px-5">
                            <div>
                                <p class="main-text 2xl:text-lg lg:text-sm md:text-xs sm:text-xxs  font-bold">
                                    Main information
                                </p>
                                <img v-if="!isEdit" class="2xl:w-24 xl:w-20 w-16 mt-4" :src="s3_storage + '/' + this.company.logo" alt="">
                                <div v-else>
                                    <img id="preview" class="2xl:w-24 xl:w-20 w-16 mt-4 cursor-pointer" v-on:click="imageTrigger"
                                         :src="s3_storage + '/' + this.company.logo" alt="">
                                    <input id="image" type="file" class="hidden" accept="image/png, image/gif, image/jpeg"
                                           v-bind:class="{'disabled-input': !isEdit}" :disabled="!isEdit" @change="setImage($event)"/>
                                    <p class="text-red-500 text-xs" v-if="check_img">Please add a company logo</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <p class="main-text font-bold  2xl:text-lg lg:text-sm md:text-xs sm:text-xxs mr-3"
                                   v-if="companies && companies.length > 0 && form.type == 2">
                                    Associated with
                                </p>
                                <!--START Select associated company  -->
                                <Multiselect
                                    class="main-bg text-white associate text-center rounded 2xl:text-base xl:text-sm text-xs max-h-8 py-1" style="width:13rem;"
                                    v-bind:class="{'disabled-input': !isEdit}"
                                    v-model="form.associate"
                                    :options="companies"
                                    mode="tags"
                                    valueProp="id"
                                    label="title"
                                    trackBy="title"
                                    v-if="companies && companies.length > 0 && form.type == 2"
                                    required
                                />
                                <!--                                <select v-if="companies && companies.length > 0 && form.type == 2"-->
                                <!--                                        class="main-bg text-center text-white rounded 2xl:text-base xl:text-sm text-xs 2xl:px-12 xl:px-10 px-8 max-h-9 py-1 ml-3 mr-10"-->
                                <!--                                        v-model="form.associate" style="letter-spacing: 0.4px;"-->
                                <!--                                        v-bind:style="{ 'background-image' : 'url(' + storage +'/images/selectdrop.svg)'}">-->
                                <!--                                    <option class="bg-white text-sm text-black" :value="company.id" :selected="form.associate == 1"-->
                                <!--                                            v-for="company in companies">-->
                                <!--                                        {{company.title}}-->
                                <!--                                    </option>-->
                                <!--                                </select>-->
                                <!--End Select associated company  -->
                                <!--START Select type - company or agency  -->
                                <Multiselect
                                    class="main-bg text-white associate text-center rounded 2xl:text-base xl:text-sm text-xs max-h-8 py-1" style="width:13rem; margin-left:0.75rem;"
                                    v-bind:class="{'disabled-input': !isEdit}"
                                    v-model="form.type"
                                    :options="[{'id': 1, 'title': 'Company'},{'id': 2, 'title': 'Agency'}]"
                                    valueProp="id"
                                    label="title"
                                    trackBy="title"
                                    required
                                    disabled
                                />
                                <!--                                <select-->
                                <!--                                    class="main-bg text-center text-white rounded 2xl:text-base xl:text-sm text-xs 2xl:px-12 xl:px-10 px-8 max-h-9 py-1 ml-3"-->
                                <!--                                    v-model="form.type" style="letter-spacing: 0.4px;"-->
                                <!--                                    v-bind:style="{ 'background-image' : 'url(' + storage +'/images/selectdrop.svg)'}">-->
                                <!--                                    <option class="bg-white text-sm text-black" value="1" :selected="form.type == 1">Company</option>-->
                                <!--                                    <option class="bg-white text-sm text-black" value="2" v-if="companies && companies.length > 0"-->
                                <!--                                            :selected="form.type == 2">Agency-->
                                <!--                                    </option>-->
                                <!--                                </select>-->
                                <!--End Select type - company or agency  -->
                            </div>
                        </div>
                        <div class="mt-12">
                            <div class="grid grid-cols-3">
                                <div class="px-5">
                                    <label class="main-text font-medium 2xl:text-base xl:text-sm text-xs font-medium" for="title">
                                        Title
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;" v-model="form.title" id="title" type="text"
                                           v-bind:class="{'disabled-input': !isEdit}" :disabled="!isEdit" required>
                                </div>
                                <div class="px-5">
                                    <label class="main-text 2xl:text-base xl:text-sm text-xs font-medium" for="tax">
                                        Tax ID
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;" v-model="form.tax_id" id="tax" type="text"
                                           v-bind:class="{'disabled-input': !isEdit}" :disabled="!isEdit" required>
                                </div>
                                <div class="px-5">
                                    <label class="main-text 2xl:text-base xl:text-sm text-xs font-medium" for="password">
                                        Password
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;" v-model="form.password" id="password"
                                           type="text" v-bind:class="{'disabled-input': !isEdit}" :disabled="!isEdit">
                                    <password-validation-error></password-validation-error>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 mt-5">
                                <div class="px-5">
                                    <label class="main-text 2xl:text-base xl:text-sm text-xs font-medium" for="assist_phone">
                                        Phone number for assistance
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;" v-model="form.assist_phone"
                                           id="assist_phone" type="text" v-bind:class="{'disabled-input': !isEdit}" :disabled="!isEdit" required>
                                </div>
                                <div class="px-5">
                                    <label class="main-text 2xl:text-base xl:text-sm text-xs font-medium" for="country">
                                        Country
                                    </label>
<!--                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;" v-model="form.country" id="country"-->
<!--                                           type="text" v-bind:class="{'disabled-input': !isEdit}" :disabled="!isEdit" required>-->
                                    <div class="mt-1" v-bind:class="{'disabled-input': !isEdit}">
                                        <VueMultiselect
                                            v-model="form.country"
                                            :options="countries"
                                            :value="id"
                                            label="name"
                                            trackBy="name"
                                            :close-on-select="true"
                                            :clear-on-select="true"
                                            :disabled="!isEdit"
                                            style="border: 1px solid #B9B9C3; height: auto;"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="px-5">
                                    <label class="main-text 2xl:text-base xl:text-sm text-xs font-medium" for="city">
                                        City
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;"  v-bind:class="{'disabled-input': !isEdit}"
                                           v-model="form.city" id="city" type="text" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 mt-5">
                                <div class="px-5">
                                    <label class="main-text 2xl:text-base xl:text-sm text-xs font-medium" for="address">
                                        Address
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;" v-model="form.address" id="address"
                                           type="text" v-bind:class="{'disabled-input': !isEdit}" :disabled="!isEdit" required>
                                </div>
                            </div>
                        </div>
                        <div class="mt-9">
                            <p class="main-text 2xl:text-lg lg:text-sm md:text-xs sm:text-xxs px-5 font-bold">
                                Responsible person
                            </p>
                            <div class="grid grid-cols-3 mt-5">
                                <div class="px-5">
                                    <label class="main-text 2xl:text-base xl:text-sm text-xs font-medium" for="name">
                                        Name
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;" v-model="form.name" id="name" type="text"
                                           v-bind:class="{'disabled-input': !isEdit}" :disabled="!isEdit" required>
                                </div>
                                <div class="px-5">
                                    <label class="main-text 2xl:text-base xl:text-sm text-xs font-medium" for="phone">
                                        Phone
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;" v-model="form.phone" id="phone" type="text"
                                           v-bind:class="{'disabled-input': !isEdit}" :disabled="!isEdit" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 mt-5">
                                <div class="px-5">
                                    <label class="main-text 2xl:text-base xl:text-sm text-xs font-medium" for="position">
                                        Position
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;" v-model="form.position" id="position"
                                           type="text" v-bind:class="{'disabled-input': !isEdit}" :disabled="!isEdit" required>
                                </div>
                                <div class="px-5">
                                    <label class="main-text 2xl:text-base xl:text-sm text-xs font-medium" for="email">
                                        Email
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;" v-model="form.email" id="email" type="email"
                                           v-bind:class="{'disabled-input': !isEdit}" :disabled="!isEdit" required>
                                </div>
                            </div>
                        </div>
                        <div class="mt-9">
                            <div class="flex items-center">
                                <p class="main-text main-text 2xl:text-lg lg:text-sm md:text-xs sm:text-xxs pl-5 font-bold">
                                    Policy number formats
                                </p>
                                <svg v-if="isEdit" @click="addFormat" class="ml-2 cursor-pointer" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="12" fill="#28C76F"/>
                                    <path d="M7.09133 11.02V13.2H10.8713V17.12H13.1113V13.2H16.9113V11.02H13.1113V7.12H10.8713V11.02H7.09133Z"
                                          fill="white"/>
                                </svg>
                            </div>
                            <p class="main-text text-xxs text-gray-600 pl-5 font-medium">
                                For example: <br>
                                Ar7/689-5TT - AA#/###-#AA</p>
                            <div class="grid grid-cols-3 mt-5">
                                <div class="px-5 mt-2" v-for="(policy, index) in form.policyFormats">
                                    <div class="flex items-center">
                                        <label class="main-text 2xl:text-base xl:text-sm text-xs font-medium">
                                            Policy number format {{index + 1}}
                                        </label>
                                        <svg v-if="form.policyFormats.length > 1 && isEdit" @click="removeFormat(index)" class="ml-2 cursor-pointer"
                                             width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="24" height="24" rx="12" fill="#EA5455"/>
                                            <rect x="5" y="11" width="14" height="3" rx="0.5" fill="white"/>
                                        </svg>
                                    </div>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;" v-model="form.policyFormats[index]"
                                           v-bind:class="{'disabled-input': !isEdit}" :disabled="!isEdit" type="text" required>
                                </div>

                            </div>
                        </div>
                        <div class="mt-9">
                            <div class="flex items-center">
                                <p class="main-text main-text 2xl:text-lg lg:text-sm md:text-xs sm:text-xxs pl-5 font-bold">
                                    Trusted telephone numbers
                                </p>
                                <svg v-if="isEdit" @click="addPhone" class="ml-2 cursor-pointer" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="12" fill="#28C76F"/>
                                    <path d="M7.09133 11.02V13.2H10.8713V17.12H13.1113V13.2H16.9113V11.02H13.1113V7.12H10.8713V11.02H7.09133Z"
                                          fill="white"/>
                                </svg>
                            </div>
                            <div class="grid grid-cols-3 mt-5">
                                <div class="px-5 mt-2" v-for="(phone, index) in form.trustedPhones">
                                    <div class="flex items-center">
                                        <label class="main-text 2xl:text-base xl:text-sm text-xs font-medium">
                                            Trusted telephone number {{index + 1}}
                                        </label>
                                        <svg v-if="form.trustedPhones.length > 1 && isEdit" @click="removePhone(index)" class="ml-2 cursor-pointer"
                                             width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="24" height="24" rx="12" fill="#EA5455"/>
                                            <rect x="5" y="11" width="14" height="3" rx="0.5" fill="white"/>
                                        </svg>
                                    </div>
                                    <div v-bind:class="{'disabled-input': !isEdit}">
                                        <vue-tel-input v-model="form.trustedPhones[index]" mode="international" class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;" :id="'trustedPhone-' + index"
                                                       onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 43'
                                                       placeholder="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-9">
                            <div class="grid grid-cols-3">

                                <div>
                                    <p class="main-text main-text 2xl:text-base xl:text-base lg:text-sm md:text-xs sm:text-xxs px-5 font-bold">
                                        Example of the Insurance Contract
                                    </p>
                                    <div class="px-5 mt-5">
                                        <label class="main-text 2xl:text-base xl:text-sm text-xs font-medium" for="example">
                                            Example
                                        </label>
                                        <input class="rounded w-full mt-1 py-1.5" style="border: 1px solid #B9B9C3;" id="example" type="file"
                                               accept="image/png, image/gif, image/jpeg" v-bind:class="{'disabled-input': !isEdit}"
                                               :disabled="!isEdit">
                                    </div>
                                </div>

                            </div>
                            <div class=" mt-5">
                                <p class="main-text main-text 2xl:text-lg xl:text-base lg:text-sm md:text-xs sm:text-xxs px-5 font-bold">
                                    Tokens
                                </p>
                                <div class="grid grid-cols-3">
                                    <div class="px-5 mt-5">
                                        <label class="main-text 2xl:text-base xl:text-sm text-xs font-medium" for="tokens">
                                            Number of available tokens
                                        </label>
                                        <input class="rounded w-full mt-1 disabled-input" style="border: 1px solid #B9B9C3;" v-model="form.tokens" id="tokens"
                                               type="number" disabled required>
                                    </div>
                                    <div class="px-5 mt-5">
                                        <label class="main-text 2xl:text-base xl:text-sm text-xs font-medium" for="tokens">
                                            Increase/Decrease available tokens by:
                                        </label>
                                        <input class="rounded w-full mt-1" v-bind:class="{'disabled-input': !isEdit}"
                                               :disabled="!isEdit" style="border: 1px solid #B9B9C3;" v-model="form.increaseTokens" id="IncreaseTokens"
                                               type="number">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-9 px-5 flex" v-if="isEdit">
                            <button class="bg-white rounded 2xl:text-base lg:text-sm md:text-xs sm:text-xxs px-10 py-2"
                                    style="color: #7367F0; border: 1px solid #7367F0;" v-bind:class="{'disabled-bg': form.processing}"
                                    :disabled="form.processing" @click="load">Reset
                            </button>
                            <button type="submit" class="ml-5 main-bg text-white rounded 2xl:text-base lg:text-sm md:text-xs sm:text-xxs px-12 py-2"
                                    v-bind:class="{'disabled-bg': form.processing}" :disabled="form.processing">Save
                            </button>
                        </div>
                    </form>
                    <div class="mt-9 px-5" v-if="!isEdit">
                        <button class="main-bg text-white rounded 2xl:text-base lg:text-sm md:text-xs sm:text-xxs px-12 py-2"
                                v-bind:class="{'disabled-bg': form.processing}" :disabled="form.processing" @click="isEdit = true">Edit
                        </button>
                    </div>
                    <jet-validation-errors class="mt-5"/>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import {VueTelInput} from 'vue-tel-input';
    import 'vue-tel-input/dist/vue-tel-input.css';
    import PasswordValidationError from "@/Jetstream/PasswordValidationError";
    import JetValidationErrors from '@/Jetstream/ValidationErrors';
    import Multiselect from '@vueform/multiselect'
    import VueMultiselect from 'vue-multiselect'

    export default {
        name: "Edit",
        components: {
            AppLayout,
            PasswordValidationError,
            JetValidationErrors,
            Multiselect,
            VueTelInput,
            VueMultiselect
        },
        props: {
            companies: Object,
            company: Object,
            countries: Object,
            associate: Object,
        },
        data: function () {
            return {
                storage: window.location.origin,
                s3_storage: process.env.MIX_AWS_PUBLIC_STORAGE,
                form: {
                    id: '',
                    title: '',
                    password: null,
                    tax_id: '',
                    assist_phone: '',
                    address: '',
                    country: [],
                    city: '',
                    name: '',
                    phone: '',
                    position: '',
                    email: '',
                    associate: null,
                    type: 1,
                    policyFormats: [],
                    trustedPhones: [],
                    processing: false,
                    tokens: '',
                    increaseTokens: '',
                },
                check_img: 0,
                isEdit: false,
            }
        },
        mounted() {
            this.load();
        },
        methods: {
            load() {
                this.isEdit = false;
                this.form.id = this.company.id;
                this.form.title = this.company.title;
                this.form.tax_id = this.company.tax_id;
                this.form.assist_phone = this.company.phone;
                this.form.country = this.company.country ? this.company.country : null;
                this.form.city = this.company.city;
                this.form.address = this.company.address;
                this.form.name = this.company.owner.name;
                this.form.position = this.company.owner.position;
                this.form.email = this.company.owner.email;
                this.form.phone = this.company.owner.phone;
                this.form.associate = this.associate;
                this.form.type = this.company.type;
                this.form.tokens = this.company.tokens_count;

                let policy = [];
                this.company.masks.forEach(function (current) {
                    policy.push(current.mask);
                });
                this.form.policyFormats = policy;
                let phones = [];
                this.company.phones.forEach(function (current) {
                    phones.push(current.phone);
                });
                this.form.trustedPhones = phones;
            },
            imageTrigger() {
                document.getElementById('image').click();
                this.check_img = 0;
            },
            setImage(event) {
                if (event.currentTarget.files && event.currentTarget.files[0]) {
                    let reader = new FileReader();

                    reader.onload = function (e) {
                        document.getElementById('preview').setAttribute("src", e.target.result);
                        document.getElementById('preview').style.width = '200px';
                    };
                    reader.readAsDataURL(event.currentTarget.files[0]);
                }
            },
            addFormat() {
                this.form.policyFormats.push(null);
            },
            removeFormat(index) {
                this.form.policyFormats.splice(index, 1);
            },
            addPhone() {
                this.form.trustedPhones.push(null);
            },
            removePhone(index) {
                this.form.trustedPhones.splice(index, 1);
            },
            submit() {
                this.form.processing = true;
                let data = new FormData();
                data.append('form', JSON.stringify(this.form));
                data.append('image', document.getElementById('image').files[0] === undefined ? null : document.getElementById('image').files[0]);
                data.append('example', document.getElementById('example').files[0] === undefined ? null : document.getElementById('example').files[0]);
                this.$inertia.post('/company/update', data, {
                    onFinish: visit => {
                        this.form.processing = false;
                    }
                });
            }
        }
    }
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>