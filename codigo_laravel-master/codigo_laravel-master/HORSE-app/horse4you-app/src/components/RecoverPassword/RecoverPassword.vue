<template>
  <section
    id="secRecoverPassword"
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
        <v-col cols="12 inputConfig">
          <label>Email de Recuperação de Senha</label>
          <v-text-field
            v-model="email"
            placeholder="Insira seu Email"
            :rules="emailRules"
            outlined
            dense
          />
          <div class="buttonForm">
            <v-btn
              class="buttonBlue"
              dark
              btn-horse
              :loading="loading"
              @click="btnnext"
            >
              {{ BtnTextNext }}
            </v-btn>
            <v-btn
              class="buttonBlue"
              dark
              btn-horse
              @click="btnGoResetCode"
            >
              {{ BtnTextGoResetCode }}
            </v-btn>
            <v-btn
              class="buttonGray"
              dark
              btn-horse
              @click="btnback"
            >
              {{ BtnTextBack }}
            </v-btn>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </section>
</template>

<script>
import Vue from "vue";
import { showError } from "@/global";
import offline from "../Modals/Offline.vue";

export default {
  components: { offline },
  data() {
    return {
      title: "Seja bem vindo!",
      subTitle: "Insira seus dados abaixo para continuar",
      loading: false,
      BtnTextBack: "Voltar",
      BtnTextNext: "Continuar",
      BtnTextGoResetCode: "Já possuo código de verificação",
      email: "",
      emailRules: [
        (v) => !!v || "O E-mail é obrigatório",
        (v) => /.+@.+\..+/.test(v) || "E-mail precisa ser válido",
      ],
    };
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
    btnnext() {
      this.loading = true;
      this.$http
        .post("/user/forgot-password", {
          email: this.email,
        })
        .then((res) => {
          this.tokenUser = res.data;
          localStorage.setItem("token", res.data);

          Vue.toasted.global.defaultSuccess({
            msg: "Uma chave de segurança sera enviada para seu Email",
          });
          this.loading = false;
          setTimeout(() => this.$router.replace("/recover-code"), 1000);
        })
        .catch((err) => {
          showError(err);
          this.loading = false;
        });
    },
    btnback() {
      this.$router.replace("/login");
    },
    btnGoResetCode() {
      this.$router.replace("/recover-code");
    },
  },
};
</script>

