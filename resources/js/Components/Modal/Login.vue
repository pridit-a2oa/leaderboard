<script setup>
import { ref } from 'vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

const showModal = ref(false);

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <button
        class="btn no-animation ml-auto hidden md:inline-flex"
        @click="
            () => {
                showModal = true;
            }
        "
    >
        <font-awesome-icon :icon="['fas', 'right-to-bracket']" size="sm" />Log
        in
    </button>

    <div class="modal" :class="{ 'modal-open': showModal }" role="dialog">
        <div
            class="modal-box w-[24rem] justify-center rounded-l-md rounded-r-md text-neutral-300"
        >
            <h3 class="text-lg font-bold">Sign in</h3>

            <button
                class="btn btn-circle btn-ghost btn-sm absolute right-2 top-2"
                @click="
                    () => {
                        showModal = false;
                    }
                "
            >
                &#x2715;
            </button>

            <form @submit.prevent="submit">
                <div class="form-control">
                    <label
                        class="input input-bordered mt-4 flex items-center gap-2"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 16 16"
                            fill="currentColor"
                            class="h-4 w-4 opacity-70"
                        >
                            <path
                                d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z"
                            />
                            <path
                                d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z"
                            />
                        </svg>

                        <TextInput
                            id="email"
                            type="email"
                            placeholder="Email"
                            v-model="form.email"
                            required
                            autocomplete="username"
                        />
                    </label>

                    <InputError class="mt-2" :message="form.errors.email" />

                    <label
                        class="input input-bordered mt-4 flex items-center gap-2"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 16 16"
                            fill="currentColor"
                            class="h-4 w-4 opacity-70"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z"
                                clip-rule="evenodd"
                            />
                        </svg>

                        <TextInput
                            id="password"
                            type="password"
                            v-model="form.password"
                            placeholder="Password"
                            required
                            autocomplete="current-password"
                        />
                    </label>

                    <InputError class="mt-2" :message="form.errors.password" />

                    <div class="mt-4 flex">
                        <label class="label cursor-pointer">
                            <Checkbox
                                name="remember"
                                class="checkbox checkbox-xs mr-2 rounded-[0.3rem]"
                                v-model:checked="form.remember"
                            />
                            <span class="label-text">Remember me</span>
                        </label>

                        <a
                            class="underlined-link ml-auto content-center text-sm"
                            href="#"
                            >Lost Password?</a
                        >
                    </div>

                    <button
                        class="btn mt-4 w-full"
                        :class="{ 'opacity-25': form.processing }"
                    >
                        Login to your account
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-sm">
                <span>Not registered?&nbsp;</span
                ><a class="underlined-link" href="#">Create account</a>
            </div>
        </div>
    </div>
</template>
