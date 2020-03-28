<script>
export default {
    props: ['mode', 'type', 'message', 'autoClose', 'confirmationCancel', 'confirmationProceed'],

    data() {
        return {
            timeout: null,
        }
    },

    mounted() {
        if (this.autoClose) {
            this.timeout = setTimeout(() => {
                this.close();
            }, this.autoClose);
        }
    },

    methods: {
        close() {
            clearTimeout(this.timeout);

            this.$root.alert.mode = null;
            this.$root.alert.type = null;
            this.$root.alert.message = '';
            this.$root.alert.autoClose = false;
            this.$root.alert.confirmationCancel = null;
            this.$root.alert.confirmationProceed = null;
        },
        confirm() {
            this.confirmationProceed();
            this.close();
        },
        cancel() {
            this.confirmationCancel
                ? this.confirmationCancel()
                : this.close();
        }
    }
}
</script>

<template>
    <transition name="modal" v-show="$root.alert.mode">
        <div id="toast" v-if="mode=='toast'">
            <div v-if="type=='success'" class="bg-green-100 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{message}}</span>
                <span v-if="!autoClose" class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="close">
                    <svg class="fill-current h-6 w-6 text-blue-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
            </div>
        </div>

        <div v-if="mode=='dialog'" class="modal-mask z-50 fixed inset-0 overflow-y-auto">
            <div class="modal-container text-sm bg-white outline-none my-10 py-8 px-5 max-w-xs mx-auto shadow" aria-modal="true" tabindex="-1" style="border-radius: 14px;">
                <div class="text-center mb-8 font-semibold text-gray-700">
                    <span>{{message}}</span>
                </div>

                <div class="flex justify-evenly">
                    <button
                        v-if="type=='confirmation'"
                        class="w-full mr-1 py-2 px-4 rounded-full text-gray-600 font-semibold bg-gray-100 rounded-full hover:bg-gray-200 focus:outline-none"
                        type="button"
                        @click="cancel">Never mind</button>
                    <button
                        v-if="type=='confirmation'"
                        class="w-full ml-1 py-2 px-4 rounded-full text-primary font-semibold bg-primary-light rounded-full hover:bg-primary-light focus:outline-none"
                        type="button"
                        @click="confirm">Yes</button>
                    <button
                        v-if="type=='error'"
                        class="w-full py-2 px-4 rounded-full text-primary font-semibold bg-primary-light rounded-full hover:bg-primary-light focus:outline-none"
                        type="button"
                        @click="close">Got it!</button>
                </div>
            </div>
        </div>
    </transition>
</template>

<style scoped>
    #toast {
        position: fixed;
        z-index: 9998;
        bottom: 20px;
        right: 10px;
    }
</style>
