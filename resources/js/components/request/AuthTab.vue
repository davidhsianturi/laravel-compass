<script>
import None from './auth/None';
import Bearer from './auth/Bearer';

export default {
    inheritAttrs: false,

    components: {
        None,
        Bearer
    },

    data() {
        return {
            types: ['None', 'Bearer']
        }
    },

    computed: {
        currentType: {
            get() { return this.$attrs.content.authType },
            set(val) { this.$emit('update:content', { ...this.$attrs.content, authType: val }) }
        }
    }
}
</script>

<template>
    <div>
        <ul class="flex inline-block ml-4 text-xs text-gray-600">
            <li class="-mb-px mr-4 py-3" v-for="(type, i) in types" :key="i">
                <input
                    type="radio"
                    name="type"
                    :id="`type-${type}`"
                    :value="type"
                    v-model="currentType">
                <label class="lowercase" :for="`type-${type}`">{{type}}</label>
            </li>
        </ul>

        <component :is="currentType" :auth-key="$attrs.authKey" class="border-t border-gray-200" />
    </div>
</template>
