<script>
export default {
    inheritAttrs: false
}
</script>

<template>
    <div class="px-4 py-3 border-t border-b border-secondary">
        <input
            class="text-gray-700 font-semibold text-md appearance-none focus:outline-none w-full"
            type="text"
            :value="$attrs.title"
            @input="$emit('update:title', $event.target.value)">

        <textarea
            class="text-gray-500 font-normal text-md italic appearance-none focus:outline-none w-full"
            placeholder="No description available"
            :value="$attrs.description"
            @input="$emit('update:description', $event.target.value)"></textarea>
    </div>
</template>
