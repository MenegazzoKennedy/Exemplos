<template>
  <div id="myFooter">
    <v-container
      class="footer-container"
      fluid
    >
      <v-row>
        <v-col
          cols="12"
          class="nopadding"
        >
          <div class="menu">
            <router-link to="/profile">
              <img
                class="imgIcon"
                src="../../assets/profile.png"
              >
            </router-link>

            <router-link to="/timeline">
              <img
                class="imgIcon"
                src="../../assets/home.png"
              >
            </router-link>

            <router-link to="/new-post">
              <img
                class="imgIcon"
                src="../../assets/post.png"
              >
            </router-link>

            <router-link to="/search">
              <img
                class="imgIcon"
                src="../../assets/search.png"
              >
            </router-link>

            <router-link to="/inbox">
              <img
                class="imgIcon"
                src="../../assets/mail.png"
              >
            </router-link>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  name: "MyFooter",
  data: () => {
    return {};
  },
  computed: {
    ...mapState(["user"]),
    currentPage() {
      return this.$route.path;
    },
  },
};
</script>