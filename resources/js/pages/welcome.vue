<script>
export default {
    created() {
        this.$root.requestTitle = Compass.app.base_url;
    }
}
</script>

<template>
    <content-space>
        <div class="flex items-center text-center text-gray-600">
            Press
            <kbd class="mx-2 inline-block align-middle text-xs font-mono border pointer-events-none border-gray-200 rounded shadow-sm" style="padding: 3px 5px;">
                ctrl
            </kbd>
            +
            <kbd class="mx-2 inline-block align-middle text-xs font-mono border pointer-events-none border-gray-200 rounded shadow-sm" style="padding: 3px 5px;">
                space
            </kbd>
            to find endpoint
        </div>
    </content-space>
</template>
