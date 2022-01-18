<template>
    <app-layout>
        <div class="py-6">
            <div class="max-w-7xl">
                <div class="w-full  contracts-block ">
                    <div class="relative   p-3 xl:p-5 2xl:p-10 w-full flex flex-wrap flex-col justify-center items-center">
                        <p class="text-3xl mb-4 font-bold w-full text-center">The Insurance Contract successfully uploaded</p>
                        <p class="text-xl mb-4 font-normal w-full text-center">Do you want to upload more?</p>
                        <inertia-link :href="route('contract/upload', 1)">
                        <button
                            class="mb-2 flex items-center justify-center py-2 px-12 bg-indigo-600 bg-opacity-75 text-white text-xs rounded-md hover:shadow-lg focus:outline-none  focus:border-indigo-600 ">
                            Upload
                        </button>
                        </inertia-link>
                        <img src="/img/upload-complete.svg" alt="success">
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    export default {
        name: "SuccessUpload",
        components: {
            AppLayout,
        },
    }
</script>

<style scoped>

</style>
