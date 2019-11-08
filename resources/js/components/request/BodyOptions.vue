<script>
export default {
    props: {
        bodyOption: {
            type: Object,
            required: true,
        }
    },

    data() {
        return {
            rawBodyOptions: [
                { key: 'text',  value: 'text/plain', text: 'Text', },
                { key: 'json',  value: 'application/json', text: 'JSON', },
                { key: 'xml',  value: 'application/xml', text: 'XML', },
                { key: 'yaml',  value: 'text/yaml', text: 'YAML', },
                { key: 'edn',  value: 'application/edn', text: 'EDN', },
            ],
            bodyOptions: [
                { key: 'none', value: null, text: 'none' },
                { key: 'form-data', value: 'multipart/form-data', text: 'multipart form' },
                { key: 'form-urlencoded', value: 'application/x-www-form-urlencoded', text: 'form URL encoded' },
                { key: 'raw', value: null, text: 'raw', options: this.rawBodyOptions },
                { key: 'binary', value: 'application/octet-stream', text: 'binary' }
            ],
            selectedBodyOption: { ...this.bodyOption }
        }
    },

    methods: {
        onChange(e) {
            const isBodyOptionRaw = this.selectedBodyOption.value === 'raw'
            const key = isBodyOptionRaw ? this.selectedBodyOption.rawOption : this.selectedBodyOption.value
            const opt = (isBodyOptionRaw ? this.rawBodyOptions : this.bodyOptions).find(o => o.key === key)
            const headerContentType = opt ? opt.value : null
            this.$emit('change', { bodyOption: this.selectedBodyOption, headerContentType });
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
