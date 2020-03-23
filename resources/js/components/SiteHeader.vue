<template>
    <header class="sm:flex sm:items-center sm:justify-between lg:bg-white lg:flex-shrink-0">
        <div class="flex border-secondary px-3 py-3 lg:w-64 lg:border-r">
            <router-link to="/" class="flex items-center text-xl text-gray-900">
                <svg class="h-8 w-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36">
                    <circle fill="#F75858" cx="18" cy="18" r="14.5" />
                    <path fill="#FFFFFF" d="M17.343 20.748l8.777 5.381-5.379-8.778z" />
                    <path fill="#FFFFFF" d="M18.657 15.267L9.879 9.886l5.38 8.779z" />
                    <circle fill="#FFFFFF" cx="18" cy="18.008" r="3.055" />
                    <circle fill="#F75858" cx="18" cy="18.008" r="1.648" />
                </svg>
                <span class="ml-3">
                    <strong>Laravel</strong> Compass
                </span>
            </router-link>
        </div>

        <nav class="hidden sm:flex sm:items-center sm:px-4 lg:flex-1 lg:justify-between">
            <div class="hidden lg:block lg:relative lg:max-w-xs lg:w-full">
                <a v-if="this.$root.requestTitle===Compass.app.base_url" :href="Compass.app.base_url" target="_blank" class="py-2 px-4 font-mono text-xs font-medium bg-light text-primary rounded-full">
                    {{Compass.app.base_url}}
                </a>
                <h3 class="text-gray-700 font-semibold" v-else>
                    <span class="font-bold text-xs text-gray-500" :class="this.$root.requestIsExample ? '' : 'hidden'">e.g.</span>{{this.$root.requestTitle}}
                </h3>
            </div>

            <div class="sm:flex sm:items-center">
                <h3 class="block py-1 rounded font-bold text-gray-700 sm:text-sm sm:px-2 uppercase">
                    {{Compass.app.name}}
                </h3>
            </div>
        </nav>
    </header>
</template>
