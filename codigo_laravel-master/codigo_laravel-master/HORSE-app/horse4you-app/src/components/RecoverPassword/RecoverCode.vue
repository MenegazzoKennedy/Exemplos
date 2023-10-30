<template>
  <section
    id="secRecoverCode"
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
          <label>Código de recuperação</label>
          <v-text-field
            v-model="validToken"
            placeholder="Insira o código recebido"
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
      subTitle:
        "Você recebera um Email com o código de recuperação em instantes.",
      loading: false,
      BtnTextBack: "Voltar",
      BtnTextNext: "Continuar",
      email: "",
      validToken: "",
      tokenUser: "",

      token: localStorage.getItem("token"),
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
        .post("/user/reset-password-token", {
          password_reset_code: this.validToken,
        })
        .then((res) => {
          this.tokenUser = res.data;
          localStorage.setItem("token", this.tokenUser.token);

          Vue.toasted.global.defaultSuccess({
            msg: "Chave validada com sucesso!",
          });
          this.loading = false;
          setTimeout(() => this.$router.replace("/new-password"), 1000);
        })
        .catch((err) => {
          showError(err);
          this.loading = false;
        });
    },
    btnback() {
      this.$router.replace("/recover-password");
    },
  },
};
</script>
