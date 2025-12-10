<template>
    <dialog class="modal" v-bind="$attrs">
        <div
            class="modal-box w-[24rem] justify-center rounded-l-md rounded-r-md text-neutral-300"
        >
            <form method="dialog">
                <button
                    class="btn absolute top-2 right-2 btn-circle btn-ghost btn-sm"
                >
                    &#x2715;
                </button>
            </form>

            <div class="flex flex-col text-sm">
                <slot />
            </div>
        </div>

        <form method="dialog" class="modal-backdrop">
            <button class="!cursor-default">Close</button>
        </form>
    </dialog>
</template>
