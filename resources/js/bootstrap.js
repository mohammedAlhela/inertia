window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

if (process.env.NODE_ENV == 'development') {
    window.axios.defaults.baseURL = 'http://127.0.0.1:8000'
}
if (process.env.NODE_ENV == 'production') {
    window.axios.defaults.baseURL = 'https://electronic.istanbuliat.store'
 }
