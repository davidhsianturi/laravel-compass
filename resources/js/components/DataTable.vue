<script>
import FilesInput from './FilesInput';
import HeaderFields from './HeaderFields';
import SelectOption from 'vue-multiselect';

export default {
    inheritAttrs: false,

    components: {
        FilesInput,
        HeaderFields,
        SelectOption
    },

    props: {
        src: {
            type: String,
            required: true
        },
        content: {
            type: Array,
            required: true
        },
        optionable: {
            type: Boolean,
            default: false
        }
    },

    computed: {
        items: {
            get() { return this.content },
            set(val) { this.$emit('update:content', val) }
        }
    },

    methods: {
        handleInput(row, obj) {
            if (!obj.included && obj.new) {
                this.updateRow(row);
                this.addRow();
            }
        },
        updateRow(row) {
            this.items[row].included = true;
            this.items[row].new = false;
        },
        addRow() {
            this.items.push({
                included: false,
                key: null,
                value: null,
                description: null,
                new: true,
                type: 'text',
            });
        },
        removeRow(row) {
            this.items.splice(row, 1);
        }
    }
}
</script>

<template>
    <table class="w-full text-left table-collapse table-fixed">
        <thead>
            <tr class="text-xs font-semibold text-gray-700 bg-secondary">
                <th class="p-4 w-4"></th>
                <th class="p-2 w-1/4">Key</th>
                <th class="p-2 w-1/4">Value</th>
                <th class="p-2 w-auto">Description</th>
            </tr>
        </thead>
        <tbody class="align-middle">
            <tr v-for="(col, row) in items"
                :key="row"
                @mouseover="activateElmnt(src + row)"
                @mouseout="activateElmnt(null)">

                <!-- Checkbox -->
                <td class="border-b border-secondary text-xs text-gray-800 text-center">
                    <input type="checkbox" v-model="col.included" :class="col.new ? 'hidden' : ''">
                </td>
                <!-- Key -->
                <td class="p-0 border-b border-secondary text-xs text-gray-800" :class="optionable ? 'relative' : ''">
                    <input
                        v-show="src!=='header'"
                        type="text"
                        class="m-2 appearance-none focus:outline-none w-full bg-transparent"
                        placeholder="Key"
                        v-model="col.key"
                        @input="handleInput(row, col)">

                    <div v-show="elementId===src + row && optionable" class="absolute inset-y-0 right-0">
                        <select-option
                            class="capitalize"
                            v-model="col.type"
                            openDirection="bottom"
                            :allowEmpty="false"
                            :showLabels="false"
                            :searchable="false"
                            :options="['text','file']" />
                    </div>

                    <header-fields v-show="src==='header'" list="keys" v-model="col.key" @input="handleInput(row, col)" />
                </td>
                <!-- Value -->
                <td class="p-0 border-b border-secondary text-xs text-gray-800">
                    <input
                        v-show="col.type==='text' && src!=='header'"
                        type="text"
                        class="m-2 appearance-none focus:outline-none w-full bg-transparent"
                        placeholder="Value"
                        v-model="col.value">

                    <files-input v-show="col.type==='file' && src!=='header'" v-model="col.value" class="p-2" />
                    <header-fields v-show="src==='header'" list="values" v-model="col.value" />
                </td>
                <!-- Description -->
                <td class="pl-2 border-b border-secondary text-xs text-gray-800 relative">
                    <input
                        type="text"
                        class="appearance-none focus:outline-none w-full bg-transparent"
                        placeholder="Description"
                        v-model="col.description">

                    <a v-show="elementId===src + row && !col.new"
                        href="#"
                        class="font-bold absolute inset-y-0 right-0 flex items-center pr-3"
                        @click="removeRow(row)">
                        <svg class="h-3 w-3 fill-current text-gray-700 hover:text-gray-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/>
                        </svg>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</template>
