<script>
import { required, minLength } from '@vuelidate/validators'
import useVuelidate from "@vuelidate/core";
import Multiselect from '@vueform/multiselect'
import VueMultiselect from 'vue-multiselect'
import { maska } from 'maska'


export default {
    name: "ContractItem",
    components: {
        Multiselect,
        VueMultiselect
    },
    props: {
        contract: [Array, Object],
        company: [Array, Object],
        countries: [Array, Object],
        contractIndex: Number,
        isRemovable: Boolean,
        masks: Object,
        selectedMask: Object,
        formatDisable: Boolean,
    },
    data() {
        return {
            item: this.contract,
            itemIndex: this.contractIndex,
            selected: null,
        }
    },
    setup() {
        return { v$: useVuelidate() }
    },
    watch: {
        item: {
            deep: true,
            handler() {
                this.$emit('updateContractData', this.item);
                this.$emit('errorsCount', this.v$.$errors.length);
            }
        }
    },
    methods: {
        isValid() {
            return this.v$.$validate();
        },
        setFormat(event) {
            this.selected = event;
            this.v$.item.policy_number.$model = '';
        },
    },
    validations() {
        return {
            item: {
                policy_number: {
                    required,
                    minLength: minLength(5),
                    $lazy: true
                },
                tax_id: {
                    required,
                    minLength: minLength(5),
                    $lazy: true
                },
                start_date: {
                    required,
                    $lazy: true
                },
                end_date: {
                    required,
                    $lazy: true
                },
                country: {
                    required,
                    $lazy: true,
                }
            }
        }
    }
}
</script>

<template>
    <div
        class="new-box-shadow rounded-lg bg-white p-6 xl:p-8 2xl:p-10 w-full flex flex-nowrap flex-col justify-start mt-4"
    >
        <p class="2xl:text-xl xl:text-lg text-base mb-5 font-bold w-full text-left">Fill the
            information about the
            Insurance Contract</p>
        <div class="flex justify-start items-start w-full relative">
            <div class="mb-5 w-5/12 mr-4 pr-3 xl:pr-5 2xl:pr-10">
                <p class="mb-5" v-if="!formatDisable">
                    <label class="2xl:text-base xl:text-sm text-xs font-medium "
                           for="policy_format">Policy
                        format</label>
                    <select
                        class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;"
                        type="text"
                        name="policy_format"
                        id="policy_format"
                        @change="setFormat($event.target.value)"
                    >
                        <option value="">Select policy format</option>
                        <option :value="format.mask" v-for="format in masks">{{format.show}}</option>
                    </select>
                </p>
                <p class="mb-5">
                    <label class="2xl:text-base xl:text-sm text-xs font-medium "
                           for="policY_number">Policy
                        number</label>
                    <input
                        class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;"
                        type="text"
                        name="policY_number"
                        id="policY_number"
                        v-maska="{mask: selectedMask ? selectedMask : selected}"
                        v-bind:class="{'disabled-input': !selectedMask && !selected}"
                        v-model.lazy="v$.item.policy_number.$model"
                        :disabled="!selectedMask && !selected"
                    >
                    <span class="text-red-500" v-if="v$ && v$.item.policy_number.$error" >
                        {{v$.item.policy_number.$errors[0].$message}}
                    </span>
                </p>
                <p class="mb-5">
                    <label class="2xl:text-base xl:text-sm text-xs font-medium " for="tax_number">Tax
                        Identification
                        Number</label>
                    <input
                        class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;"
                        type="text"
                        name="tax_number"
                        id="tax_number"
                        v-model.lazy="v$.item.tax_id.$model"
                    >
                    <span class="text-red-500" v-if="v$.item.tax_id.$error" >
                        {{v$.item.tax_id.$errors[0].$message}}
                    </span>
                </p>
                <p class="mb-5">
                    <label class="2xl:text-base xl:text-sm text-xs font-medium mb-2" for="country">Country
                        of the
                        insured</label>
                    <VueMultiselect
                        style="border: 1px solid rgb(185, 185, 195); height: auto;"
                        v-model="v$.item.country.$model"
                        :options="countries"
                        valueProp="id"
                        id="country"
                        label="name"
                        trackBy="name"
                        :searchable="true"
                        :close-on-select="true"
                        :clear-on-select="true"
                        required
                    />
                    <span class="text-red-500" v-if="v$.item.country.$error" >
                        {{v$.item.country.$errors[0].$message}}
                    </span>
                </p>
            </div>
            <div class="mb-5 w-5/12">
                <p class="mb-5">
                    <label class="2xl:text-base xl:text-sm text-xs font-medium " for="start_date">Start
                        date</label>
                    <input
                        class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;"
                        type="datetime-local"
                        name="start_date"
                        id="start_date"
                        v-model.lazy="v$.item.start_date.$model"
                    >
                    <span class="text-red-500" v-if="v$.item.start_date.$error" >
                        {{v$.item.start_date.$errors[0].$message}}
                    </span>
                </p>
                <p class="mb-5">
                    <label class="2xl:text-base xl:text-sm text-xs font-medium " for="end_date">End
                        date</label>
                    <input
                        class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;"
                        type="datetime-local"
                        name="end_date"
                        id="end_date"
                        v-model.lazy="v$.item.end_date.$model"
                    >
                    <span class="text-red-500" v-if="v$.item.end_date.$error" >
                        {{v$.item.end_date.$errors[0].$message}}
                    </span>
                </p>
            </div>
            <!-- button DONE with block done-->
            <!--                    <img class="w-4 absolute bottom-0 right-24" src="/img/done-plus.png" alt="done">-->
            <!-- button DONE with block done-->
        </div>
        <!-- button DELETE with block contract-->
        <img v-if="isRemovable" @click="$emit('removeItem',itemIndex)"
             class="w-4 absolute top-6 right-6 cursor-pointer"
             src="/img/clear.svg" alt="delete form">
        <!-- button DELETE with block contract-->
    </div>
</template>
<style src="@vueform/multiselect/themes/default.css"></style>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style scoped>

</style>
