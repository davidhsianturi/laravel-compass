<script>
import Dropdown from './../components/Dropdown';
import FilesInput from './../components/FilesInput';
import HeaderFields from './../components/HeaderFields';

export default {
    components: {
        'dropdown': Dropdown,
        'files-input': FilesInput,
        'header-fields': HeaderFields,
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
            this.request.content[tab][row].included = true;
            this.request.content[tab][row].new = false;
        },

        addRow(tab) {
            this.request.content[tab].push({
                included: false,
                key: null,
                value: null,
                description: null,
                new: true,
                type: 'text',
            });
        },

        removeRow(tab, row) {
            this.request.content[tab].splice(row, 1);
        },

        sendRequestData() {
            this.$emit('request-data-ready');
        },
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
                        <a :class="{'text-gray-800 border-primary border-b-2': currentTab=='about'}"
                            class="inline-block text-sm py-2 px-4 text-gray-600 hover:text-gray-800"
                            href="#"
                            @click.prevent="currentTab='about'">About
                            <div v-if="!request.storageId" class="rounded-full bg-primary h-2 w-2 inline-block"></div>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="ml-auto px-3" v-if="okToSend">
                <button type="button"
                    class="inline-block py-2 px-1 text-sm text-primary focus:outline-none"
                    @click="sendRequestData">Save request</button>

                <div class="inline-block text-gray-300">|</div>
                <dropdown class="inline-block py-2 px-1">
                    <template v-slot:trigger>
                        <div class="text-sm text-primary inline-flex items-center">
                            <span>Examples ({{examples.length}})</span>
                            <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
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
                                    <router-link :to="{name:'response', params:{id: example.uuid}}" class="block text-gray-800 px-4 py-2 hover:bg-gray-200">
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
                            <th class="border-gray-200 text-xs font-semibold text-gray-700 w-auto"></th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-1/4">Key</th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-1/4">Value</th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-2/4">Description</th>
                        </tr>
                    </thead>
                    <tbody class="align-baseline">
                        <tr v-for="(header, row) in request.content.headers"
                            :key="row"
                            @mouseover="hoverInElement('header#' + row)"
                            @mouseout="hoverInElement(false)">
                            <td class="px-2 border-t border-gray-200 text-xs text-gray-800 text-right">
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
                                    @input="handleInput('headers', row, header)">

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
                                        @click="removeRow('headers', row)">
                                        <svg class="h-3 w-3 fill-current text-gray-700 hover:text-gray-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
                                    </a>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="currentTab=='body'">
                <table class="w-full text-left table-collapse">
                    <thead>
                        <tr>
                            <th class="border-gray-200 text-xs font-semibold text-gray-700 w-auto"></th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-1/4">Key</th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-1/4">Value</th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-2/4">Description</th>
                        </tr>
                    </thead>
                    <tbody class="align-baseline">
                        <tr v-for="(reqBody, row) in request.content.body"
                            :key="row"
                            @mouseover="hoverInElement('body#' + row)"
                            @mouseout="hoverInElement(false)">
                            <td class="px-2 border-t border-gray-200 text-xs text-gray-800 text-right">
                                <input type="checkbox"
                                    v-model="reqBody.included"
                                    :class="reqBody.new ? 'hidden' : ''">
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800 relative">
                                <input type="text"
                                    class="mt-0 mb-0 appearance-none focus:outline-none block w-full"
                                    placeholder="Key"
                                    v-model="reqBody.key"
                                    @input="handleInput('body', row, reqBody)">

                                <div v-show="hoverId==='body#' + row">
                                    <select v-model="reqBody.type" class="capitalize rounded-none appearance-none absolute inset-y-0 right-0 flex items-center bg-white text-gray-500 leading-tight focus:outline-none pr-6">
                                        <option>text</option>
                                        <option>file</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">
                                <input v-show="reqBody.type==='text'"
                                    type="text"
                                    class="mt-0 mb-0 appearance-none focus:outline-none w-full"
                                    placeholder="Value"
                                    v-model="reqBody.value">

                                <files-input v-show="reqBody.type==='file'" v-model="reqBody.value"></files-input>
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800 relative">
                                <input type="text"
                                    class="mt-0 mb-0 appearance-none focus:outline-none block w-full"
                                    placeholder="Description"
                                    v-model="reqBody.description">

                                <a v-show="hoverId==='body#' + row && !reqBody.new"
                                    href="#"
                                    class="font-bold absolute inset-y-0 right-0 flex items-center pr-3"
                                    @click="removeRow('body', row)">

                                    <svg class="h-3 w-3 fill-current text-gray-700 hover:text-gray-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="currentTab=='about' && okToSend">
                <table class="w-full text-left table-collapse">
                    <thead>
                        <tr>
                            <th class="border-gray-200 text-xs font-semibold text-gray-700 w-auto"></th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-1/5">Key</th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-4/5">Value</th>
                        </tr>
                    </thead>
                    <tbody class="align-baseline">
                        <tr>
                            <td class="px-2 border-t border-gray-200 text-xs text-gray-800 text-right">
                                <input type="checkbox" :checked="true" disabled>
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">Title</td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">
                                <input type="text" class="mt-0 mb-0 appearance-none focus:outline-none w-full" v-model="request.title">
                            </td>
                        </tr>
                        <tr>
                            <td class="px-2 border-l border-t border-gray-200 text-xs text-gray-800 text-right">
                                <input type="checkbox" :checked="true" disabled>
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">Description</td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">
                                <input type="text" class="mt-0 mb-0 appearance-none focus:outline-none w-full" placeholder="description" v-model="request.description">
                            </td>
                        </tr>
                        <tr>
                            <td class="px-2 border-l border-t border-gray-200 text-xs text-gray-800 text-right">
                                <input type="checkbox" :checked="true" disabled>
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">Name</td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">{{request.info.name || '...'}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 border-l border-t border-gray-200 text-xs text-gray-800 text-right">
                                <input type="checkbox" :checked="true" disabled>
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">Domain</td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">{{request.info.domain || '...'}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 border-l border-t border-gray-200 text-xs text-gray-800 text-right">
                                <input type="checkbox" :checked="true" disabled>
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">Uri</td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">{{request.info.uri || '...'}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 border-l border-t border-gray-200 text-xs text-gray-800 text-right">
                                <input type="checkbox" :checked="true" disabled>
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">Method</td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">{{request.info.methods.join("|") || '...'}}</td>
                        </tr>
                        <tr>
                            <td class="px-2 border-l border-t border-gray-200 text-xs text-gray-800 text-right">
                                <input type="checkbox" :checked="true" disabled>
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">Action</td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">{{request.info.action || '...'}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
