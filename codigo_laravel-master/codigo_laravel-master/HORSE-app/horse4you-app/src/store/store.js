import axios from "axios";
import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({

  state: {
    user: null,
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
      if (user) {

        axios.defaults.headers.common["USER_EMAIL"] = `${user.email}`;
        axios.defaults.headers.common["USER_TOKEN"] = `${user.token}`;
        axios.defaults.headers.common["Authorization"] = `Bearer ${user.token}`;

      }
    },
  }
});