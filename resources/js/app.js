require('bootstrap/dist/css/bootstrap.min.css');
require('../css/main.css');

import Vue from 'vue';
Vue.component('bsbutton', {
	template: '<input type="button" class="btn btn-primary" value="Hello bootstrap">'
})

new Vue({
    el: '#app',
    data: {

     	message: "Welcome to an awesome app.",
     	title: "Bootstrap Slim", 

    },

    delimiters: ['${', '}'],
});