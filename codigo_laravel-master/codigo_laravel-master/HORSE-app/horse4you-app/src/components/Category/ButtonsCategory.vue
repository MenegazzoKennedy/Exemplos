<template>
  <section id="buttonsCategory">
    <v-container>
      <v-row>
        <v-col cols="12">
          <div class="buttonForm">
            <v-btn
              class="buttonBlue"
              dark
              btn-horse
              @click="signup"
            >
              Continuar
            </v-btn>
            <v-btn
              class="buttonGray"
              dark
              btn-horse
              @click="btnBack"
            >
              Voltar
            </v-btn>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </section>
</template>

<script>
import { userKey, showError } from "@/global";
export default {
  props: {
    selecteds: {
      type: Array,
      default: null
    }
  },
  data() {
    return {
      user: localStorage.getItem("userInf"),
    };
  },
  methods: {
    signup() {
      let infUser = JSON.parse(this.user);
      this.loading = true;
      this.$http
        .post("/user/register", {
          name: infUser.name,
          email: infUser.email,
          aniversario: infUser.aniversario,
          perfil: parseInt(infUser.role),
          tags: this.selecteds,
          password: infUser.password,
          password_confirmation: infUser.password_confirmation,
          responsible_email: infUser.responsible_email,
        })
        .then((res) => {
          this.$store.commit("setUser", res.data);
          localStorage.setItem(userKey, JSON.stringify(res.data));
          this.user = res.data;
          this.loading = false;
          this.$router.replace("/thankyou");
        })
        .catch(showError);
    },
    btnBack: function () {
      this.$router.replace("/register");
    },
  }
};
</script>