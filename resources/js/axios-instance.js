import axios from 'axios';

const instance = axios.create({
    baseURL: Compass.app.base_url
});

instance.interceptors.request.use((config) => {
    config.timing = {
        start: performance.now(),
        end: null,
        duration: 0
    };

    return config;
})

instance.interceptors.response.use((response) => {
    response.config.timing.end = performance.now();
    response.config.timing.duration = response.config.timing.end - response.config.timing.start;

    return response;
})

export default instance;
