<script>
import CodeEditor from '../CodeEditor';

export default {
    inheritAttrs: false,

    components: {
        CodeEditor
    },

    props: {
        showBodyOptions: {
            type: Boolean,
            default: true
        }
    },

    computed: {
        responseBody: {
            get() {
                let data = this.$attrs.data;
                return typeof data === 'string' ? data : JSON.stringify(data, null, '\t');
            },
            set(val) {
                this.$emit('update:data', val);
            }
        }
    },

    data() {
        return {
            currentBodyOption: 'pretty',
            editorMode: this.$attrs.headers['content-type']
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
                class="py-1 px-4 text-xs bg-white text-primary rounded-r-lg border border-primary-light border-l-0 hover:bg-primary-light focus:outline-none"
                type="button"
                @click.prevent="currentBodyOption='preview'">Preview</button>
        </div>

        <code-editor
            v-if="currentBodyOption=='pretty'"
            :code.sync="responseBody"
            :mode="editorMode"
            :readOnly="showBodyOptions" />

        <iframe
            v-if="currentBodyOption=='preview'"
            :srcdoc="responseBody"
            frameborder="0"
            class="w-full min-h-screen"  />
    </div>
</template>
