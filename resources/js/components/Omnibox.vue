<script>
export default {
    props: {
        methods: {
            type: Array,
            required: true
        },
        url: {
            type: String,
            required: true
        },
        selectedMethod: {
            type: String,
            required: true
        },
        okToSubmit: {
            type: Boolean,
            default: true
        },
        params: {
            type: Array,
            default: () => []
        }
    },

    computed: {
        queryParams: {
            get() { return this.params },
            set(val) { this.$emit('update:params', val) }
        }
    },

    methods: {
        endpointReady() {
            this.$emit('endpoint-ready');
        },
        onInputUri(val) {
            this.$emit('update:url', val);
            if (this.params.length > 0) {
                this.queryParams = this.decodeParams(val);
            }
        }
    }
}
</script>

<template>
    <div class="flex justify-between">
        <div class="relative">
            <select
                class="appearance-none block bg-white border border-gray-400 border-r-0 text-gray-700 py-2 px-4 pr-8 rounded rounded-r-none leading-tight focus:outline-none focus:border-gray-500"
                @change="$emit('update:selected-method', $event.target.value)">

                <option
                    v-for="(method, index) in methods"
                    :key="index"
                    :selected="selectedMethod == method ? true : false">
                    {{method}}
                </option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>

        <input
            class="appearance-none block w-full bg-white text-gray-700 border border-l-0 border-gray-400 py-2 px-2 leading-tight rounded rounded-l-none focus:outline-none focus:border-gray-500"
            type="text"
            :value="url"
            @input="onInputUri($event.target.value)">

        <button
            class="block sm:w-auto sm:inline-block bg-orange-400 hover:bg-orange-500 focus:outline-none font-bold text-white ml-2 py-2 px-4 rounded text-sm"
            type="button"
            v-if="okToSubmit"
            @click="endpointReady">SEND</button>
    </div>
</template>
