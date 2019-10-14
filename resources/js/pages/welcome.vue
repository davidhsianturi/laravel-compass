<script>
export default {
    props: [],

    created() {
        this.$root.requestTitle = Compass.app.base_url;
    },
}
</script>

<template>
    <div class="flex content-center flex-wrap px-6 py-4 min-h-full">
        <div class="text-center mx-auto">
            <svg class="h-64 w-64" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36">
                <circle fill="#F3F3F3" cx="18" cy="18" r="18" />
                <circle fill="#F3F3F3" cx="18" cy="18" r="14.5" />
                <circle fill="#FAFAFA" cx="18" cy="18" r="13" />
                <path fill="#F3F3F3" d="M18 8l1.531 6.304 5.54-3.375-3.375 5.54L28 18l-6.304 1.531 3.375 5.54-5.54-3.375L18 28l-1.531-6.304-5.54 3.375 3.375-5.54L8 18l6.304-1.531-3.375-5.54 5.54 3.375z" />
                <path fill="#F3F3F3" d="M17.343 20.748l8.777 5.381-5.379-8.778z" />
                <path fill="#F3F3F3" d="M18.657 15.267L9.879 9.886l5.38 8.779z" />
                <circle fill="#F3F3F3" cx="18" cy="18.008" r="3.055" />
                <circle fill="#F5F8FA" cx="18" cy="18.008" r="1.648" /></svg>

            <p class="text-gray-600 text-lg mt-5 mb-2">Buld API Documentation</p>
            <code class="text-gray-500 border p-1 rounded">php artisan compass:build</code>
        </div>
    </div>
</template>
