<script>
export default {
    data() {
        return {
            busy: true,
            errors: null,
            exampleData: {},
            id: this.$route.params.id
        }
    },

    mounted() {
        this.$http
            .get('/' + Compass.path + '/response/' + this.id)
            .then(response => {
                this.exampleData = response.data;
                this.busy = false;
            })
            .catch(error => {
                this.errors = error.response;
            });
    },

    methods: {
        updateExample() {
            this.$http
                .post('/' + Compass.path + '/response', this.exampleData)
                .then(response => {
                    this.$router.push({name: 'cortex', params:{id: this.exampleData.content.request.id}});
                    this.alertSuccess('An example data successfully updated!', 3000);
                }).catch(error => {
                    this.errors = error.response;
                });
        },
        deleteExample() {
            this.$http
                .delete('/' + Compass.path + '/response/' + this.id)
                .then(response => {
                    this.$router.push({name: 'cortex', params:{id: this.exampleData.content.request.id}});
                    this.alertSuccess('An example data successfully deleted!', 3000);
                }).catch(error => {
                    this.errors = error.response;
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
    <div>
        <template v-if="busy">
            <content-space description="Please wait..." />
        </template>

        <template v-if="!busy">
            <section class="flex justify-content-between pb-4 px-4">
                <div class="w-full">
                    <label class="block uppercase text-gray-600 text-xs font-semibold py-2" for="title">Title</label>
                    <input class="appearance-none text-xs font-semibold block w-full bg-white text-gray-700 border border-gray-300 rounded py-2 px-4 leading-tight focus:outline-none focus:border-gray-500"
                            id="title"
                            type="text"
                            v-model="exampleData.title"
                            autofocus>
                </div>
                <div class="ml-auto">
                    <router-link :to="{name:'cortex', params:{id: exampleData.content.request.id}}" class="block uppercase text-xs font-semibold py-2 text-right text-primary">
                        {{ exampleData.content.request.title }}  &rarr;
                    </router-link>
                    <div class="inline-flex ml-3">
                        <button type="button" @click="updateExample" class="text-xs bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-2 px-4 leading-normal rounded-l focus:outline-none">
                            Update
                        </button>
                        <button type="button" @click="deleteExample" class="text-xs bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-2 px-4 rounded-r leading-normal focus:outline-none">
                            Delete
                        </button>
                    </div>
                </div>
            </section>

            <section class="w-full px-4 pb-6">
                <label class="block uppercase text-gray-600 text-xs mb-2 font-semibold">Example request</label>
                <div class="bg-white shadow rounded-md border border-secondary border-b-0">
                    <omnibox
                        class="px-4 pt-3"
                        :methods="exampleData.content.request.info.methods"
                        :url.sync="exampleData.content.request.content.url"
                        :selected-method.sync="exampleData.content.request.content.selectedMethod"
                        :okToSubmit="false" />

                    <request-tabs v-bind.sync="exampleData.content.request" :exclude-tabs="['Params', 'Auth','Docs']" ignore-extra-tabs />
                </div>
            </section>

            <section class="w-full px-4">
                <label class="block uppercase text-gray-600 text-xs mb-2 font-semibold">Example response</label>
                <div class="bg-white shadow rounded-md border border-secondary border-b-0">
                    <response-tabs v-bind="exampleData.content.response" is-example-data ignore-body-options />
                </div>
            </section>
        </template>
    </div>
</template>
