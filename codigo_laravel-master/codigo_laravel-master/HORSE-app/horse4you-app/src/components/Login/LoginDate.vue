<template>
  <section
    id="secLoginDate"
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
          <h5>{{ subTitleAsk }}</h5>
        </v-col>
        <v-col
          cols="12 inputConfig"
          class="dataInput"
        >
          <v-form v-model="valid">
            <v-menu
              ref="menu"
              v-model="menu"
              :close-on-content-click="false"
              transition="scale-transition"
              offset-y
            >
              <template v-slot:activator="{ on, attrs }">
                <label>Data Aniversario</label>
                <v-text-field
                  v-model="dateFormatted"
                  :rules="requiredRules"
                  placeholder="DD/MM/AAAA"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                />
              </template>
              <v-date-picker
                ref="picker"
                v-model="date"
                color="#EE6C4D"
                font-size="20px"
                locale="pt-br"
                :show-current="true"
                full-width
                :max="new Date().toISOString().substr(0, 10)"
                min="1950-01-01"
                @change="save"
                @input="menu = false"
              />
            </v-menu>
          </v-form>
          <div class="buttonForm">
            <v-btn
              class="buttonBlue"
              dark
              btn-horse
              :disabled="!valid"
              @click="moment"
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
import moment from "moment";
import offline from "../Modals/Offline.vue";

export default {
  components: { offline },
  data: (vm) => ({
    date: new Date().toISOString().substr(0, 10),
    dateFormatted: vm.formatDate(),
    nascimento: localStorage.getItem("dataNasc"),
    menu: false,
    valid: true,
    requiredRules: [(v) => !!v || "Data de inicio é obrigatoria"],
    title: "Seja bem-vindo!",
    subTitle: "Insira sua data de nascimento para continuar",
    subTitleAsk: "Você é maior de 14 anos?",
    BtnTextNext: "Continuar",
  }),
  watch: {
    date() {
      this.dateFormatted = this.formatDate(this.date);
    },
    menu(val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
    },
  },
  beforeMount() {
    if (this.nascimento) {
      this.$router.push({ path: "/login" });
    }
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
    save(date) {
      this.$refs.menu.save(date);
    },
    formatDate(date) {
      if (!date) return null;

      const [year, month, day] = date.split("-");
      return `${day}/${month}/${year}`;
    },
    moment() {
      var birthDate = this.date.split("-");
      let birthday = moment(moment.now()).diff(
        moment(birthDate[2] + birthDate[1] + birthDate[0], "DD.MM.YYYY"),
        "years"
      );
      if (birthday > 14) {
        this.$router.push({ path: "/login" });
        localStorage.removeItem("menorIdade");
        localStorage.setItem("dataNasc", this.date);
      } else {
        this.$router.push({ path: "/login" });
        localStorage.setItem("menorIdade", "true");
        localStorage.setItem("dataNasc", this.date);
      }
    },
  },
};
</script>

