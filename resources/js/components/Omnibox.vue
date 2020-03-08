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
        <div class="w-full inline-flex items-center font-mono border py-1 border-gray-400 rounded focus-within:border-gray-500">
            <div class="relative">
                <select
                    class="appearance-none bg-white text-sm font-semibold text-gray-700 pl-5 pr-2 rounded leading-tight outline-none"
                    @change="$emit('update:selected-method', $event.target.value)">

                    <option
                        v-for="(method, index) in methods"
                        :key="index"
                        :selected="selectedMethod == method ? true : false">
                        {{method}}
                    </option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-2 text-gray-500">
                    <svg class="stroke-current" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"  style="width: 10px;height: 10px;">
                        <path d="M11.591 9.992a1 1 0 1 1 1.416 1.415l-4.3 4.3a1 1 0 0 1-1.414 0l-4.3-4.3A1 1 0 0 1 4.41 9.992L8 13.583zm0-3.984L8 2.417 4.409 6.008a1 1 0 1 1-1.416-1.415l4.3-4.3a1 1 0 0 1 1.414 0l4.3 4.3a1 1 0 1 1-1.416 1.415z" fill-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
            <input
                class="appearance-none text-sm w-full bg-white text-gray-800 leading-tight outline-none rounded"
                type="text"
                :value="url"
                @input="onInputUri($event.target.value)">
        </div>

        <button
            class="block sm:w-auto sm:inline-block bg-orange-400 hover:bg-orange-500 focus:outline-none font-bold text-white ml-2 py-2 px-4 rounded text-sm"
            type="button"
            v-if="okToSubmit"
            @click="endpointReady">SEND</button>
    </div>
</template>
