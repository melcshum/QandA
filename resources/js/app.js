/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('./fontawesome');

window.Vue = require('vue');

import VueIziToast from 'vue-izitoast';
import 'izitoast/dist/css/iziToast.min.css';
Vue.use(VueIziToast);

import Authorization from './authorization/authorize';
Vue.use(Authorization);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// Vue.component('user-info', require('./components/UserInfo.vue'));
// Vue.component('answer', require('./components/Answer.vue'));
// Vue.component('favorite', require('./components/Favorite.vue'));
// Vue.component('accept', require('./components/Accept.vue'));
//  Vue.component('vote', require('./components/Vote.vue'));
// Vue.component('answers', require('./components/Answers.vue'));
// Vue.component('question', require('./components/Question.vue'));
 Vue.component('question-page', require('./pages/QuestionPage.vue').default);



const app = new Vue({
    el: '#app'
});
