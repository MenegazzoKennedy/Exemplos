<template>
  <section
    id="secSplash"
    class="pattern_dark"
  >
    <v-container>
      <v-row>
        <v-col cols="12">
          <img
            class="brand"
            src="../../assets/LogoHorse.png"
            alt=""
          >
        </v-col>
      </v-row>
    </v-container>
  </section>
</template>

<script>
import { mapState } from "vuex";
export default {
  components: {

  },
  data: () => {
    return {

    };
  },
      
  computed: {
    ...mapState(["user"]),
    currentPage() {
      return this.$route.path;
    },
  },
};
</script>
