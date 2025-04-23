<script setup>
import { BaseModal } from '@/Components/base';
import { UserSettings } from '@/Components/features/user';
import { FormInput, FormSelect } from '@/Components/forms/elements';
import { Alert } from '@/Components/ui';
import {
    faAddressCard,
    faCircle,
    faEllipsis,
    faPencil,
    faPlus,
    faTrash,
} from '@fortawesome/free-solid-svg-icons';
import {
    FontAwesomeIcon,
    FontAwesomeLayers,
    FontAwesomeLayersText,
} from '@fortawesome/vue-fontawesome';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const type = ref();
const open = ref(null);

function toggle(id) {
    open.value = open.value === id ? null : id;
}

defineProps({
    mutes: {
        type: Object,
    },

    reasons: {
        type: Object,
    },
});

const form = useForm({
    reason_id: '',
    guid: '',
});
</script>

<template>
    <Head title="Settings &#x2022; Mutes" />

    <Teleport to="body">
        <BaseModal id="mute-modal" @reset="modal = false">
            <h2 class="text-lg font-bold">{{ type }} Mute</h2>

            <form @submit.prevent="submit">
                <div class="form-control">
                    <FormInput
                        id="guid"
                        type="guid"
                        class="!border-transparent"
                        classes="mt-4"
                        placeholder="GUID"
                        :error="form.errors.guid"
                        v-model="form.guid"
                        :readonly="type === 'Edit'"
                        required
                    >
                        <FontAwesomeIcon
                            class="text-neutral-500"
                            :icon="faAddressCard"
                            size="sm"
                            fixed-width
                        />
                    </FormInput>

                    <div class="mt-4 flex items-center">
                        <FormSelect
                            class="!border-transparent"
                            classes="grow"
                            :error="form.errors.reason_id"
                            v-model="form.reason_id"
                            required
                        >
                            <option disabled selected value="">
                                Select a reason
                            </option>
                            <option
                                v-for="reason in reasons"
                                :key="reason.id"
                                :value="reason.id"
                            >
                                {{ reason.formatted_name }}
                            </option>
                        </FormSelect>

                        <span
                            v-if="form.reason_id"
                            class="ml-3 cursor-pointer rounded-full border border-2 px-1.5"
                            :title="reasons[form.reason_id - 1].description"
                            >?</span
                        >
                    </div>

                    <button
                        class="btn no-animation mt-4 w-full"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        {{ type === 'Edit' ? 'Update Mute' : 'Create Mute' }}
                    </button>
                </div>
            </form>
        </BaseModal>
    </Teleport>

    <UserSettings title="Mutes">
        <template #header>
            <label
                for="mute-modal"
                role="button"
                tabindex="0"
                @click="
                    type = 'New';
                    form.reset();
                "
            >
                <FontAwesomeLayers class="indicator mr-0.5" fixed-width>
                    <FontAwesomeIcon :icon="faAddressCard" transform="left-4" />
                    <FontAwesomeIcon
                        :icon="faPlus"
                        class="indicator-item indicator-end indicator-bottom bg-base-100 rounded-full p-0.5"
                        size="xs"
                        transform="shrink-2"
                    />
                </FontAwesomeLayers>
            </label>
        </template>

        <Alert v-if="mutes.data.length === 0" message="No mutes found" />

        <table v-else class="bg-base-200 mt-2 table table-fixed rounded-md">
            <tbody>
                <tr
                    v-for="(mute, key) in mutes.data"
                    :key="mute.id"
                    class="group border-base-100 [&:not(:first-child)]:!border-t-4 [&:not(:last-child)]:!border-b-4"
                    :class="{
                        'opacity-25': key !== open && open !== null,
                    }"
                >
                    <td class="w-10">
                        <FontAwesomeLayers class="indicator" fixed-width>
                            <FontAwesomeIcon :icon="faAddressCard" size="lg" />
                            <FontAwesomeLayers
                                v-if="mute.characters_count"
                                class="indicator-item indicator-end indicator-bottom cursor-pointer rounded-full"
                                fixed-width
                                @click="toggle(key)"
                            >
                                <FontAwesomeIcon
                                    class="text-base-200"
                                    :icon="faCircle"
                                    transform="right-3"
                                    size="lg"
                                />
                                <FontAwesomeLayersText
                                    class="text-warning right-1 !text-left font-bold select-none"
                                    transform="shrink-4 up-1"
                                    title="Show/hide character(s) affected"
                                    :value="mute.characters_count"
                                />
                            </FontAwesomeLayers>
                        </FontAwesomeLayers>
                    </td>

                    <td
                        class="grid grid-flow-col auto-rows-fr grid-cols-2 grid-rows-2 gap-x-8 text-neutral-300"
                    >
                        <span
                            :class="{
                                'row-span-2 self-center': key !== open,
                            }"
                            >{{ mute.guid }}</span
                        >

                        <span
                            v-if="key === open"
                            class="max-w-auto text-warning z-[1] col-span-1 max-h-0 text-xs"
                        >
                            {{
                                mute.relations.characters
                                    .map((e) => e.name)
                                    .join(', ')
                                    .toString()
                            }}
                        </span>

                        <span>{{
                            reasons[mute.reason_id - 1].formatted_name
                        }}</span>

                        <span
                            class="text-xs text-neutral-500 select-none"
                            title="Last active"
                        >
                            <template
                                v-if="mute.relations.characters.length > 0"
                            >
                                {{
                                    mute.relations.characters.filter(
                                        (e) =>
                                            Math.max(
                                                ...mute.relations.characters.map(
                                                    (e) =>
                                                        new Date(
                                                            e.last_seen_at,
                                                        ),
                                                ),
                                            ) ===
                                            new Date(e.last_seen_at).getTime(),
                                    )[0].formatted_last_seen_at
                                }}
                            </template>

                            <template v-else>n/a</template>
                        </span>
                    </td>

                    <td class="w-0 pr-9">
                        <div class="dropdown dropdown-bottom">
                            <label class="cursor-pointer" tabindex="0">
                                <FontAwesomeIcon
                                    :icon="faEllipsis"
                                    size="lg"
                                    fixed-width
                                />
                            </label>

                            <ul
                                class="menu dropdown-content bg-base-300 z-10 mt-1 w-32 rounded-md p-2 shadow"
                                tabindex="0"
                            >
                                <li class="mb-0.5">
                                    <label
                                        class="pl-2"
                                        for="mute-modal"
                                        role="button"
                                        tabindex="0"
                                        @click="
                                            type = 'Edit';
                                            Object.assign(
                                                form,
                                                Object.fromEntries(
                                                    Object.entries(mute).filter(
                                                        ([key]) =>
                                                            [
                                                                'reason_id',
                                                                'guid',
                                                            ].includes(key),
                                                    ),
                                                ),
                                            );
                                        "
                                    >
                                        <FontAwesomeIcon
                                            :icon="faPencil"
                                            fixed-width
                                        />
                                        Edit
                                    </label>
                                </li>

                                <li>
                                    <label
                                        class="text-error focus:text-error active:!text-error pl-2"
                                        method="post"
                                        as="button"
                                    >
                                        <FontAwesomeIcon
                                            :icon="faTrash"
                                            fixed-width
                                        />
                                        Delete
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </UserSettings>
</template>
