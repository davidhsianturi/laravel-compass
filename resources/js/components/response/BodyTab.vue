<script>
import CodeEditor from '../CodeEditor';

export default {
    components: {
        CodeEditor
    },

    props: {
        response: {
            type: Object,
            required: true
        },
        showBodyOptions: {
            type: Boolean,
            default: true
        }
    },

    computed: {
        code() {
            let data = this.response.data;
            return typeof data === 'string' ? data : JSON.stringify(data, null, '\t');
        }
    },

    data() {
        return {
            currentBodyOption: 'pretty'
        }
    }
}
</script>

<template>
    <div>
        <div v-if="showBodyOptions" class="w-full px-3 py-2 inline-flex">
            <a :class="{'text-gray-800': currentBodyOption=='pretty'}"
                class="text-xs py-2 px-4 bg-gray-300 text-gray-600 rounded-l hover:text-gray-800"
                href="#"
                @click.prevent="currentBodyOption='pretty'">Pretty</a>

            <a :class="{'text-gray-800': currentBodyOption=='preview'}"
                class="text-xs py-2 px-4 bg-gray-300 text-gray-600 rounded-r hover:text-gray-800"
                href="#"
                @click.prevent="currentBodyOption='preview'">Preview</a>
        </div>

        <code-editor v-if="currentBodyOption=='pretty'" :code="code" mode="application/json" readOnly />
        <iframe v-if="currentBodyOption=='preview'" :srcdoc="code" frameborder="0" class="w-full min-h-screen" />
    </div>
</template>

<style lang="scss" scoped>
::v-deep .CodeMirror {
    height: 100vh;
}
</style>
