<template>
  <section id="categoryHeader">
    <v-container>
      <v-row>
        <v-col cols="12">
          <img
            src="../../assets/LogoHorse.png"
            alt=""
          >
        </v-col>
        <v-col cols="12">
          <h1>{{ title }}</h1>
          <h5>{{ subTitle }}</h5>
        </v-col>
      </v-row>
    </v-container>
  </section>
</template>

<script>
export default {
  data() {
    return {
      title: "Seja bem-vindo!",
      subTitle: "Queremos saber quem é você"
    };
  }
};
</script>