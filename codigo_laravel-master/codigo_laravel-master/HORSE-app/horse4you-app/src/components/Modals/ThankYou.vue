<template>
  <section
    id="secThankYou"
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
        <v-col cols="12">
          <img
            class="thankYou"
            src="../../assets/obrigado.png"
            alt=""
          >
          <div class="buttonForm">
            <v-btn
              class="buttonBlue"
              dark
              btn-horse
              @click="btnNext"
            >
              {{ BtnTextNext }}
            </v-btn>
            <v-btn
              class="buttonGray"
              dark
              btn-horse
              @click="btnBack"
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
import offline from "./Offline.vue";
export default {
  components: { offline },
  data: () => ({
    title: "Obrigado!",
    subTitle: "Você agora faz parte da Horse4u.Seja bem vindo :)",
    BtnTextNext: "Continuar para a timeline",
    BtnTextBack: "Voltar para login",
  }),
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
    btnNext: function () {
      this.$router.replace("/timeline");
    },
    btnBack: function () {
      this.$router.replace("/login");
    },
  },
};
</script>

