<script>
export default {
    props: ['response'],
    data () {
        return {
            colors: [
                { group: "1", class: "text-blue-500" },
                { group: "2", class: "text-green-500" },
                { group: "3", class: "text-yellow-500" },
                { group: "4", class: "text-orange-400" },
                { group: "5", class: "text-red-600" }
            ]
        }
    },
    computed: {
        color: function () {
            let statusGroup = String(this.response.status)[0] || ''
            let color = this.colors.find(color => statusGroup === color.group)
            return color ? color.class : "text-red-600"
        }
    }
}
</script>

<template>
    <div class="inline-block text-xs py-2 px-1">
        <span class="text-gray-500">Status:</span>
        <span :class="color">{{response.status}} {{response.statusText}}</span>
    </div>
</template>
