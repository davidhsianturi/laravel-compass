import { REQUEST_BODY_OPTIONS } from './constants';

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
         * The mouseOver and mouseOut event target in element.
         */
        hoverInElement(val) {
            window.clearTimeout(this.hoverTimer);

            this.hoverTimer = window.setTimeout(() => {
                this.hoverId = val;
            }, 100);
        },

        /**
         * Truncate the given string.
         *
         * src: https: //gist.github.com/DylanAttal/13716cfd9272e92a544ddddde221eab1
         */
        truncateString(str, num) {
            if (str.length <= num) {
                return str
            }

            return str.slice(0, num) + '...'
        },
        
        /**
         * Normalize header 'Content-Type' into selected request body option
         *
         * @param {String} contentType 
         * @return {Object}
         */
        normalizeContentType(contentType) {
            let bodyOption = { value: 'none', rawOption: 'text' }
            if (!contentType) return bodyOption

            let option = REQUEST_BODY_OPTIONS.find(opt => opt.value === contentType)
            bodyOption.value = option ? option.key : 'raw'

            if (bodyOption.value === 'raw') {
                option = REQUEST_BODY_OPTIONS.find(opt => opt.key === 'raw')
                const rawOption = option.options.find(opt => opt.value === contentType)
                bodyOption.rawOption = rawOption ? rawOption.key : 'text'
            }

            return bodyOption
        }
    }
};
