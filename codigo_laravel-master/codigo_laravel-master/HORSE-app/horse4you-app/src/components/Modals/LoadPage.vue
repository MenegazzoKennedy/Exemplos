<template>
  <section id="loadPage">
    <myHeader />
    <v-progress-circular
      color="primary"
      class="mx-auto d-block mt-2"
      indeterminate
    />
    <myFooter />
  </section>
</template>

<script>
import myHeader from "../Header/header.vue";
import myFooter from "../Footer/footer.vue";
export default {
  components: {myHeader, myFooter},
};
</script>