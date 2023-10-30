<template>
  <div>
    <v-dialog
      v-model="value"
      scrollable
      persistent
      fullscreen
    >
      <div
        id="offline"
        class="pattern_dark"
      >
        <v-container>
          <v-row>
            <v-col
              cols="12"
              class="colTeste"
            >
              <div class="infoConfig">
                <img
                  class="brand"
                  src="../../assets/LogoHorse.png"
                  alt=""
                >
                <div class="text-center pt-5 white--text">
                  <h3>Conecte-se à Internet!</h3>
                  <p>Você está off-line. Verifique sua conexão.</p>
                </div>

                <div class="buttonForm">
                  <v-btn
                    class="buttonGray"
                    dark
                    btn-horse
                    @click="retryConnection"
                  >
                    Tentar Novamente
                  </v-btn>
                </div>
              </div>
            </v-col>
          </v-row>
        </v-container>
      </div>
    </v-dialog>
  </div>
</template>

<script>
export default {
  data: () => {
    return {
      value: false,
    };
  },
  methods: {
    retryConnection() {
      window.location.reload();
    },
    loadPage() {
      this.value = true;
    },
  },
};
</script>