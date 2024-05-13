<script setup>
import { ref } from 'vue';
import SaveButton from '@/Components/SaveButton.vue';
import SuccessMessage from '@/Components/SuccessMessage.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

const nameInput = ref(null);

let form = useForm({
    name: '',
});

const submit = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
        onError: () => nameInput.value.focus(),
        onSuccess: () => form.reset('name'),
    });
};
</script>

<template>
    <div class="rounded-md bg-base-200 p-4 [&:not(:last-child)]:mb-4">
        <form @submit.prevent="submit">
            <label class="form-control">
                <div class="label !pt-0">
                    <span class="label-text">Display Name</span>
                </div>

                <TextInput
                    id="name"
                    ref="nameInput"
                    type="text"
                    class="input input-bordered"
                    required
                    v-model="form.name"
                    :error="form.errors.name"
                    :placeholder="$page.props.auth.user.name"
                />

                <div class="mt-3 flex justify-end">
                    <SuccessMessage
                        v-if="form.wasSuccessful"
                        message="Display name was changed"
                    />

                    <SaveButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Save
                    </SaveButton>
                </div>
            </label>
        </form>
    </div>
</template>
