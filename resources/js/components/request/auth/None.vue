<script>
export default {
    props: {
        authKey: {
            type: String,
            required: true
        }
    }
}
</script>

<template>
    <div class="w-full px-3 py-2 text-center">
        <span class="text-xs text-gray-500">
            No authorization was set for this request
        </span>
    </div>
</template>
