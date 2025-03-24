<script setup>
import { FormCheckbox } from '@/Components/forms/elements';
import { NormalLink } from '@/Components/links';
import { useForm, usePage } from '@inertiajs/vue3';
import { onBeforeMount, ref } from 'vue';
import { defineCustomElementSFC } from 'vue-web-component-wrapper';
import { BaseButton } from '@/Components/base';
import { FormResponse } from '@/Components/forms/elements';

const options = {};

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

const form = useForm({
    options: {},
});

if (!customElements.get('component-link')) {
    customElements.define(
        'component-link',
        defineCustomElementSFC(
            {
                props: ['title'],
                components: {
                    NormalLink,
                },
                template: `<NormalLink>{{ title }}</NormalLink>`,
            },
            { shadowRoot: false },
        ),
    );
}
</script>

<template>
    <div class="mb-4 flex items-center">
        <h2 class="grow">Preferences</h2>
    </div>

    <div class="rounded-md bg-base-200 p-4 [&:not(:last-child)]:mb-4">
        <form @submit.prevent="form.patch(route('preferences.update'))">
            <template
                v-for="(preference, index) in $page.props.preferences"
                :key="preference.id"
            >
                <FormCheckbox
                    class="no-animation"
                    v-model:checked="form.options[preference.id]"
                >
                    <span
                        class="ml-2 block"
                        v-html="preference.description"
                    ></span>
                </FormCheckbox>

                <div
                    v-if="index !== $page.props.preferences.length - 1"
                    class="divider m-0"
                ></div>
            </template>

            <div class="mt-3 flex justify-end">
                <FormResponse
                    v-if="form.wasSuccessful"
                    :message="['success', 'Your preferences were saved']"
                />

                <span
                    v-if="form.processing"
                    class="loading loading-spinner mr-2"
                ></span>

                <BaseButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing || !form.isDirty"
                >
                    Save
                </BaseButton>
            </div>
        </form>
    </div>
</template>
