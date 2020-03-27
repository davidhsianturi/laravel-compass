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
        <div v-if="showBodyOptions" class="flex justify-end px-3 py-2">
            <button
                :class="{'bg-primary-light font-semibold': currentBodyOption=='pretty'}"
                class="py-1 px-4 text-xs bg-white text-primary rounded-l-lg border border-primary-light border-r-0 hover:bg-primary-light focus:outline-none"
                type="button"
                @click.prevent="currentBodyOption='pretty'">Pretty</button>
            <button
                :class="{'bg-primary-light font-semibold': currentBodyOption=='preview'}"
                class="py-1 px-4 text-xs bg-white text-primary rounded-r-lg border border-primary-light border-l-0 hover:bg-primary-light hover:bg-primary-light focus:outline-none"
                type="button"
                @click.prevent="currentBodyOption='preview'">Preview</button>
        </div>

        <code-editor v-if="currentBodyOption=='pretty'" :code="code" mode="application/json" readOnly />
        <iframe class="w-full min-h-screen" v-if="currentBodyOption=='preview'" :srcdoc="code" frameborder="0" />
    </div>
</template>

<style lang="scss" scoped>
::v-deep .CodeMirror {
    height: 100vh;
}
</style>
