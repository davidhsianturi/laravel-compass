<script>
import CodeEditor from './CodeEditor';
import HttpStatus from './HttpStatus';
import HttpResponseSize from './HttpResponseSize';
import HttpResponseTime from './HttpResponseTime';

export default {
    components: {
        CodeEditor,
        HttpStatus,
        HttpResponseSize,
        HttpResponseTime
    },

    props: {
        response: {
            type: Object,
            default () {
                return {
                    data: null,
                    headers: [],
                    status: null,
                    statusText: ''
                };
            }
        },
        okToSave: {
            type: Boolean,
            default: true
        }
    },

    computed: {
        code() {
            let data = this.response.data

            return typeof data === 'string'
                ? data
                : JSON.stringify(data, null, '\t')
        }
    },

    data() {
        return {
            currentTab: 'body',
            currentBodyOption: 'pretty'
        }
    },

    methods: {
        sendResponseData() {
            this.$emit('response-data-ready');
        }
    },
}
</script>

<template>
    <div>
        <!-- tabs -->
        <div class="flex justify-content-between border-b border-gray-200">
            <div>
                <ul class="flex inline-block">
                    <li class="-mb-px mr-1">
                        <a :class="{'text-gray-800 border-primary border-b-2': currentTab=='body'}"
                            class="inline-block text-sm py-2 px-4 text-gray-600 hover:text-gray-800"
                            href="#"
                            @click.prevent="currentTab='body'">Body</a>
                    </li>
                    <li class="-mb-px mr-1">
                        <a :class="{'text-gray-800 border-primary border-b-2': currentTab=='headers'}"
                            class="inline-block text-sm py-2 px-4 text-gray-600 hover:text-gray-800"
                            href="#"
                            @click.prevent="currentTab='headers'">Headers</a>
                    </li>
                </ul>
            </div>

            <div class="ml-auto px-3">
                <http-status :response="response" />
                <template v-if="okToSave">
                    <http-response-time :response="response" />
                    <http-response-size :response="response" />
                    <div class="inline-block text-gray-300">|</div>
                    <button @click="sendResponseData" class="inline-block py-2 px-1 text-sm text-primary focus:outline-none">
                        Save response as example
                    </button>
                </template>
            </div>
        </div>

        <!-- content -->
        <div v-if="currentTab=='body'" class="bg-white">
            <div v-if="okToSave" class="w-full px-3 py-2 inline-flex">
                <a :class="{'text-gray-800': currentBodyOption=='pretty'}"
                    class="text-xs py-2 px-4 bg-gray-300 text-gray-600 rounded-l hover:text-gray-800"
                    href="#"
                    @click.prevent="currentBodyOption='pretty'">Pretty</a>

                <a :class="{'text-gray-800': currentBodyOption=='preview'}"
                    class="text-xs py-2 px-4 bg-gray-300 text-gray-600 rounded-r hover:text-gray-800"
                    href="#"
                    @click.prevent="currentBodyOption='preview'">Preview</a>
            </div>

            <code-editor v-if="currentBodyOption=='pretty'" :code="code" mode="application/json" readOnly />
            <iframe v-if="currentBodyOption=='preview'" :src="response.config.url" frameborder="0" class="w-full min-h-screen" />
        </div>
        <div v-if="currentTab=='headers'" class="bg-white">
            <table class="w-full text-left table-collapse">
                <thead>
                    <tr>
                        <th class="border-b border-r border-gray-200 text-xs font-semibold text-gray-700 w-auto"></th>
                        <th class="p-2 border-b border-r border-gray-200 text-xs font-semibold text-gray-700 w-1/2">Key</th>
                        <th class="p-2 border-b border-gray-200 text-xs font-semibold text-gray-700 w-1/2">Value</th>
                    </tr>
                </thead>
                <tbody class="align-baseline">
                    <tr v-for="(value, key) in response.headers" :key="key">
                        <td class="px-4 border-b border-r border-gray-200 text-xs text-gray-800 text-right"></td>
                        <td class="p-2 border-b border-r border-gray-200 text-xs text-gray-800">{{key}}</td>
                        <td class="p-2 border-b border-gray-200 text-xs text-gray-800">{{value}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style lang="scss" scoped>
::v-deep .CodeMirror {
    height: 100vh;
}
</style>
