<script>
import { codemirror } from 'vue-codemirror';

/** Addons */
import 'codemirror/addon/fold/foldcode';
import 'codemirror/addon/fold/xml-fold';
import 'codemirror/addon/fold/brace-fold';
import 'codemirror/addon/fold/foldgutter';
import 'codemirror/addon/comment/comment';
import 'codemirror/addon/fold/indent-fold';
import 'codemirror/addon/fold/comment-fold';
import 'codemirror/addon/edit/closebrackets';
import 'codemirror/addon/edit/matchbrackets';
import 'codemirror/addon/display/placeholder';
import 'codemirror/addon/selection/active-line';
/** Mode */
import 'codemirror/mode/javascript/javascript';

export default {
    components: {
        codemirror
    },

    props: {
        code: {
            type: String,
            default: ''
        },
        mode: {
            type: String,
            default: 'text/plain'
        },
        readOnly: {
            type: Boolean,
            default: false
        }
    },

    data() {
        return {
            options: {
                mode: this.mode,
                readOnly: this.readOnly,
                tabSize: 2,
                indentUnit: 2,
                indentWithTabs: true,
                lineNumbers: true,
                styleActiveLine: true,
                matchBrackets: true,
                autoCloseBrackets: true,
                foldGutter: true,
                gutters: ['CodeMirror-linenumbers', 'CodeMirror-foldgutter'],
                placeholder: '...'
            }
        }
    },

    watch: {
        mode(val) {
            if (val) this.$refs['code-mirror'].codemirror.setOption('mode', val)
        }
    }
}
</script>

<template>
    <codemirror
        ref="code-mirror"
        :value="code"
        :options="options"
        @input="$emit('update:code', $event)" />
</template>
