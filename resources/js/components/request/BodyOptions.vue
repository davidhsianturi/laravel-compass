<script>
import { REQUEST_BODY_OPTIONS } from '../../constants';

export default {
    props: {
        bodyOption: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            selectedBodyOption: this.bodyOption
        }
    },

    computed: {
        bodyOptions() {
            return REQUEST_BODY_OPTIONS
        },
        rawBodyOptions() {
            return REQUEST_BODY_OPTIONS.find(option => option.key === 'raw').options
        }
    },

    methods: {
        onChange(e) {
            const isBodyOptionRaw = this.selectedBodyOption.value === 'raw'
            const key = isBodyOptionRaw ? this.selectedBodyOption.rawOption : this.selectedBodyOption.value
            const option = (isBodyOptionRaw ? this.rawBodyOptions : REQUEST_BODY_OPTIONS).find(opt => opt.key === key)
            const headerContentType = option ? option.value : null

            this.$emit('update:body-option', this.selectedBodyOption)
            this.$emit('change', headerContentType)
        }
    }
}
</script>

<template>
    <ul class="flex inline-block ml-4 text-xs text-gray-600">
        <li class="-mb-px mr-4 py-3" v-for="(option, index) in bodyOptions" :key="index">
            <input
                type="radio"
                name="body-opts"
                :id="`body-opts-${option.key}`"
                :value="option.key"
                v-model="selectedBodyOption.value"
                @change="onChange">
            <label :for="`body-opts-${option.key}`">{{option.text}}</label>
        </li>
        <li v-if="selectedBodyOption.value=='raw'" class="-mb-px mr-4 py-3">
            <select
                v-model="selectedBodyOption.rawOption"
                class="border-0 text-primary focus:outline-none"
                @change="onChange">
                <option
                    class="text-gray-600"
                    v-for="(option, index) in rawBodyOptions"
                    :key="index"
                    :value="option.key">
                    {{option.text}}
                </option>
            </select>
        </li>
    </ul>
</template>
