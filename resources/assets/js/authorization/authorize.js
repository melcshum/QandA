// define a method authorize, to call like this
// authorize ('modify', answer)
// it is this convert in to call method in policies.js
// policies.modify(user, answer)
import policies from './policies';

export default {
    install(Vue, options) {
        Vue.prototype.authorize = function (policy, model) {
            if (!window.Auth.signedIn) return false;

            if (typeof policy === 'string' && typeof model === 'object') {
                const user = window.Auth.user;

                return policies[policy](user, model);

            }
        };

        Vue.prototype.signedIn = window.Auth.signedIn;
    }
}
