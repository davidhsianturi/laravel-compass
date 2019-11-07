<script>
export default {
    props: ['response'],

    computed: {
        time () {
            const miliseconds = this.response.config.timing.duration || 0
            let duration = '0 ms'
            if (miliseconds == 0) return duration

            const sizes = [
                { token: 'ms', divisor: 1 },
                { token: 's', divisor: 1000 },
                { token: 'min', divisor: 60 * 1000 }
            ]
            sizes.some((size) => {
                if ((miliseconds / size.divisor) < 1) return true
                duration = `${Math.round(miliseconds / size.divisor, 2)} ${size.token}`

                return false
            })

            return duration
        }
    }
}
</script>

<template>
    <div class="inline-block text-xs py-2 px-1">
        <span class="text-gray-500">Time:</span>
        <span class="text-green-500">{{time}}</span>
    </div>
</template>
