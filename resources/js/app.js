// Core Application Dependencies...
require('./core/dependencies');

Vue.config.debug = true;

import Dashboard from './components/Dashboard.vue';
import Conference from './components/Conference.vue';
import ConferenceIntroduction from './components/ConferenceIntroduction.vue';

// Global Errors Component...
Vue.component('form-errors', require('./components/FormErrors.vue'));

Vue.mixin({
    methods: {
        // Flatten errors and set them on the given form
        setErrorsOnForm: function (form, errors) {
            if (typeof errors === 'object') {
                form.errors = _.flatten(_.toArray(errors));
            } else {
                form.errors.push('Something went wrong. Please try again.');
            }
        }
    }
});

if (document.getElementById("confomo-app")) {
    new Vue({
        el: '#confomo-app',

        components: {
            Dashboard,
            Conference,
            ConferenceIntroduction
        }
    });
}
