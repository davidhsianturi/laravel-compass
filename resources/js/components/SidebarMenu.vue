<script>
import HttpMethods from './HttpMethods'

export default {
    components: {
        HttpMethods
    },

    data() {
        return {
            errors: null,
            requests: [],
            ready: false,
            isOpen: false,
            currentTab: 'list',
        }
    },

    mounted() {
        this.loadRequests();
        this.spotlightWithKey();
    },

    methods: {
        toggle() {
            this.isOpen = !this.isOpen
        },
        loadRequests() {
            this.ready = false;
            this.$http
                .get('/' + Compass.path + '/request')
                .then(response => {
                    this.requests = response.data.data;
                    this.ready = true;
                }).catch(error => {
                    this.errors = error.response;
                });
        },
        openSpotlight() {
            this.$root.spotlight.open = true;
        },
        spotlightWithKey() {
            document.onkeyup = e => {
                if (e.ctrlKey && e.code == 'Space') {
                    e.preventDefault();
                    this.openSpotlight();
                }
            }
        }
    }
}
</script>

<template>
    <section class="md:w-64 border-secondary border-r">
        <div :class="{'hidden': !isOpen, 'block': isOpen}" class="md:block md:h-full md:flex md:flex-col md:justify-between">
            <div class="sm:flex md:block md:overflow-y-auto">
                <div class="text-sm text-center text-gray-500">
                    <span v-if="!ready">...</span>
                    <span v-if="ready && requests.list.length == 0">No data were found</span>
                </div>
                <div v-if="ready && requests.list.length > 0" class="px-4 md:w-full">
                    <ul v-if="currentTab=='list'">
                        <li class="sm:mb-2 truncate text-gray-600" v-for="request in requests.list" :key="request.id">
                            <router-link
                                :to="{name:'cortex', params:{id: request.id}}"
                                active-class="text-primary"
                                class="text-sm text-gray-600 font-medium hover:text-primary">

                                <http-methods :request="request" />
                                <span class="ml-2">{{ request.title }}</span>
                            </router-link>
                        </li>
                    </ul>
                    <template v-if="currentTab=='group'">
                        <details class="sm:mb-2 cursor-pointer" v-for="(resources, name) in requests.group" :key="name">
                            <summary class="py-1 text-base text-gray-700 font-semibold capitalize hover:text-primary focus:text-primary focus:outline-none">
                                {{name}}
                            </summary>
                            <ul class="ml-4">
                                <li class="sm:mb-2 truncate" v-for="request in resources" :key="request.id">
                                    <router-link :to="{name:'cortex', params:{id: request.id}}" active-class="text-primary" class="text-sm text-gray-600 font-medium hover:text-primary">
                                        <http-methods :request="request" />
                                        <span class="ml-2">{{ request.title }}</span>
                                    </router-link>
                                </li>
                            </ul>
                        </details>
                    </template>
                </div>
            </div>
            <div class="flex items-center justify-between px-4 py-3">
                <div class="w-full inline-flex">
                    <button
                        :class="{'bg-gray-300 font-semibold': currentTab=='list'}"
                        class="w-full py-1 px-4 text-xs bg-gray-200 text-gray-600 rounded-l hover:bg-gray-300 hover:font-semibold focus:outline-none"
                        type="button"
                        @click.prevent="currentTab='list'">List</button>
                    <button
                        :class="{'bg-gray-300 font-semibold': currentTab=='group'}"
                        class="w-full py-1 px-4 text-xs bg-gray-200 text-gray-600 rounded-r hover:bg-gray-300 hover:font-semibold focus:outline-none"
                        type="button"
                        @click.prevent="currentTab='group'">Group</button>
                </div>
                <div class="inline-flex">
                    <a href="#" class="ml-3" @click.prevent="loadRequests" title="refresh">
                        <svg class="h-5 w-5 fill-current text-gray-300 hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M10 3v2a5 5 0 0 0-3.54 8.54l-1.41 1.41A7 7 0 0 1 10 3zm4.95 2.05A7 7 0 0 1 10 17v-2a5 5 0 0 0 3.54-8.54l1.41-1.41zM10 20l-4-4 4-4v8zm0-12V0l4 4-4 4z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>
