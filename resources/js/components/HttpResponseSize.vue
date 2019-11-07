<script>
export default {
    props: ['response'],

    computed: {
        size () {
            const sizes = ['B', 'KB', 'MB', 'GB', 'TB']
            const bytes = this.response.headers['content-length'] || 0
            if (bytes == 0) return '0 B'
            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)))

            return `${Math.round(bytes / Math.pow(1024, i), 2)} ${sizes[i]}`
        }
    }
}
</script>

<template>
    <div class="inline-block text-xs py-2 px-1">
        <span class="text-gray-500">Size:</span>
        <span class="text-green-500">{{size}}</span>
    </div>
</template>
