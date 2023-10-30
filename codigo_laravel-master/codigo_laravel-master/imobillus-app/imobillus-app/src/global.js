import Vue from 'vue'
import router from './route';

export const userKey = 'imobillus_user'
export const BASE_URL_STAGING = 'https://dev.maiscode.com.br/imobl-crm/api'
export const BASE_URL_PROD = ''

export function showError(e) {
    if (e.response.status == 401) {
        localStorage.removeItem('imobillus_user');
        localStorage.setItem(userKey, JSON.stringify(null))
        setTimeout(() => (
            router.push({ path: '/' })
        ), 1000)
    }
    if (e.response.status == 422) {
        var i;
        var chaves = Object.keys(e.response.data.errors);

        for (i of chaves) {
            Vue.toasted.global.defaultError({ errors: e.response.data.errors[i] })
        }
    } else if (e && e.response && e.response.data) {
        Vue.toasted.global.defaultError({ errors: e.response.data.errors })
    } else if (typeof e === 'string') {
        Vue.toasted.global.defaultError({ errors: e })
    } else {
        Vue.toasted.global.defaultError()
    }
}

// Vue.mixin({
//     methods: {
//         validateUser() {
//             this.$http.get('/users/me')
//                 .then(res => {
//                     this.$store.commit('setUser', res.data)
//                     localStorage.setItem(userKey, JSON.stringify(res.data))
//                 })
//         }       
//     }
// });

export default { BASE_URL_STAGING, BASE_URL_PROD, userKey, showError }