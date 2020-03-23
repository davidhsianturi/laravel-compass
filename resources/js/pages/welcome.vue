<script>
export default {
    created() {
        this.$root.requestTitle = Compass.app.base_url;
    }
}
</script>

<template>
    <content-space>
        <div class="flex items-center text-center text-gray-500">
            Press
            <kbd class="mx-2 text-xs shadow-sm">
                ctrl
            </kbd>
            +
            <kbd class="mx-2 text-xs shadow-sm">
                space
            </kbd>
            to find an endpoint
        </div>
    </content-space>
</template>
