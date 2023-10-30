import Vue from "vue";
import router from "./route";

export const userKey = "app_horse4you";
//export const BASE_URL_STAGING = "https://api.app.horse4ubrasil.com.br/api";
export const BASE_URL_STAGING = "https://dev.maiscode.com.br/horse4u-crm/api";
// export const BASE_URL_STAGING = "http://127.0.0.1:8000/api";
export const BASE_URL_PROD = "";

export function showError(e) {
  if (e.response.status == 401) {
    localStorage.removeItem("app_horse4you");
    localStorage.removeItem("conected");
    setTimeout(() => (
      router.push({ path: "/login" })
    ), 1000);
  }
  if (e.response.status == 422) {
    var i;
    var chaves = Object.keys(e.response.data.errors);

    for (i of chaves) {
      Vue.toasted.global.defaultError({ errors: e.response.data.errors[i] });
    }
  } else if (e && e.response && e.response.data) {
    Vue.toasted.global.defaultError({ errors: e.response.data.errors });
  } else if (typeof e === "string") {
    Vue.toasted.global.defaultError({ errors: e });
  } else {
    Vue.toasted.global.defaultError();
  }
}

Vue.mixin({
  methods: {
    validateUser() {
      this.$http.get("/auth/me")
        .then(res => {
          this.$store.commit("setUser", res.data);
          localStorage.setItem(userKey, JSON.stringify(res.data));
        });
    }
  }
});

export default { BASE_URL_STAGING, BASE_URL_PROD, userKey, showError };