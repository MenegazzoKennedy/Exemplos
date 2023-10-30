<template>
  <section
    v-if="loadPage = true"
    id="secCategory"
    class="pattern_dark"
  >
    <offline ref="offline" />
    <categoryHeader />
    <optionsCategory :options="options" />
  </section>
  <section v-else>
    <loadPage />
  </section>
</template>

<script>
import { showError } from "@/global";
import Offline from "../Modals/Offline.vue";
import LoadPage from "../Modals/LoadPage.vue";
import CategoryHeader from "./CategoryHeader.vue";
import OptionsCategory from "./OptionsCategory.vue";

export default {
  components: { Offline, CategoryHeader,  OptionsCategory, LoadPage },
  data() {
    return {
      options: [],
      loadPage: false
    };
  },
  mounted() {
    this.getCategories();
  },
  methods: {
    getCategories() {
      var isOnline = navigator.onLine;
      if (!isOnline) {
        this.$refs.offline.loadPage();
      } else {
        this.$http
          .get("/tags", {
            iduser: "register",
          })
          .then((res) => {
            this.options = res.data;
            setTimeout(() => (this.loadPage = true), 1000);
          })
          .catch(showError);
      }
    },
  },
};
</script>