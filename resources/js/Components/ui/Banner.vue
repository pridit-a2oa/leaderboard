<template>
    <div class="bg-base-200">
        <div class="navbar justify-center bg-base-200 text-neutral-300">
            <h1 class="text-xl">
                <Link
                    class="inline-flex items-center py-4"
                    :href="route('home')"
                >
                    <picture
                        class="mr-4 h-10 w-10 rounded-full bg-base-100 select-none"
                    >
                        <source type="image/webp" srcset="/images/logo.webp" />
                        <img src="/images/logo.png" alt="Logo" loading="lazy" />
                    </picture>

                    {{ $page.props.app.name }}
                </Link>
            </h1>
        </div>
    </div>
</template>
