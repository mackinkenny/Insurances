<template>
    <app-layout>
        <div class="w-full py-6 flex flex-nowrap justify-content-between">
            <div class="w-8/12 mr-6">
                <div class=" new-box-shadow rounded-lg bg-white p-6 xl:p-8 2xl:p-10 ">
                <p class="mb-3 font-medium text-base">Employees:</p>
                <div
                    class="relative rounded flex gap-y-2 gap-x-5 justify-between
                    items-center bg-gray-50 w-full px-6 py-4  text-xs  2xl:text-sm mb-3  font-normal rounded-xs" v-for="employee in employees">
                    <div>
                        <p class="font-normal">Name:</p>
                        <p class="font-medium">{{employee.name}}</p>
                    </div>
                    <div>
                        <p class="font-normal">Email:</p>
                        <p class="font-normal text-sm">{{employee.email}}</p>
                    </div>
                </div>
                </div>
            </div>
            <div class="w-4/12">
                <div class="new-box-shadow rounded-lg bg-white p-6 xl:p-8 2xl:p-10 ">
                <p class="mb-3 font-medium text-base">Active invites list:</p>
                <div class="text-left new-bg-purple-100 focus:bg-purple-300 p-2.5 2xl:text-sm xl:text-xs text-xs
                    font-sm border w-full rounded-lg placeholder-gray-600 placeholder-opacity-75 focus:outline-none  focus:border-indigo-300
                        focus:border mb-3" style="color: #5E5873;" v-for="invite in invites">
                    <p class="font-medium">{{invite.email}}</p>
                    <p class="mt-1 text-xs">active until: {{moment(invite.end_date).format("MMM DD, YYYY - HH:mm a")}}</p>
                </div>
                <button class="main-bg text-white rounded 2xl:text-base lg:text-sm md:text-xs sm:text-xxs px-5 text-center w-full h-10" @click="add = true">Add new invite</button>
                </div>
            </div>
        </div>
        <div class="bg-gray-900 bg-opacity-10 absolute w-full h-full top-0 left-0 flex items-center justify-center" v-if="add === true">
            <form class="rounded bg-white p-5 w-1/5" @submit.prevent="submit">
                <div class="flex justify-between items-center">
                    <p class="text-base font-medium">Add invite</p>
                    <svg class="cursor-pointer" @click="add = false" width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.186 0.849998L19.336 3.916L13.078 10.174L19.252 16.39L16.186 19.498L9.928 13.324L3.754 19.456L0.688 16.348L6.778 10.174L0.646 4L3.754 0.849998L9.928 6.982L16.186 0.849998Z" fill="black"/>
                    </svg>
                </div>
                <div class="mt-10">
                    <label class="font-normal text-xs" for="email">Email of employee</label>
                    <input class="rounded w-full mt-1" style="border: 1px solid #B9B9C3;"
                            v-model="form.email" id="email" type="email" required>
                </div>
                <jet-validation-errors class="mt-5"/>
                <div class="flex justify-center mt-5">
                    <button type="submit" class="main-bg text-white rounded 2xl:text-base lg:text-sm md:text-xs sm:text-xxs px-5 text-center w-full h-10">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'
    import moment from 'moment'
    import Swal from 'sweetalert2'

    export default {
        name: "Index",
        components: {
            AppLayout,
            JetValidationErrors,
        },
        props: {
            invites: Object,
            employees: Object,
        },
        created: function () {
            this.moment = moment;
        },
        data: function() {
            return {
                add: false,
                form: this.$inertia.form({
                    email: '',
                }),
            }
        },
        methods: {
            submit() {
                this.form.post(this.route('company/addInvite'), {
                    onSuccess: () => {
                        this.form.email = '';
                        this.add = false;
                        Swal.fire({
                            text: 'Invite was sent',
                            backdrop: false,
                            showConfirmButton: false,
                            timer: 1500,
                            position: 'top-end',
                            background: '#87DDA0'
                        });

                    }
                });
            },
        }
    }
</script>

<style scoped>

</style>
