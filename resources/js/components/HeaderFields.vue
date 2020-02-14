<script>
import SelectOption from 'vue-multiselect';
import HeaderFields from './../data/HeaderFields.json';

export default {
    components: {
        SelectOption
    },

    props: ['value', 'list'],

    data() {
        return {
            fields: [],
            selectedField: this.value,
        }
    },

    computed: {
        placeholder() {
            return 'Select ' + this.list.slice(0, -1) + ' options';
        }
    },

    watch: {
        value(value) {
            this.selectedField = value;
        }
    },

    mounted() {
        this.list === 'keys'
            ? this.fields = HeaderFields.keys
            : this.fields = HeaderFields.values;
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
