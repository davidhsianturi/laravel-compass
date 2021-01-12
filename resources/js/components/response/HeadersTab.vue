<script>
export default {
    inheritAttrs: false
}
</script>

<template>
    <table class="w-full text-left table-collapse">
        <thead>
            <tr class="text-xs font-semibold text-gray-700 bg-secondary">
                <th class="p-4 w-auto"></th>
                <th class="p-2 w-1/3">Key</th>
                <th class="p-2 w-2/3">Value</th>
            </tr>
        </thead>
        <tbody class="align-baseline">
            <tr v-for="(value, key) in $attrs.headers" :key="key">
                <td class="px-4 border-b border-secondary text-xs text-gray-800"></td>
                <td class="p-2 border-b border-secondary text-xs text-gray-800">{{key}}</td>
                <td class="p-2 border-b border-secondary text-xs text-gray-800">{{value}}</td>
            </tr>
        </tbody>
    </table>
</template>
