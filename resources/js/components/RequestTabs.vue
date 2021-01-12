<script>
import Dropdown from './Dropdown';
import Auth from './request/AuthTab';
import Body from './request/BodyTab';
import Docs from './request/DocsTab';
import Route from './request/RouteTab';
import Params from './request/ParamsTab';
import Headers from './request/HeadersTab';

export default {
    inheritAttrs: false,

    components: {
        Auth,
        Body,
        Docs,
        Route,
        Params,
        Headers,
        Dropdown
    },

    props: {
        excludeTabs: {
            type: Array,
            default: () => []
        },
        ignoreExtraTabs: {
            type: Boolean,
            default: false
        }
    },

    data() {
        return {
            currentTab: '',
            defaultTabs: ['Params', 'Headers', 'Body', 'Auth', 'Route', 'Docs']
        }
    },

    computed: {
        ignoreAuth() {
            return Compass.app.env !== 'local';
        },
        tabs() {
            const tabs = this.ignoreAuth ? [...['Auth'], ...this.excludeTabs] : this.excludeTabs;
            return this.defaultTabs.filter(tab => !tabs.includes(tab));
        }
    },

    mounted() {
        this.currentTab = this.tabs[0];
    }
}
</script>

<template>
    <div>
        <div class="flex justify-content-between">
            <ul class="flex">
                <li class="-mb-px mr-1" v-for="(tab, i) in tabs" :key="i">
                    <a :class="{'text-gray-800 border-primary border-b': currentTab==tab}"
                        class="inline-block text-sm capitalize py-2 px-4 text-gray-600 hover:text-gray-800"
                        href="#"
                        @click.prevent="currentTab=tab">{{ tab }}</a>
                </li>
            </ul>

            <div v-if="!ignoreExtraTabs" class="flex items-center ml-auto px-3">
                <button
                    class="inline-block py-2 px-1 rounded-full text-xs text-primary focus:outline-none"
                    type="button"
                    @click="$emit('request-data-ready')">Save request</button>
                <div class="inline-block text-secondary">|</div>
                <dropdown class="inline-block">
                    <template v-slot:trigger>
                        <div class="inline-flex items-center py-2 px-1 rounded-full text-xs text-primary focus:outline-none">
                            <span>Examples ({{ $attrs.examples.length }})</span>
                            <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </template>
                    <template v-slot:lists>
                        <div class="mr-4 bg-white rounded w-48 shadow">
                            <div v-if="$attrs.examples.length == 0" class="p-5 text-center">
                                <h3 class="text-gray-900 text-sm">No examples added</h3>
                                <p class="text-gray-500 text-xs mt-3">Save responses and associated requests as Examples.</p>
                            </div>
                            <ul v-if="$attrs.examples.length > 0">
                                <li v-for="(example, index) in $attrs.examples" :key="index">
                                    <router-link :to="{name:'example', params:{id: example.uuid}}" class="block text-xs text-gray-600 px-4 py-2 hover:bg-light hover:text-primary">
                                        {{ example.title }}
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </template>
                </dropdown>
            </div>
        </div>

        <keep-alive>
            <component :is="currentTab" v-bind="$attrs" v-on="$listeners" />
        </keep-alive>
    </div>
</template>
