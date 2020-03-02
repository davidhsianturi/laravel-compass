import qs from 'querystring';
import { REQUEST_BODY_OPTIONS } from './constants';

export default {
    data() {
        return {
            elementId: null,
            waitingTime: null,
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
         * Convert entries value and key to Form URL encoded string.
         *
         * @param {Array} entries
         * @param {String}
         */
        toFormUrlEncoded(entries) {
            let data = this.filterFormRequests(entries);
            return qs.stringify(data);
        },

        /**
         * Convert entries value and key to request data based on 'Content-Type'.
         *
         * @param {Array|String} entries
         * @param {String} contentType
         * @return {FormData|String}
         */
        toRequestData(entries, contentType) {
            if (contentType === 'multipart/form-data') return this.toFormData(entries)
            if (contentType === 'application/x-www-form-urlencoded') return this.toFormUrlEncoded(entries)
            return entries
        },

        /**
         * Normalize headers with the given auth.
         *
         * @param {Array} entries
         * @param {Object} auth
         * @return {Object}
         */
        toRequestHeaders(entries, auth) {
            const authInStorage = localStorage.getItem(auth.key);
            const token = authInStorage ? JSON.parse(authInStorage).token : '';
            const authHeader = { Authorization: `${auth.type} ${token}` };
            const headers = this.filterFormRequests(entries);
            return auth.type === 'Bearer' ? { ...headers, ...authHeader } : headers;
        },

        /**
         * The mouseOver/mouseOut event target in element.
         */
        activateElmnt(val) {
            window.clearTimeout(this.waitingTime);

            this.waitingTime = window.setTimeout(() => {
                this.elementId = val;
            }, 100);
        },

        /**
         * Normalize header 'Content-Type' into selected request body option.
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
        },

        /**
         * Encode parameter entries to query string.
         *
         * @param {Array} entries
         * @param {String} uri
         */
        encodeParams(entries, uri) {
            let query = this.toFormUrlEncoded(entries);
            let url = new URL(Compass.app.base_url.concat('/', uri));
            url.search = query;
            let newUri = url.pathname + url.search;

            return decodeURI(newUri).slice(1);
        },

        /**
         * Decode query string to parameter entries.
         *
         * @param {String} query
         */
        decodeParams(query) {
            let newEntry = this.newFormRequests();
            let url = new URL(Compass.app.base_url.concat('/', query));
            let entries = [...url.searchParams.entries()].map(item => (
                { ...newEntry[0], included: true, new: false, key: item[0], value: item[1] }
            ));

            return [...entries, ...newEntry];
        }
    }
};
