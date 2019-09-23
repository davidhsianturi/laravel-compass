export default {
    data() {
        return {
            active: null,
            timer: null,
        };
    },

    computed: {
        Compass() {
            return Compass;
        }
    },

    methods: {
        alertSuccess(message, autoClose) {
            this.$root.alert.mode = 'toast';
            this.$root.alert.type = 'success';
            this.$root.alert.message = message;
            this.$root.alert.autoClose = autoClose;
        },

        defaultReqData() {
            return [
                {
                    included: false,
                    key: null,
                    value: null,
                    description: null,
                    new: true,
                    type: 'text',
                },
            ];
        },

        customReqData(input) {
            let arr = input.filter(data => data.included == true);

            return arr.reduce((obj, item) => (obj[item.key] = item.value, obj), {});
        },

        encodeParams(data) {
            return Object.entries(data).map(kv => kv.map(encodeURIComponent).join("=")).join("&");
        },

        activate(val) {
            window.clearTimeout(this.timer);

            this.timer = window.setTimeout(() => {
                this.active = val;
            }, 100);
        },

        deactivate() {
            window.clearTimeout(this.timer);

            this.timer = window.setTimeout(() => {
                this.active = false;
            }, 100);
        }
    }
};
