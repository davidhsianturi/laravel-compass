<script>
import Dropdown from './Dropdown';
import { RESPONSE_CODE_DESCRIPTIONS } from '../constants';

export default {
    components: {
        'dropdown': Dropdown,
    },

    props: ['response'],

    data () {
        return {
            colors: [
                { group: "1", class: "text-blue-500" },
                { group: "2", class: "text-green-500" },
                { group: "3", class: "text-yellow-500" },
                { group: "4", class: "text-orange-400" },
                { group: "5", class: "text-red-600" }
            ]
        }
    },

    computed: {
        status () {
            return this.response.status
                ? `${this.response.status} ${this.response.statusText}`
                : "Error"
        },
        description () {
            return RESPONSE_CODE_DESCRIPTIONS[this.response.status] || "Unknown Response Code"
        },
        color () {
            let statusGroup = String(this.response.status)[0] || ''
            let color = this.colors.find(color => statusGroup === color.group)
            return color ? color.class : "text-red-600"
        }
    }
}
</script>

<template>
    <dropdown class="inline-block text-xs py-2 px-1">
        <template v-slot:trigger>
            <span class="text-gray-500">Status:</span>
            <span :class="color">{{status}}</span>
        </template>
        <template v-slot:lists>
            <div class="mt-2 mr-4 bg-white rounded w-64 shadow">
                <div class="p-3 text-left">
                    <h3 class="text-gray-900 text-sm">{{status}}</h3>
                    <p class="text-gray-500 text-xs">{{description}}</p>
                </div>
            </div>
        </template>
    </dropdown>
</template>
