<template>
    <app-layout>
        <div class="py-6">
            <div class="max-w-7xl">
                <div class="rounded-lg bg-white px-5 py-6">
                    <form @submit.prevent="submit">
                        <div class="flex justify-between px-5">
                            <div>
                                <p class="main-text 2xl:text-lg lg:text-sm md:text-xs sm:text-xxs  font-bold">
                                    Main information
                                </p>
                                <!--START Add Company logo section -->
                                <img id="preview" class="2xl:w-24 xl:w-20 w-16 mt-4 cursor-pointer" v-on:click="imageTrigger"
                                     :src="storage + '/images/upload.png'" alt="">
                                <input id="image" type="file" class="hidden" accept="image/png, image/gif, image/jpeg" @change="setImage($event)"/>
                                <p class="text-red-500 text-xs" v-if="check_img">Please add a company logo</p>
                                <!--END Add Company logo section -->
                            </div>
                            <div class="flex items-center">
                                <p class="main-text font-bold  2xl:text-lg lg:text-sm md:text-xs sm:text-xxs mr-3"
                                   v-if="companies && companies.length > 0 && form.type == 2">
                                    Associated with
                                </p>
                                <!--START Select associated company  -->
                                <Multiselect
                                    class="main-bg text-white associate text-center rounded 2xl:text-base xl:text-sm text-xs max-h-8 py-1" style="width:13rem;"
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
                                    v-model="form.type"
                                    :options="[{'id': 1, 'title': 'Company'},{'id': 2, 'title': 'Agency'}]"
                                    valueProp="id"
                                    label="title"
                                    trackBy="title"
                                    required
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

                        <!--START Main company information-->
                        <div class="mt-12">
                            <div class="grid grid-cols-3">
                                <div class="px-5">
                                    <label class="main-text font-medium 2xl:text-base xl:text-sm text-xs" for="title">
                                        Title
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;" v-model="form.title" id="title" type="text"
                                           required>
                                </div>
                                <div class="px-5">
                                    <label class="main-text font-medium 2xl:text-base xl:text-sm text-xs" for="tax">
                                        Tax ID
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;" v-model="form.tax_id" id="tax" type="text"
                                           required>
                                </div>
                                <div class="px-5">
                                    <label class="main-text font-medium 2xl:text-base xl:text-sm text-xs" for="password">
                                        Password
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;" v-model="form.password" id="password"
                                           type="text" required>
                                    <password-validation-error></password-validation-error>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 mt-5">
                                <div class="px-5">
                                    <label class="main-text font-medium 2xl:text-base xl:text-sm text-xs" for="assist_phone">
                                        Phone number for assistance
                                    </label>
                                    <vue-tel-input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;" id="assist_phone" :inputOptions="inputOptions"
                                                   v-model="form.assist_phone" mode="international"
                                                   onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 43'
                                                   placeholder="" />
                                </div>

                                <div class="px-5">
                                    <label class="main-text font-medium 2xl:text-base xl:text-sm text-xs" for="country">
                                        Country
                                    </label>
<!--                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;"-->
<!--                                           v-model="form.country" id="country" type="text" required>-->
                                    <div class="mt-1">
                                    <VueMultiselect
                                        style="border: 1px solid rgb(185, 185, 195); height: auto;"
                                        v-model="form.country"
                                        :options="countries"
                                        valueProp="id"
                                        label="name"
                                        trackBy="name"
                                        :close-on-select="true"
                                        :clear-on-select="true"
                                        required
                                    />
                                    </div>
                                </div>
                                <div class="px-5">
                                    <label class="main-text font-medium 2xl:text-base xl:text-sm text-xs" for="city">
                                        City
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;"
                                           v-model="form.city" id="city" type="text" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 mt-5">
                                <div class="px-5">
                                    <label class="main-text font-medium 2xl:text-base xl:text-sm text-xs" for="address">
                                        Address
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;"
                                           v-model="form.address" id="address" type="text" required>
                                </div>
                            </div>
                        </div>
                        <!--End Main company information-->
                        <!--START Main responsible person information-->
                        <div class="mt-9">
                            <p class="main-text font-bold  2xl:text-lg lg:text-sm md:text-xs sm:text-xxs px-5">
                                Responsible person
                            </p>
                            <div class="grid grid-cols-3 mt-5">
                                <div class="px-5">
                                    <label class="main-text font-medium 2xl:text-base xl:text-sm text-xs" for="name">
                                        Name
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;"
                                           v-model="form.name" id="name" type="text" required>
                                </div>
                                <div class="px-5">
                                    <label class="main-text font-medium 2xl:text-base xl:text-sm text-xs" for="phone">
                                        Phone
                                    </label>
                                    <vue-tel-input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;" :inputOptions="inputOptions"
                                                   id="phone" v-model="form.phone" mode="international"
                                                   onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 43'
                                                   placeholder="" />
                                </div>
                            </div>
                            <div class="grid grid-cols-3 mt-5">
                                <div class="px-5">
                                    <label class="main-text font-medium 2xl:text-base xl:text-sm text-xs" for="position">
                                        Position
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;"
                                           v-model="form.position" id="position" type="text" required>
                                </div>
                                <div class="px-5">
                                    <label class="main-text font-medium 2xl:text-base xl:text-sm text-xs" for="email">
                                        Email
                                    </label>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;"
                                           v-model="form.email" id="email" type="email" required>
                                </div>
                            </div>
                        </div>
                        <!--END Main responsible person information-->
                        <!--START Add policy number formats section-->
                        <div class="mt-9">
                            <div class="flex items-center">
                                <p class="main-text font-bold 2xl:text-lg lg:text-sm md:text-xs sm:text-xxs pl-5">
                                    Policy number formats
                                </p>
                                <svg @click="addFormat" class="ml-2 cursor-pointer" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="12" fill="#28C76F"/>
                                    <path
                                        d="M7.09133 11.02V13.2H10.8713V17.12H13.1113V13.2H16.9113V11.02H13.1113V7.12H10.8713V11.02H7.09133Z"
                                        fill="white"/>
                                </svg>
                            </div>
                            <p class="main-text font-medium text-xxs text-gray-600 pl-5">
                                For example: <br>
                                Ar7/689-5TT - AA#/###-#AA <br>
                                X - letters or numbers </p>
                            <div class="grid grid-cols-3 mt-5">
                                <div class="px-5 mt-2" v-for="(policy, index) in form.policyFormats">
                                    <div class="flex items-center">
                                        <label class="main-text font-medium 2xl:text-base xl:text-sm text-xs">
                                            Policy number format
                                        </label>
                                        <svg v-if="form.policyFormats.length > 1" @click="removeFormat(index)"
                                             class="ml-2 cursor-pointer" width="24" height="24" viewBox="0 0 24 24"
                                             fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="24" height="24" rx="12" fill="#EA5455"/>
                                            <rect x="5" y="11" width="14" height="3" rx="0.5" fill="white"/>
                                        </svg>
                                    </div>
                                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;"
                                           v-model="form.policyFormats[index]" type="text" required>
                                </div>

                            </div>
                        </div>
                        <!--END Add policy number formats section-->
                        <!--START Add trusted phones section-->
                        <div class="mt-9">
                            <div class="flex items-center">
                                <p class="main-text font-bold 2xl:text-lg lg:text-sm md:text-xs sm:text-xxs pl-5">
                                    Trusted telephone numbers
                                </p>
                                <svg @click="addPhone" class="ml-2 cursor-pointer" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="12" fill="#28C76F"/>
                                    <path
                                        d="M7.09133 11.02V13.2H10.8713V17.12H13.1113V13.2H16.9113V11.02H13.1113V7.12H10.8713V11.02H7.09133Z"
                                        fill="white"/>
                                </svg>
                            </div>
                            <div class="grid grid-cols-3 mt-5">
                                <div class="px-5 mt-2" v-for="(phone, index) in form.trustedPhones">
                                    <div class="flex items-center">
                                        <label class="main-text font-medium 2xl:text-base xl:text-sm text-xs">
                                            Trusted telephone number {{ index + 1 }}
                                        </label>
                                        <svg v-if="form.trustedPhones.length > 1" @click="removePhone(index)"
                                             class="ml-2 cursor-pointer" width="24" height="24" viewBox="0 0 24 24"
                                             fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="24" height="24" rx="12" fill="#EA5455"/>
                                            <rect x="5" y="11" width="14" height="3" rx="0.5" fill="white"/>
                                        </svg>
                                    </div>
                                    <vue-tel-input :inputOptions="inputOptions"
                                        class="rounded w-full mt-1"
                                        style="border: 1px solid #B9B9C3;"
                                        v-model="form.trustedPhones[index]" mode="international"
                                        onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 43'
                                        placeholder=""
                                    />
                                </div>
                            </div>
                        </div>
                        <!--END Add trusted phones section-->

                        <div class="mt-9">
                            <div class="grid grid-cols-3">
                                <!--START Add Tokens to company-->
                                <div>
                                    <p class="main-text font-bold  2xl:text-lg xl:text-base lg:text-sm md:text-xs sm:text-xxs px-5">
                                        Tokens
                                    </p>
                                    <div class="px-5 mt-5">
                                        <label class="main-text font-medium 2xl:text-base xl:text-sm text-xs" for="tokens">
                                            Number of available tokens
                                        </label>
                                        <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;"
                                               v-model="form.tokens" id="tokens" type="number" required>
                                    </div>
                                </div>
                                <!--END Add Tokens to company-->
                                <!--START Add Example image-->
                                <div>
                                    <p class="main-text font-bold 2xl:text-base xl:text-base lg:text-sm md:text-xs sm:text-xxs px-5">
                                        Example of the Insurance Contract
                                    </p>
                                    <div class="px-5 mt-5">
                                        <label class="main-text font-medium 2xl:text-base xl:text-sm text-xs" for="example">
                                            Example
                                        </label>
                                        <input class="rounded w-full mt-1 py-1.5" style="border: 1px solid #B9B9C3;"
                                               id="example" type="file" accept="image/png, image/gif, image/jpeg"
                                               required>
                                    </div>
                                </div>
                                <!--END Add Example image-->
                            </div>
                        </div>
                        <div class="mt-9 px-5">
                            <button type="submit" class="main-bg text-white rounded 2xl:text-base lg:text-sm md:text-xs sm:text-xxs px-12 py-2"
                                    v-bind:class="{'disabled-bg': form.processing}" :disabled="form.processing">Save
                            </button>
                        </div>
                        <!--START Validation errors component-->
                        <jet-validation-errors class="mt-5"/>
                        <!--END Validation errors component-->
                    </form>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import {VueTelInput} from 'vue-tel-input';
    import 'vue-tel-input/dist/vue-tel-input.css';
    import JetValidationErrors from '@/Jetstream/ValidationErrors'
    import PasswordValidationError from "@/Jetstream/PasswordValidationError";
    import Multiselect from '@vueform/multiselect'
    import VueMultiselect from 'vue-multiselect'

    export default {
        name: "Create",
        components: {
            AppLayout,
            VueTelInput,
            JetValidationErrors,
            Multiselect,
            PasswordValidationError,
            VueMultiselect
        },
        props: {
            companies: Object,
            countries: Object,
        },
        data: function () {
            return {
                storage: window.location.origin,
                form: {
                    title: '',
                    password: '',
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
                    policyFormats: [null],
                    trustedPhones: [null],
                    processing: false,
                    tokens: '',
                },
                check_img: 0,
                isEdit: false,
                inputOptions: {
                    styleClasses: 'h-10 w-full rounded',
                    placeholder: '+1 657 238 4028'
                },
            }
        },
        methods: {
            selectCountry() {
                console.log('success');
            },
            //Start: trigger and set logo functions
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
            //END: trigger and set logo functions

            //Add new policy number format input
            addFormat() {
                this.form.policyFormats.push(null);
            },
            //Remove one of policy number formats input by index
            removeFormat(index) {
                this.form.policyFormats.splice(index, 1);
            },
            //Add new trusted phone input
            addPhone() {
                this.form.trustedPhones.push(null);
            },
            //Remove one of trusted phones input by index
            removePhone(index) {
                this.form.trustedPhones.splice(index, 1);
            },
            //set trusted phones value to form parameter (TelInput plugin can't use v-model)
            setPhone(event, index) {
                this.form.trustedPhones[index] = event.currentTarget.children[1].value;
            },
            //set responsible person phone value to form parameter (TelInput plugin can't use v-model)
            setUserPhone(event) {
                this.form.phone = event.currentTarget.children[1].value;
            },
            //Submit form function
            submit() {
                this.form.processing = true;
                let image = document.getElementById('image').files[0];
                if (!image) {
                    this.check_img = 1;
                    window.scrollTo(0, 0);
                    this.form.processing = false;
                } else {
                    let data = new FormData();
                    data.append('form', JSON.stringify(this.form));
                    data.append('image', document.getElementById('image').files[0]);
                    data.append('example', document.getElementById('example').files[0]);

                    this.$inertia.post('/company/store', data, {
                        onFinish: () => this.form.processing = false,
                    });
                }
            }
        }
    }
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>