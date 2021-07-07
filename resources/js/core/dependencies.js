/*
 * Load Vue & Vue-Resource.
 */
window.Vue = require('vue');

Vue.use(require('vue-resource'));
Vue.http.headers.common['X-CSRF-TOKEN'] = Confomo.csrfToken;

/*
 * Load Underscore.js, used for map / reduce on arrays.
 */
window._ = require('underscore');

require('sweetalert/lib/sweetalert');
