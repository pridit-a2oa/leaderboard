<script setup>
import { BaseCheckbox } from '@/Components/base';

const props = defineProps({
    id: {
        type: String,
    },
    checked: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div>
        <BaseCheckbox :id="id" class="modal-toggle" :checked="checked" />

        <div class="modal" role="dialog">
            <div
                class="modal-box w-[24rem] justify-center rounded-l-md rounded-r-md text-neutral-300"
            >
                <label
                    v-if="id"
                    :for="id"
                    class="btn btn-circle btn-ghost btn-sm absolute right-2 top-2"
                    @click="$emit('reset')"
                >
                    &#x2715;
                </label>

                <div class="flex flex-col text-sm">
                    <slot />
                </div>
            </div>

            <label
                v-if="id"
                :for="id"
                class="modal-backdrop"
                @click="$emit('reset')"
            ></label>
        </div>
    </div>
</template>
