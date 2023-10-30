<template>
  <section id="arqCadastro">
    <myHeader />

    <div class="banner-perfil" v-if="infUser.clientes">
      <v-container class="firstContainer">
        <v-row>
          <v-col offset-md="2" md="8" cols="12" class="telaCel">
            <div class="perfil-title">
              <h1>PERFIL</h1>
              <div class="inf-principais-user">
                <v-file-input
                  :style="{
                    'background-image': 'url(' + infUser.clientes[0].url + ')',
                  }"
                  class="img-perfil"
                  @change="enviaArquivo"
                  v-model="imgUpdate"
                ></v-file-input>

                <v-icon>mdi-calendar</v-icon>
                <p>{{ formatDate(infUser.clientes[0].nascimento) }}</p>
              </div>
              <div class="informacoes-gerais-user">
                <label>E-mail</label>
                <p>{{ infUser.email }}</p>
                <label>Senha</label>
                <input type="password" value="xxxxxxxxxxx" readonly />
                <label>Telefone</label>
                <p>{{ infUser.clientes[0].telefone }}</p>
              </div>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </div>
    <div class="banner-perfil" v-else>
      <v-container class="firstContainer">
        <v-row>
          <v-col offset-md="2" md="8" cols="12" class="telaCel">
            <div class="perfil-title">
              <h1>PERFIL</h1>
              <div class="inf-principais-user">
                <v-file-input
                  :style="{
                    'background-image':
                      'url(' + infUser.corretores[0].url + ')',
                  }"
                  class="img-perfil"
                  @change="enviaArquivo"
                  v-model="imgUpdate"
                ></v-file-input>
                <h2>{{ infUser.name }}</h2>
                <!-- <v-icon>mdi-calendar</v-icon>
                <p>{{ formatDate(infUser.corretores[0].nascimento) }}</p> -->
              </div>
              <div class="informacoes-gerais-user">
                <label>E-mail</label>
                <p>{{ infUser.email }}</p>
                <label>Senha</label>
                <input type="password" value="xxxxxxxxxxx" readonly />
                <!-- <label>Telefone</label>
                <p>{{ infUser.corretores[0].telefone }}</p> -->
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
import { mapState } from "vuex";
import myHeader from "../Header/header.vue";
import myFooter from "../Footer/footer.vue";
import { showError } from "@/global";

export default {
  name: "meu-perfil",
  data() {
    return {
      infUser: [],
      imgUpdate: "",
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
        this.userData.email === this.email_confirmation ||
        "Os emails não são iguais"
      );
    },
  },
  mounted() {
    this.loadUser();
  },
  methods: {
    loadUser() {
      //
      this.$http.post("/minha-conta").then((res) => {
        this.infUser = res.data;
        // console.log(this.infUser);
      });
    },
    formatDate(date) {
      if (!date) return null;
      const [year, month, day] = date.split("-");
      return `${day}/${month}/${year}`;
    },
    enviaArquivo() {
      // console.log(this.imgUpdate);
      if (typeof this.imgUpdate != "undefined") {
        var postData = new FormData();
        postData.append("arquivo", this.imgUpdate);
        this.$http
          .post("/profile/avatar/update", postData)
          .then(() => {
            this.loadUser();
          })
          .catch(showError);
      }
    },
  },
};
</script>

<style>
#arqCadastro .banner-perfil {
  background-image: url("../../assets/banner-cadastro.png");
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
  padding: 100px 0px;
  z-index: 1;
  display: flex;
}
#arqCadastro .banner-perfil:before {
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
#arqCadastro .perfil-title {
  background-color: rgba(0, 0, 0, 0.8);
  padding: 65px 145px;
  margin: 50px 0px;
}
#arqCadastro .perfil-title h1 {
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
#arqCadastro .perfil-title h1:after {
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
#inspire .banner-perfil .firstContainer .perfil-title .inf-principais-user {
  text-align: center;
  padding-top: 30px;
  padding-bottom: 30px;
}
#inspire .banner-perfil .firstContainer .perfil-title .inf-principais-user img {
  width: 150px;
  height: 150px;
  object-fit: cover;
  object-position: center;
  border-radius: 50%;
}
#inspire .banner-perfil .firstContainer .perfil-title .inf-principais-user h2 {
  font-family: Archivo;
  font-style: normal;
  font-weight: 600;
  font-size: 22px;
  line-height: 24px;
  padding-top: 10px;
  text-align: center;
  color: #ffffff;
}
#inspire
  .banner-perfil
  .firstContainer
  .perfil-title
  .inf-principais-user
  .v-icon {
  color: #fff;
  display: inline;
}
#inspire .banner-perfil .firstContainer .perfil-title .inf-principais-user p {
  color: #fff;
  display: inline;
}
#inspire .banner-perfil .firstContainer .perfil-title .informacoes-gerais-user {
  font-family: Archivo;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 30px;
  /* or 187% */

  color: #ffffff;
}
#inspire
  .banner-perfil
  .firstContainer
  .perfil-title
  .informacoes-gerais-user
  input {
  color: #fff;
  display: block;
  font-weight: 700;
  margin-top: -8px;
  margin-bottom: 5px;
}
#inspire
  .banner-perfil
  .firstContainer
  .perfil-title
  .informacoes-gerais-user
  p {
  font-weight: 700;
  color: #fff;
  display: block;
  margin-top: -8px;
  margin-bottom: 5px;
}
#inspire .banner-perfil .img-perfil {
  background-size: cover;
  width: 150px;
  height: 150px;
  border-radius: 50%;
  margin: auto;
  padding: 0;
}
#inspire .banner-perfil .img-perfil .v-input__prepend-outer {
  height: 100% !important;
  width: 100% !important;
  margin: 0 !important;
}
#inspire .banner-perfil .img-perfil .v-input__prepend-outer .v-input__icon {
  width: 100% !important;
  height: 100% !important;
  display: block !important;
}
#inspire .banner-perfil .img-perfil .v-input__prepend-outer {
  width: 100% !important;
  height: 100% !important;
  display: block !important;
}
#inspire .banner-perfil .img-perfil .v-input__prepend-outer button {
  width: 100% !important;
  height: 100% !important;
  border-radius: 50% !important;
}
#inspire .banner-perfil .img-perfil .v-input__prepend-outer button:before {
  content: "";
  display: none;
}
#inspire .banner-perfil .img-perfil .v-input__prepend-outer button:before {
  content: "Trocar Avatar";
  display: block;
  transition-duration: 0.5s;
  color: #fff0;
}
#inspire
  .banner-perfil
  .img-perfil
  .v-input__prepend-outer
  button:hover::before {
  content: "Trocar Avatar";
  display: block;
  transition-duration: 0.5s;
  color: #fff;
}
#inspire .banner-perfil .img-perfil .v-input__control {
  display: none;
}
@media (max-width: 768px) {
  #app #inspire #arqCadastro .banner-perfil .perfil-title {
    padding: 65px 80px;
  }
}
@media (max-width: 425px) {
  #app #inspire #arqCadastro .banner-perfil .perfil-title {
    padding: 65px 40px;
  }
  #app #inspire #arqCadastro .firstContainer {
    padding: 0px !important;
  }
}
@media (max-width: 375px) {
  #app
    #inspire
    .perfil-title
    .user-dados
    .v-input__control
    .v-input__slot
    .v-input--radio-group__input {
    display: block;
  }
  #app
    #inspire
    .perfil-title
    .user-dados
    .v-input__control
    .v-input__slot
    .theme--light {
    margin-bottom: 5px;
  }
  #app #inspire .banner-perfil {
    padding: 0;
  }
  #app #inspire .banner-perfil .telaCel {
    padding: 0;
  }
  #app #inspire .banner-perfil .telaCel .perfil-title {
    margin: 0;
    padding-top: 80px;
  }
}
</style>