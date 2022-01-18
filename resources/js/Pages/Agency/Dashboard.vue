<template>
  <app-layout>
    <div class="w-full py-6 box-border">
      <div class="w-full flex justify-content-between mb-8">
        <div class="w-1/2 flex justify-start  items-center">
          <p><img class="2xl:w-28 xl:w-24 lg:w-20 w-16 mr-2" :src="storage + '/img/company-logo.png'"
                  alt="company logo"></p>
          <p class="flex flex-col justify-start items-start ">
            <span class=" 2xl:text-3xl xl:text-2xl lg:text-xl text-lg text-left font-bold">Imkliva Agency</span>
            <span class="2xl:text-lg xl:text-base lg:text-sm text-left font-normal">17364398438934039409 (Tax ID)</span>
          </p>
        </div>
        <div class="w-1/2 flex flex-col justify-center  items-end">
          <div class="2xl:text-3xl xl:text-2xl lg:text-xl text-base text-right font-bold">Associated with</div>

          <div class="flex flex-row justify-between items-start ">
            <img class="2xl:w-10 xl:w-9 lg:w-8 w-7 mr-1" :src="storage + '/img/insh-company-2.png'"
                 alt="company logo">
            <p class="2xl:text-xs xl:text-xxs text-xxs text-right font-normal">PromTransInvest</p>
          </div>
        </div>
      </div>

      <div class="w-full flex flex-nowrap justify-content-between mb-6">
        <div class="w-5/12 new-box-shadow rounded-lg mr-6 2xl:p-10 xl:p-8 p-6 bg-white">
          <p class="mb-5">
            <label class="2xl:text-base xl:text-sm text-sm font-medium " for="phone">Phone for assistance</label>
            <input
                class="2xl:p-2.5 xl:p-2 lg:p-1.5 p-1.5 2xl:text-base xl:text-sm text-xs  font-normal border w-full rounded-lg placeholder-gray-600 placeholder-opacity-75 focus:outline-none  focus:border-indigo-300 focus:border"
                type="text" name="phone" id="phone" placeholder="+7 (902) 750-98-00">
          </p>
          <p class="mb-5">
            <label class="2xl:text-base xl:text-sm text-sm  font-medium " for="adress">Adress</label>
            <input
                class="2xl:p-2.5 xl:p-2 lg:p-1.5 p-1.5 2xl:text-base xl:text-sm text-xs  font-normal border w-full rounded-lg placeholder-gray-300 focus:outline-none  focus:border-indigo-300 focus:border"
                type="text"
                name="adress" id="adress" placeholder="1st Avenue 27, 3874" disabled>
          </p>
          <p class="">
            <label class="2xl:text-base xl:text-sm text-sm  font-medium " for="number">Insurance Identification
              Number</label>
            <input
                class="2xl:p-2.5 xl:p-2 lg:p-1.5 p-1.5 2xl:text-base xl:text-sm text-xs  font-normal border w-full rounded-lg placeholder-gray-300 focus:outline-none  focus:border-indigo-300 focus:border"
                type="text"
                name="number" id="number" placeholder="837483358" disabled>
          </p>
        </div>
        <div class="w-7/12 new-box-shadow rounded-lg   p-6 xl:p-8 2xl:p-10 bg-white">
          <p class="2xl:text-xl xl:text-lg text-base  mb-5 font-bold w-full text-left">Statistics of the certified
            contracts</p>
          <p> block </p>
        </div>
      </div>

      <div class="w-full  mb-6">
        <div class="new-box-shadow rounded-lg bg-white  p-6 xl:p-8 2xl:p-10 w-full flex flex-nowrap flex-col">
          <p class="2xl:text-xl xl:text-lg text-base mb-5 font-bold w-full text-left">Responsible</p>
          <div class="flex justify-start items-center w-full">
            <div class="mb-5 w-5/12 mr-4 pr-3 xl:pr-5 2xl:pr-10">
              <p class="mb-5">
                <label class="2xl:text-base xl:text-sm text-sm font-medium " for="name">Name</label>
                <input
                    class="2xl:p-2.5 xl:p-2 lg:p-1.5 p-1.5 2xl:text-base xl:text-sm text-xs font-normal border w-full rounded-lg placeholder-gray-600 placeholder-opacity-75 focus:outline-none  focus:border-indigo-300 focus:border"
                    type="text" name="name" id="name" placeholder="Jax Teller">
              </p>
              <p class="mb-5">
                <label class="2xl:text-base xl:text-sm text-sm font-medium " for="position">Position</label>
                <input
                    class="2xl:p-2.5 xl:p-2 lg:p-1.5 p-1.5 2xl:text-base xl:text-sm text-xs font-normal border w-full rounded-lg placeholder-gray-600 placeholder-opacity-75 focus:outline-none  focus:border-indigo-300 focus:border"
                    type="text" name="position" id="position" placeholder="Director">
              </p>
            </div>
            <div class="mb-5 w-5/12">
              <p class="mb-5">
                <label class="2xl:text-base xl:text-sm text-sm font-medium " for="user-phone">Phone</label>
                <input
                    class="2xl:p-2.5 xl:p-2 lg:p-1.5 p-1.5 2xl:text-base xl:text-sm text-xs font-normal border w-full rounded-lg placeholder-gray-600 placeholder-opacity-75 focus:outline-none  focus:border-indigo-300 focus:border"
                    type="text" name="user-phone" id="user-phone" placeholder="+7 (902) 750-98-00">
              </p>
              <p class="mb-5">
                <label class="2xl:text-base xl:text-sm text-sm font-medium " for="email">Email</label>
                <input
                    class="2xl:p-2.5 xl:p-2 lg:p-1.5 p-1.5 2xl:text-base xl:text-sm text-xs font-normal border w-full rounded-lg placeholder-gray-600 placeholder-opacity-75 focus:outline-none  focus:border-indigo-300 focus:border"
                    type="email" name="email" id="email" placeholder="1@1.com">
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

export default {
  name: "List",
  components: {
    AppLayout,
  },
  data: function () {
    return {
      storage: window.location.origin,
    }
  }
}
</script>

<style scoped>

</style>
