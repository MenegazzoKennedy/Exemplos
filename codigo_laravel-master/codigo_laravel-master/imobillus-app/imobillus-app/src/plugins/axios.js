import Vue from 'vue'
import axios from 'axios'

axios.defaults.baseURL = 'https://dev.maiscode.com.br/imobl-crm/api'
axios.defaults.headers.common['Content-Type'] = 'application/json; charset=utf-8'
// axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*'

Vue.use({
    install(Vue) {
        Vue.prototype.$http = axios
    }
})