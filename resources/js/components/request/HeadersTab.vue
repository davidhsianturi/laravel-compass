<script>
import DataTable from '../DataTable';

export default {
    inheritAttrs: false,

    components: {
        DataTable
    }
}
</script>

<template>
    <data-table src="header" :content="$attrs.content.headers" />
</template>
