<script>
import Body from './response/BodyTab';
import HttpStatus from './HttpStatus';
import Headers from './response/HeadersTab';
import HttpResponseSize from './HttpResponseSize';
import HttpResponseTime from './HttpResponseTime';

export default {
    inheritAttrs: false,

    components: {
        Body,
        Headers,
        HttpStatus,
        HttpResponseSize,
        HttpResponseTime
    },

    props: {
        isExampleData: {
            type: Boolean,
            default: false
        },
        showBodyOptions: {
            type: Boolean,
            default: false
        }
    },

    data() {
        return {
            currentTab: 'Body',
            tabs: ['Body', 'Headers']
        }
    }
}
</script>

<template>
    <div>
        <div class="flex justify-content-between border-b border-secondary">
            <ul class="flex">
                <li class="-mb-px mr-1" v-for="(tab, i) in tabs" :key="i">
                    <a :class="{'text-gray-800 border-primary border-b': currentTab==tab}"
                        class="inline-block text-sm capitalize py-2 px-4 text-gray-600 hover:text-gray-800"
                        href="#"
                        @click.prevent="currentTab=tab">{{ tab }}</a>
                </li>
            </ul>

            <div class="flex items-center ml-auto px-3">
                <http-status :response="$attrs" />
                <template v-if="!isExampleData">
                    <http-response-time :response="$attrs" />
                    <http-response-size :response="$attrs" />
                    <div class="inline-block text-secondary">|</div>
                    <button @click="$emit('response-data-ready')" class="inline-block py-2 px-1 text-xs text-primary focus:outline-none">
                        Save response as example
                    </button>
                </template>
            </div>
        </div>

        <keep-alive>
            <component :is="currentTab" v-bind="$attrs" v-on="$listeners" :show-body-options="showBodyOptions" />
        </keep-alive>
    </div>
</template>
