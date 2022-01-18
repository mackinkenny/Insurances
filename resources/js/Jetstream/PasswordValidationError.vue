<template>
    <div v-if="hasErrors">
        <p class="text-xxs text-gray-600  mt-1">
            Password must be 8 characters with at least 1 Upper Case, 1 lower case, and 1 numeric character
        </p>
    </div>
</template>

<script>
    export default {
        computed: {
            errors() {
                return this.$page.props.errors
            },

            hasErrors() {
                if ((this.errors).hasOwnProperty('password')) {
                    return true;
                }
                else {
                    return false;
                }
            },
        }
    }
</script>
