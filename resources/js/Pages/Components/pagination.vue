<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, p) in links" :key="p">
                <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-xs leading-4 text-gray-400"
                     v-html="link.label" />
                <inertia-link v-if="parseInt(link.label)"
                              class="mr-1 mb-1 px-3 py-2 text-xs h-full leading-4 border-transparent border hover:border-gray-300 hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                              :class="{ 'bg-ins-2': link.active }" style="font-size: .85rem;" :href="link.url" v-html="link.label" />
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            links: Array
        },
    }

</script>

<style scoped>
    .paginator {
        font-size: .85rem;
        margin: 10px 0;
    }
    .paginator .page,
    .paginator .previous,
    .paginator .next {
        padding: 5px 10px;
        cursor: pointer;
        margin: 0 5px;
    }
    .active-page {
        background: #EDEBFF;
    }
    .previous.disabled,
    .next.disabled {
        color: #eee;
    }
</style>
