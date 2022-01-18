<template>
    <inertia-link :href="'/'">
        <img class="inline w-12" :src="storage + '/images/logo.png'" alt="">
        <span class="text-lg ml-2" style="color: #5E5873;">POLIZZA<b>CERTA</b></span>
    </inertia-link>
</template>
<script>
export default {
    data() {
        return {
            storage: window.location.origin,
        }
    }
}
</script>
