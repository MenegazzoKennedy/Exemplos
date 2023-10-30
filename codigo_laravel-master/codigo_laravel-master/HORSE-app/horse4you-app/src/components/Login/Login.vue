<template>
  <section
    id="secLogin"
    class="pattern_dark"
  >
    <offline ref="offline" />
    <v-container>
      <v-row>
        <v-col
          cols="12"
          style="padding-top: 23px; padding-bottom: 34px"
        >
          <img
            class="brand"
            src="../../assets/LogoHorse.png"
            alt=""
          >
        </v-col>
        <v-col
          cols="12"
          style="padding-bottom: inherit"
        >
          <h1>Seja bem-vindo!</h1>
          <h5>Insira seus dados abaixo para continuar</h5>
        </v-col>
        <v-col
          cols="12"
          class="buttonForm"
        >
          <v-btn
            class="buttonBlue"
            dark
            btn-hors
            @click="loginWithEmail"
          >
            Entrar com e-Mail
          </v-btn>
          <v-btn
            class="buttonBlue d-none"
            dark
            btn-horse
            @click="AuthProvider('facebook')"
          >
            Entrar com Facebook
          </v-btn>
          <v-btn
            class="buttonBlue d-none"
            dark
            btn-hors
            @click="loginGoogle()"
          >
            Entrar com Google
          </v-btn>
          <div class="buttonRegister">
            <v-btn
              class="buttonOrange"
              dark
              btn-horse
              @click="btnRegister"
            >
              Não tem uma conta? Cadastre-se!
            </v-btn>
          </div>
          <div class="linkRecoverPassword">
            <router-link
              to="/recover-password"
            >
              esqueceu sua senha?

              <GoogleLogin :params="params" :renderParams="renderParams" :onSuccess="onSuccess" :onFailure="onFailure"></GoogleLogin>

<div id="my-signin2"></div>


              <span class="font-weight-bold">Recupera aqui</span>
            </router-link>
          </div>
        </v-col>
      </v-row>
    </v-container>

    

  </section>
</template>

<script>
import offline from "../Modals/Offline.vue";
import GoogleLogin from "vue-google-login";

export default {
  name: "FacebookLogin",
  components: { offline, GoogleLogin },
  data() {
    return {
      isChecked: localStorage.getItem("conected"),
      userLogin: localStorage.getItem("app_horse4you"),
      params: {
        client_id: "140761380904-870c8l42hi4fc2k026ai6lmmc1ecran7.apps.googleusercontent.com"
      },
      renderParams: {
        width: 250,
        height: 50,
        longtitle: true,
      }
    };
  },
  beforeMount() {
    if (this.isChecked == "true" && this.userLogin) {
      this.$router.push({ path: "/timeline" });
    }
  },
  methods: {
    isOnline() {
      var isOnline = navigator.onLine;
      if (!isOnline) {
        this.$refs.offline.loadPage();
      }
    },
    onSuccess(googleUser) {
      console.log(googleUser);
      // This only gets the user information: id, name, imageUrl and email
      console.log(googleUser.getBasicProfile());
      console.log(googleUser.getAuthResponse(true));
    },
    onFailure(error) {
      console.log(error);
    },

    /* MÉTODO PARA FAZER LOGIN PELO GOOGLE, EM PRODUÇÃO.
    async loginGoogle() {
      const googleUser = await this.$gAuth.signIn();
      console.log("google user: ", googleUser);
      console.log("get id: ", googleUser.getId());
      console.log("get base profile: ", googleUser.getBasicProfile());
      console.log("get auth response: ", googleUser.getAuthResponse());
      console.log("get auth response$G", this.$gAuth.GoogleAuth.currentUser.get().getAuthResponse());
    },*/
    /* MÉTODO AUTH PROVIDER PARA TENTATIVA DE LOGIN SOCIAL, TESTES.
    AuthProvider(provider) {
      var self = this;

      this.$auth
        .authenticate(provider)
        .then((response) => {
          console.log("AuthProvider");
          console.log(response);
          self.SocialLogin(provider, response);
        })
        .catch((err) => {
          console.log({ err: err });
        });
    },*/

    /* MÉTODO SOCIAL LOGIN DE TESTES PARA LOGIN COM GOOGLE.
    SocialLogin(provider, response) {
      this.$http
        .post("/sociallogin/" + provider, response)
        .then((response) => {
          console.log("social login");
          console.log(response.data);
        })
        .catch((err) => {
          console.log({ err: err });
        });
    },*/
    loginWithEmail: function () {
      this.$router.replace("/loginemail");
    },
    btnRegister: function () {
      this.$router.replace("/register");
    },
  },
};
</script>


