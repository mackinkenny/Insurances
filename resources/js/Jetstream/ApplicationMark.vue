<template>
    <img class="inline w-12" :src="storage + '/images/logo.png'" alt="">
    <span class="text-2xl ml-2" style="color: rgba(0, 0, 0, 1);">POLIZZA<b>CERTA</b></span>
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
