<script>

export default {
    props: ['request'],

    data () {
        return {
            colors: [
                {method: "GET", class: "text-green-500"},
                {method: "POST", class: "text-orange-400"},
                {method: "DELETE", class: "text-red-600"},
                {method: "PUT", class: "text-blue-500"},
                {method: "PATCH", class: "text-blue-400"},
                {method: "OPTIONS", class: "text-grey-500"}
            ]
        }
    },

    computed: {
        color: function () {
            let methods = this.request.info.methods

            let colors = this.colors.filter(color => {
                return methods.indexOf(color.method) !== -1
            })

            return colors.length === 1 ? colors[0].class : "text-grey-500"
        }
    }
}
</script>

<template>
    <span :class="'method-chip text-xs text-center font-bold uppercase ' + color">
        {{ request.info.methods.length > 1 ? '*' : request.info.methods[0] }}
    </span>
</template>

<style scoped>
    .method-chip {
        max-width: 45px;
        width: 100%;
        display: inline-block;
    }
</style>
