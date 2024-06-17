<script setup>
const props = defineProps({
    class: {
        type: String,
    },
});
</script>

<template>
    <div class="modal" :class="class" role="dialog">
        <div
            class="modal-box w-[24rem] justify-center rounded-l-md rounded-r-md text-neutral-300"
        >
            <label
                for="modal"
                class="btn btn-circle btn-ghost btn-sm absolute right-2 top-2"
                @click="$emit('reset')"
            >
                &#x2715;
            </label>

            <slot />
        </div>

        <label for="modal" class="modal-backdrop" @click="$emit('reset')"
            >Close</label
        >
    </div>
</template>
