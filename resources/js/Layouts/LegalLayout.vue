<template>
    <div class="flex flex-col gap-6">
        <slot />
    </div>
</template>

<style scoped>
:deep(h1),
:deep(h2),
:deep(h3) {
    font-weight: var(--font-weight-bold);
}

:deep(h1) {
    font-size: var(--text-2xl);
}

:deep(h2) {
    font-size: var(--text-xl);
}

:deep(h3) {
    font-size: var(--text-lg);
}

:deep(h4) {
    text-decoration: underline;
}

:deep(ul) {
    display: flex;
    flex-direction: column;

    background-color: var(--color-base-200);

    padding-inline: calc(var(--spacing) * 3);
    padding-block: calc(var(--spacing) * 3);
    padding-left: calc(var(--spacing) * 4);

    border-radius: var(--radius-md);

    gap: calc(var(--spacing) * 4);

    list-style-position: inside;
    list-style-type: decimal;

    p {
        display: inline;
    }
}
</style>
