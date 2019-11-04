<script>

export default {
    props: ['request'],

    data () {
        return {
            colors: [
                {method: "GET", class: "text-green-500"},
                {method: "POST", class: "text-orange-400"},
                {method: "DELETE", class: "text-red-600"},
                {method: "PUT", class: "text-blue-500"}
            ]
        }
    },

    computed: {
        color: function () {
            let methods = this.request.info.methods

            let color = this.colors.find(color => {
                return methods.indexOf(color.method) !== -1
            })

            return color ? color.class : "text-grey-500"
        }
    }
}
</script>

<template>
    <span :class="'method-chip text-xs font-bold uppercase ' + color">
        {{request.info.methods.join("|")}}
    </span>
</template>

<style scoped>
    .method-chip {
        max-width: 45px;
        width: 100%;
        display: inline-block;
    }
</style>
