<script setup>
import { BaseButton } from '@/Components/base';
import { FormCheckbox, FormResponse } from '@/Components/forms/elements';
import { NormalLink } from '@/Components/links';
import { useForm, usePage } from '@inertiajs/vue3';
import { defineCustomElement, onBeforeMount } from 'vue';

const options = {};
const form = useForm({
    options: {},
});

onBeforeMount(() => {
    usePage().props.preferences.map((preference) => {
        const user = usePage().props.auth.user.preferences.filter(
            (e) => e.id === preference.id,
        );

        options[preference['id']] = user[0] ? !!user[0].pivot.value : false;
    });

    form.defaults({
        options: options,
    });

    form.reset();
});

if (!customElements.get('component-link')) {
    customElements.define(
        'component-link',
        defineCustomElement({
            shadowRoot: false,
            props: ['title'],
            components: {
                NormalLink,
            },
            template: `<NormalLink>{{ title }}</NormalLink>`,
        }),
    );
}

const submit = () => {
    form.patch(route('preferences.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <div class="mb-4 flex items-center">
        <h2 class="grow">Preferences</h2>
    </div>

    <div class="rounded-md bg-base-200 p-4 [&:not(:last-child)]:mb-4">
        <form @submit.prevent="submit">
            <template
                v-for="(preference, index) in $page.props.preferences"
                :key="preference.id"
            >
                <FormCheckbox v-model:checked="form.options[preference.id]">
                    <span v-html="preference.description"></span>
                </FormCheckbox>

                <div
                    v-if="index !== $page.props.preferences.length - 1"
                    class="divider m-0"
                ></div>
            </template>

            <div class="mt-3 flex justify-end">
                <FormResponse
                    v-if="form.wasSuccessful"
                    :message="['success', 'Saved changes']"
                />

                <span
                    v-if="form.processing"
                    class="loading mr-2 loading-spinner"
                ></span>

                <BaseButton
                    :title="(!form.isDirty && 'No changes') || ''"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing || !form.isDirty"
                >
                    Save
                </BaseButton>
            </div>
        </form>
    </div>
</template>
