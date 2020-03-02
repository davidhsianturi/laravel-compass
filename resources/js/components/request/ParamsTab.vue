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
    <data-table src="params" :content="$attrs.content.params" />
</template>
