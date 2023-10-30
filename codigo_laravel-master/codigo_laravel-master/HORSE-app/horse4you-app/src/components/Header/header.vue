<template>
  <div id="myHeader">
    <v-container
      fluid
      class="header-container"
    >
      <img
        class="brandHeader"
        src="../../assets/LogoHorseHeader.png"
        alt=""
      >
    </v-container>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  name: "MyHeader",
  data: () => ({}),

  computed: {
    ...mapState(["user"]),
    currentPage() {
      return this.$route.path;
    },
  },
};
</script>