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
            users: [],
            selectedUser: null
        }
    },

    mounted() {
        this.loadUsers();
        this.loadSelectedUser();
    },

    methods: {
        loadUsers() {
            let users = this.getItem('users');
            users ? this.users = users : Compass.auth_enabled ? this.getUsers() : undefined;
        },
        loadSelectedUser() {
            let selectedUser = this.getItem(this.authKey);
            if (selectedUser) {
                this.selectedUser = selectedUser;
            }
        },
        getUsers() {
            axios.get('/' + Compass.path + '/users').then(response => {
                this.users = response.data.data;
                this.saveUser();
            }).catch(error => {
                console.log(error);
            });
        },
        saveUser(val) {
            let newUser = val ? [val] : [];
            let oldUsers = this.users;
            const uKey = 'token'; // unique key.
            // update old users or create a new one.
            let users = [...newUser, ...oldUsers].reduce((acc, cur) => !acc.filter(n => cur[uKey] === n[uKey]).length ? [...acc, cur] : acc, []);
            this.setItem('users', users);
        },
        onAddAttr(val) {
            let newAttr = {token: '', userAttribute: val};
            this.selectedUser ? this.selectedUser.userAttribute = val : this.selectedUser = newAttr;
            this.$refs.token.focus();
        },
        onInputToken(val) {
            let newUser = {token: val, userAttribute: this.selectedUser ? this.selectedUser.userAttribute : 'unknown'};
            let oldUser = this.users.find(user => user.token === val);
            this.selectedUser = oldUser || newUser;
        },
        onRemoveUser(val) {
            this.users.splice(val, 1);
            this.removeItem(this.authKey);
            this.saveUser();
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
        selectedUser: {
            deep: true,
            handler(val) {
                if (val) {
                    this.setItem(this.authKey, val)
                    this.saveUser(val)
                }
            }
        }
    }
}
</script>

<template>
    <table class="w-full text-left table-collapse">
        <thead>
            <tr>
                <th class="border-b border-r border-gray-200 text-xs font-semibold text-gray-700 w-auto"></th>
                <th class="p-2 border-b border-r border-gray-200 text-xs font-semibold text-gray-700 w-1/3">User</th>
                <th class="p-2 b border-b border-gray-200 text-xs font-semibold text-gray-700 w-2/3">Token</th>
            </tr>
        </thead>
        <tbody class="align-baseline">
            <tr @mouseover="activateElmnt(authKey)" @mouseout="activateElmnt(null)">
                <td class="px-4 border-r border-gray-200 text-xs text-gray-800 text-right"></td>
                <td class="p-0 border-r border-gray-200 text-xs text-gray-800">
                    <select-options
                        class="hide-arrow-icon"
                        v-model="selectedUser"
                        openDirection="bottom"
                        tag-placeholder="Add this as new attribute"
                        placeholder="Search or add an attribute"
                        label="userAttribute"
                        select-label="Select user"
                        deselect-label="Remove user"
                        track-by="token"
                        :show-no-results="false"
                        :options="users"
                        :taggable="true"
                        @open="loadUsers"
                        @remove="onRemoveUser"
                        @tag="onAddAttr" />
                </td>
                <td class="pl-2 border-gray-200 text-xs text-gray-800 relative">
                    <input
                        class="appearance-none focus:outline-none w-full bg-transparent"
                        ref="token"
                        type="text"
                        placeholder="Select from user or paste here to create a new one"
                        :value="selectedUser ? selectedUser.token : ''"
                        @input="onInputToken($event.target.value)">

                    <a v-show="elementId===authKey"
                        href="#"
                        title="Refresh users"
                        class="font-bold absolute inset-y-0 right-0 flex items-center pr-3"
                        @click="getUsers">
                        <svg class="h-5 w-5 fill-current text-gray-500 hover:text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M10 3v2a5 5 0 0 0-3.54 8.54l-1.41 1.41A7 7 0 0 1 10 3zm4.95 2.05A7 7 0 0 1 10 17v-2a5 5 0 0 0 3.54-8.54l1.41-1.41zM10 20l-4-4 4-4v8zm0-12V0l4 4-4 4z" />
                        </svg>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</template>
