<script>
export default {
    data() {
        return {
            fileName: 'Select file',
        }
    },

    methods: {
        onChange(e) {
            if (!e.target.files.length) return;

            let selectedFile = e.target.files[0];

            this.fileName = selectedFile.name;

            this.$emit('input', selectedFile);
        },
    }
}
</script>

<template>
    <div>
        <div slot="picker">
            <label for="compassFile" class="w-auto py-1 px-1 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded cursor-pointer">
                {{fileName}}
            </label>
        </div>

        <input
            id="compassFile"
            type="file"
            ref="file"
            class="hidden"
            @change="onChange">
    </div>
</template>
