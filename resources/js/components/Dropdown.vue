<script>
export default {
    data() {
        return {
            isOpen: false,
        }
    },

    methods: {
        toggle() {
            this.isOpen = !this.isOpen
        },
    },
}
</script>

<template>
    <div class="relative">
        <button @click="toggle" type="button" class="block focus:outline-none">
            <slot name="trigger" :isOpen="isOpen"></slot>
        </button>
        <div :class="[isOpen ? 'block' : 'hidden']">
            <button @click="isOpen = false" type="button" class="z-30 block fixed inset-0 w-full h-full cursor-default"></button>
            <div class="absolute z-40 right-0">
                <slot name="lists"></slot>
            </div>
        </div>
    </div>
</template>
