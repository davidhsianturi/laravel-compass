<script>
export default {
    props: {
        request: {
            type: Object,
            required: true,
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
            });
        },

        removeRow(tab, row) {
            this.request.content[tab].splice(row, 1);
        }
    }
}
</script>

<template>
    <div>
        <!-- tabs -->
        <ul class="flex border-b border-gray-200 bg-secondary">
            <li class="mr-1">
                <a :class="{'text-gray-800 border-primary border-b-2': currentTab=='headers'}"
                    class="inline-block text-sm py-2 px-4 text-gray-600 hover:text-gray-800 font-sm"
                    href="#"
                    @click.prevent="currentTab='headers'">Headers</a>
            </li>
            <li class="mr-1">
                <a :class="{'text-gray-800 border-primary border-b-2': currentTab=='body'}"
                    class="inline-block text-sm py-2 px-4 text-gray-600 hover:text-gray-800 font-sm"
                    href="#"
                    @click.prevent="currentTab='body'">Body</a>
            </li>
            <li class="-mb-px mr-1">
                <a :class="{'text-gray-800 border-primary border-b-2': currentTab=='about'}"
                    class="inline-block text-sm py-2 px-4 text-gray-600 hover:text-gray-800 font-sm"
                    href="#"
                    @click.prevent="currentTab='about'">About
                    <div v-if="!request.storageId" class="rounded-full bg-primary h-2 w-2 inline-block"></div>
                </a>
            </li>
        </ul>

        <!-- contents -->
        <div class="bg-white border-b border-gray-200">
            <div v-if="currentTab=='headers'">
                <table class="w-full text-left table-collapse">
                    <thead>
                        <tr>
                            <th class="border-l border-gray-200 text-xs font-semibold text-gray-700 w-auto"></th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-1/4">Key</th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-1/4">Value</th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-2/4">Description</th>
                        </tr>
                    </thead>
                    <tbody class="align-baseline">
                        <tr v-for="(header, row) in request.content.headers" :key="row" @mouseover="activate('header#' + row)" @mouseout="deactivate('header#' + row)">
                            <td class="px-2 border-l border-t border-gray-200 text-xs text-gray-800 text-right">
                                <input type="checkbox" v-model="header.included" :class="header.new ? 'hidden' : ''">
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">
                                <input type="text" class="mt-0 mb-0 appearance-none focus:outline-none w-full" placeholder="Key" v-model="header.key" @keypress="handleInput('headers', row, header)">
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">
                                <input type="text" class="mt-0 mb-0 appearance-none focus:outline-none w-full" placeholder="Value" v-model="header.value">
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800 relative">
                                <input type="text" class="mt-0 mb-0 appearance-none focus:outline-none block w-full" placeholder="Description" v-model="header.description">
                                <span v-if="!header.new">
                                    <a v-show="active === 'header#' + row" href="#" class="font-bold absolute inset-y-0 right-0 flex items-center pr-3" @click="removeRow('headers', row)">
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
                            <th class="border-l border-gray-200 text-xs font-semibold text-gray-700 w-auto"></th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-1/4">Key</th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-1/4">Value</th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-2/4">Description</th>
                        </tr>
                    </thead>
                    <tbody class="align-baseline">
                        <tr v-for="(reqBody, row) in request.content.body" :key="row" @mouseover="activate('body#' + row)" @mouseout="deactivate('body#' + row)">
                            <td class="px-2 border-l border-t border-gray-200 text-xs text-gray-800 text-right">
                                <input type="checkbox" v-model="reqBody.included" :class="reqBody.new ? 'hidden' : ''">
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">
                                <input type="text" class="mt-0 mb-0 appearance-none focus:outline-none w-full" placeholder="Key" v-model="reqBody.key" @keypress="handleInput('body', row, reqBody)">
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">
                                <input type="text" class="mt-0 mb-0 appearance-none focus:outline-none w-full" placeholder="Value" v-model="reqBody.value">
                            </td>
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800 relative">
                                <input type="text" class="mt-0 mb-0 appearance-none focus:outline-none block w-full" placeholder="Description" v-model="reqBody.description">
                                <span v-if="!reqBody.new">
                                    <a v-show="active === 'body#' + row" href="#" class="font-bold absolute inset-y-0 right-0 flex items-center pr-3" @click="removeRow('body', row)">
                                        <svg class="h-3 w-3 fill-current text-gray-700 hover:text-gray-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
                                    </a>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="currentTab=='about'">
                <table class="w-full text-left table-collapse">
                    <thead>
                        <tr>
                            <th class="border-l border-gray-200 text-xs font-semibold text-gray-700 w-auto"></th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-2/5">Key</th>
                            <th class="p-2 border-l border-gray-200 text-xs font-semibold text-gray-700 w-3/5">Value</th>
                        </tr>
                    </thead>
                    <tbody class="align-baseline">
                        <tr>
                            <td class="px-2 border-l border-t border-gray-200 text-xs text-gray-800 text-right">
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
                            <td class="p-2 border-l border-t border-gray-200 text-xs text-gray-800">{{request.info.method || '...'}}</td>
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