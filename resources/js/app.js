import Vue from 'vue'
import UserProfile from './components/user/ProfileComponent' // User profile component
import Login from './components/auth/LoginComponent' // Login component
import Register from './components/auth/RegisterComponent' //Registration component
import Search from './components/shop/SearchComponent' //Searchbar
import OfferImages from './components/admin/OfferImagesComponent' // Image uploado component
import Scrapper from './components/admin/ScrapperComponent' // Scrapperio komponentas
require('./helpers/lazyload');

Vue.directive('click-outside', {
  bind: function (el, binding, vnode) {
    el.clickOutsideEvent = function (event) {
      if (!(el == event.target || el.contains(event.target))) {
        vnode.context[binding.expression](event);
      }
    };
    document.body.addEventListener('click', el.clickOutsideEvent)
  },
  unbind: function (el) {
    document.body.removeEventListener('click', el.clickOutsideEvent)
  },
});

let app = new Vue({
    components : { 'app-search' : Search,
    UserProfile, 
    'app-login':Login, 
    'app-registraion':Register,
    'app-images' : OfferImages,
    'app-scrapper' : Scrapper
  }
}).$mount('#app')
