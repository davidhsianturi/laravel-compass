<script>
import axios from 'axios';
import RequestTabs from './../components/RequestTabs';
import ResponseTabs from './../components/ResponseTabs';

export default {
    components: {
        'request-tabs': RequestTabs,
        'response-tabs': ResponseTabs,
    },

    data() {
        return {
            busy: true,
            id: this.$route.params.id,
            selectedMethod: null,
            requestErrors: null,
            requestData: {
                id: '',
                storageId: '',
                title: '',
                description: '',
                info: {
                    uri: '',
                    methods: '',
                    action: '',
                    domain: '',
                    name: '',
                },
                content: {
                    headers: '',
                    body: '',
                },
            },
            responseReady: false,
            responseData: null,
        }
    },

    mounted() {
        axios.get('/' + Compass.path + '/routes/' + this.id).then(response => {
            this.fillRequest(response.data.route);

            this.busy = false;
        });
    },

    methods: {
        fillRequest(data) {
            this.requestData.id = data.id;
            this.requestData.storageId = data.storageId;
            this.requestData.title = data.title;
            this.requestData.description = data.description;
            this.requestData.info.uri = data.info.uri;
            this.requestData.info.methods = data.info.methods;
            this.requestData.info.action = data.info.action;
            this.requestData.info.domain = data.info.domain;
            this.requestData.info.name = data.info.name;
            this.requestData.content.url = data.content.url || data.info.uri;
            this.requestData.content.headers = data.content.headers || this.defaultReqData();
            this.requestData.content.body = data.content.body || this.defaultReqData();

            this.selectedMethod = data.info.methods[0];
        },

        saveRequest()  {
            axios.post('/' + Compass.path + '/routes', this.requestData).then(response => {
                this.fillRequest(response.data.route);
                this.alertSuccess('Request data successfully saved!', 3000);
            }).catch(error => {
                this.requestErrors = error.response;
            });
        },

        sendRequest() {
            axios({
                url: this.requestData.content.url,
                method: this.selectedMethod,
                baseURL: Compass.app.base_url,
                headers: this.customReqData(this.requestData.content.headers),
                data: this.customReqData(this.requestData.content.body),
            }).then(response => {
                this.responseData = response;
                this.responseReady = true;
            }).catch(error => {
                this.responseData = error.response;
                this.responseReady = true;
            });
        }
    },

    watch: {
        'requestData.title'(val) {
            this.$root.title = val;
        },
    }
}
</script>

<template>
    <div v-if="!busy">
        <div class="p-4 border-t border-b border-gray-200 bg-secondary">
            <div class="flex justify-between">
                 <div class="relative">
                     <select v-model="selectedMethod" class="block font-semibold appearance-none bg-gray-200 border border-r-0 text-gray-600 py-3 px-4 pr-8 rounded rounded-r-none leading-tight focus:outline-none">
                        <option v-for="(method, index) in requestData.info.methods" :key="index">{{method}}</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>

                <input class="w-full py-2 px-4 rounded rounded-l-none border bg-gray-200 text-gray-600 inline-block appearance-none focus:outline-none"
                       type="text"
                       v-model="requestData.content.url">

                <button class="block sm:w-auto sm:inline-block bg-orange-400 hover:bg-orange-500 focus:outline-none font-bold text-white ml-2 py-2 px-4 rounded text-sm"
                        type="button"
                        @click="sendRequest">SEND</button>
                <button class="block sm:w-auto sm:inline-block bg-gray-300 hover:bg-gray-400 focus:outline-none font-bold text-gray-600 ml-2 py-2 px-4 rounded text-sm"
                        type="button"
                        @click="saveRequest">SAVE</button>
            </div>
        </div>
        <request-tabs :request="requestData"></request-tabs>

        <div v-if="!responseReady">
            <div class="flex justify-content-between border-b border-gray-200 bg-secondary">
                <div class="-mb-px mr-1">
                    <h3 class="inline-block text-sm py-2 px-4 text-gray-500">Response</h3>
                </div>
            </div>
            <div class="px-4 py-4">
                <p class="text-gray-600 text-medium">No response yet</p>
            </div>
        </div>
        <div v-if="responseReady">
            <response-tabs :response="responseData"></response-tabs>
        </div>
    </div>
</template>
