<script>
import AppLayout from "../../../Layouts/AppLayout";

export default {
  name: "Upload",
  components: {
    AppLayout
  },
  data() {
    return {
      storage: window.location.origin,
    }
  }
}
</script>

<template>
  <AppLayout>
    <div class="w-full  mb-6 contracts-block ">
      <div class="relative new-box-shadow rounded-lg   p-3 xl:p-5 2xl:p-10 w-full flex flex-nowrap flex-col justify-start">
        <p class="text-xl mb-5 font-bold w-full text-left">Fill the information about the Insurance Contract</p>
        <div class="flex justify-start items-start w-full relative">
          <div class="mb-5 w-5/12 mr-4 pr-3 xl:pr-5 2xl:pr-10">
            <p class="mb-5">
              <label class="text-base font-medium " for="policY_number">Policy number</label>
              <input class="p-2.5 text-base font-normal border w-full rounded-lg placeholder-gray-600 placeholder-opacity-75 focus:outline-none  focus:border-indigo-300 focus:border"
                     type="text" name="policY_number" id="policY_number" placeholder="1837000">
            </p>
            <p class="mb-5">
              <label class="text-base font-medium " for="tax_number">Tax Identification Number</label>
              <input class="p-2.5 text-base font-normal border w-full rounded-lg placeholder-gray-600 placeholder-opacity-75 focus:outline-none  focus:border-indigo-300 focus:border"
                     type="text" name="tax_number" id="tax_number" placeholder="1736 8576 894 000">
            </p>
            <p class="mb-5">
              <label class="text-base font-medium " for="country">Country of the insured</label>
              <input class="p-2.5 text-base font-normal border w-full rounded-lg placeholder-gray-600 placeholder-opacity-75 focus:outline-none  focus:border-indigo-300 focus:border"
                     type="text" name="country" id="country" placeholder="UK">
            </p>
          </div>
          <div class="mb-5 w-5/12">
            <p class="mb-5">
              <label class="text-base font-medium " for="start_date">Start date</label>
              <input class="p-2.5 text-base font-normal border w-full rounded-lg placeholder-gray-600 placeholder-opacity-75 focus:outline-none  focus:border-indigo-300 focus:border"
                     type="text" name="start_date" id="start_date" placeholder="21/07/2019 18:30">
            </p>
            <p class="mb-5">
              <label class="text-base font-medium " for="end_date">End date</label>
              <input class="p-2.5 text-base font-normal border w-full rounded-lg placeholder-gray-600 placeholder-opacity-75 focus:outline-none  focus:border-indigo-300 focus:border"
                     type="text" name="end_date" id="end_date" placeholder="21/07/2021 18:00">
            </p>
          </div>
          <!-- button DONE with block done-->
          <img class="w-4 absolute bottom-0 right-24" :src="`${storage}/images/done-plus.png`" alt="done">
          <!-- button DONE with block done-->
        </div>
        <!-- button DELETE with block contract-->
        <img class="w-4 absolute top-6 right-6" :src="`${storage}/images/clear.svg`" alt="delete form">
        <!-- button DELETE with block contract-->
      </div>
    </div>
    <!-- button ADD new contracts -->
    <button class="mb-5 relative left-1/2 items-center justify-center py-2 px-12 bg-indigo-600 bg-opacity-75 text-white text-xs rounded-md hover:shadow-lg focus:outline-none  focus:border-indigo-600 focus:border focus:bg-opacity-100 ">
      + Add more contracts
    </button>
    <!-- button ADD new contracts -->

    <div class="w-full flex flex-wrap justify-content-start mb-6">
      <div class="w-5/12 new-box-shadow rounded-lg mr-6  mb-5 p-3 xl:p-5 2xl:p-10 ">
        <p class="text-xl mb-5 font-bold w-full text-left">Fill the telephone number</p>
        <p class="mb-2">
          <label class="text-base font-medium " for="phone">Phone</label>
          <input class="p-2.5 text-base font-normal border w-full rounded-lg placeholder-gray-600 placeholder-opacity-75 focus:outline-none  focus:border-indigo-300 focus:border"
                 type="text" name="phone" id="phone" placeholder="+7 (902) 750-98-00">
        </p>
        <p class="text-xs">The confirmation code will be sent to this number</p>
      </div>

      <!-- number is not related start -->
      <div class="w-5/12 new-box-shadow rounded-lg mr-6  mb-5 p-3 xl:p-5 2xl:p-10 ">
        <p class="text-xl mb-5 font-bold w-full text-left">Fill the telephone number</p>
        <p class="mb-2">
          <label class="text-base font-medium " for="phone">Phone</label>
          <input class="p-2.5 text-base font-normal border border-red-500 w-full rounded-lg placeholder-gray-600 placeholder-opacity-75 focus:outline-none  focus:border-red-500 focus:border"
                 type="text" name="phone" id="phone" placeholder="+7 (902) 750-98-00">
        </p>
        <p class=" text-xs text-red-500">The telephone number is not related</p>
      </div>
      <!-- number is not related end -->

      <!-- Code done start -->
      <div class="w-5/12 new-box-shadow rounded-lg mr-6 mb-5  p-3 xl:p-5 2xl:p-10 ">
        <p class="text-xl mb-5 font-bold w-full text-left">Fill the confirmation code</p>
        <p class="mb-2">
          <label class="text-base font-medium " for="code">Code</label>
          <input class="p-2.5 text-base font-normal border border-green-400 w-full rounded-lg placeholder-gray-600 placeholder-opacity-75 focus:outline-none  focus:border-green-400 focus:border"
                 type="text" name="code" id="code" placeholder="658394">
        </p>
        <div class=" text-xs text-green-400 flex items-start ">
          <img class="w-3 mr-1" :src="`${storage}/images/Check.png`" alt="done">
          <p>Done</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>

</style>
