import axios from 'axios';

axios.interceptors.request.use(config => {
    config.headers['X-Requested-With'] = 'XMLHttpRequest';
    config.headers['Accept'] = 'application/json';
    return config;
});

window.axios = axios;
export default window.axios;
