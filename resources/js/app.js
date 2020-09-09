import Vue from 'vue'
import UserProfile from './components/user/ProfileComponent' // User profile component
import Login from './components/auth/LoginComponent' // Login component
import Register from './components/auth/RegisterComponent' //Registration component
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
    components : { UserProfile, 'app-login':Login, 'app-registraion':Register }
}).$mount('#app')
