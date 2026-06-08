import axios from 'axios';
(window as any).axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
