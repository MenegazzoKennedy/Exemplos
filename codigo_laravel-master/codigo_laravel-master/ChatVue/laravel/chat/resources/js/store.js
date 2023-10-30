import axios from 'axios'
import Vue from 'vue'
import { compileToFunctions } from 'vue-template-compiler'
import Vuex from 'vuex'

Vue.use(Vuex)
export default new Vuex.Store({
    state: {
        user: {},
    },
    mutations: {
        setUserState: (state, value) => state.user = value
    },
    actions: {
        userStateAction: () => {
            axios.get('api/user').then(response => {
                compileToFunctions('setUserState', response.data.user)
            })
        }
    }
})