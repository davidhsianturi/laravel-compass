<script>
import axios from 'axios';

export default {
    data() {
        return {
            busy: true,
            exampleData: {},
            id: this.$route.params.id
        }
    },

    mounted() {
        axios.get('/' + Compass.path + '/response/' + this.id).then(response => {
            this.exampleData = response.data;
            this.busy = false;
        });
    },

    methods: {
        updateExample() {
            axios.post('/' + Compass.path + '/response', this.exampleData).then(response => {
                this.$router.push({name: 'cortex', params:{id: this.exampleData.content.request.id}});
                this.alertSuccess('An example data successfully updated!', 3000);
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
    <div>
        <template v-if="busy">
            <content-space description="Please wait..." />
        </template>

        <template v-if="!busy">
            <section class="flex justify-content-between mb-5 px-4">
                <div class="w-full">
                    <label class="block uppercase text-gray-600 text-xs font-semibold py-2" for="title">Title</label>
                    <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-400 rounded py-2 px-4 leading-tight focus:outline-none focus:border-gray-500"
                            id="title"
                            type="text"
                            v-model="exampleData.title"
                            autofocus>
                </div>
                <div class="ml-auto">
                    <router-link :to="{name:'cortex', params:{id: exampleData.content.request.id}}" class="block uppercase text-xs font-semibold py-2 text-right hover:text-orange-600 text-orange-500">
                        {{ exampleData.content.request.title }}
                    </router-link>
                    <div class="inline-flex pl-3">
                        <button @click="updateExample" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-2 px-4 rounded-l leading-tight focus:outline-none">
                            Update
                        </button>
                        <button @click="deleteExample" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-2 px-4 rounded-r leading-tight focus:outline-none">
                            Delete
                        </button>
                    </div>
                </div>
            </section>

            <section class="w-full">
                <label class="block uppercase text-gray-600 text-xs font-semibold py-2 px-4 border-t border-gray-200 bg-secondary">Example request</label>
                <omnibox
                    class="pt-2 px-4 border-t border-gray-200"
                    :methods="exampleData.content.request.info.methods"
                    :url.sync="exampleData.content.request.content.url"
                    :selected-method.sync="exampleData.content.request.content.selectedMethod"
                    :okToSubmit="false" />

                <request-tabs v-bind.sync="exampleData.content.request" :exclude-tabs="['Params', 'Auth','Docs']" ignore-extra-tabs />
            </section>

            <section class="w-full">
                <label class="block uppercase text-gray-600 text-xs font-semibold py-2 px-4 bg-secondary">Example response</label>
                <response-tabs class="border-t border-gray-200" v-bind="exampleData.content.response" is-example-data ignore-body-options />
            </section>
        </template>
    </div>
</template>
