import Vue from "vue";
import App from "./App.vue";
import vuetify from "./plugins/vuetify";
import router from "./route";
import "./plugins/axios";
import "./config/msgs";
import store from "./store/store";
import VueClipboard from "vue-clipboard2";
import Toasted from "vue-toasted";
import VueChatScroll from "vue-chat-scroll";
import "@morioh/v-lightbox/dist/lightbox.css";
import Lightbox from "@morioh/v-lightbox";
import VueMask from "v-mask";
//import Echo from "laravel-echo";

// window.Pusher = require("pusher-js");

// window.Echo = new Echo({
//   broadcaster: "pusher",
//   key: process.env.VUE_APP_WEBSOCKETS_KEY,
//   wsHost: process.env.VUE_APP_WEBSOCKETS_SERVER,
//   wsPort: 6001,
//   wssPort: 6001,
//   forceTLS: false,
//   disableStats: true
// });

Vue.use(Lightbox);
Vue.use(VueClipboard);
Vue.use(Toasted);
Vue.use(VueMask);
Vue.use(VueChatScroll);

Vue.config.productionTip = false;

new Vue({
  vuetify,
  router,
  store,
  render: h => h(App)
}).$mount("#app");
