<script>
import DataTable from '../DataTable';
import CodeEditor from '../CodeEditor';
import { REQUEST_BODY_KEYS, REQUEST_BODY_OPTIONS } from '../../constants';

export default {
    inheritAttrs: false,

    components: {
        DataTable,
        CodeEditor
    },

    data() {
        return {
            headerContentType: null,
            headerKey: 'Content-Type',
            headerContentTypeIndex: -1,
            bodyForm: {
                [REQUEST_BODY_KEYS.FORM_DATA]: [],
                [REQUEST_BODY_KEYS.FORM_URL_ENCODED]: [],
                [REQUEST_BODY_KEYS.RAW]: ''
            },
            currentBody: { value: 'none', rawOption: 'text' }
        }
    },

    computed: {
        content: {
            get() { return this.$attrs.content },
            set(val) { this.$emit('update:content', val) }
        },
        bodyFormRequest() {
            return this.bodyForm[this.currentBody.value] || '';
        },
        bodyKeys() {
            return REQUEST_BODY_KEYS;
        },
        bodyOptions() {
            return REQUEST_BODY_OPTIONS;
        },
        rawBodyOptions() {
            return this.bodyOptions.find(raw => raw.key === this.bodyKeys.RAW).options;
        }
    },

    watch: {
        currentBody: {
            deep: true,
            handler(body) {
                if (body.value === 'none' && this.headerContentTypeIndex !== -1) {
                    this.content.headers.splice(this.headerContentTypeIndex, 1);
                    this.headerContentTypeIndex = -1;
                } else if (body.value !== this.bodyKeys.RAW && !this.bodyForm[body.value].length) {
                    this.bodyForm[body.value] = this.newFormRequests();
                }
                this.updateContent();
            }
        },
        bodyForm: {
            deep: true,
            handler() {
                this.updateContent();
            }
        }
    },

    mounted() {
        this.headerContentTypeIndex = this.content.headers.findIndex(h => h.key === this.headerKey);
        if (this.headerContentTypeIndex !== -1) {
            this.headerContentType = this.content.headers[this.headerContentTypeIndex].value;
            this.currentBody = this.normalizeContentType(this.headerContentType);
            this.bodyForm[this.currentBody.value] = this.isCurrentBody(this.bodyKeys.RAW) ? this.content.body : [ ...this.content.body ];
        }
    },

    methods: {
        onSelectedBody(opt) {
            const contentType = opt.key === this.bodyKeys.RAW
                ? this.rawBodyOptions.find(raw => raw.key === this.currentBody.rawOption).value
                : opt.value;
            this.headerContentType = contentType;
            this.headerContentTypeIndex !== -1
                ? this.content.headers[this.headerContentTypeIndex].value = contentType
                : this.changesHeader(this.headerKey, contentType);
        },
        changesHeader(headerKey, contentType) {
            // whatever, just change it directly!
            this.content.headers.splice(0, 0, {
                included: true,
                key: headerKey,
                value: contentType,
                description: null,
                new: false,
                type: 'text',
            });
            this.headerContentTypeIndex = 0;
        },
        updateContent() {
            this.content = { ...this.content, body: this.bodyFormRequest };
        },
        isCurrentBody(value) {
            return this.currentBody.value === value;
        }
    }
}
</script>

<template>
    <div class="border-t border-secondary">
        <ul class="flex inline-block ml-4 text-xs text-gray-600">
            <li class="-mb-px mr-4 py-3" v-for="(option, index) in bodyOptions" :key="index">
                <input
                    type="radio"
                    name="body-opts"
                    :id="`body-opts-${option.key}`"
                    :value="option.key"
                    v-model="currentBody.value"
                    @change="onSelectedBody(option)">
                <label :for="`body-opts-${option.key}`">{{option.text}}</label>
            </li>
            <li v-if="isCurrentBody(bodyKeys.RAW)" class="-mb-px mr-4 py-3">
                <select
                    class="border-0 bg-secondary text-primary focus:outline-none"
                    v-model="currentBody.rawOption"
                    @change="onSelectedBody({key: bodyKeys.RAW})">
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

        <div class="border-t border-secondary">
            <data-table v-if="isCurrentBody(bodyKeys.FORM_DATA)"
                        :src="bodyKeys.FORM_DATA"
                        :content="bodyForm[currentBody.value]"
                        optionable />
            <data-table v-else-if="isCurrentBody(bodyKeys.FORM_URL_ENCODED)"
                        :src="bodyKeys.FORM_URL_ENCODED"
                        :content="bodyForm[currentBody.value]" />
            <code-editor v-else-if="isCurrentBody(bodyKeys.RAW)"
                        class="border-b border-secondary"
                        :mode="headerContentType"
                        :code.sync="bodyForm[currentBody.value]" />

            <div v-else class="px-3 py-2 text-center border-b border-secondary">
                <span class="text-xs text-gray-500">This request does not have a body</span>
            </div>
        </div>
    </div>
</template>
