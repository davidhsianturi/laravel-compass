<script>
export default {
    props: {
        methods: {
            type: Array,
            required: true,
        },
        url: {
            type: String,
            required: true,
        },
        httpMethod: {
            type: String,
            required: true,
        },
        okToSubmit: {
            type: Boolean,
            default: true,
        }
    },

    data() {
        return {
            selectedMethod: this.httpMethod,
        }
    },

    methods: {
        onChange() {
            this.$emit('update:http-method', this.selected);
        },

        requestReady() {
            this.$emit('request-ready');
        }
    }
}
</script>

<template>
    <div>
        <div class="flex justify-between">
            <div class="relative">
                <select v-model="selectedMethod" class="block font-semibold appearance-none bg-gray-200 border border-r-0 text-gray-600 py-3 px-4 pr-8 rounded rounded-r-none leading-tight focus:outline-none" @change="onChange">
                    <option v-for="(method, index) in methods" :key="index">{{method}}</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>

            <input class="w-full px-3 rounded rounded-l-none border bg-gray-200 text-gray-600 inline-block appearance-none focus:outline-none"
                    type="text"
                    :value="url"
                    @input="$emit('update:url', $event.target.value)">

            <button v-if="okToSubmit"
                    class="block sm:w-auto sm:inline-block bg-orange-400 hover:bg-orange-500 focus:outline-none font-bold text-white ml-2 py-2 px-4 rounded text-sm"
                    type="button"
                    @click="requestReady">SEND</button>
        </div>
    </div>
</template>
