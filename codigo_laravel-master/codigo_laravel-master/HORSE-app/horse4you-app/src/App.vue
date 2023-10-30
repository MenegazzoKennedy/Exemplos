<template>
  <div id="app">
    <offline ref="offline" />
    <v-app id="inspire">
      <router-view />
    </v-app>
  </div>
</template>

<script>
import { mapState } from "vuex";
import { userKey } from "@/global";
import offline from "./components/Modals/Offline.vue";

export default {
  components: { offline },
  data() {
    return {
      validatingToken: true,
    };
  },
  computed: mapState(["user"]),
  mounted() {
    this.isOnline();
  },
  created() {
    this.validateToken();
  },
  methods: {
    isOnline() {
      var isOnline = navigator.onLine;
      if (!isOnline) {
        this.$refs.offline.loadPage();
      }
    },
    async validateToken() {
      this.validatingToken = true;

      const json = localStorage.getItem(userKey);
      const userData = JSON.parse(json);
      this.$store.commit("setUser", null);

      if (!userData) {
        this.validatingToken = false;
        this.$router.push({ path: "/" });
        return;
      }

      if (userData) {
        this.$store.commit("setUser", userData);
      } else {
        localStorage.removeItem(userKey);
        this.$router.push({ path: "/" });
      }

      this.validatingToken = false;
    },
    logout() {
      localStorage.removeItem(userKey);
      this.$store.commit("setUser", null);
      this.$router.push({ path: "/login" });
    },
  },
};
</script>


<style scoped>
@import "../src/css/stylesheet.css";
@import "../src/css/stylesheet2.css";
@import "../src/css/stylesheet3.css";
</style>
