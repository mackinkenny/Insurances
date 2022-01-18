<template>
    <section class="h-full">
        <div class="signup_full">

        <!-- Start item_brand -->
        <div class="item_brand">
            <div class="container mx-auto px-0 xl:px-0 lg:px-14">
                    <img class="inline" :src="storage + '/images/logo.png'" alt="">
                    <span class="polizzacerta">POLIZZA<b>CERTA</b></span>
            </div>
        </div>
        <!-- End. item_brand -->

        <!-- Start form_signup_onek -->
        <section class="form_signup_one">
            <div class="container mx-auto px-0 xl:px-0 lg:px-14">
                <div class="flex justify-center xl:justify-end lg:justify-end md:justify-end items-center responsive-screen">
                    <div class="w-12/12 xl:w-5/12 lg:w-5/12 md:w-7/12 px-2">
                        <div class="item_group">
                            <form @submit.prevent="submit">
                                <div class="w-full px-2">
                                    <div class="title_sign">
                                        <h2>{{phrases.verify_your_policy}}</h2>
                                        <p>{{ phrases.how_work }} <a href="/how_it_works" style="color: #fd6b3b;">{{phrases.discover }}</a></p>
                                    </div>
                                </div>
                                <div v-if="step === 1">
                                    <div class="w-full px-2">
                                        <div class="form-group mb-4">
                                            <label class="pb-2">{{ phrases.choose }}</label>
                                            <div class="select form-group mt-2">
                                                <div class="flex items-center cursor-pointer relative select-company w-full" style="font-size: 14px; color: #9090a1; font-weight: 400;" @click="select = !select">
                                                    <span>{{toShow}}</span>
                                                    <div v-if="select === true" class="absolute w-full left-0 py-2 overflow-auto bg-white z-50 rounded" style="top:100%; box-shadow: 0px 5px 25px rgba(0, 0, 0, 0.1); max-height: 10rem;">
                                                        <div class="py-2 px-2 select-text flex items-center" v-bind:class="{'active': form.company === company.id}" v-for="company in companies" @click="changeImage(company.id)">
                                                            <img class="w-1/12" :src="s3_storage + '/' + company.logo" alt="">
                                                            <p class="w-11/12 px-3">{{company.title}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="step === 2">
                                    <div class="w-full px-2">
                                        <div class="form-group">
                                            <p class="text-blue-500 hover:text-blue-700 focus:text-blue-700 cursor-pointer" @click="show"><i class="tio info"></i> <span class="font-s-13">{{phrases.where_i_can_find_a_policy_number}}</span>
                                            </p>
                                            <div class="images hidden"
                                                 v-viewer="{navbar: false, title: false, toolbar: false, tooltip: false, movable: false}">
                                                <img :src="s3_storage + '/' + image" alt="">
                                            </div>
                                            <div class="logos hidden"
                                                 v-viewer="{navbar: false, title: false, toolbar: false, tooltip: false, movable: false}">
                                                 <img :src="storage + '/images/polizzalogo.png'" alt="">
                                            </div>
                                            <label class="pb-2 mb-2">{{phrases.policy_format}} </label>
                                            <div class="select-company w-full my-2 flex items-center hover:bg-purple-100 cursor-pointer"
                                                 v-for="mask in masks" @click="selectFormat(mask.mask)">
                                                <span>{{mask.show}}</span>
                                            </div>
                                        </div>

                                        <div class="flex justify-between">
                                            <p class="font-s-13 c-orange-red cursor-pointer" @click="step = 1">{{phrases.back}}</p>
                                            <p class="font-s-13 c-orange-red cursor-pointer" @click="dataSafe = true">{{phrases.data_safe}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="" v-if="step === 3">
                                <div class="w-full px-2">
                                    <div class="form-group mb-4">

                                        <div class="images hidden" v-viewer="{navbar: false, title: false, toolbar: false, tooltip: false, movable: false}">
                                            <img :src="storage + '/' + image" alt="">
                                        </div>
                                        <div class="logos hidden"
                                             v-viewer="{navbar: false, title: false, toolbar: false, tooltip: false, movable: false}">
                                            <img :src="storage + '/images/polizzalogo.png'" alt="">
                                        </div>
                                        <label class="pb-2">{{phrases.policy_number }} <span class="text-blue-500 hover:text-blue-700 focus:text-blue-700 cursor-pointer" @click="show"><i class="tio info"></i> <span class="font-s-13">{{phrases.where_i_can_find_a_policy_number}}</span></span></label>
                                        <input type="text" class="form-control w-full mt-2" v-maska="{mask: selectedFormat}" v-model="form.policy" :placeholder="phrases.policy_number" required>
                                    </div>
                                </div>

                                <div class="w-full px-2">
                                    <div class="form-group mb-4 --password" id="show_hide_password">
                                        <label class="pb-2">{{phrases.tax }}</label>
                                        <div class="input-group relative mt-2">
                                            <input :type="visibility === true ? 'text' : 'password'"  v-model="form.tax" class="form-control w-full text-uppercase" data-toggle="password" :placeholder="phrases.tax"
                                                   required="" />
                                            <div class="input-group-prepend hide_show" @click="visibility = !visibility">
                                                <span class="input-group-text tio cursor-pointer" v-bind:class="{'hidden_outlined' : !visibility, 'visible_outlined' : visibility}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-between">
                                        <p class="font-s-13 c-orange-red cursor-pointer" @click="masks.length === 1 ? step = 1 : step = 2">{{phrases.back}}</p>
                                        <p class="font-s-13 c-orange-red cursor-pointer" @click="dataSafe = true">{{phrases.data_safe}}</p>
                                    </div>
                                </div>
                                <div class="w-full px-2">
                                    <button type="submit" class="btn w-full margin-t-3 btn_account bg-lightgreen c-white rounded-8 cursor-pointer">
                                        {{phrases.check }}
                                    </button>
                                </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <!--Not found modal-->
                    <div class="form-alert absolute fade-in" v-if="status && !type">
                        <div class="form-block relative flex justify-center pt-28">
                            <div class="absolute top-4 right-4 cursor-pointer" @click="closeSearch">
                                <svg width="50" height="50" viewBox="0 0 50 50" fill="#B9B9C3" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M38.9596 36.042C39.793 36.8753 39.793 38.1253 38.9596 38.9587C38.543 39.3753 38.1263 39.5837 37.5013 39.5837C36.8763 39.5837 36.4596 39.3753 36.043 38.9587L25.0013 27.917L13.9596 38.9587C13.543 39.3753 13.1263 39.5837 12.5013 39.5837C11.8763 39.5837 11.4596 39.3753 11.043 38.9587C10.2096 38.1253 10.2096 36.8753 11.043 36.042L22.0846 25.0003L11.043 13.9587C10.2096 13.1253 10.2096 11.8753 11.043 11.042C11.8763 10.2087 13.1263 10.2087 13.9596 11.042L25.0013 22.0837L36.043 11.042C36.8763 10.2087 38.1263 10.2087 38.9596 11.042C39.793 11.8753 39.793 13.1253 38.9596 13.9587L27.918 25.0003L38.9596 36.042Z"
                                          fill="#B9B9C3"/>
                                    <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="10" y="10" width="30" height="30">
                                        <path d="M38.9596 36.042C39.793 36.8753 39.793 38.1253 38.9596 38.9587C38.543 39.3753 38.1263 39.5837 37.5013 39.5837C36.8763 39.5837 36.4596 39.3753 36.043 38.9587L25.0013 27.917L13.9596 38.9587C13.543 39.3753 13.1263 39.5837 12.5013 39.5837C11.8763 39.5837 11.4596 39.3753 11.043 38.9587C10.2096 38.1253 10.2096 36.8753 11.043 36.042L22.0846 25.0003L11.043 13.9587C10.2096 13.1253 10.2096 11.8753 11.043 11.042C11.8763 10.2087 13.1263 10.2087 13.9596 11.042L25.0013 22.0837L36.043 11.042C36.8763 10.2087 38.1263 10.2087 38.9596 11.042C39.793 11.8753 39.793 13.1253 38.9596 13.9587L27.918 25.0003L38.9596 36.042Z"
                                              fill="white"/>
                                    </mask>
                                </svg>
                            </div>
                            <div class="icon-block icon-fail absolute flex items-center justify-center">
                                <svg class="alert-logo" viewBox="0 0 106 106" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M9.25094 94.9995C11.4384 96.312 13.6259 96.7495 15.8134 96.7495H90.1884C93.6884 96.7495 96.7509 95.437 98.9384 92.812C101.563 90.6245 102.876 87.1245 102.876 83.6245C102.876 81.437 102.438 79.2495 101.126 77.062L64.3759 15.3745C62.1884 12.312 59.5634 10.1245 56.0634 9.24949C52.5634 8.37449 49.0634 8.81199 46.0009 10.562C44.2509 11.437 42.5009 13.187 41.6259 14.937L4.43844 77.062C0.938435 83.187 3.12594 91.4995 9.25094 94.9995ZM12.3133 81.4368L49.0633 19.7493C49.5008 18.8743 49.9383 18.4368 50.8133 17.9993C53.0008 17.1243 55.6258 17.5618 56.9383 19.7493L93.6883 81.4368C94.1258 82.3118 94.1258 82.7493 94.1258 83.6243C94.1258 84.9368 93.6883 85.8118 92.8133 86.6868C91.9383 87.5618 91.0633 87.9993 89.7508 87.9993H15.8133C15.3758 87.9993 14.5008 87.9993 14.0633 87.5618C11.8758 86.2493 11.0008 83.6243 12.3133 81.4368ZM57.3751 57.375V39.875C57.3751 37.25 55.6251 35.5 53.0001 35.5C50.3751 35.5 48.6251 37.25 48.6251 39.875V57.375C48.6251 60 50.3751 61.75 53.0001 61.75C55.6251 61.75 57.3751 60 57.3751 57.375ZM57.3757 74.875C57.3757 76.1875 56.9382 77.0625 56.0632 77.9375C55.1882 78.8125 54.3132 79.25 52.5632 79.25C51.2507 79.25 50.3757 78.8125 49.5007 77.9375C48.6257 77.0625 48.1882 76.1875 48.1882 74.875C48.1882 74.3624 48.3383 74 48.4627 73.6998C48.5506 73.4874 48.6257 73.3062 48.6257 73.125C48.6257 72.6875 49.0632 72.25 49.5007 71.8125C49.9382 71.375 50.3757 70.9375 50.8132 70.9375C51.6882 70.5 52.5632 70.5 53.4382 70.5C53.6898 70.7516 53.7967 70.8585 53.9253 70.9039C54.0204 70.9375 54.1273 70.9375 54.3132 70.9375C54.5319 70.9375 54.6413 71.0469 54.7507 71.1562C54.8601 71.2656 54.9694 71.375 55.1882 71.375C55.6257 71.375 56.0632 71.8125 56.0632 71.8125C56.5007 72.25 56.9382 72.6875 56.9382 73.125C57.3757 73.5625 57.3757 74.4375 57.3757 74.875Z"
                                          fill="white"/>
                                    <mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="2" y="8" width="101"
                                          height="89">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M9.25094 94.9995C11.4384 96.312 13.6259 96.7495 15.8134 96.7495H90.1884C93.6884 96.7495 96.7509 95.437 98.9384 92.812C101.563 90.6245 102.876 87.1245 102.876 83.6245C102.876 81.437 102.438 79.2495 101.126 77.062L64.3759 15.3745C62.1884 12.312 59.5634 10.1245 56.0634 9.24949C52.5634 8.37449 49.0634 8.81199 46.0009 10.562C44.2509 11.437 42.5009 13.187 41.6259 14.937L4.43844 77.062C0.938435 83.187 3.12594 91.4995 9.25094 94.9995ZM12.3133 81.4368L49.0633 19.7493C49.5008 18.8743 49.9383 18.4368 50.8133 17.9993C53.0008 17.1243 55.6258 17.5618 56.9383 19.7493L93.6883 81.4368C94.1258 82.3118 94.1258 82.7493 94.1258 83.6243C94.1258 84.9368 93.6883 85.8118 92.8133 86.6868C91.9383 87.5618 91.0633 87.9993 89.7508 87.9993H15.8133C15.3758 87.9993 14.5008 87.9993 14.0633 87.5618C11.8758 86.2493 11.0008 83.6243 12.3133 81.4368ZM57.3751 57.375V39.875C57.3751 37.25 55.6251 35.5 53.0001 35.5C50.3751 35.5 48.6251 37.25 48.6251 39.875V57.375C48.6251 60 50.3751 61.75 53.0001 61.75C55.6251 61.75 57.3751 60 57.3751 57.375ZM57.3757 74.875C57.3757 76.1875 56.9382 77.0625 56.0632 77.9375C55.1882 78.8125 54.3132 79.25 52.5632 79.25C51.2507 79.25 50.3757 78.8125 49.5007 77.9375C48.6257 77.0625 48.1882 76.1875 48.1882 74.875C48.1882 74.3624 48.3383 74 48.4627 73.6998C48.5506 73.4874 48.6257 73.3062 48.6257 73.125C48.6257 72.6875 49.0632 72.25 49.5007 71.8125C49.9382 71.375 50.3757 70.9375 50.8132 70.9375C51.6882 70.5 52.5632 70.5 53.4382 70.5C53.6898 70.7516 53.7967 70.8585 53.9253 70.9039C54.0204 70.9375 54.1273 70.9375 54.3132 70.9375C54.5319 70.9375 54.6413 71.0469 54.7507 71.1562C54.8601 71.2656 54.9694 71.375 55.1882 71.375C55.6257 71.375 56.0632 71.8125 56.0632 71.8125C56.5007 72.25 56.9382 72.6875 56.9382 73.125C57.3757 73.5625 57.3757 74.4375 57.3757 74.875Z"
                                              fill="white"/>
                                    </mask>
                                    <g mask="url(#mask0)">
                                        <rect x="0.5" y="0.5" width="105" height="105" fill="white"/>
                                    </g>
                                </svg>
                            </div>
                            <div class="2xl:pb-20 xl:pb-16 pb-8 w-10/12 text-center">
                                <p class="2xl:text-3xl xl:text-2xl text-xl font-bold" style="color:#5E5873;">
                                    {{phrases.policy_not_found }}
                                </p>
                                <p class="pt-3" style="color: #5E5873; font-weight: 300;">
                                    {{phrases.policy_no }} <strong class="font-bold">{{form.policy}}</strong> <br> {{phrases.with_tax_id }} <strong class="font-bold">{{form.tax}}</strong>
                                    {{phrases.is_not_validated }}
                                </p>
                                <p class="2xl:pt-8 xl:pt-5 text-left sm:mb-1 xl:mb-0"
                                   style="color: #5E5873; font-weight: 300;">
                                    1) {{phrases.check_if_the_policy_no }} <span class="text-blue-500 cursor-pointer" @click="show">{{phrases.here}}</span>
                                </p>
                                <p class="text-left sm:mb-1 xl:mb-0" style="color: #5E5873; font-weight: 300;">
                                    2) {{phrases.check_if_the_tax_id_is_the_same_of_the_insurance_contract }}
                                </p>
                                <p class="text-left sm:mb-1 xl:mb-0" style="color: #5E5873; font-weight: 300;">
                                    3) {{phrases.check_if_the_contract_show_the_certified_logo_show_logo}} <span class="text-blue-500 cursor-pointer" @click="showLogo">{{phrases.show_logo}}</span>
                                </p>
                                <p class="text-left sm:mb-1 xl:mb-0" style="color: #5E5873; font-weight: 300;">
                                    4) {{phrases.if_you_still_have_doubts_please_contact_us_via_chat }} <br>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--Success search modal-->
                    <div class="form-alert absolute fade-in" v-if="status && type">
                        <div class="form-block relative flex justify-center pt-28">
                            <div class="absolute top-4 right-4 cursor-pointer" @click="closeSearch">
                                <svg width="50" height="50" viewBox="0 0 50 50" fill="#B9B9C3" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M38.9596 36.042C39.793 36.8753 39.793 38.1253 38.9596 38.9587C38.543 39.3753 38.1263 39.5837 37.5013 39.5837C36.8763 39.5837 36.4596 39.3753 36.043 38.9587L25.0013 27.917L13.9596 38.9587C13.543 39.3753 13.1263 39.5837 12.5013 39.5837C11.8763 39.5837 11.4596 39.3753 11.043 38.9587C10.2096 38.1253 10.2096 36.8753 11.043 36.042L22.0846 25.0003L11.043 13.9587C10.2096 13.1253 10.2096 11.8753 11.043 11.042C11.8763 10.2087 13.1263 10.2087 13.9596 11.042L25.0013 22.0837L36.043 11.042C36.8763 10.2087 38.1263 10.2087 38.9596 11.042C39.793 11.8753 39.793 13.1253 38.9596 13.9587L27.918 25.0003L38.9596 36.042Z"
                                          fill="#B9B9C3"/>
                                    <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="10" y="10" width="30" height="30">
                                        <path d="M38.9596 36.042C39.793 36.8753 39.793 38.1253 38.9596 38.9587C38.543 39.3753 38.1263 39.5837 37.5013 39.5837C36.8763 39.5837 36.4596 39.3753 36.043 38.9587L25.0013 27.917L13.9596 38.9587C13.543 39.3753 13.1263 39.5837 12.5013 39.5837C11.8763 39.5837 11.4596 39.3753 11.043 38.9587C10.2096 38.1253 10.2096 36.8753 11.043 36.042L22.0846 25.0003L11.043 13.9587C10.2096 13.1253 10.2096 11.8753 11.043 11.042C11.8763 10.2087 13.1263 10.2087 13.9596 11.042L25.0013 22.0837L36.043 11.042C36.8763 10.2087 38.1263 10.2087 38.9596 11.042C39.793 11.8753 39.793 13.1253 38.9596 13.9587L27.918 25.0003L38.9596 36.042Z"
                                              fill="white"/>
                                    </mask>
                                </svg>
                            </div>
                            <div class="icon-block icon-success absolute flex items-center justify-center">
                                <svg class="alert-logo" viewBox="0 0 89 88" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M73.8351 29.2724C73.8351 13.1726 60.6351 0 44.5018 0C28.3685 0 15.1685 13.1726 15.1685 29.2724C15.1685 38.7859 19.5685 47.2017 26.5351 52.3243L22.5018 83.7921C22.1351 85.2557 22.8685 86.7193 23.9685 87.4511C25.0685 88.183 26.5351 88.183 28.0018 87.4511L44.5018 77.5717L61.0018 87.4511C61.3685 87.817 62.1018 87.817 62.8351 87.817C63.5685 87.817 64.3018 87.4511 64.6685 87.0852C65.7685 86.3534 66.5018 84.8898 66.1351 83.4262L62.1018 52.3243C69.4351 47.2017 73.8351 38.7859 73.8351 29.2724ZM22.502 29.2724C22.502 17.1976 32.402 7.31816 44.502 7.31816C56.602 7.31816 66.502 17.1976 66.502 29.2724C66.502 41.3473 56.602 51.2267 44.502 51.2267C32.402 51.2267 22.502 41.3473 22.502 29.2724ZM46.3351 70.2534L58.0684 77.2056L55.5017 56.349C52.2017 57.8127 48.5351 58.5445 44.5017 58.5445C40.4684 58.5445 36.8017 57.8127 33.5017 56.349L30.9351 77.2056L42.6684 70.2534C43.7684 69.5216 45.2351 69.5216 46.3351 70.2534Z"
                                          fill="black"/>
                                    <mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="15" y="0" width="59"
                                          height="88">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M73.8351 29.2724C73.8351 13.1726 60.6351 0 44.5018 0C28.3685 0 15.1685 13.1726 15.1685 29.2724C15.1685 38.7859 19.5685 47.2017 26.5351 52.3243L22.5018 83.7921C22.1351 85.2557 22.8685 86.7193 23.9685 87.4511C25.0685 88.183 26.5351 88.183 28.0018 87.4511L44.5018 77.5717L61.0018 87.4511C61.3685 87.817 62.1018 87.817 62.8351 87.817C63.5685 87.817 64.3018 87.4511 64.6685 87.0852C65.7685 86.3534 66.5018 84.8898 66.1351 83.4262L62.1018 52.3243C69.4351 47.2017 73.8351 38.7859 73.8351 29.2724ZM22.502 29.2724C22.502 17.1976 32.402 7.31816 44.502 7.31816C56.602 7.31816 66.502 17.1976 66.502 29.2724C66.502 41.3473 56.602 51.2267 44.502 51.2267C32.402 51.2267 22.502 41.3473 22.502 29.2724ZM46.3351 70.2534L58.0684 77.2056L55.5017 56.349C52.2017 57.8127 48.5351 58.5445 44.5017 58.5445C40.4684 58.5445 36.8017 57.8127 33.5017 56.349L30.9351 77.2056L42.6684 70.2534C43.7684 69.5216 45.2351 69.5216 46.3351 70.2534Z"
                                              fill="white"/>
                                    </mask>
                                    <g mask="url(#mask0)">
                                        <rect x="0.500977" width="88" height="88" fill="white"/>
                                    </g>
                                </svg>


                            </div>
                            <div class="2xl:pb-20 xl:pb-16 pb-8 w-10/12 text-center">
                                <p class="2xl:text-3xl xl:text-2xl text-xl font-bold" style="color:#5E5873;">
                                    {{phrases.policy_certified }}
                                </p>
                                <p class="form-subtitle pt-3" style="color: #5E5873; font-weight: 400;">
                                    {{phrases.policy_no }} <strong class="font-bold">{{form.policy}}</strong> {{phrases.referring_to_the_tax_id }}<br>
                                    {{form.tax}} {{phrases.is_certified }}
                                </p>
                                <div class="flex mt-8">
                                    <img class="success-icon" src="images/done.png" alt="">
                                    <div>
                                        <p class="success-text montserrat text-left ml-2 mb-2" style="font-weight: 500;">
                                            {{phrases.insurance }}
                                        </p>
                                        <p class="success-text montserrat text-left ml-2 mb-2" style="font-weight: 400;">
                                            {{contract.company}}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex mt-5">
                                    <img class="success-icon" src="images/calendar.png" alt="">
                                    <div>
                                        <p class="success-text montserrat text-left ml-2 mb-2" style="font-weight: 500;">
                                            {{phrases.expiration_date }}
                                        </p>
                                        <p class="success-text montserrat text-left ml-2 mb-2" style="font-weight: 400;">
                                            {{contract.date}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--background color block-->
                    <div class="alert-flag absolute fade-in" v-if="status" v-bind:class="{'fail':!type, 'success': type}"></div>
                    <div class="backdrop absolute" v-if="status || dataSafe"></div>
                </div>
            </div>

        </section>
        <!-- End.form_signup_one -->

        <!-- Start item_footer -->
        <div class="item_footer">
            <div class="container mx-auto px-0 xl:px-0 lg:px-14">
                <p>© 2021 <a href="https://www.polizzacerta.it" target="_blank">PolizzaCerta.</a> All Right Reseved <span class="ml-2">VAT code: IT12009560967</span> <a v-bind:href="phrases.legalPrivacyLink" target="_blank">{{phrases.legalPrivacy}}</a></p>
            </div>
        </div>
        <!-- End. item_footer -->


        <!-- Back to top with progress indicator-->
        <div class="prgoress_indicator">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>
            <div class="form-alert absolute z-50" v-if="dataSafe">
                <div class="form-block px-4 pb-4 pt-12 bg-white relative overflow-y-auto" style="white-space: pre-wrap;">
                    <div class="absolute top-4 right-4 cursor-pointer" @click="dataSafe = false">
                        <svg width="25" height="25" viewBox="0 0 50 50" fill="#B9B9C3" xmlns="http://www.w3.org/2000/svg">
                            <path d="M38.9596 36.042C39.793 36.8753 39.793 38.1253 38.9596 38.9587C38.543 39.3753 38.1263 39.5837 37.5013 39.5837C36.8763 39.5837 36.4596 39.3753 36.043 38.9587L25.0013 27.917L13.9596 38.9587C13.543 39.3753 13.1263 39.5837 12.5013 39.5837C11.8763 39.5837 11.4596 39.3753 11.043 38.9587C10.2096 38.1253 10.2096 36.8753 11.043 36.042L22.0846 25.0003L11.043 13.9587C10.2096 13.1253 10.2096 11.8753 11.043 11.042C11.8763 10.2087 13.1263 10.2087 13.9596 11.042L25.0013 22.0837L36.043 11.042C36.8763 10.2087 38.1263 10.2087 38.9596 11.042C39.793 11.8753 39.793 13.1253 38.9596 13.9587L27.918 25.0003L38.9596 36.042Z"
                                  fill="#B9B9C3"/>
                            <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="10" y="10" width="30" height="30">
                                <path d="M38.9596 36.042C39.793 36.8753 39.793 38.1253 38.9596 38.9587C38.543 39.3753 38.1263 39.5837 37.5013 39.5837C36.8763 39.5837 36.4596 39.3753 36.043 38.9587L25.0013 27.917L13.9596 38.9587C13.543 39.3753 13.1263 39.5837 12.5013 39.5837C11.8763 39.5837 11.4596 39.3753 11.043 38.9587C10.2096 38.1253 10.2096 36.8753 11.043 36.042L22.0846 25.0003L11.043 13.9587C10.2096 13.1253 10.2096 11.8753 11.043 11.042C11.8763 10.2087 13.1263 10.2087 13.9596 11.042L25.0013 22.0837L36.043 11.042C36.8763 10.2087 38.1263 10.2087 38.9596 11.042C39.793 11.8753 39.793 13.1253 38.9596 13.9587L27.918 25.0003L38.9596 36.042Z"
                                      fill="white"/>
                            </mask>
                        </svg>
                    </div>
                    <p class="font-normal">
                        {{phrases.dataSafe}}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import 'viewerjs/dist/viewer.css'
    import { directive as viewer } from "v-viewer"
    import { maska } from 'maska'
    import LangJson from '@lang/en/auth.php'
    import Hide from '@/Jetstream/HideComponent'

    export default {
        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            laravelVersion: String,
            phpVersion: String,
            companies: Array,
            phrases: Object
        },
        directives: {
            viewer: viewer({
                debug: true,
            }),
            maska,
        },
        data: function () {
            return {
                status: false,
                type: false,
                contract: null,
                storage: window.location.origin,
                s3_storage: process.env.MIX_AWS_PUBLIC_STORAGE,
                image: null,
                masks: null,
                selectedFormat: null,
                formatDisable: false,
                select: false,
                step: 1,
                visibility: false,
                dataSafe: false,
                toShow: this.__('userpage.insurance'),
                form: {
                    company: null,
                    policy: '',
                    tax: '',
                }
            }
        },
        methods: {
            //search function
            search: function () {
                if (this.company == 1) {
                    this.type = true;
                }
                else {
                    this.type = false;
                }
                this.status = true;
            },
            //close modal function
            closeSearch: function () {
                this.status = false;
            },
            show () {
                const viewer = this.$el.querySelector('.images').$viewer
                viewer.show()
            },
            showLogo() {
                const viewer = this.$el.querySelector('.logos').$viewer
                viewer.show()
            },
            changeImage(id) {
                this.form.company = id;
                let filtered = this.companies.filter(function(el) {
                    return el.id == id;
                });
                this.image = filtered[0].example;
                this.form.policy = '';
                this.selectedFormat = filtered[0].masks[0].mask;
                this.masks = filtered[0].masks;
                filtered[0].masks && filtered[0].masks.length > 1 ? this.formatDisable = false : this.formatDisable = true;
                if(filtered[0].masks.length > 1) {
                    const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
                    filtered[0].masks.forEach(function(item, index) {
                        let numbers = 1;
                        let letters = 0;
                        item.show = item.mask;
                        for (let i = 0; i < item.mask.length; i ++) {
                            if (item.mask[i] === 'A'){
                                item.show = item.show.substring(0,i) + alphabet[letters] + item.show.substring(i+1);
                                letters++;
                            }
                            else if (item.mask[i] === '#'){
                                item.show = item.show.substring(0,i) + numbers + item.show.substring(i+1);
                                numbers === 9 ? numbers = 0 : numbers++;
                            }
                        }
                    });
                }
                filtered[0].masks && filtered[0].masks.length > 1 ? this.step = 2 : this.step = 3;


                // let masks = [];
                // filtered[0].masks.forEach(function(current) {
                //     filtered[0].masks.length > 1 ? masks.push(current.mask) : masks = current.mask;
                // });

                this.toShow = filtered[0].title;

            },
            selectFormat(event) {
                this.selectedFormat = event;
                this.form.policy = null;
                this.step = 3;
            },
            submit() {
                axios.post('user/contract/search', {
                    'data': this.form,
                }).then(response => {
                    if (response.data.status == true) {
                        this.status = true;
                        this.type = true;
                        this.contract = response.data.contract;
                    }
                    else {
                        this.type = false;
                        this.status = true;
                    }
                });
            }
        }
    }
</script>
<style scoped>
  .select-text {
       color: #6E6B7B;
   }
  .select-text:hover, .select-text.active {
        background: rgba(115, 103, 240, 0.12);
        color: #7367F0!important;
    }
    .form-alert {
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 100;
    }

    .form-alert .form-block {
        width: 550px;
        height: 450px;
        background: #F7F7F7;
        border-radius: 12px;
    }

    .alert-flag {
        top: 50%;
        left: 50%;
        transform: translate(-50%, -18.5%);
        z-index: 75;
        width: 450px;
        height: 315px;
        border-radius: 20px;
    }

    .alert-flag.fail {
        background: linear-gradient(85.65deg, #FF7272 19.65%, #FFD295 111.26%);
    }

    .alert-flag.success {
        background: linear-gradient(82.01deg, #00BE6A 18.04%, #A2EBA1 102.83%);
    }

    .alert-logo {
        width: 80px;
        height: 80px;
    }

    .icon-block {
        top: 0%;
        left: 50%;
        transform: translate(-50%, -40%);
        width: 180px;
        height: 180px;
        border-radius: 50%;
        z-index: 100;
        box-shadow: 0px 5.54276px 33.2565px rgba(0, 0, 0, 0.06);
    }

    .icon-fail {
        background: linear-gradient(85.65deg, #FF7272 19.65%, #FFD295 111.26%);
        filter: drop-shadow(0px 10px 100px rgba(255, 114, 114, 0.4));
    }

    .icon-success {
        background: linear-gradient(82.01deg, #00BE6A 18.04%, #A2EBA1 102.83%);
        filter: drop-shadow(0px 10px 100px rgba(0, 190, 106, 0.4));
    }

    .success-icon {
        width: 65px;
        height: 65px;
    }

    .success-text {
        font-size: 17px;
        line-height: 21px;
        color: #5E5873;
    }

    .backdrop {
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100%;
        background-color: #000000;
        opacity: 0.5;
        z-index: 50;
    }



    @media screen and (max-width: 768px) {
        .form-alert .form-block {
            width: 300px;
            height: 440px;
            background: #F7F7F7;
            border-radius: 12px;
        }

        .icon-block {
            top: 0%;
            left: 50%;
            transform: translate(-50%, -40%);
            width: 100px;
            height: 100px;
            border-radius: 50%;
            z-index: 100;
        }

        .alert-flag {
            top: 50%;
            left: 50%;
            transform: translate(-50%, 40%);
            z-index: 75;
            width: 296px;
            height: 183px;
            background: linear-gradient(85.65deg, #FF7272 19.65%, #FFD295 111.26%);
            border-radius: 20px;
        }

        .alert-logo {
            width: 48px;
            height: 48px;
        }

        .success-icon {
            width: 50px;
            height: 50px;
        }

        .success-text {
            font-size: 16px;
            line-height: 18px;
            color: #5E5873;
        }
    }

</style>

