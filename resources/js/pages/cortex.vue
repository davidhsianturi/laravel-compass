<script>
import axios from 'axios';

export default {
    data() {
        return {
            id: this.$route.params.id,
            requestErrors: null,
            requestReady: false,
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
                    methods: []
                },
                content: {
                    url: '',
                    body: [],
                    params: [],
                    headers: [],
                    authType: '',
                    selectedMethod: ''
                }
            },
            responseMeta: null,
            responseErrors: null,
            responseReady: false,
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

    computed: {
        baseUrl() {
            let appUrl = new URL(Compass.app.base_url);
            let newHostname = this.requestData.info.domain;

            if (!newHostname) {
                return appUrl.origin
            };

            appUrl.hostname = newHostname;
            return appUrl.origin;
        },
        authenticator() {
            let type = this.requestData.content.authType;
            let key = `${type}@${this.requestData.id}`;

            return {type, key};
        }
    },

    mounted() {
        this.getRequest();
    },

    methods: {
        getRequest() {
            axios.get('/' + Compass.path + '/request/' + this.id).then(response => {
                this.fillRequest(response.data);
                this.requestReady = true;
            });
        },
        fillRequest(data) {
            this.requestData.id = data.id;
            this.requestData.title = data.title;
            this.requestData.examples = data.examples;
            this.requestData.storageId = data.storageId;
            this.requestData.description = data.description;
            this.requestData.info.uri = data.info.uri;
            this.requestData.info.name = data.info.name;
            this.requestData.info.action = data.info.action;
            this.requestData.info.domain = data.info.domain;
            this.requestData.info.methods = data.info.methods;
            this.requestData.content.body = data.content.body || '';
            this.requestData.content.url = data.content.url || data.info.uri;
            this.requestData.content.authType = data.content.authType || 'None';
            this.requestData.content.params = data.content.params || this.newFormRequests();
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
                baseURL: this.baseUrl,
                url: this.requestData.content.url,
                method: this.requestData.content.selectedMethod,
                headers: this.toRequestHeaders(this.requestData.content.headers, this.authenticator),
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
        'requestData.content.params': {
            deep: true,
            handler(val) {
                let uri = this.encodeParams(val, this.requestData.content.url);
                this.requestData.content.url = uri.endsWith('=') ? uri.slice(0, -1) : uri;
            }
        }
    }
}
</script>

<template>
    <div>
        <section class="px-3 pb-1">
            <omnibox
                :methods="requestData.info.methods"
                :url.sync="requestData.content.url"
                :selected-method.sync="requestData.content.selectedMethod"
                :params.sync="requestData.content.params"
                @endpoint-ready="sendRequest" />
        </section>

        <section>
            <request-tabs v-bind.sync="requestData" :authKey="authenticator.key" @request-data-ready="saveRequest" />
        </section>

        <template v-if="!responseReady">
            <content-space description="Hit send to get a response" />
        </template>

        <section v-if="responseReady">
            <response-tabs v-bind="responseMeta" @response-data-ready="saveResponse" show-body-options />
        </section>
    </div>
</template>
