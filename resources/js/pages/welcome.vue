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
        <p class="text-gray-700 text-xl">Laravel REST client</p>
        <p class="text-gray-700 text-xl">for testing and build API documentation.</p>
    </div>
</template>
