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
    <section class="lg:w-64 border-secondary border-r">
        <div class="hidden lg:flex items-center justify-between px-3 mt-1 mb-3">
            <div class="w-full inline-flex">
                <button
                    :class="{'bg-primary-light font-semibold': currentTab=='list'}"
                    class="w-full py-1 text-xs bg-white text-primary rounded-l-lg border border-primary-light border-r-0 hover:bg-primary-light focus:outline-none"
                    type="button"
                    @click.prevent="currentTab='list'">List</button>
                <button
                    :class="{'bg-primary-light font-semibold': currentTab=='group'}"
                    class="w-full py-1 text-xs bg-white text-primary rounded-r-lg border border-primary-light border-l-0 hover:bg-primary-light focus:outline-none"
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
        <div :class="{'hidden': !isOpen, 'block': isOpen}" class="lg:block lg:h-full lg:flex lg:flex-col lg:justify-between">
            <div class="sm:flex lg:block lg:overflow-y-auto">
                <div class="text-sm text-center text-gray-500">
                    <span v-if="!ready">...</span>
                    <span v-if="ready && requests.list.length == 0">No data were found</span>
                </div>
                <div v-if="ready && requests.list.length > 0" class="px-4 lg:w-full">
                    <ul v-if="currentTab=='list'">
                        <li class="sm:mb-1 truncate text-gray-600" v-for="request in requests.list" :key="request.id">
                            <router-link
                                :to="{name:'cortex', params:{id: request.id}}"
                                active-class="text-primary"
                                class="text-sm text-gray-600 hover:text-primary">

                                <http-methods :request="request" />
                                <span class="ml-2">{{ request.title }}</span>
                            </router-link>
                        </li>
                    </ul>
                    <template v-if="currentTab=='group'">
                        <details class="sm:mb-1 cursor-pointer" v-for="(resources, name) in requests.group" :key="name">
                            <summary class="py-1 text-sm text-gray-600 font-semibold capitalize hover:text-primary focus:text-primary focus:outline-none">
                                {{name}}
                            </summary>
                            <ul class="ml-4">
                                <li class="sm:mb-1 truncate" v-for="request in resources" :key="request.id">
                                    <router-link :to="{name:'cortex', params:{id: request.id}}" active-class="text-primary" class="text-sm text-gray-600 hover:text-primary">
                                        <http-methods :request="request" />
                                        <span class="ml-2">{{ request.title }}</span>
                                    </router-link>
                                </li>
                            </ul>
                        </details>
                    </template>
                </div>
            </div>
            <div class="flex items-center justify-between px-3 py-6">
                <span class="shadow"></span>
            </div>
        </div>
    </section>
</template>

<style scoped>
.py-1 {
    padding-top: 0.15rem;
    padding-bottom: 0.15rem;
}
</style>
