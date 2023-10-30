<template>
  <section id="arqRecuperar">
    <myHeader />

    <div class="banner-cadastro">
      <v-container>
        <v-row>
          <v-col offset-md="2" md="8" cols="12">
            <div class="cadastro-title">
              <h1>RECUPERAR SENHA</h1>

              <div v-if="stepOne == false" class="user-dados">
                <h4 class="bt-border">Email de recuperação</h4>

                <v-text-field
                  v-model="email"
                  :rules="emailRules"
                  placeholder="Email"
                ></v-text-field>

                <div class="arq-center">
                  <v-btn
                    class="btn-cadastro"
                    @click="recuperar"
                    :loading="loading"
                    >Recuperar</v-btn
                  >
                </div>
              </div>

              <div
                v-else-if="stepOne == true && stepTwo == false"
                class="user-dados"
              >
                <h4 class="bt-border">Token de validação</h4>
                <p>
                  Um token de recuperação foi enviado para o email, verifique
                  seu email e digite o token abaixo.
                </p>

                <v-text-field
                  v-model="token"
                  placeholder="Token de recupeção"
                ></v-text-field>

                <div class="arq-center">
                  <v-btn
                    class="btn-cadastro"
                    @click="validarToken"
                    :loading="loading"
                    >Validar</v-btn
                  >
                </div>
              </div>

              <div
                v-else-if="stepOne == true && stepTwo == true"
                class="user-dados"
              >
                <h4 class="bt-border">Redefinir senha</h4>

                <v-text-field
                  v-model="password"
                  :rules="passRules"
                  type="password"
                  placeholder="Nova senha"
                ></v-text-field>
                <v-text-field
                  v-model="password_confirmation"
                  :rules="passRules.concat(passConfRule)"
                  type="password"
                  placeholder="Confirmar nova senha"
                ></v-text-field>

                <div class="arq-center">
                  <v-btn
                    class="btn-cadastro"
                    @click="redefinirSenha"
                    :loading="loading"
                    >Redefinir senha</v-btn
                  >
                </div>
              </div>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </div>

    <myFooter />
  </section>
</template>

<script>
import Vue from "vue";
import { mapState } from "vuex";
import { userKey, showError } from "@/global";
import myHeader from "../Header/header.vue";
import myFooter from "../Footer/footer.vue";

export default {
  name: "recuperar-senha",
  data() {
    return {
      email: "",
      emailRules: [
        (v) => !!v || "O Email é obrigatório",
        (v) => /.+@.+\..+/.test(v) || "Email precisa ser válido",
      ],
      dadosSenha: [],
      loading: false,
      stepOne: false,
      stepTwo: false,
      token: "",
      password: "",
      password_confirmation: "",
      passRules: [
        (v) => !!v || "A senha é obrigatória",
        (v) =>
          (v && v.length > 7) || "A senha deve conter no minimo 8 caracteres",
      ],
    };
  },
  components: {
    myHeader,
    myFooter,
  },
  computed: {
    ...mapState(["user"]),
    currentPage() {
      return this.$route.path;
    },
    passConfRule() {
      return (
        this.password === this.password_confirmation ||
        "As senhas não são iguais"
      );
    },
  },
  methods: {
    recuperar() {
      this.loading = true;

      this.$http
        .post("/user/forgot-password", {
          email: this.email,
        })
        .then((res) => {
          this.dadosSenha = res.data;
          this.loading = false;
          this.stepOne = true;
        })
        .catch(
          showError,
          setTimeout(() => (this.loading = false), 2000)
        );
    },

    validarToken() {
      this.loading = true;

      this.$http
        .post("/user/reset-password-token", {
          password_reset_code: this.token,
        })
        .then((res) => {
          this.dadosSenha = res.data;
          this.loading = false;
          this.stepTwo = true;
        })
        .catch(
          showError,
          setTimeout(() => (this.loading = false), 2000)
        );
    },

    redefinirSenha() {
      this.loading = true;

      this.$http
        .post("/user/new-password", {
          password_token: this.dadosSenha.token,
          password: this.password,
        })
        .then((res) => {
          this.dadosSenha = res.data;
          Vue.toasted.global.defaultSuccess({
            msg: "Senha alterada com sucesso!",
          });
          this.logout();
        })
        .catch(
          showError,
          setTimeout(() => (this.loading = false), 2000)
        );
    },

    logout() {
      this.$http
        .post("/logout")
        .then((res) => {
          localStorage.removeItem(userKey);
          this.$store.commit("setUser", null);
          console.log(res.data);

          setTimeout(
            () => ((this.loading = false), this.$router.push({ path: "/" })),
            1000
          );
        })
        .catch(
          showError,
          setTimeout(() => (this.loading = false), 2000)
        );
    },
  },
};
</script>

<style>
#arqRecuperar .banner-cadastro {
  background-image: url("../../assets/banner-cadastro.png");
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
  padding: 100px 0px;
  z-index: 1;
  display: flex;
}
#arqRecuperar .banner-cadastro:before {
  content: "";
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  z-index: -1;
  background-image: url("../../assets/filter-cadastro.png");
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
#arqRecuperar .cadastro-title {
  background-color: rgba(0, 0, 0, 0.8);
  padding: 65px 145px;
  margin: 50px 0px;
}
#arqRecuperar .cadastro-title h1 {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: bold;
  font-size: 30px;
  line-height: 32px;
  text-align: center;
  color: #ffffff;
  position: relative;
  width: fit-content;
  margin: auto;
}
#arqRecuperar .cadastro-title h1:after {
  content: "";
  border-bottom: 0.5px solid #43cea2;
  width: 75%;
  height: 0.5px;
  position: absolute;
  margin: auto;
  display: block;
  right: 0;
  left: 0;
}
#arqRecuperar .cadastro-title h4 {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 22px;
  color: #ffffff;
  margin-right: 15px;
}
#arqRecuperar .cadastro-title .v-input__slot {
  background-color: transparent;
  border-radius: 0;
  margin-bottom: 5px;
}
#arqRecuperar .cadastro-title .user-dados .v-input input {
  border-bottom: 1px solid #fff;
}
#arqRecuperar .cadastro-title .user-dados p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 17px;
  text-align: left;
  color: #828282;
  padding: 10px 0 0;
}
#arqRecuperar .cadastro-title .bt-border {
  margin-top: 35px;
  margin-bottom: 10px;
  position: relative;
  width: fit-content;
}
#arqRecuperar .cadastro-title .bt-border:after {
  content: "";
  position: absolute;
  display: block;
  width: 35px;
  height: 0.5px;
  border-bottom: 0.5px solid #43cea2;
}
#arqRecuperar .cadastro-title .btn-cadastro {
  background-color: #43cea2;
  border-radius: 2px;
  margin-top: 50px;
}
#arqRecuperar
  .cadastro-title
  .btn-cadastro.v-btn--disabled:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
  background-color: #4f4f4f !important;
}
#arqRecuperar .cadastro-title .btn-cadastro span {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 14px;
  line-height: 19px;
  text-align: center;
  color: #000000;
  text-transform: initial;
}
#arqRecuperar .cadastro-title .arq-center a {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 14px;
  line-height: 19px;
  text-align: center;
  color: #005aa1;
  display: block;
  padding: 10px 0px;
}

@media (max-width: 768px) {
  #arqRecuperar .cadastro-title {
    padding: 50px 25px;
  }
}
</style>