<template>
    <div class="font-sans text-gray-900 antialiased">
        <div class="pt-4" style="background-image: url('/images/bg1.jpg'); background-size: cover; background-position: center;">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                <div>
                    <inertia-link :href="'/'">
                        <img class="inline w-12" :src="storage + '/images/logo.png'" alt="">
                        <span class="text-lg ml-2 text-white">POLIZZA<b>CERTA</b></span>
                    </inertia-link>
                </div>

                <div v-html="policy" class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose" style="white-space: pre-wrap;">

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'

export default {
    props: ['policy'],

    components: {
        JetAuthenticationCardLogo,
    },

    data: function () {
        return {
            storage: window.location.origin,
        }
    }
}
</script>
