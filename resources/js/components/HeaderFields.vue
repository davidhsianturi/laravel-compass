<script>
import HeaderFields from './../data/HeaderFields.json';

export default {
    props: ["listId"],

    data() {
        return {
            fields: HeaderFields,
        }
    }
}
</script>

<template>
    <div>
        <datalist :id="listId">
            <slot name="keys" v-if="listId=='keys'">
                <option v-for="(key, index) in fields.keys" :key="index">{{key}}</option>
            </slot>
            <slot name="values" v-if="listId=='values'">
                <option v-for="(value, index) in fields.values" :key="index">{{value}}</option>
            </slot>
        </datalist>
    </div>
</template>
