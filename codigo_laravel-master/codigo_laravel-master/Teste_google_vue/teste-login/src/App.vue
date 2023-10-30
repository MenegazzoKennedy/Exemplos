<template>
  <div id="app">
    <router-view />
    <GoogleLogin :params="params" :onSuccess="success">
      <span>Entrar no google</span>
    </GoogleLogin>
  </div>
</template>
<script>
window.fbAsyncInit = function () {
  FB.init({
    appId: "404204021316578",
    cookie: true,
    xfbml: true,
    version: "v12.0",
  });

  FB.AppEvents.logPageView();
};

(function (d, s, id) {
  var js,
    fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {
    return;
  }
  js = d.createElement(s);
  js.id = id;
  js.src = "https://connect.facebook.net/en_US/sdk.js";
  fjs.parentNode.insertBefore(js, fjs);
})(document, "script", "facebook-jssdk");

function checkLoginState() {
  FB.getLoginStatus(function (response) {
    console.log(response);
  });
}
</script>
         <script>
function onSuccess(googleUser) {
  console.log(googleUser.getAuthResponse(true));
}
function onFailure(error) {
  console.log(error);
}
function renderButton() {
  gapi.signin2.render("my-signin2", {
    scope: "profile email",
    width: 240,
    height: 50,
    longtitle: true,
    theme: "dark",
    onsuccess: onSuccess,
    onfailure: onFailure,
  });
}
</script>

        <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
<script>
import GoogleLogin from "vue-google-login";
export default {
  components: {
    GoogleLogin,
  },
  data: () => ({
    params: {
      client_id:
        "401911218122-qrf3o7hic6mg2h20jukvd0t0cgreu1bg.apps.googleusercontent.com",
      ux_mode: "redirect",
      redirect_uri: "https://dev.maiscode.com.br/horse4u-app-teste",
    },
  }),
  methods: {
    success(googleUser) {
      console.log("estamos aqui tbmmmm");
      console.log(googleUser);
    },
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}
</style>
