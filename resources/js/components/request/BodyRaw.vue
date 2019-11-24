<script>
/** CodeMirror mode */
import 'codemirror/mode/javascript/javascript';
// TODO: support body raw options for XML, YAML, and EDN

/** CodeMirror addons */
// Selection addon
import 'codemirror/addon/selection/active-line';
// Edit addon
import 'codemirror/addon/edit/matchbrackets';
import 'codemirror/addon/edit/closebrackets';
// Comment addon
import 'codemirror/addon/comment/comment';
// Display addon
import 'codemirror/addon/display/placeholder';
// Fold addon
import 'codemirror/addon/fold/xml-fold';
import 'codemirror/addon/fold/foldcode';
import 'codemirror/addon/fold/foldgutter';
import 'codemirror/addon/fold/brace-fold';
import 'codemirror/addon/fold/indent-fold';
import 'codemirror/addon/fold/comment-fold';

export default {
    props: {
        content: {
            type: String,
            default: ''
        },
        contentType: {
            type: String,
            default: 'text/plain'
        }
    },

    data() {
        return {
            options: {
                mode: this.contentType,
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
        contentType(val) {
            if (val) this.$refs['code-mirror'].codemirror.setOption('mode', val)
        }
    }
}
</script>
<template>
    <vue-codemirror
        ref="code-mirror"
        :value="content"
        :options="options"
        @input="$emit('update:content', $event)">
    </vue-codemirror>
</template>
