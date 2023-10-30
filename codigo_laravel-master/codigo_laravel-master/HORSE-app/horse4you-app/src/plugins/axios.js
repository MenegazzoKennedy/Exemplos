import Vue from "vue";
import axios from "axios";

axios.defaults.baseURL = "https://dev.maiscode.com.br/horse4u-crm/api";
// axios.defaults.baseURL = "http://127.0.0.1:8000/api";
//axios.defaults.baseURL = "https://api.app.horse4ubrasil.com.br/api";
axios.defaults.headers.common["Content-Type"] = "application/json";
axios.defaults.headers.common["Accept"] = "application/json";

Vue.use({
  install(Vue) {
    Vue.prototype.$http = axios;
  }
});