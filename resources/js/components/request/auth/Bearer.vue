<script>
import axios from 'axios';
import selectOptions from 'vue-multiselect';

export default {
    components: {
        selectOptions
    },

    props: {
        authKey: {
            type: String,
            required: true
        }
    },

    data() {
        return {
            auths: [],
            selectedAuth: null
        }
    },

    mounted() {
        this.loadAuths();
        this.loadSelectedAuth();
    },

    methods: {
        loadAuths() {
            let auths = this.getItem('auths');
            if (auths) this.auths = auths;
        },
        loadSelectedAuth() {
            let selectedAuth = this.getItem(this.authKey);
            if (selectedAuth) this.selectedAuth = selectedAuth;
        },
        saveAuth(val) {
            let newAuth = val ? [val] : [];
            let oldAuth = this.auths;
            const uKey = 'token'; // unique key.
            // update old auth or create a new one.
            let auths = [...newAuth, ...oldAuth].reduce((acc, cur) => !acc.filter(n => cur[uKey] === n[uKey]).length ? [...acc, cur] : acc, []);
            this.setItem('auths', auths);
        },
        onAddAuth(val) {
            let newAuth = {token: '', name: val};
            this.selectedAuth ? this.selectedAuth.name = val : this.selectedAuth = newAuth;
            this.$refs.token.focus();
        },
        onInputToken(val) {
            let newAuth = {token: val, name: this.selectedAuth ? this.selectedAuth.name : 'unknown'};
            let oldUser = this.auths.find(user => user.token === val);
            this.selectedAuth = oldUser || newAuth;
        },
        onRemoveAuth(val) {
            this.auths.splice(val, 1);
            this.removeItem(this.authKey);
            this.saveAuth();
        },
        setItem(key, value) {
            try {
                localStorage.setItem(key, JSON.stringify(value));
            } catch (e) {
                console.log(e);
            }
        },
        getItem(key) {
            const itemInStorage = localStorage.getItem(key);

            if (itemInStorage) {
                try {
                    return JSON.parse(itemInStorage);
                } catch (e) {
                    console.log(e);
                }
            }

            return;
        },
        removeItem(key) {
            try {
                localStorage.removeItem(key);
            } catch (e) {
                console.log(e);
            }
        }
    },

    watch: {
        selectedAuth: {
            deep: true,
            handler(val) {
                if (val) {
                    this.setItem(this.authKey, val)
                    this.saveAuth(val)
                }
            }
        }
    }
}
</script>

<template>
    <table class="w-full text-left table-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border-b border-gray-200 text-xs font-semibold text-gray-700 w-auto"></th>
                <th class="p-2 border-b border-gray-200 text-xs font-semibold text-gray-700 w-1/3">Name</th>
                <th class="p-2 b border-b border-gray-200 text-xs font-semibold text-gray-700 w-2/3">Token</th>
            </tr>
        </thead>
        <tbody class="align-baseline">
            <tr>
                <td class="px-4 border-b border-gray-200 text-xs text-gray-800 text-right"></td>
                <td class="p-0 border-b border-gray-200 text-xs text-gray-800">
                    <select-options
                        class="hide-arrow-icon"
                        v-model="selectedAuth"
                        openDirection="bottom"
                        tag-placeholder="Add this as new auth"
                        placeholder="Search or add a new auth"
                        label="name"
                        select-label="Select auth"
                        deselect-label="Remove from this request"
                        track-by="token"
                        :show-no-results="false"
                        :options="auths"
                        :taggable="true"
                        @open="loadAuths"
                        @remove="onRemoveAuth"
                        @tag="onAddAuth" />
                </td>
                <td class="pl-2 border-b border-gray-200 text-xs text-gray-800 relative">
                    <input
                        class="appearance-none focus:outline-none w-full bg-transparent"
                        ref="token"
                        type="text"
                        placeholder="Select from the list or paste here to create a new one"
                        :value="selectedAuth ? selectedAuth.token : ''"
                        @input="onInputToken($event.target.value)">
                </td>
            </tr>
        </tbody>
    </table>
</template>
