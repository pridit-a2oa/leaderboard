<script setup>
import { FormCheckbox } from '@/Components/forms/elements';
import { NormalLink } from '@/Components/links';
import { useForm, usePage } from '@inertiajs/vue3';
import { onBeforeMount } from 'vue';
import { defineCustomElementSFC } from 'vue-web-component-wrapper';

const form = useForm({
    options: {},
});

onBeforeMount(() => {
    usePage().props.preferences.map((preference) => {
        const user = usePage().props.auth.user.preferences.filter(
            (e) => e.id === preference.id,
        );

        form.options[preference['id']] = user[0]
            ? !!user[0].pivot.value
            : false;
    });
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
    <div class="rounded-md bg-base-200 p-4 [&:not(:last-child)]:mb-4">
        <label class="label !pt-0">
            <span class="label-text">Preferences</span>
        </label>

        <form @change="form.patch(route('preferences.update'))">
            <template
                v-for="preference in $page.props.preferences"
                :key="preference.id"
            >
                <FormCheckbox
                    class="no-animation"
                    v-model:checked="form.options[preference.id]"
                    :disabled="form.processing || form.recentlySuccessful"
                >
                    <span
                        class="ml-1 block"
                        v-html="preference.description"
                    ></span>
                </FormCheckbox>
            </template>
        </form>
    </div>
</template>
