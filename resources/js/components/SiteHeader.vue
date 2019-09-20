<script>
export default {
    props: [],

    data() {
        return {
            navIsOpen: false,
        }
    },

    methods: {
        toggleNav() {
            this.navIsOpen = !this.navIsOpen
        },
    }
}
</script>

<template>
    <header class="bg-secondary sm:flex sm:items-center sm:justify-between md:bg-white md:flex-shrink-0">
        <div class="flex justify-between md:border-r sm:shadow-none px-4 py-3 md:w-72 md:bg-secondary md:justify-center md:py-4 md:border-gray-200 md:border-b">
            <div class="flex inline-block">
                <svg class="h-8 w-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36">
                    <circle fill="#F4900C" cx="18" cy="18" r="18" />
                    <circle fill="#FFD983" cx="18" cy="18" r="14.5" />
                    <circle fill="#F5F8FA" cx="18" cy="18" r="13" />
                    <path fill="#CCD6DD" d="M18 8l1.531 6.304 5.54-3.375-3.375 5.54L28 18l-6.304 1.531 3.375 5.54-5.54-3.375L18 28l-1.531-6.304-5.54 3.375 3.375-5.54L8 18l6.304-1.531-3.375-5.54 5.54 3.375z" />
                    <path fill="#292F33" d="M17.343 20.748l8.777 5.381-5.379-8.778z" />
                    <path fill="#DD2E44" d="M18.657 15.267L9.879 9.886l5.38 8.779z" />
                    <circle fill="#8899A6" cx="18" cy="18.008" r="3.055" />
                    <circle fill="#F5F8FA" cx="18" cy="18.008" r="1.648" /></svg>

                <router-link to="/" class="text-xl ml-3 text-gray-800">
                    <strong>Laravel</strong> Compass
                </router-link>
            </div>

            <div class="flex sm:hidden">
                <button @click="toggleNav" type="button" class="px-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-500">
                    <svg class="h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path v-if="navIsOpen" fill-rule="evenodd" clip-rule="evenodd" d="M18.278 16.864a1 1 0 0 1-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 0 1-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 0 1 1.414-1.414l4.829 4.828 4.828-4.828a1 1 0 1 1 1.414 1.414l-4.828 4.829 4.828 4.828z" />
                        <path v-if="!navIsOpen" fill-rule="evenodd" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z" />
                    </svg>
                </button>
            </div>
        </div>

        <nav :class="{'hidden': !navIsOpen, 'block': navIsOpen}" class="sm:flex sm:items-center sm:px-4 md:flex-1 md:justify-between">
            <div class="hidden md:block md:relative md:max-w-xs md:w-full">
                <a v-if="this.$root.title===Compass.app.base_url" :href="Compass.app.base_url" target="_blank" class="pr-4 bg-orange-100 font-mono font-medium text-orange-700 rounded p-2 hover:bg-orange-200">
                    {{Compass.app.base_url}}
                </a>
                <h3 class="text-gray-900 font-semibold" v-else>{{this.$root.title}}</h3>
            </div>

            <div class="sm:flex sm:items-center">
                <div class="px-2 pt-2 pb-5 sm:flex sm:border-b-0 sm:py-0 sm:px-0">
                    <h3 class="block mr-2 px-3 py-1 rounded font-semibold text-gray-900 bg-gray-200 sm:text-sm sm:px-2 uppercase font-mono">
                        {{Compass.app.name}}
                    </h3>
                </div>
                <div class="relative px-5 py-5 sm:py-0 sm:ml-4 sm:px-0">
                    <div class="flex items-center" :title="'LARAVEL v' + Compass.app.laravel_version">
                        <svg class="h-10 w-10 object-cover" viewBox="0 0 50 52" xmlns="http://www.w3.org/2000/svg">
                            <path d="M49.626 11.564a.809.809 0 0 1 .028.209v10.972a.8.8 0 0 1-.402.694l-9.209 5.302V39.25c0 .286-.152.55-.4.694L20.42 51.01c-.044.025-.092.041-.14.058-.018.006-.035.017-.054.022a.805.805 0 0 1-.41 0c-.022-.006-.042-.018-.063-.026-.044-.016-.09-.03-.132-.054L.402 39.944A.801.801 0 0 1 0 39.25V6.334c0-.072.01-.142.028-.21.006-.023.02-.044.028-.067.015-.042.029-.085.051-.124.015-.026.037-.047.055-.071.023-.032.044-.065.071-.093.023-.023.053-.04.079-.06.029-.024.055-.05.088-.069h.001l9.61-5.533a.802.802 0 0 1 .8 0l9.61 5.533h.002c.032.02.059.045.088.068.026.02.055.038.078.06.028.029.048.062.072.094.017.024.04.045.054.071.023.04.036.082.052.124.008.023.022.044.028.068a.809.809 0 0 1 .028.209v20.559l8.008-4.611v-10.51c0-.07.01-.141.028-.208.007-.024.02-.045.028-.068.016-.042.03-.085.052-.124.015-.026.037-.047.054-.071.024-.032.044-.065.072-.093.023-.023.052-.04.078-.06.03-.024.056-.05.088-.069h.001l9.611-5.533a.801.801 0 0 1 .8 0l9.61 5.533c.034.02.06.045.09.068.025.02.054.038.077.06.028.029.048.062.072.094.018.024.04.045.054.071.023.039.036.082.052.124.009.023.022.044.028.068zm-1.574 10.718v-9.124l-3.363 1.936-4.646 2.675v9.124l8.01-4.611zm-9.61 16.505v-9.13l-4.57 2.61-13.05 7.448v9.216l17.62-10.144zM1.602 7.719v31.068L19.22 48.93v-9.214l-9.204-5.209-.003-.002-.004-.002c-.031-.018-.057-.044-.086-.066-.025-.02-.054-.036-.076-.058l-.002-.003c-.026-.025-.044-.056-.066-.084-.02-.027-.044-.05-.06-.078l-.001-.003c-.018-.03-.029-.066-.042-.1-.013-.03-.03-.058-.038-.09v-.001c-.01-.038-.012-.078-.016-.117-.004-.03-.012-.06-.012-.09v-.002-21.481L4.965 9.654 1.602 7.72zm8.81-5.994L2.405 6.334l8.005 4.609 8.006-4.61-8.006-4.608zm4.164 28.764l4.645-2.674V7.719l-3.363 1.936-4.646 2.675v20.096l3.364-1.937zM39.243 7.164l-8.006 4.609 8.006 4.609 8.005-4.61-8.005-4.608zm-.801 10.605l-4.646-2.675-3.363-1.936v9.124l4.645 2.674 3.364 1.937v-9.124zM20.02 38.33l11.743-6.704 5.87-3.35-8-4.606-9.211 5.303-8.395 4.833 7.993 4.524z"
                                fill="#FF2D20"
                                fill-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>
