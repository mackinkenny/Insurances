<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <jet-validation-errors />

        <div v-if="status" class="my-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <p class="mt-9 2xl:text-lg xl:text-base  text-color" style="color: #5E5873;">
                Welcome to PolizzaCerta👋🏻
            </p>
            <p class="mt-2 2xl:mb-8 xl:mb-4 2xl:text-base xl:text-sm text-color font-normal" style="line-height: 1rem;">
                Please sign-in to your account to make the insurance world a better place.
            </p>
            <div>
                <jet-label class="2xl:text-sm xl:text-xs text-color" for="login" value="ID" />
                <jet-input id="login" type="text" class="mt-1 block w-full text-color 2xl:text-sm xl:text-xs auth-placeholder" style="border-radius: 5px;" v-model="form.login" placeholder="johndoe@gmail.com" required autofocus />
            </div>

            <div class="mt-4">
                <div class="flex justify-between">
                <jet-label class="2xl:text-sm xl:text-xs text-color" for="password" value="Password" />
                <inertia-link v-if="canResetPassword" :href="route('password.request')" class="text-xs" style="color: #7367F0;">
                    Forgot password?
                </inertia-link>
                </div>
                <jet-input id="password" type="password" class="mt-1 block w-full text-color 2xl:text-sm xl:text-xs auth-placeholder" v-model="form.password" required placeholder="⚉ ⚉ ⚉ ⚉ ⚉ ⚉ ⚉ ⚉" autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <jet-checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 2xl:text-sm xl:text-xs text-color">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-center mt-4">
                <jet-button class="w-full text-center 2xl:text-base xl:text-sm text-white tracking-wide 2xl:py-1 xl:py-2 main-bg" style="border-radius:5px;" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Login
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from '@/Jetstream/Checkbox'
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors
        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    login: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    }
</script>
