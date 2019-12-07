<script>

export default {
    props: ['request'],

    data () {
        return {
            methods: [
                {name: "GET", color: "text-green-500"},
                {name: "POST", color: "text-orange-400"},
                {name: "DELETE", color: "text-red-600"},
                {name: "PUT", color: "text-blue-500"},
                {name: "PATCH", color: "text-blue-400"},
                {name: "OPTIONS", color: "text-grey-500"}
            ]
        }
    },

    computed: {
        method() {
            const selectedMethod = this.request.content.selectedMethod || this.request.info.methods[0]

            return this.methods.filter(method => method.name === selectedMethod)[0]
        }
    }
}
</script>

<template>
    <span :class="'w-full inline-block max-w-xxs text-xs font-bold uppercase ' + method.color">
        {{ method.name }}
    </span>
</template>

<style scoped>
    .max-w-xxs {
        max-width: 45px;
    }
</style>
