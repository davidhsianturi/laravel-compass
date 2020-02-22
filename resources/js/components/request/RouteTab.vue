<script>
export default {
    inheritAttrs: false
}
</script>

<template>
    <table class="w-full text-left table-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-4 border-b border-gray-200 text-xs font-semibold text-gray-700 w-auto"></th>
                <th class="p-2 border-b border-gray-200 text-xs font-semibold text-gray-700 w-1/5">Key</th>
                <th class="p-2 border-b border-gray-200 text-xs font-semibold text-gray-700 w-4/5">Value</th>
            </tr>
        </thead>
        <tbody class="align-baseline">
            <tr v-for="(value, key) in $attrs.info" :key="key">
                <td class="border-b border-gray-200 text-xs text-gray-800 text-center">
                    <input type="checkbox" :checked="true" disabled>
                </td>
                <td class="p-2 border-b border-gray-200 text-xs text-gray-800 capitalize">
                    {{key}}
                </td>
                <td class="p-2 border-b border-gray-200 text-xs text-gray-800">
                    {{key === 'methods' ? value.join(" | ") : value || '...'}}
                </td>
            </tr>
        </tbody>
    </table>
</template>
