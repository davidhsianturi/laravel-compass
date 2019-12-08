<script>
import Dropdown from './Dropdown';
import HeaderFields from './HeaderFields';
import BodyRawVue from './request/BodyRaw';
import BodyOptions from './request/BodyOptions';
import { REQUEST_BODY_KEYS } from '../constants';
import BodyMultipartForm from './request/BodyMultipartForm';
import BodyFormUrlEncoded from './request/BodyFormUrlEncoded';

export default {
    components: {
        'dropdown': Dropdown,
        'header-fields': HeaderFields,
        'body-options': BodyOptions,
        'body-multipart-form': BodyMultipartForm,
        'body-form-url-encoded': BodyFormUrlEncoded,
        'body-raw': BodyRawVue
    },

    props: {
        request: {
            type: Object,
            required: true,
        },
        examples: {
            type: Array,
            required: false,
        },
        okToSend: {
            type: Boolean,
            default: true,
        }
    },

    data() {
        return {
            currentTab: 'headers',
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
                    url: this.request.content.url,
                    headers: this.headers,
                    body: this.body[this.bodyOption.value],
                    selectedMethod: this.request.content.selectedMethod,
                }
            }
        },

        requestBodyKeys() {
            return REQUEST_BODY_KEYS
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
        handleInput(tab, row, obj) {
            if (!obj.included && obj.new) {
                this.updateRow(tab, row);
                this.addRow(tab);
            }
        },

        updateRow(tab, row) {
            tab[row].included = true;
            tab[row].new = false;
        },

        addRow(tab) {
            tab.push({
                included: false,
                key: null,
                value: null,
                description: null,
                new: true,
                type: 'text',
            });
        },

        removeRow(tab, row) {
            tab.splice(row, 1);
        },

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
            <div>
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
                    <li class="-mb-px mr-1" v-if="okToSend">
                        <a :class="{'text-gray-800 border-primary border-b-2': currentTab=='info'}"
                            class="inline-block text-sm py-2 px-4 text-gray-600 hover:text-gray-800"
                            href="#"
                            @click.prevent="currentTab='info'">Info
                            <div v-if="!request.storageId" class="rounded-full bg-primary h-2 w-2 inline-block"></div>
                        </a>
                    </li>
                </ul>
            </div>

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
        <div class="bg-white border-gray-200">
            <div v-if="currentTab=='headers'">
                <table class="w-full text-left table-collapse">
                    <thead>
                        <tr>
                            <th class="p-4 border-gray-200 text-xs font-semibold text-gray-700 w-auto"></th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-1/4">Key</th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-1/4">Value</th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-1/2">Description</th>
                        </tr>
                    </thead>
                    <tbody class="align-baseline">
                        <tr v-for="(header, row) in headers"
                            :key="row"
                            @mouseover="hoverInElement('header#' + row)"
                            @mouseout="hoverInElement(false)">
                            <td class="border-t border-gray-200 text-xs text-gray-800 text-center">
                                <input type="checkbox"
                                    v-model="header.included"
                                    :class="header.new ? 'hidden' : ''">
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">
                                <input type="text"
                                    class="mt-0 mb-0 appearance-none focus:outline-none w-full"
                                    placeholder="Key"
                                    v-model="header.key"
                                    list="keys"
                                    @input="handleInput(headers, row, header)">

                                <header-fields :listId="'keys'"></header-fields>
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">
                                <input type="text"
                                    class="mt-0 mb-0 appearance-none focus:outline-none w-full"
                                    placeholder="Value"
                                    list="values"
                                    v-model="header.value">

                                <header-fields :listId="'values'"></header-fields>
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800 relative">
                                <input type="text"
                                    class="mt-0 mb-0 appearance-none focus:outline-none block w-full"
                                    placeholder="Description"
                                    v-model="header.description">

                                <span v-if="!header.new">
                                    <a v-show="hoverId==='header#' + row"
                                        href="#"
                                        class="font-bold absolute inset-y-0 right-0 flex items-center pr-3"
                                        @click="removeRow(headers, row)">
                                        <svg class="h-3 w-3 fill-current text-gray-700 hover:text-gray-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/>
                                        </svg>
                                    </a>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="currentTab=='body'">
                <body-options :body-option.sync="bodyOption" @change="onBodyOptionChange" />
                <div class="border-t border-gray-200">
                    <body-multipart-form v-if="isBodyOption(requestBodyKeys.FORM_DATA)"
                        :content="body[bodyOption.value]" />
                    <body-form-url-encoded v-else-if="isBodyOption(requestBodyKeys.FORM_URL_ENCODED)"
                        :content="body[bodyOption.value]" />
                    <body-raw v-else-if="isBodyOption(requestBodyKeys.RAW)"
                        :content-type="headerContentType"
                        :content.sync="body[bodyOption.value]" />
                    <div v-else class="flex justify-center my-3">
                        <span class="text-xs text-gray-500">This request does not have a body</span>
                    </div>
                </div>
            </div>
            <div v-if="currentTab=='info' && okToSend">
                <div class="px-4 py-3">
                    <input
                        type="text"
                        class="text-gray-700 font-semibold text-xl appearance-none focus:outline-none w-full"
                        v-model="about.title">

                    <textarea
                        class="text-gray-500 font-normal text-md italic appearance-none focus:outline-none w-full"
                        placeholder="No description available"
                        v-model="about.description"></textarea>
                </div>
                <div class="border-b border-t border-gray-200 bg-secondary">
                    <div class="-mb-px mr-1">
                        <h3 class="text-sm py-2 px-4 text-gray-600">Route Information</h3>
                    </div>
                </div>
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
            </div>
        </div>
    </div>
</template>
