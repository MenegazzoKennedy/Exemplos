<template>
  <section id="arqCadastro">
    <myHeader />

    <div class="banner-cadastro">
      <v-container class="firstContainer">
        <v-row>
          <v-col offset-md="2" md="8" cols="12" class="telaCel">
            <div class="cadastro-title">
              <h1>CADASTRO</h1>

              <div class="select-client">
                <h4>Eu sou *</h4>
                <v-select
                  v-model="userData.role"
                  class="user-select"
                  :items="clientValue"
                  item-text="nameValue"
                  item-value="itemValue"
                  append-icon="fas fa-angle-down"
                ></v-select>
              </div>

              <div class="user-dados">
                <h4 class="bt-border">Dados pessoais</h4>

                <v-text-field
                  v-model="userData.name"
                  label="Nome completo *"
                ></v-text-field>

                <v-menu
                  ref="menu"
                  v-model="menu"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  min-width="auto"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      class="birthdate-picker"
                      v-model="birthdate"
                      prepend-icon="mdi-calendar"
                      placeholder="Data de Nascimento *"
                      hint="dd/mm/aaaa"
                      persistent-hint
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    color="#43CEA2"
                    header-color="#43CEA2"
                    ref="picker"
                    v-model="date"
                    locale="pt-BR"
                    :max="new Date().toISOString().substr(0, 10)"
                    min="1850-01-01"
                    @change="save"
                  ></v-date-picker>
                </v-menu>

                <v-text-field
                  v-if="userData.role == 'cliente'"
                  v-model="userData.telefone"
                  label="Telefone"
                  v-mask="'(##) #####-####'"
                ></v-text-field>

                <v-text-field
                  v-if="userData.role == 'cliente'"
                  v-model="userData.cpf"
                  label="CPF *"
                  v-mask="'###.###.###-##'"
                ></v-text-field>

                <v-text-field
                  v-if="userData.role == 'corretor'"
                  v-model="userData.creci"
                  label="CRECI *"
                ></v-text-field>

                <h5>Sexo</h5>
                <v-radio-group :row="true" v-model="userGenero">
                  <v-radio label="Feminino" value="2"></v-radio>
                  <v-radio label="Masculino" value="1"></v-radio>
                  <v-radio label="Outros" value="3"></v-radio>
                </v-radio-group>

                <template v-if="userData.role == 'corretor'">
                  <h4 class="bt-border">Área de atuação</h4>

                  <div class="select-area">
                    <v-select
                      v-model="estado"
                      @change="loadCidade"
                      class="user-select"
                      placeholder="Estado de Atuação"
                      :items="estadoData"
                      item-text="name"
                      item-value="id"
                      append-icon="fas fa-angle-down"
                    ></v-select>

                    <v-select
                      v-if="stepCity == true"
                      v-model="cidade"
                      @change="loadBairro"
                      class="user-select"
                      placeholder="Cidade de Atuação"
                      :items="cidadeData"
                      item-text="name"
                      item-value="id"
                      append-icon="fas fa-angle-down"
                    ></v-select>

                    <div v-if="stepBairro == true" class="arqRegiao">
                      <v-select
                        v-model="bairros"
                        multiple
                        class="user-select localeSelect"
                        placeholder="Bairros"
                        :items="bairroData"
                        item-text="name"
                        item-value="id"
                        append-icon="fas fa-angle-down"
                      ></v-select>
                      <v-select
                        v-model="regioes"
                        multiple
                        class="user-select localeSelect"
                        placeholder="Regiões"
                        :items="regiaoData"
                        item-text="name"
                        item-value="id"
                        append-icon="fas fa-angle-down"
                      ></v-select>
                    </div>
                  </div>
                </template>

                <h4 class="bt-border">Conta</h4>

                <v-text-field
                  v-model="userData.email"
                  label="E-mail *"
                  :rules="emailRules"
                ></v-text-field>
                <v-text-field
                  v-model="email_confirmation"
                  label="Confirme seu e-mail *"
                  :rules="emailRules.concat(passConfRule)"
                ></v-text-field>

                <v-text-field
                  v-model="userData.password"
                  :rules="passRules"
                  type="password"
                  label="Crie sua senha *"
                ></v-text-field>

                <v-btn
                  class="btn-cadastro"
                  v-if="userData.role != 'corretor'"
                  @click="isDialogVisible = true"
                  :loading="loading"
                  :disabled="checkbox"
                  >Já Possuo um Corretor</v-btn
                >

                <v-dialog
                  v-model="isDialogVisible"
                  max-width="762px"
                  persistent
                >
                  <div class="consultor-title">
                    <h2>Qual consultor imobiliário está te atendendo?</h2>
                    <p>
                      Digite o nome ou o CRECI do consultor no espaço abaixo.
                    </p>

                    <div class="search-consult">
                      <v-text-field
                        v-model="consultarConsultor"
                        rounded
                        v-on:keyup="acoesPorTecla"
                      ></v-text-field>
                      <v-btn
                        @click="searchConsultorID"
                        icon
                        class="btn-search-consult"
                      >
                        <v-icon>mdi-magnify</v-icon>
                      </v-btn>
                    </div>
                    <v-container class="scrollDiv">
                      <div
                        class="card-consultor"
                        v-for="(consultor, i) in consultorData"
                        :key="i"
                        :class="[
                          showBox ? '' : 'arq-none',
                          { mudarBack: divSelecionada(i) },
                        ]"
                        @click="selectConsultor(i, consultor.id)"
                      >
                        <img :src="verificaFotoCons(consultor)" />
                        <div class="text-infos">
                          <h2>{{ consultor.name }}</h2>
                          <h4>CRECI - {{ consultor.creci }}</h4>
                        </div>
                      </div>
                    </v-container>
                    <div class="salvarCons">
                      <v-btn
                        @click="salvarConsultor"
                        text
                        class="btn-next"
                        :loading="loading"
                      >
                        Salvar
                      </v-btn>
                    </div>
                    <div class="cancelarCons">
                      <v-btn
                        @click="fecharDialog"
                        text
                        class="btn-next"
                        :loading="loading"
                      >
                        Cancelar
                      </v-btn>
                    </div>
                  </div>
                </v-dialog>

                <div class="more-dados">
                  <v-checkbox
                    v-if="
                      (userData.role != 'corretor' && userData.genero == 2) ||
                      userData.genero == 3
                    "
                    :disabled="!disabilitaCheck"
                    v-model="checkbox"
                  >
                    <template v-slot:label>
                      <p>Quero ser atendido por uma corretora.</p>
                    </template>
                  </v-checkbox>
                  <v-checkbox v-model="checkboxtwo">
                    <template v-slot:label>
                      <div>
                        Aceito os
                        <v-tooltip>
                          <template v-slot:activator="{ on }">
                            <a
                              target="_blank"
                              href="./termos-de-uso"
                              @click.stop
                              v-on="on"
                              >Termos de Condições</a
                            >
                          </template>
                        </v-tooltip>
                        e a
                        <v-tooltip>
                          <template v-slot:activator="{ on }">
                            <a
                              target="_blank"
                              href="./politica-de-privacidade"
                              @click.stop
                              v-on="on"
                              >Política de Privacidade</a
                            >
                          </template>
                        </v-tooltip>
                        da Imobillus.
                      </div>
                    </template>
                  </v-checkbox>
                </div>

                <div class="arq-center">
                  <v-btn
                    class="btn-cadastro"
                    @click="goSelectConsult"
                    :disabled="!checkboxtwo"
                    :loading="loading"
                    >Finalizar cadastro</v-btn
                  >
                  <a @click="dialogLogin = true">Já tenho cadastro</a>
                </div>
                <v-dialog v-model="dialogLogin" max-width="762px" persistent>
                  <div class="box-client">
                    <div class="information-client">
                      <v-text-field
                        v-model="userData.email"
                        :rules="emailRules"
                        @keyup="lowercase"
                        label="E-mail"
                        required
                      ></v-text-field>
                      <v-text-field
                        v-model="userData.password"
                        type="password"
                        label="Senha"
                      ></v-text-field>
                    </div>

                    <div class="salvarCons">
                      <v-btn
                        class="btn-login"
                        @click="login"
                        :loading="loading"
                        rounded
                        v-on:keyup="submitLogin"
                        >Acessar</v-btn
                      >
                    </div>
                    <div class="cancelarCons">
                      <v-btn @click="dialogLogin = false"> Voltar</v-btn>
                    </div>

                    <p v-show="false">Entrar com Facebook</p>
                    <p v-show="false">Entrar com Google</p>
                  </div>
                </v-dialog>
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
  name: "cadastro",
  data() {
    return {
      date: null,
      birthdate: "",
      menu: false,
      dialogLogin: false,
      checkbox: false,
      ultimoClickCorr: null,
      selecionado: false,
      isDialogVisible: false,
      loading: false,
      stepCity: false,
      disabilitaCheck: true,
      stepBairro: false,
      checkboxtwo: false,
      corretor: "",
      consultarConsultor: "",
      tipoConsulta: "",
      consultorData: [],
      showBox: false,
      idCorretor: 0,
      estado: "",
      cidade: "",
      bairros: [],
      regioes: [],
      userGenero: "",
      imgPadrao: {
        src: require("../../assets/icone_corretor.png"),
      },
      estadoData: [],
      cidadeData: [],
      bairroData: [],
      regiaoData: [],
      userData: {
        name: "",
        email: "",
        password: "",
        cpf: "",
        role: "",
        telefone: "",
        nascimento: "",
        genero: "",
        corretor_id: "",
        creci: "",
      },
      clientValue: [
        {
          nameValue: "Cliente",
          itemValue: "cliente",
        },
        {
          nameValue: "Corretor",
          itemValue: "corretor",
        },
      ],
      emailRules: [
        (v) => !!v || "O Email é obrigatório",
        (v) => /.+@.+\..+/.test(v) || "Email precisa ser válido",
      ],
      email_confirmation: "",
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
        this.userData.email === this.email_confirmation ||
        "Os emails não são iguais"
      );
    },
  },
  watch: {
    menu(val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
    },
    date() {
      this.birthdate = this.formatDate(this.date);
      this.userData.nascimento = this.date;
    },
    corretor() {
      if (this.corretor == "true") {
        this.userData.role = "corretor";
      }
    },
    userGenero() {
      this.userData.genero = this.userGenero;
    },
  },
  created() {
    this.corretor = this.$route.query.corretor;
  },
  mounted() {
    this.loadEstados();
  },
  methods: {
    searchConsultorID() {
      if (this.consultarConsultor != "") {
        this.$http
          .post("/corretores/busca", {
            consuta: this.consultarConsultor,
          })
          .then((res) => {
            this.consultorData = res.data;
            this.selecionado = this.consultorData.map(() => false);
            this.showBox = true;
          })
          .catch(showError);
      } else {
        Vue.toasted.global.defaultError({
          errors: "Digitar o CRECI ou nome do Corretor!",
        });
      }
    },
    login() {
      this.loading = true;

      this.$http
        .post("/login", this.userData)
        .then((res) => {
          this.$store.commit("setUser", res.data);
          localStorage.setItem(userKey, JSON.stringify(res.data));
          this.userData = res.data;
          setTimeout(
            () => (
              (this.loading = false),
              (this.clientMenu = false),
              this.$router.push({ path: "/meu-perfil" })
            ),
            2000
          );
        })
        .catch(
          showError,
          setTimeout(() => (this.loading = false), 2000)
        );
    },
    lowercase() {
      this.userData.email = this.userData.email.toLowerCase();
    },
    submitLogin(e) {
      if (e.keyCode === 13) {
        this.login();
      } else if (e.keyCode === 27) {
        this.dialogLogin = false;
      }
    },
    selectConsultor(i, idCorr) {
      this.idCorretor = idCorr;
      Vue.set(this.selecionado, i, !this.selecionado[i]);
    },
    divSelecionada(i) {
      for (let j = 0; j < this.consultorData.length; j++) {
        if (this.idCorretor == this.consultorData[i].id) {
          return this.selecionado[i];
        } else {
          return (this.selecionado[i] = false);
        }
      }
    },
    verificaFotoCons(img) {
      if (typeof img.url == "string") {
        return img.url;
      } else {
        return this.imgPadrao.src;
      }
    },
    salvarConsultor() {
      this.isDialogVisible = false;
    },
    fecharDialog() {
      if (this.userData.genero == 2) {
        this.isDialogVisible = false;
        this.checkbox = false;
        this.disabilitaCheck = true;
        this.consultarConsultor = "";
        this.showBox = false;
      }
      this.isDialogVisible = false;
      this.checkbox = false;
      this.consultarConsultor = "";
      this.showBox = false;
    },
    acoesPorTecla(e) {
      if (e.keyCode === 27) {
        this.fecharDialog();
      } else if (e.keyCode === 13) {
        this.searchConsultorID();
      }
    },
    save(date) {
      this.$refs.menu.save(date);
    },
    formatDate(date) {
      if (!date) return null;
      const [year, month, day] = date.split("-");
      return `${day}/${month}/${year}`;
    },
    formatDate2(date) {
      if (!date) return null;
      return `${date}`;
    },
    goSelectConsult() {
      this.loading = true;

      if (this.userData.role == "cliente") {
        this.$http
          .post("/cadastro-usuario", {
            name: this.userData.name,
            email: this.userData.email,
            tipo: this.userData.role,
            password: this.userData.password,
            password_confirmation: this.userData.password,
            cpf: this.userData.cpf,
            nascimento: this.userData.nascimento,
            genero: this.userData.genero,
            telefone: this.userData.telefone,
            corretor_id: this.idCorretor,
          })
          .then((res) => {
            this.userData = res.data;
            this.$store.commit("setUser", res.data);
            localStorage.setItem(userKey, JSON.stringify(res.data));
            setTimeout(
              () => (
                localStorage.removeItem("userDados"),
                (this.loading = false),
                this.$router.push({ path: "/lista-imoveis" })
              ),
              2000
            );
          })
          .catch(
            showError,
            setTimeout(() => (this.loading = false), 2000)
          );
      } else if (this.userData.role == "corretor") {
        this.$http
          .post("/cadastro-usuario", {
            name: this.userData.name,
            email: this.userData.email,
            tipo: this.userData.role,
            password: this.userData.password,
            password_confirmation: this.userData.password,
            creci: this.userData.creci,
            genero: this.userData.genero,
            bairros: this.bairros,
            regioes: this.regioes,
          })
          .then((res) => {
            this.userData = res.data;
            this.$store.commit("setUser", res.data);
            localStorage.setItem(userKey, JSON.stringify(res.data));
            setTimeout(
              () => ((this.loading = false), this.$router.push({ path: "/" })),
              2000
            );
          })
          .catch(
            showError,
            setTimeout(() => (this.loading = false), 2000)
          );
      } else {
        setTimeout(() => (this.loading = false), 2000);
        Vue.toasted.global.defaultError({
          errors: "O campo eu sou é obrigatório.",
        });
      }
    },

    loadEstados() {
      this.$http
        .get("/localidades/estados")
        .then((res) => {
          this.estadoData = res.data;
        })
        .catch(showError);
    },
    loadCidade() {
      this.$http
        .get("/localidades/cidades/" + this.estado + "")
        .then((res) => {
          const loadCidade = res.data;
          this.cidadeData = loadCidade[0].cidades;
          this.stepCity = true;
        })
        .catch(showError);
    },
    loadBairro() {
      this.$http
        .get("/localidades/" + this.cidade + "/locaisBairros")
        .then((res) => {
          const loadBairro = res.data;
          this.bairroData = loadBairro[0].bairros;
          this.regiaoData = loadBairro[0].regioes;

          this.stepBairro = true;
        })
        .catch(showError);
    },
  },
};
</script>

<style>
#arqCadastro .banner-cadastro {
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
#arqCadastro .banner-cadastro:before {
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
#arqCadastro .cadastro-title {
  background-color: rgba(0, 0, 0, 0.8);
  padding: 65px 145px;
  margin: 50px 0px;
}
#arqCadastro .cadastro-title h1 {
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
#arqCadastro .cadastro-title h1:after {
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
#arqCadastro .cadastro-title .select-client {
  display: flex;
  width: fit-content;
  margin: auto;
  align-items: center;
  margin: 40px auto 5px;
}
#arqCadastro .cadastro-title .select-client .user-select {
  min-width: 150px;
  width: min-content;
}
#arqCadastro .cadastro-title .select-client .v-select__slot .v-icon {
  font-size: 15px;
  color: #fff !important;
}
#arqCadastro
  .cadastro-title
  .select-client
  .v-select
  .v-select__selection--comma {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 22px;
  text-align: center;
  color: #ffffff;
  width: 100%;
  margin: 0;
}

#arqCadastro .cadastro-title .select-area .arqRegiao {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
#arqCadastro .cadastro-title .select-area .arqRegiao .localeSelect {
  width: fit-content;
  max-width: 45%;
}

#inspire .v-menu__content .v-list-item__action .v-icon {
  color: #43cea2 !important;
  caret-color: #43cea2 !important;
}

#inspire .v-input__slot {
  background-color: transparent;
  border-radius: 29.5px;
}

#arqCadastro .cadastro-title .v-select .v-select__selection--comma {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 22px;
  text-align: left;
  color: #ffffff;
  width: 100%;
  margin: 0;
}
#arqCadastro .cadastro-title h4 {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 22px;
  color: #ffffff;
  margin-right: 15px;
}

#arqCadastro .cadastro-title .v-input__slot {
  background-color: transparent;
  border-radius: 29.5px;
}
#arqCadastro .cadastro-title .user-dados .v-input input,
#arqCadastro .cadastro-title .select-client .v-select__slot,
#arqCadastro .cadastro-title .v-select__slot,
.box-client .information-client .v-input__slot {
  border-bottom: 1px solid #fff;
}
#arqCadastro .cadastro-title .v-select.v-text-field input {
  top: 1px;
}
#arqCadastro .cadastro-title .v-text-field .v-label,
#arqCadastro .cadastro-title .v-input--selection-controls .v-radio > .v-label,
#arqCadastro .cadastro-title .user-dados h5 {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 14px;
  color: #828282;
}
#arqCadastro .cadastro-title .user-dados h5 {
  margin-top: 15px;
}
#arqCadastro
  .cadastro-title
  .v-input--selection-controls
  .v-input--selection-controls__input:hover
  .v-input--selection-controls__ripple:before {
  transform: scale(0.4);
  color: #fff;
}
#arqCadastro .cadastro-title .v-input--selection-controls__input .v-icon {
  font-size: 15px;
  color: #fff;
}
#arqCadastro .cadastro-title .v-input--selection-controls__input {
  margin-right: 0px;
}
#arqCadastro .cadastro-title .v-input--radio-group {
  margin: 0;
}
#arqCadastro
  .cadastro-title
  .v-input--radio-group--row
  .v-input--radio-group__input {
  justify-content: space-between;
}
#arqCadastro .cadastro-title .bt-border {
  margin-top: 35px;
  margin-bottom: 10px;
  position: relative;
  width: fit-content;
}
#arqCadastro .cadastro-title .bt-border:after {
  content: "";
  position: absolute;
  display: block;
  width: 35px;
  height: 0.5px;
  border-bottom: 0.5px solid #43cea2;
}
#arqCadastro .cadastro-title .birthdate-picker .v-input__prepend-outer .v-icon {
  color: #fff;
  font-size: 35px;
}
#arqCadastro .cadastro-title .birthdate-picker .v-messages__message {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 22px;
  color: #828282;
  padding: 2px 5px;
}
#arqCadastro .cadastro-title .more-dados {
  margin: 35px 0px;
}
#arqCadastro .cadastro-title .more-dados .v-input__slot .v-label p {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 14px;
  line-height: 19px;
  color: #828282;
  margin: 0;
}
#arqCadastro .cadastro-title .more-dados .v-input__slot .v-label a {
  color: #43cea2;
}
#arqCadastro .cadastro-title .more-dados .v-input--checkbox {
  margin: 0;
}
#arqCadastro .cadastro-title .more-dados .v-input--checkbox .v-messages {
  display: none;
}
#arqCadastro .cadastro-title .btn-cadastro {
  background-color: #43cea2;
  border-radius: 2px;
}
#arqCadastro .cadastro-title .btn-cadastro:hover {
  background-color: #43cec5;
  border-radius: 2px;
}
#arqCadastro
  .cadastro-title
  .btn-cadastro.v-btn--disabled:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
  background-color: #4f4f4f !important;
}
#arqCadastro .cadastro-title .btn-cadastro span {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 14px;
  line-height: 19px;
  text-align: center;
  color: #000000;
  text-transform: initial;
}

.btnSelecao {
  background-color: transparent;
  background-repeat: no-repeat;
  border: none;
  cursor: pointer;
  overflow: hidden;
}

#app #inspire .v-dialog__content .v-dialog .box-client .cancelarCons,
#app #inspire .v-dialog__content .v-dialog .consultor-title .cancelarCons {
  padding-right: 5px;
  padding-left: 5px;
  display: inline;
}
#app #inspire .v-dialog__content .v-dialog .box-client .salvarCons,
#app #inspire .v-dialog__content .v-dialog .consultor-title .salvarCons {
  padding-right: 5px;
  padding-left: 5px;
  display: inline;
}

#app
  #inspire
  .v-dialog__content
  .v-dialog
  .box-client
  .information-client
  .v-input
  .v-input__control
  .v-input__slot {
  background-color: transparent;
  border-radius: 0px;
}

#app
  #inspire
  .v-dialog__content
  .v-dialog
  .box-client
  .information-client
  .v-input
  .v-input__control
  .v-input__slot::before {
  background-color: transparent;
  border-radius: 0px;
}

#arqCadastro .cadastro-title .arq-center a {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: normal;
  text-decoration: underline;
  font-size: 14px;
  line-height: 19px;
  text-align: center;
  color: #43cea2;
  display: block;
  padding: 10px 0px;
}

.consultor-title {
  background-color: rgba(0, 0, 0, 0.8);
  padding: 50px 45px 95px;
  text-align: center;
}

.consultor-title h2 {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 25px;
  line-height: 41px;
  color: #ffffff;
}
.consultor-title p {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 200;
  font-size: 20px;
  line-height: 33px;
  color: #ffffff;
}
.consultor-title .search-consult {
  margin: 25px 0px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.consultor-title .search-consult .btn-search-consult {
  background-color: #43cea2;
  color: #fff;
  width: 35px;
  height: 35px;
}
.consultor-title .search-consult .btn-search-consult:hover {
  background-color: #43cec5;
  color: #fff;
  width: 35px;
  height: 35px;
}
.consultor-title .search-consult .v-input__slot {
  border: 1px solid #ffffff;
  box-sizing: border-box;
  border-radius: 29.5px;
  background-color: transparent;
  width: fit-content;
  margin: 0;
}
.consultor-title .search-consult .v-input {
  width: fit-content;
  flex: initial;
  margin: 5px 10px;
  padding: 0;
}
.consultor-title .search-consult .v-input input {
  border: 1px solid transparent;
  border-radius: 29.5px;
  text-align: center;
}
.consultor-title .search-consult .v-input .v-text-field__details {
  display: none;
}
.consultor-title .search-consult .v-input .v-text-field__slot {
  min-width: 115px;
  width: min-content;
}

.consultor-title .btn-next {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 200;
  font-size: 16px;
  line-height: 27px;
  color: #000;
  text-transform: initial;
  margin-top: 45px;
  background-color: #43cea2;
  border-radius: 2px;
}
.consultor-title .btn-next:hover {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 200;
  font-size: 16px;
  line-height: 27px;
  color: #000;
  text-transform: initial;
  margin-top: 45px;
  background-color: #43cec5;
  border-radius: 2px;
}
.consultor-title .btn-next p {
  padding: 0 5px;
  margin: 0;
  font-size: 14px;
  font-weight: lighter;
  font-family: monospace;
}

.scrollDiv {
  max-height: 190px;
  overflow-y: auto;
}

.consultor-title .card-consultor {
  border: 0.5px solid #ffffff;
  box-sizing: border-box;
  border-radius: 8px;
  display: flex;
  align-items: center;
  padding: 10px 15px;
  width: 100%;
  margin: 10px auto 0;
  cursor: pointer;
}

.consultor-title .card-consultor:hover {
  background-color: #4f4f4f;
}

.mudarBack {
  background-color: #43cea2;
}

.consultor-title .card-consultor img {
  width: 65px;
  height: 60px;
  object-fit: cover;
  object-position: center;
  border-radius: 50%;
}
.consultor-title .card-consultor .text-infos {
  display: block;
  text-align: left;
  margin: 0 20px;
}
.consultor-title .card-consultor .text-infos h2 {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 15px;
  line-height: 23px;
  color: #ffffff;
}
.consultor-title .card-consultor .text-infos h4 {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 300;
  font-size: 13px;
  line-height: 20px;
  color: #ffffff;
}

#app #inspire .v-dialog .box-client {
  background-color: rgba(0, 0, 0, 0.8);
  padding: 50px 45px 95px;
  text-align: center;
  height: 300px;
}

.theme--light.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 200;
  font-size: 16px;
  line-height: 27px;
  color: #000;
  text-transform: initial;
  background-color: #43cea2;
  border-radius: 2px;
}

.theme--light.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined):hover {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 200;
  font-size: 16px;
  line-height: 27px;
  color: #000;
  text-transform: initial;
  background-color: #43cec5;
  border-radius: 2px;
}

.arq-none {
  display: none !important;
}

.classCheckBox {
  display: inline !important;
}
@media (max-width: 768px) {
  #app #inspire #arqCadastro .banner-cadastro .cadastro-title {
    padding: 65px 80px;
  }
}
@media (max-width: 425px) {
  #app #inspire #arqCadastro .banner-cadastro .cadastro-title {
    padding: 65px 40px;
  }
  #app #inspire #arqCadastro .firstContainer {
    padding: 0px !important;
  }
}
@media (max-width: 375px) {
  #app
    #inspire
    .cadastro-title
    .user-dados
    .v-input__control
    .v-input__slot
    .v-input--radio-group__input {
    display: block;
  }
  #app
    #inspire
    .cadastro-title
    .user-dados
    .v-input__control
    .v-input__slot
    .theme--light {
    margin-bottom: 5px;
  }
  #app #inspire .banner-cadastro {
    padding: 0;
  }
  #app #inspire .banner-cadastro .telaCel {
    padding: 0;
  }
  #app #inspire .banner-cadastro .telaCel .cadastro-title {
    margin: 0;
    padding-top: 80px;
  }
}
</style>