<template>
  <section
    id="secMessagePasswordChanged"
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
          <div class="infoConfig">
            <img
              class="brand"
              src="../../assets/obrigado.png"
              alt=""
            >
          </div>
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
import offline from "../Modals/Offline.vue";
export default {
  components: { offline },
  data() {
    return {
      title: "Senha alterada!",
      subTitle:
        "Bom trabalho! Agora volte a tela inicial para entrar com a nova senha.",
      BtnTextNext: "Voltar a tela inicial",
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
      this.$router.replace("/login");
    },
  },
};
</script>
