<script>
import axios from 'axios';

export default {
    props: [],

    data() {
        return {
            requests: [],
            ready: false,
            isOpen: false,
            currentTab: 'list',
        }
    },

    mounted() {
        this.loadRequests();
    },

    methods: {
        toggle() {
            this.isOpen = !this.isOpen
        },

        loadRequests() {
            this.ready = false;

            axios.get('/' + Compass.path + '/routes').then(response => {
                this.requests = response.data.routes;
                this.ready = true;
            });
        },
    }
}
</script>

<template>
    <section class="bg-white border-gray-200 border-r md:w-72">
        <div class="flex justify-between px-4 py-3 bg-secondary">
            <div class="relative max-w-xs w-full">
                <h3 class="font-semibold text-gray-700">Requests</h3>
            </div>

            <div class="inline-flex items-center">
                <a href="#" class="ml-3" @click.prevent="loadRequests" title="refresh">
                    <svg class="h-5 w-5 fill-current text-gray-500 hover:text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M10 3v2a5 5 0 0 0-3.54 8.54l-1.41 1.41A7 7 0 0 1 10 3zm4.95 2.05A7 7 0 0 1 10 17v-2a5 5 0 0 0 3.54-8.54l1.41-1.41zM10 20l-4-4 4-4v8zm0-12V0l4 4-4 4z" />
                    </svg>
                </a>
                <a href="#" class="ml-4 md:hidden" @click.prevent="toggle">
                    <svg class="h-5 w-5 fill-current text-gray-600 hover:text-gray-700" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path v-if="isOpen" fill-rule="evenodd" clip-rule="evenodd" d="M18.278 16.864a1 1 0 0 1-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 0 1-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 0 1 1.414-1.414l4.829 4.828 4.828-4.828a1 1 0 1 1 1.414 1.414l-4.828 4.829 4.828 4.828z" />
                        <path v-if="!isOpen" d="M3 6a1 1 0 0 1 1-1h16a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1zm3 6a1 1 0 0 1 1-1h10a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1zm4 5a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-4z" />
                    </svg>
                </a>
            </div>
        </div>

        <div :class="{'hidden': !isOpen, 'block': isOpen}" class="md:block md:h-full md:flex md:flex-col">
            <!-- Request tabs -->
            <div class="bg-secondary">
                <ul class="flex border-gray-200">
                    <li class="-mb-px mr-3">
                        <a :class="{'bg-white text-gray-700': currentTab=='list'}"
                            class="inline-block py-2 px-4 text-gray-500 hover:text-gray-700 font-semibold"
                            href="#"
                            @click.prevent="currentTab='list'">List</a>
                    </li>
                    <li class="mr-3">
                        <a :class="{'bg-white text-gray-700': currentTab=='resources'}"
                            class="inline-block py-2 px-4 text-gray-500 hover:text-gray-700 font-semibold"
                            href="#"
                            @click.prevent="currentTab='resources'">Resources</a>
                    </li>
                </ul>
            </div>

            <!-- Requests -->
            <div class="sm:flex md:block md:overflow-y-auto">
                <div v-if="!ready" class="px-4 py-4 text-center">
                    <p class="text-gray-600">...</p>
                </div>
                <div v-if="ready && requests.list.length == 0" class="px-4 py-4 text-center">
                    <p class="text-gray-600">No data were found</p>
                </div>

                <div v-if="ready && requests.list.length > 0" class="px-4 py-4 md:w-full">
                    <ul v-if="currentTab=='list'">
                        <li class="sm:mb-2" v-for="request in requests.list" :key="request.id">
                            <router-link :to="{name:'request', params:{id: request.id}}" active-class="text-orange-600" class="text-md px-2 -mx-2 py-1 hover:text-orange-600 text-gray-600">
                                <span class="text-xs text-gray-500 uppercase">{{request.info.methods.join("|")}}</span>
                                <span class="ml-2">{{request.title}}</span>
                            </router-link>
                        </li>
                    </ul>

                    <div v-if="currentTab=='resources'">
                        <details class="sm:mb-2 cursor-pointer" v-for="(resources, name) in requests.group" :key="name">
                            <summary class="px-2 -mx-2 py-1 hover:text-orange-600 focus:text-orange-600 text-gray-600 font-medium capitalize">
                                {{name}}
                            </summary>
                            <ul class="ml-4">
                                <li class="sm:mb-2" v-for="request in resources" :key="request.id">
                                    <router-link :to="{name:'request', params:{id: request.id}}" active-class="text-orange-600" class="text-md px-2 -mx-2 py-1 hover:text-orange-600 text-gray-600">
                                        <span class="text-xs text-gray-500 uppercase">{{request.info.methods.join("|")}}</span>
                                        <span class="ml-2">{{request.title}}</span>
                                    </router-link>
                                </li>
                            </ul>
                        </details>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
