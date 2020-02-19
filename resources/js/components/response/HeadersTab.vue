<script>
export default {
    props: {
        response: {
            type: Object,
            required: true
        }
    }
}
</script>

<template>
    <table class="w-full text-left table-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border-b border-gray-200 text-xs font-semibold text-gray-700 w-auto"></th>
                <th class="p-2 border-b border-gray-200 text-xs font-semibold text-gray-700 w-1/2">Key</th>
                <th class="p-2 border-b border-gray-200 text-xs font-semibold text-gray-700 w-1/2">Value</th>
            </tr>
        </thead>
        <tbody class="align-baseline">
            <tr v-for="(value, key) in response.headers" :key="key">
                <td class="px-4 border-b border-gray-200 text-xs text-gray-800 text-right"></td>
                <td class="p-2 border-b border-gray-200 text-xs text-gray-800">{{key}}</td>
                <td class="p-2 border-b border-gray-200 text-xs text-gray-800">{{value}}</td>
            </tr>
        </tbody>
    </table>
</template>
