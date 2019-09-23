<script>
import axios from 'axios';
import Omnibox from './../components/Omnibox';
import RequestTabs from './../components/RequestTabs';
import ResponseTabs from './../components/ResponseTabs';

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
            examples: null,
            requestMethod: null,
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
            responseErrors: null,
            responseMeta: null,
            responseData: {
                uuid: '',
                route_hash: '',
                title: '',
                description: '',
                content: {
                    request: '',
                    response: {
                        data: '',
                        headers: '',
                        status: '',
                        statusText: '',
                    },
                },
            }
        }
    },

    mounted() {
        axios.get('/' + Compass.path + '/request/' + this.id).then(response => {
            this.fillRequest(response.data);
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
            this.isExample = data.isExample;
            this.examples = data.examples;
            this.requestMethod = data.info.methods[0];
        },

        saveRequest()  {
            axios.post('/' + Compass.path + '/request', this.requestData).then(response => {
                this.fillRequest(response.data);
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
                this.fillResponse(response);
            }).catch(error => {
                this.fillResponse(error.response);
            });
        },

        fillResponse(data) {
            this.responseMeta = data;

            this.responseData.route_hash = this.id;
            this.responseData.title = this.requestData.title;
            this.responseData.content.request = this.requestData;
            this.responseData.content.response.data = data.data;
            this.responseData.content.response.headers = data.headers;
            this.responseData.content.response.status = data.status;
            this.responseData.content.response.statusText = data.statusText;

            this.responseReady = true;
        },

        saveResponse() {
            axios.post('/' + Compass.path + '/response', this.responseData).then(response => {
                this.$router.push({name: 'example', params: {id: response.data.uuid}});
            }).catch(error => {
                this.responseErrors = error.response;
            });
        }
    },

    watch: {
        'requestData.title'(val) {
            this.$root.requestTitle = val;
            this.$root.requestIsExample = false;
        },
    }
}
</script>

<template>
    <div v-if="!busy" class="bg-white min-h-full">
        <omnibox
            class="p-4 border-t border-b border-gray-200 bg-secondary"
            :methods="requestData.info.methods"
            :url.sync="requestData.content.url"
            :http-method.sync="requestMethod"
            @request-ready="sendRequest"></omnibox>

        <request-tabs
            class="bg-secondary"
            :request="requestData"
            :examples="examples"
            @request-data-ready="saveRequest"></request-tabs>

        <div v-if="!responseReady">
            <div class="flex justify-content-between border-b border-t border-gray-200 bg-secondary">
                <div class="-mb-px mr-1">
                    <h3 class="inline-block text-sm py-2 px-4 text-gray-500">Response</h3>
                </div>
            </div>
            <div class="px-4 py-4">
                <p class="text-gray-600 text-medium">No response yet</p>
            </div>
        </div>

        <div v-if="responseReady" class="border-t border-gray-200">
            <response-tabs
                class="bg-secondary"
                :response="responseMeta"
                @response-data-ready="saveResponse"></response-tabs>
        </div>
    </div>
</template>
