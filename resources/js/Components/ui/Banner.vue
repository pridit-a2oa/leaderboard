<template>
    <div class="bg-base-200">
        <div class="navbar bg-base-200 justify-center text-neutral-300">
            <h1 class="text-xl">
                <Link
                    class="inline-flex items-center py-4"
                    :href="route('home')"
                >
                    <picture
                        class="bg-base-100 mr-4 h-10 w-10 rounded-full select-none"
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
