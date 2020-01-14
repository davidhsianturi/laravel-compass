<script>
import axios from 'axios';
import Omnibox from "../components/Omnibox";
import RequestTabs from '../components/RequestTabs';
import ResponseTabs from '../components/ResponseTabs';

export default {
    components: {
        'omnibox': Omnibox,
        'request-tabs': RequestTabs,
        'response-tabs': ResponseTabs,
    },

    data() {
        return {
            busy: true,
            id: this.$route.params.id,
            exampleData: {},
        }
    },

    mounted() {
        axios.get('/' + Compass.path + '/response/' + this.id).then(response => {
            this.exampleData = response.data;
            this.busy = false;
        });
    },

    methods: {
        saveExample() {
            axios.post('/' + Compass.path + '/response', this.exampleData).then(response => {
                this.$router.push({name: 'cortex', params:{id: this.exampleData.content.request.id}});
                this.alertSuccess('An example data successfully saved!', 3000);
            });
        },

        deleteExample() {
            axios.delete('/' + Compass.path + '/response/' + this.id).then(response => {
                this.$router.push({name: 'cortex', params:{id: this.exampleData.content.request.id}});
                this.alertSuccess('An example data successfully deleted!', 3000);
            });
        },
    },

    watch: {
        'exampleData.title'(val) {
            this.$root.requestTitle = val;
            this.$root.requestIsExample = true;
        },
    }
}
</script>

<template>
    <div v-if="!busy" class="border-t border-gray-200 p-4">
        <div class="flex justify-content-between">
            <div class="w-full">
                <label class="block uppercase text-gray-500 text-xs font-semibold mb-2" for="title">Title</label>
                <input class="w-full block py-2 px-4 rounded border bg-gray-100 text-gray-600 appearance-none text-sm focus:outline-none focus:bg-white"
                        id="title"
                        type="text"
                        v-model="exampleData.title">
            </div>
            <div class="ml-auto">
                <router-link :to="{name:'cortex', params:{id: exampleData.content.request.id}}" class="block uppercase text-xs font-semibold mb-2 text-right hover:text-orange-600 text-orange-500">
                    {{exampleData.content.request.title}}
                </router-link>
                <div class="inline-flex pl-3">
                    <button @click="saveExample" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-2 px-4 rounded-l focus:outline-none">
                        Save
                    </button>
                    <button @click="deleteExample" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-2 px-4 rounded-r focus:outline-none">
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <label class="block uppercase text-gray-500 text-xs font-semibold mb-2">Example request</label>
            <div class="bg-white border">
                <omnibox
                    class="py-2 px-4"
                    :methods="exampleData.content.request.info.methods"
                    :url.sync="exampleData.content.request.content.url"
                    :selected-method.sync="exampleData.content.request.content.selectedMethod"
                    :okToSubmit="false" />

                <div class="border-t border-gray-200">
                    <request-tabs :request.sync="exampleData.content.request" :okToSend="false" />
                </div>
            </div>
        </div>

        <div class="mt-5">
            <label class="block uppercase text-gray-500 text-xs font-semibold mb-2">Example response</label>
            <div class="bg-white border">
                <response-tabs :response="exampleData.content.response" :okToSave="false" />
            </div>
        </div>
    </div>
</template>
