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
            <button
                class="btn btn-circle btn-ghost btn-sm absolute right-2 top-2"
                @click="$emit('close')"
            >
                &#x2715;
            </button>

            <slot />
        </div>
    </div>
</template>
