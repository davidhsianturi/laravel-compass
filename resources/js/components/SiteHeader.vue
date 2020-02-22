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
    <header class="sm:flex sm:items-center sm:justify-between md:bg-white md:flex-shrink-0">
        <div class="flex justify-between md:border-r border-gray-200 sm:shadow-none px-4 py-3 md:w-72 md:py-3">
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
                <a v-if="this.$root.requestTitle===Compass.app.base_url" :href="Compass.app.base_url" target="_blank" class="pr-4 font-mono font-semibold text-orange-700 rounded p-2 hover:bg-orange-200">
                    {{Compass.app.base_url}}
                </a>
                <h3 class="text-gray-700 font-semibold" v-else>
                    <span class="font-bold text-xs text-gray-500" :class="this.$root.requestIsExample ? '' : 'hidden'">e.g.</span>{{this.$root.requestTitle}}
                </h3>
            </div>

            <div class="sm:flex sm:items-center">
                <div class="sm:flex sm:border-b-0 sm:py-0 sm:px-0">
                    <h3 class="block py-1 rounded font-bold text-gray-700 border-b-4 border-gray-300 sm:text-sm sm:px-2 uppercase">
                        {{Compass.app.name}}
                    </h3>
                </div>
            </div>
        </nav>
    </header>
</template>
