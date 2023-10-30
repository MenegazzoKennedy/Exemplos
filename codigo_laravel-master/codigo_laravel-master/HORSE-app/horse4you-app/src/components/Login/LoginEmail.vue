<template>
  <section
    id="secLoginEmail"
    class="pattern_dark"
  >
    <offline ref="offline" />
    <v-container>
      <v-row>
        <v-col cols="12">
          <img
            class="brand"
            src="../../assets/LogoHorse.png"
            alt=""
          >
        </v-col>
        <v-col cols="12">
          <h1>{{ title }}</h1>
          <h5>{{ subTitle }}</h5>
        </v-col>
        <v-col
          cols="12"
          style="padding-top: 6px"
        >
          <div class="inputConfig">
            <v-text-field
              v-model="user.email"
              label="Email"
              outlined
              dense
              :rules="emailRules"
              required
              @keyup.enter="signin"
              @keyup="lowercase"
            />
            <v-text-field
              v-model="user.password"
              label="Senha"
              outlined
              dense
              name="password"
              :rules="passRules"
              :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
              :type="show ? 'text' : 'password'"
              required
              @keyup.enter="signin"
              @click:append="show = !show"
            />
          </div>
          <div class="toggleConfig">
            <v-switch
              v-model="switch1"
              inset
              color="blue"
            />
            <h5>Lembrar da minha conta</h5>
          </div>
          <div class="buttonForm">
            <v-btn
              class="buttonBlue"
              :loading="loading"
              dark
              btn-horse
              @click="signin"
            >
              {{ BtnTextLogIn }}
            </v-btn>
            <v-btn
              class="buttonOrange"
              dark
              btn-horse
              @click="btnregister"
            >
              {{ BtnTextRegister }}
            </v-btn>
          </div>
          <router-link
            to="/recover-password"
          >
            esqueceu sua senha? <span>Recupera aqui</span>
          </router-link>
        </v-col>
      </v-row>
    </v-container>
  </section>
</template>

<script>
import { userKey, showError } from "@/global";
import offline from "../Modals/Offline.vue";

export default {
  components: { offline },
  data() {
    return {
      user: {
        email: "",
        password: "",
      },
      show: false,
      loading: false,
      title: "Seja bem-vindo!",
      subTitle: "Insira seus dados abaixo para continuar",
      switch1: false,
      BtnTextLogIn: "Log in",
      BtnTextRegister: "Não tem uma conta? Cadastre-se!",
      isChecked: localStorage.getItem("conected"),
      userLogin: localStorage.getItem("app_horse4you"),
      emailRules: [
        (v) => !!v || "O E-mail é obrigatório",
        (v) => /.+@.+\..+/.test(v) || "E-mail precisa ser válido",
      ],
      passRules: [
        (v) => !!v || "A senha é obrigatória",
        (v) =>
          (v && v.length > 5) || "A senha deve conter no minimo 6 caracteres",
      ],
    };
  },
  beforeMount() {
    if (this.isChecked == "true" && this.userLogin) {
      this.$router.push({ path: "/timeline" });
    }
  },
  mounted() {
    this.isOnline();
  },
  methods: {
    isOnline() {
      var isOnline = navigator.onLine;
      if (!isOnline) {
        this.$refs.offline.loadPage();
      }
    },
    lowercase() {
      this.user.email = this.user.email.toLowerCase();
    },
    btnlogin: function () {
      this.$router.replace("/timeline");
    },
    btnregister: function () {
      this.$router.replace("/register");
    },
    signin() {
      this.loading = true;
      setTimeout(() => (this.loading = false), 2000);
      this.$http
        .post("/auth/singin", this.user)
        .then((res) => {
          this.$store.commit("setUser", res.data);
          localStorage.setItem(userKey, JSON.stringify(res.data));
          localStorage.setItem("conected", this.switch1);
          this.user = res.data;
          this.loading = false;
          this.$router.replace("/timeline");
        })
        .catch(showError);
    },
  },
};
</script>
