<template>
    <div v-if="hasErrors">
        <div class="font-medium text-xs text-red-600">Whoops! Something went wrong.</div>

        <ul class="mt-1 list-disc list-inside text-xs text-red-600">
            <li v-for="(error, key) in errors" :key="key">
                <span v-if="key !== 'password'">{{ error }}</span>
                <span v-else>Your password must be 8 characters with at least 1 Upper Case, 1 lower case, and 1 numeric character</span>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        computed: {
            errors() {
                return this.$page.props.errors
            },

            hasErrors() {
                return Object.keys(this.errors).length > 0;
            },
        }
    }
</script>
