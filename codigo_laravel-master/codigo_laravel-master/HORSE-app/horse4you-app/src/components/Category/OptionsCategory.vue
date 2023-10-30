<template>
  <section id="optionsCategory">
    <v-container>
      <v-row>
        <v-col
          cols="12"
          style="margin-top: 25px; padding-bottom: inherit"
        >
          <div class="checkBox">
            <span
              v-for="(category, i) in options"
              :key="i"
            >
              <label>
                <input
                  v-model="categoriesSelected"
                  type="checkbox"
                  class="chk-btn"
                  :value="category.id"
                >
                <span>#{{ category.tag }}</span>
              </label>
            </span>
          </div>
        </v-col>
      </v-row>
    </v-container>
    <buttonsCategory :selecteds="categoriesSelected" />
  </section>
</template>

<script>
import ButtonsCategory from "./ButtonsCategory.vue";
export default {
  components: {ButtonsCategory},
  props: {
    options: {
      type: Array,
      default: null,
    }
  },
  data() {
    return {
      categoriesSelected: [],
    };
  },
  watch: {
    categoriesSelected() {
      localStorage.setItem("selecteds", JSON.stringify(this.categoriesSelected));
    }
  }
};
</script>