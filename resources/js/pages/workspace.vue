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
            requestErrors: null,
            requestData: {
                id: '',
                storageId: '',
                title: '',
                description: '',
                info: {
                    uri: '',
                    method: '',
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
            this.requestData.info.method = data.info.method;
            this.requestData.info.action = data.info.action;
            this.requestData.info.domain = data.info.domain;
            this.requestData.info.name = data.info.name;
            this.requestData.content.url = data.content.url || data.info.uri;
            this.requestData.content.headers = data.content.headers || this.defaultReqData();
            this.requestData.content.body = data.content.body || this.defaultReqData();
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
                method: this.requestData.info.method,
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
                <input class="font-semibold w-full py-2 px-4 rounded border bg-gray-200 text-gray-600 inline-block appearance-none focus:outline-none"
                       type="text"
                       v-model="requestData.content.url">

                <button class="block sm:w-auto sm:inline-block bg-orange-400 hover:bg-orange-500 focus:outline-none font-bold text-white ml-3 py-2 px-4 rounded text-sm"
                        type="button"
                        @click="sendRequest">{{requestData.info.method}}</button>
                <button class="block sm:w-auto sm:inline-block bg-gray-300 hover:bg-gray-400 focus:outline-none font-bold text-gray-600 ml-3 py-2 px-4 rounded text-sm"
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
