export default {
    data() {
        return {
            hoverId: null,
            hoverTimer: null,
        };
    },

    computed: {
        Compass() {
            return Compass;
        }
    },

    methods: {
        /**
         * Show a success message.
         */
        alertSuccess(message, autoClose) {
            this.$root.alert.mode = 'toast';
            this.$root.alert.type = 'success';
            this.$root.alert.message = message;
            this.$root.alert.autoClose = autoClose;
        },

        /**
         * The default entries for form request body.
         */
        newFormRequests() {
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

        /**
         * Filter form request body key/value pair.
         */
        filterFormRequests(entries) {
            let arr = entries.filter(data => data.included == true);

            return arr.reduce((obj, item) => (obj[item.key] = item.value, obj), {});
        },

        /**
         * Append entries value and key to FormData object.
         */
        toFormData(entries) {
            let data = this.filterFormRequests(entries);
            let formData = new FormData();

            for (let pair in data) {
                formData.append(pair, data[pair]);
            }

            return formData;
        },

        /**
         * List of HTTP header key fields
         */
        headerKeyList() {},

        /**
         * List of HTTP header value fields
         */
        headerValueList() {},

        /**
         * The mouseOver and mouseOut event target in element.
         */
        hoverInElement(val) {
            window.clearTimeout(this.hoverTimer);

            this.hoverTimer = window.setTimeout(() => {
                this.hoverId = val;
            }, 100);
        },
    }
};
