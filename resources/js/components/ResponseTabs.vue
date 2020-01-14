<script>
import HttpStatus from './HttpStatus';
import HttpResponseSize from './HttpResponseSize';
import HttpResponseTime from './HttpResponseTime';

export default {
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
            },
        },
        okToSave: {
            type: Boolean,
            default: true,
        }
    },

    components: {
        HttpStatus,
        HttpResponseSize,
        HttpResponseTime
    },

    data() {
        return {
            currentTab: 'body',
        }
    },

    methods: {
        sendResponseData() {
            this.$emit('response-data-ready');
        }
    }
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
        <div v-if="currentTab=='body'" class="p-4 text-orange-800 text-sm bg-white">
            <vue-json-pretty :data="response.data" />
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
