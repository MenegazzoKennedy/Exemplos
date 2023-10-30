import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import router from './route'
import store from './store/store'

import VueClipboard from 'vue-clipboard2'

import './plugins/axios'
import './config/msgs'
import Toasted from 'vue-toasted'
import GSignInButton from 'vue-google-signin-button'
import VueSocialSharing from 'vue-social-sharing'
import VueMask from 'v-mask'

import VueSlickCarousel from 'vue-slick-carousel'

import 'vue-slick-carousel/dist/vue-slick-carousel.css'
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

Vue.component('VueSlickCarousel', VueSlickCarousel)

Vue.use(VueSocialSharing)
Vue.use(Toasted)
Vue.use(GSignInButton)
Vue.use(VueClipboard)
Vue.use(VueMask)

Vue.config.productionTip = false

new Vue({
  vuetify,
  router,
  store,
  GSignInButton,
  render: h => h(App)
}).$mount('#app')