<script>
import Dropdown from './Dropdown';
import DataTable from './DataTable';
import CodeEditor from './CodeEditor';
import Authenticator from './Authenticator';
import BodyOptions from './request/BodyOptions';
import { REQUEST_BODY_KEYS } from '../constants';

export default {
    components: {
        Dropdown,
        DataTable,
        CodeEditor,
        BodyOptions,
        Authenticator
    },

    props: {
        request: {
            type: Object,
            required: true
        },
        examples: {
            type: Array,
            required: false
        },
        okToSend: {
            type: Boolean,
            default: true
        },
        authKey: {
            type: String,
            default: ''
        }
    },

    data() {
        return {
            currentTab: 'headers',
            authType: this.request.content.authType,
            headers: [ ...this.request.content.headers ],
            headerContentType: null,
            headerContentTypeIndex: -1,
            body: {
                [REQUEST_BODY_KEYS.FORM_DATA]: [],
                [REQUEST_BODY_KEYS.FORM_URL_ENCODED]: [],
                [REQUEST_BODY_KEYS.RAW]: ''
            },
            bodyOption: { value: 'none', rawOption: 'text' },
            about: {
                title: this.request.title,
                description: this.request.description
            }
        }
    },

    computed: {
        requestData() {
            return {
                ...this.request,
                title: this.about.title,
                description: this.about.description,
                content: {
                    headers: this.headers,
                    authType: this.authType,
                    url: this.request.content.url,
                    body: this.body[this.bodyOption.value],
                    selectedMethod: this.request.content.selectedMethod
                }
            }
        },
        requestBodyKeys() {
            return REQUEST_BODY_KEYS
        },
        ignoreAuth() {
            return Compass.app.env !== 'local';
        }
    },

    watch: {
        headers: {
            deep: true,
            handler() {
                this.$emit('update:request', this.requestData);
            }
        },
        body: {
            deep: true,
            handler() {
                this.$emit('update:request', this.requestData);
            }
        },
        bodyOption: {
            deep: true,
            handler(val) {
                if(val.value === 'none' && this.headerContentTypeIndex !== -1) {
                    this.headers.splice(this.headerContentTypeIndex, 1)
                    this.headerContentTypeIndex = -1
                    this.headerContentType = null
                } else if (val.value !== 'raw' && !this.body[val.value].length) {
                    this.body[val.value] = this.newFormRequests()
                }
            }
        },
        about: {
            deep: true,
            handler() {
                this.$emit('update:request', this.requestData);
            }
        },
        authType: {
            deep: true,
            handler() {
                this.$emit('update:request', this.requestData);
            }
        }
    },

    mounted() {
        this.headerContentTypeIndex = this.request.content.headers
            .findIndex(header => header.key === 'Content-Type')
        if (this.headerContentTypeIndex !== -1) {
            this.headerContentType = this.request.content.headers[this.headerContentTypeIndex].value
            this.bodyOption = this.normalizeContentType(this.headerContentType)

            this.body[this.bodyOption.value] = this.isBodyOption(REQUEST_BODY_KEYS.RAW) ?
                this.request.content.body : [ ...this.request.content.body ]
        }
    },

    methods: {
        sendRequestData() {
            this.$emit('request-data-ready');
        },
        onBodyOptionChange(headerContentType) {
            if (!headerContentType) return;
            this.headerContentType = headerContentType
            if (this.headerContentTypeIndex !== -1) {
                this.headers[this.headerContentTypeIndex].value = headerContentType
            } else {
                this.headers.splice(0, 0, {
                    included: true,
                    key: 'Content-Type',
                    value: headerContentType,
                    description: null,
                    new: false,
                    type: 'text',
                })
                this.headerContentTypeIndex = 0
            }
        },
        isBodyOption(optionKey) {
            return this.bodyOption.value === optionKey
        }
    }
}
</script>

<template>
    <div>
        <!-- tabs -->
        <div class="flex justify-content-between border-b border-gray-200">
            <ul class="flex inline-block">
                <li class="-mb-px mr-1">
                    <a :class="{'text-gray-800 border-primary border-b-2': currentTab=='headers'}"
                        class="inline-block text-sm py-2 px-4 text-gray-600 hover:text-gray-800"
                        href="#"
                        @click.prevent="currentTab='headers'">Headers</a>
                </li>
                <li class="-mb-px mr-1">
                    <a :class="{'text-gray-800 border-primary border-b-2': currentTab=='body'}"
                        class="inline-block text-sm py-2 px-4 text-gray-600 hover:text-gray-800"
                        href="#"
                        @click.prevent="currentTab='body'">Body</a>
                </li>
                <li class="-mb-px mr-1" v-if="okToSend && !ignoreAuth">
                    <a :class="{'text-gray-800 border-primary border-b-2': currentTab=='auth'}"
                        class="inline-block text-sm py-2 px-4 text-gray-600 hover:text-gray-800"
                        href="#"
                        @click.prevent="currentTab='auth'">Auth</a>
                </li>
                <li class="-mb-px mr-1">
                    <a :class="{'text-gray-800 border-primary border-b-2': currentTab=='route'}"
                        class="inline-block text-sm py-2 px-4 text-gray-600 hover:text-gray-800"
                        href="#"
                        @click.prevent="currentTab='route'">Route</a>
                </li>
                <li class="-mb-px mr-1" v-if="okToSend">
                    <a :class="{'text-gray-800 border-primary border-b-2': currentTab=='docs'}"
                        class="inline-block text-sm py-2 px-4 text-gray-600 hover:text-gray-800"
                        href="#"
                        @click.prevent="currentTab='docs'">Docs</a>
                </li>
            </ul>
            <div class="ml-auto" v-if="okToSend">
                <button
                    class="inline-block py-2 mr-1 text-sm text-primary focus:outline-none"
                    type="button"
                    @click="sendRequestData">Save request</button>
                <div class="inline-block text-gray-300 mr-1">|</div>
                <dropdown class="inline-block pr-3">
                    <template v-slot:trigger>
                        <div class="text-sm text-primary inline-flex items-center">
                            <span>Examples ({{examples.length}})</span>
                            <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </template>
                    <template v-slot:lists>
                        <div class="mt-2 mr-4 bg-white border rounded w-48 py-2 shadow-xl">
                            <div v-if="examples.length == 0" class="p-5 text-center">
                                <h3 class="text-gray-900">No examples added</h3>
                                <p class="text-gray-500 text-sm mt-3">
                                    Save responses and associated requests as Examples.
                                </p>
                            </div>

                            <ul v-if="examples.length > 0">
                                <li v-for="(example, index) in examples" :key="index">
                                    <router-link :to="{name:'example', params:{id: example.uuid}}" class="block text-gray-800 px-4 py-2 hover:bg-gray-200">
                                        {{example.title}}
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </template>
                </dropdown>
            </div>
        </div>

        <!-- contents -->
        <div class="w-full bg-white">
            <template v-if="currentTab=='headers'">
                <data-table src="header" :content="headers" />
            </template>
            <template v-if="currentTab=='body'">
                <body-options :body-option.sync="bodyOption" @change="onBodyOptionChange" />
                <div class="border-t border-gray-200">
                    <data-table src="form-data" v-if="isBodyOption(requestBodyKeys.FORM_DATA)"
                        :content="body[bodyOption.value]" optionable />
                    <data-table src="form-url-encoded" v-else-if="isBodyOption(requestBodyKeys.FORM_URL_ENCODED)"
                        :content="body[bodyOption.value]" />
                    <code-editor v-else-if="isBodyOption(requestBodyKeys.RAW)"
                        :mode="headerContentType"
                        :code.sync="body[bodyOption.value]" />
                    <div v-else class="px-3 py-2 text-center">
                        <span class="text-xs text-gray-500">This request does not have a body</span>
                    </div>
                </div>
            </template>
            <template v-if="currentTab=='auth' && !ignoreAuth">
                <authenticator :auth-type.sync="authType" :auth-key="authKey" />
            </template>
            <template v-if="currentTab=='route'">
                <table class="w-full text-left table-collapse">
                    <thead>
                        <tr>
                            <th class="p-4 border-gray-200 text-xs font-semibold text-gray-700 w-auto"></th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-1/5">Key</th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-4/5">Value</th>
                        </tr>
                    </thead>
                    <tbody class="align-baseline">
                        <tr v-for="(value, key) in request.info" :key="key">
                            <td class="border-t border-gray-200 text-xs text-gray-800 text-center">
                                <input type="checkbox" :checked="true" disabled>
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800 capitalize">
                                {{key}}
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">
                                {{key === 'methods' ? value.join(" | ") : value || '...'}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <template v-if="currentTab=='docs'">
                <div class="px-4 py-3">
                    <input v-model="about.title" type="text" class="text-gray-700 font-semibold text-xl appearance-none focus:outline-none w-full">
                    <textarea v-model="about.description" placeholder="No description available" class="text-gray-500 font-normal text-md italic appearance-none focus:outline-none w-full"></textarea>
                </div>
            </template>
        </div>
    </div>
</template>
