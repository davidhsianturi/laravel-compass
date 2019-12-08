<script>
import axios from 'axios';
import Omnibox from '../components/Omnibox';
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
            id: this.$route.params.id,
            requestReady: false,
            requestErrors: null,
            requestData: {
                id: '',
                storageId: '',
                title: '',
                description: '',
                examples: [],
                info: {
                    uri: '',
                    name: '',
                    action: '',
                    domain: '',
                    methods: [],
                },
                content: {
                    url: '',
                    body: [],
                    headers: [],
                    selectedMethod: '',
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
            this.requestReady = true;
        });
    },

    methods: {
        fillRequest(data) {
            this.requestData.id = data.id;
            this.requestData.title = data.title;
            this.requestData.storageId = data.storageId;
            this.requestData.description = data.description;
            this.requestData.examples = data.examples;
            this.requestData.info.uri = data.info.uri;
            this.requestData.info.name = data.info.name;
            this.requestData.info.action = data.info.action;
            this.requestData.info.domain = data.info.domain;
            this.requestData.info.methods = data.info.methods;
            this.requestData.content.url = data.content.url || data.info.uri;
            this.requestData.content.body = data.content.body || this.newFormRequests();
            this.requestData.content.headers = data.content.headers || this.newFormRequests();
            this.requestData.content.selectedMethod = data.content.selectedMethod || data.info.methods[0];
        },

        saveRequest()  {
            axios.post('/' + Compass.path + '/request', this.requestData).then(response => {
                this.alertSuccess('Request data successfully saved!', 3000);
            }).catch(error => {
                this.requestErrors = error.response;
            });
        },

        sendRequest() {
            let contentType = this.requestData.content.headers.find(header => header.key === 'Content-Type')
            contentType = contentType ? contentType.value : null

            this.http({
                url: this.requestData.content.url,
                method: this.requestData.content.selectedMethod,
                headers: this.filterFormRequests(this.requestData.content.headers),
                data: this.toRequestData(this.requestData.content.body, contentType),
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
            this.responseData.content.response.data = data ? data.data : '';
            this.responseData.content.response.headers = data ? data.headers : '';
            this.responseData.content.response.status = data ? data.status : '';
            this.responseData.content.response.statusText = data ? data.statusText : '';

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
    <div class="bg-white min-h-full">
        <div class="bg-secondary px-4 py-2 text-sm text-gray-700 border-t border-gray-200">
            <span v-if="requestData.description">{{ requestData.description }}</span>
            <span v-else class="italic">No description available</span>
        </div>

        <omnibox
            class="px-3 py-2 bg-secondary border-t border-b border-gray-200 "
            :methods="requestData.info.methods"
            :url.sync="requestData.content.url"
            :selected-method.sync="requestData.content.selectedMethod"
            @endpoint-ready="sendRequest"></omnibox>

        <div v-if="requestReady">
            <request-tabs
                class="bg-secondary"
                :request.sync="requestData"
                :examples="requestData.examples"
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
    </div>
</template>
