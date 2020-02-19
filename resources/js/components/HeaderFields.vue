<script>
import SelectOption from 'vue-multiselect';
import { HTTP_HEADER_FIELDS } from '../constants';

export default {
    components: {
        SelectOption
    },

    props: ['value', 'list'],

    data() {
        return {
            selectedField: this.value,
        }
    },

    computed: {
        fields() {
            return this.list === 'keys' ? HTTP_HEADER_FIELDS.KEYS : HTTP_HEADER_FIELDS.VALUES;
        },
        placeholder() {
            return 'Select ' + this.list.slice(0, -1) + ' options';
        }
    },

    watch: {
        value(value) {
            this.selectedField = value;
        }
    },

    methods: {
        handleHeader() {
            this.$emit('input', this.selectedField);
        },

        addTag(newTag) {
            this.fields.push(newTag);
            this.selectedField = newTag;
            this.handleHeader();
        }
    }
}
</script>

<template>
    <div>
        <select-option
            class="hide-arrow-icon"
            v-model="selectedField"
            openDirection="bottom"
            tag-placeholder="Add this as new header"
            :placeholder="placeholder"
            :showLabels="false"
            :show-no-results="false"
            :taggable="true"
            :options="fields"
            :hide-selected="true"
            @input="handleHeader"
            @tag="addTag" />
    </div>
</template>
