<script>
export default {
    created() {
        this.$root.requestTitle = Compass.app.base_url;
    },
}
</script>

<template>
    <content-space description="404 — Not found" />
</template>
