<script>
import { HTTP_REQUEST_METHODS } from "../constants";

export default {
    props: ['request'],

    computed: {
        method() {
            const selectedMethod = this.request.content.selectedMethod || this.request.info.methods[0];
            return HTTP_REQUEST_METHODS.filter(method => method.name === selectedMethod)[0];
        }
    }
}
</script>

<template>
    <span :class="'w-full inline-block max-w-xxs text-xs uppercase ' + method.color">
        {{ method.name }}
    </span>
</template>

<style scoped>
    .max-w-xxs {
        max-width: 45px;
    }
</style>
