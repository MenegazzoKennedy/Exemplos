<template>
  <section
    id="secNewPassword"
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
          <label>{{ subdescriptionPass }}</label>
          <v-text-field
            v-model="passwordNew"
            placeholder="Digite sua nova senha"
            name="password"
            :rules="newpassRules"
            outlined
            dense
            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
            :type="show1 ? 'text' : 'password'"
            @click:append="show1 = !show1"
          />

          <label>{{ subdescriptionConfPass }}</label>
          <v-text-field
            v-model="password_confirmation"
            placeholder="Repita a nova senha"
            name="confPassword"
            :rules="confPassRules.concat(passConfRule)"
            outlined
            dense
            :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
            :type="show2 ? 'text' : 'password'"
            @click:append="show2 = !show2"
          />

          <div class="buttonForm">
            <v-btn
              class="buttonBlue"
              dark
              btn-horse
              @click="btnnext"
            >
              {{ BtnTextNext }}
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
      passwordNew: "",
      password_confirmation: "",
      title: "Seja bem vindo!",
      subTitle:
        "Muito bom! Agora insire a nova senha que vai ser usada a partir de agora.",
      subdescriptionPass: "Nova senha",
      subdescriptionConfPass: "Repitar nova senha",
      BtnTextNext: "Continuar",
      show1: false,
      show2: false,
      newpassRules: [
        (v) => !!v || "A senha é obrigatória",
        (v) =>
          (v && v.length > 5) || "A senha deve conter no minimo 6 caracteres",
      ],
      confPassRules: [(v) => !!v || "A senha é obrigatória"],
      validToken: localStorage.getItem("token"),
      dadosUser: [],
    };
  },
  computed: {
    passConfRule() {
      return (
        this.passwordNew === this.password_confirmation ||
        "As senhas não são iguais"
      );
    },
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
      this.$http
        .post("/user/new-password", {
          password_token: this.validToken,
          password: this.passwordNew,
        })
        .then((res) => {
          this.dadosUser = res.data;
          localStorage.removeItem("token");

          Vue.toasted.global.defaultSuccess({
            msg: "Senha alterada com sucesso!",
          });
          setTimeout(() => this.$router.replace("/message-password"), 1000);
        })
        .catch(showError);
    },
  },
};
</script>

