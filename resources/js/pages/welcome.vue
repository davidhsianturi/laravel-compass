<script>
export default {
    props: [],

    created() {
        this.$root.requestTitle = Compass.app.base_url;
    },
}
</script>

<template>
    <div class="px-6 py-4 bg-secondary">
        <p class="text-gray-700 text-xl">REST assistant for building APIs in Laravel.</p>
        <p class="text-gray-600">
            <a href="#" target="_blank" class="hover:text-gray-700">Documentation</a>
        </p>
    </div>
</template>