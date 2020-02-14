<script>
import None from './request/auth/None';
import Bearer from './request/auth/Bearer';

export default {
    components: {
        None,
        Bearer
    },

    props: {
        authType: {
            type: String,
            required: true
        },
        authKey: {
            type: String,
            required: true
        }
    },

    data() {
        return {
            currentTab: this.authType,
            tabs: ['None', 'Bearer']
        }
    },

    watch: {
        currentTab(val) {
            this.$emit('update:auth-type', val);
        }
    }
}
</script>

<template>
    <div>
        <ul class="flex inline-block ml-4 text-xs text-gray-600">
            <li class="-mb-px mr-4 py-3" v-for="(tab, i) in tabs" :key="i">
                <input
                    type="radio"
                    name="tab"
                    :id="`tab-${tab}`"
                    :value="tab"
                    v-model="currentTab">
                <label class="lowercase" :for="`tab-${tab}`">{{tab}}</label>
            </li>
        </ul>

        <component :is="currentTab" :auth-key="authKey" class="border-t border-gray-200" />
    </div>
</template>
