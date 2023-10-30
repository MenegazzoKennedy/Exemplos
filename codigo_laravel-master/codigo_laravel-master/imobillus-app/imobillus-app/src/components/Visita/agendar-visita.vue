<template>
  <section v-if="pageReady == true" id="agendarVisita">
    <myHeader />

    <div
      class="banner-destaque"
      :style="{
        'background-image': 'url(' + verificBanner(imovelData.midias[0]) + ')',
      }"
    >
      <v-container>
        <v-row>
          <v-col sm="6" cols="12">
            <h1>{{ imovelData.titulo }}</h1>
            <h3>{{ imovelData.bairro }}</h3>
          </v-col>
          <v-col sm="6" cols="12" class="align-right">
            <div class="icon-area">
              <div
                class="btnPreferidos"
                v-if="idsArray.find((element) => element == imovelData.id)"
              >
                <v-btn
                  icon
                  class="banner-btn btn-circle btnNonePreferidos"
                  @click="btnPreferido(imovelData.id)"
                  ><v-icon>mdi-plus</v-icon></v-btn
                >
                <v-btn
                  icon
                  class="banner-btn btn-circle"
                  @click="btnPreferido(imovelData.id)"
                >
                  <v-icon>mdi-minus</v-icon>
                </v-btn>
              </div>
              <div class="btnPreferidos" v-else>
                <v-btn
                  icon
                  class="banner-btn btn-circle"
                  @click="btnPreferido(imovelData.id)"
                  ><v-icon>mdi-plus</v-icon></v-btn
                >
                <v-btn
                  icon
                  class="banner-btn btn-circle btnNonePreferidos"
                  @click="btnPreferido(imovelData.id)"
                >
                  <v-icon>mdi-minus</v-icon>
                </v-btn>
              </div>
              <v-btn
                icon
                class="banner-btn btn-circle btn-share"
                @click="copiarLink(imovelData.slug)"
                ><v-icon>mdi-share-variant</v-icon></v-btn
              >
            </div>
            <h3>{{ formatValor(imovelData.valor) }}</h3>
          </v-col>

          <v-col cols="12" class="menu-single">
            <div class="imovel-actions">
              <ul>
                <li>
                  <v-btn icon @click="insereLinkTour" v-show="botaoTour">
                    <img src="../../assets/tour.png" class="tourImg" />
                  </v-btn>
                  <v-dialog max-width="1920px" v-model="dialog360">
                    <iframe
                      class="iframeTour"
                      :src="link"
                      frameborder="0"
                    ></iframe>
                  </v-dialog>
                </li>
                <li>
                  <v-btn icon @click="insereLinkYtb" v-show="botaoYtb">
                    <img src="../../assets/play.png" class="playImg" />
                  </v-btn>
                  <v-dialog max-width="762px" v-model="dialogYtb">
                    <iframe
                      width="642"
                      height="361"
                      :src="link"
                      frameborder="0"
                      allowfullscreen
                    ></iframe>
                  </v-dialog>
                </li>
                <li>
                  <v-btn icon v-show="botaoQuant">
                    <p>{{ quantUnidade }} <span>un.</span></p>
                  </v-btn>
                </li>
              </ul>
            </div>
            <div class="imovel-menu align-right">
              <ul>
                <li><p @click="goSingleImovel">Sobre o imóvel</p></li>
                <li class="divisor-menu active-page"><p>Agendar visita</p></li>
                <li class="divisor-menu">
                  <p @click="goNegociacao">Iniciar negociação</p>
                </li>
                <li class="divisor-menu">
                  <p @click="goSimulacao">Simular financiamento</p>
                </li>
              </ul>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </div>

    <div class="agendar-infos">
      <v-container>
        <v-row>
          <v-col offset-md="2" md="8" cols="12">
            <div class="box-agendar">
              <div class="align-agendar">
                <div class="selected-imovel">
                  <img src="../../assets/casa-single.png" />
                  <div class="imovel-details">
                    <h3>{{ imovelData.titulo }}</h3>
                    <p>{{ imovelData.bairro }} - {{ imovelData.numero }}</p>
                    <p>Valor do imóvel: {{ formatValor(imovelData.valor) }}</p>
                  </div>
                </div>

                <div
                  v-if="
                    is_loged == true && this.user.corretor_id_preferido != null
                  "
                  class="selected-corretor"
                >
                  <h4>CORRETOR</h4>
                  <img :src="consultorData[0].url_foto" />
                  <h4>{{ consultorData[0].name }}</h4>
                  <p>CRECI - {{ consultorData[0].creci }}</p>
                </div>
              </div>
              <div
                class="consultor-title"
                v-if="
                  is_loged == false || this.user.corretor_id_preferido == null
                "
              >
                <div class="search-consult">
                  <h2>Qual consultor imobiliário está te atendendo?</h2>

                  <v-text-field
                    v-model="consultarConsultor"
                    rounded
                  ></v-text-field>
                  <v-btn
                    @click="searchCorrCreci"
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
                    :class="{ mudarBack: divSelecionada(i) }"
                    @click="selectConsultor(i, consultor.id)"
                  >
                    <img :src="verificaFotoCons(consultor)" />
                    <div class="text-infos">
                      <h2>{{ consultor.users.name }}</h2>
                      <h4>CRECI - {{ consultor.creci }}</h4>
                    </div>
                  </div>
                </v-container>
              </div>

              <template v-if="is_loged == false">
                <v-btn class="btn-padrao" @click="dialogLogin = true"
                  >Necessário Fazer Login</v-btn
                >
              </template>

              <template v-else>
                <v-btn class="btn-padrao" @click="dialogAgendar = true"
                  >Agendar visita neste imóvel</v-btn
                >
              </template>

              <v-dialog v-model="dialogLogin" max-width="762px" persistent>
                <div class="box-client">
                  <div class="information-client">
                    <v-text-field
                      v-model="userData.email"
                      :rules="emailRules"
                      @keyup="lowercase"
                      label="E-mail"
                      required
                      v-on:keyup="submitLogin"
                    ></v-text-field>
                    <v-text-field
                      v-model="userData.password"
                      type="password"
                      label="Senha"
                      v-on:keyup="submitLogin"
                    ></v-text-field>
                  </div>
                  <div class="salvarCons">
                    <v-btn
                      class="btn-login"
                      @click="login"
                      :loading="loading"
                      rounded
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
          </v-col>
        </v-row>
      </v-container>

      <v-dialog v-model="dialogAgendar" max-width="600px">
        <v-card class="modal-agendar">
          <v-card-title>
            <span>Agendar Visita</span>
          </v-card-title>

          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12">
                  <v-menu
                    ref="menu"
                    v-model="menu"
                    :close-on-content-click="false"
                    offset-y
                    min-width="auto"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        class="visita-picker"
                        v-model="viewVisita"
                        label="Data da visita"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                      ></v-text-field>
                    </template>

                    <v-date-picker
                      color="#43CEA2"
                      header-color="#43CEA2"
                      ref="picker"
                      locale="pt-BR"
                      v-model="date"
                      :min="new Date().toISOString().substr(0, 10)"
                      @change="save"
                    ></v-date-picker>
                  </v-menu>
                </v-col>

                <v-col class="hourLabel" cols="12">
                  <label>Hora da visita</label>
                  <v-text-field
                    class="timePicker"
                    v-model="visitaHora"
                    type="time"
                  >
                  </v-text-field>

                  <label>Tipo da visita</label>
                  <v-radio-group
                    class="timePicker"
                    :row="true"
                    v-model="tipoVisita"
                  >
                    <v-radio label="Presencial" value="1"></v-radio>
                    <v-radio label="Virtual" value="0"></v-radio>
                  </v-radio-group>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn text @click="dialogAgendar = false">Cancelar</v-btn>

            <v-btn
              text
              @click="agendarVisita"
              :loading="loading"
              class="loaderBtn"
              >Agendar</v-btn
            >
          </v-card-actions>
        </v-card>
      </v-dialog>
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
  name: "single-imovel",
  data() {
    return {
      loged_user: JSON.parse(localStorage.getItem(userKey)),
      is_loged: false,
      loading: false,
      link: "",
      dialogYtb: false,
      dialog360: false,
      quantUnidade: 0,
      botaoYtb: false,
      botaoTour: false,
      botaoQuant: false,
      dialogLogin: false,
      dialogAgendar: false,
      verifica: false,
      consultarConsultor: "",
      selecionado: true,
      imgPadraoCorr: {
        src: require("../../assets/icone_corretor.png"),
      },
      pageReady: false,
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
      id: 0,
      slug: "",
      imovelData: [],
      emailRules: [
        (v) => !!v || "O Email é obrigatório",
        (v) => /.+@.+\..+/.test(v) || "Email precisa ser válido",
      ],
      date: null,
      menu: false,
      viewCorr: false,
      viewVisita: "",
      dataVisita: "",
      visitaHora: "",
      tipoVisita: "",
      idsArray: [],
      visitaData: [],
      consultorData: [],
      corretorID: "",

      changedValue: "",
      imgPadrao: {
        src: require("../../assets/banner-cadastro.png"),
      },
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
  },
  created() {
    this.slug = this.$route.params.slug;
  },
  mounted() {
    this.loadImovel();
    this.listaPreferidos();
  },
  beforeMount() {
    if (this.loged_user) {
      this.is_loged = true;
      this.loadCorretor();
    }
  },
  watch: {
    menu(val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = "MONTH"));
    },
    date() {
      this.viewVisita = this.formatDate(this.date);
      this.dataVisita = this.date;
    },
  },
  methods: {
    insereLinkTour() {
      for (let i = 0; i < this.imovelData.caracteristicas.length; i++) {
        if (this.imovelData.caracteristicas[i].descricao == "Tour360") {
          this.dialog360 = true;
          // console.log(this.imovelData.caracteristicas[i].valor);
          // console.log("entrou no tour");
          this.link = this.imovelData.caracteristicas[i].valor;
          return this.link;
        }
      }
    },
    insereLinkYtb() {
      this.dialog360 = true;
      for (let i = 0; i < this.imovelData.caracteristicas.length; i++) {
        if (this.imovelData.caracteristicas[i].descricao == "Youtube") {
          // console.log(this.imovelData.caracteristicas[i].valor);
          // console.log("entrou no youtube");
          this.link = this.imovelData.caracteristicas[i].valor;
          return this.link;
        }
      }
    },
    copiarLink() {
      var dummy = document.createElement("input"),
        text = window.location.href;

      document.body.appendChild(dummy);
      dummy.value = text;
      dummy.select();
      document.execCommand("copy");
      document.body.removeChild(dummy);
      Vue.toasted.global.defaultSuccess({
        msg: "Link copiado com sucesso!",
      });
    },
    existLinkYtb() {
      // console.log(this.imovelData.caracteristicas.length);
      for (let i = 0; i < this.imovelData.caracteristicas.length; i++) {
        if (this.imovelData.caracteristicas[i].descricao == "Youtube") {
          this.botaoYtb = true;
        }
      }
    },

    existLinkTour() {
      for (let i = 0; i < this.imovelData.caracteristicas.length; i++) {
        if (this.imovelData.caracteristicas[i].descricao == "Tour360") {
          this.botaoTour = true;
        }
      }
    },
    existQuantidade() {
      for (let i = 0; i < this.imovelData.caracteristicas.length; i++) {
        if (this.imovelData.caracteristicas[i].descricao == "Unidades") {
          this.botaoQuant = true;
          this.quantUnidade = this.imovelData.caracteristicas[i].quantidade;
        }
      }
    },
    goSingleImovel() {
      this.$router.push({ path: "/imovel/" + this.slug + "" });
    },
    goSimulacao() {
      this.$router.push({ path: "/simular-financiamento/" + this.slug + "" });
    },
    goNegociacao() {
      this.$router.push({ path: "/iniciar-negociacao/" + this.slug + "" });
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

    btnPreferido(id) {
      // btnNonePreferidos  .classList.add
      if (this.user != null) {
        if (this.user.cliente_id) {
          let teste = document.querySelectorAll(
            ".imovel" + id + " .btnPreferidos button"
          );

          this.preferidoId = id;

          let chamaFuncao = false;
          //console.log("teste");
          //console.log(teste);
          //console.log("teste");
          let tam = teste.length - 1;

          for (var i = 0; i <= tam; i++) {
            //console.log(i);
            if (
              teste[i].className.split(" ").indexOf("btnNonePreferidos") != -1
            ) {
              teste[i].classList.remove("btnNonePreferidos");
              chamaFuncao = true;
            } else {
              teste[i].classList.add("btnNonePreferidos");
              chamaFuncao = false;
            }
          }
          if (chamaFuncao) {
            //
            //console.log("insere funcao");
            this.inserePreferido();
          } else {
            //
            //console.log("remove funcao");
            this.removePreferido();
          }
        } else {
          Vue.toasted.global.defaultError({
            errors: "Necessário ser cliente!",
          });
        }
      } else {
        Vue.toasted.global.defaultError({
          errors: "Necessário estar logado para executar ação!",
        });
      }
    },

    inserePreferido() {
      //console.log(this.preferidoId);
      this.$http
        .post("/preferido/inserir", {
          produtoid: this.preferidoId,
        })
        .then((res) => {
          this.preferidosData = res.data;
          this.restartImg();
        })
        .catch(showError);
    },

    removePreferido() {
      //console.log("remove id " + this.preferidoId);
      this.$http
        .post("/preferido/excluir", {
          produtoid: this.preferidoId,
        })
        .then((res) => {
          this.preferidosData = res.data;
          this.listaPreferidos();
          this.restartImg();
          this.listaPreferidos();
        })
        .catch(showError);
    },

    listaPreferidos() {
      if (this.user != null) {
        if (this.user.cliente_id) {
          this.$http
            .post("/preferido/listar")
            .then((res) => {
              this.preferidosData = res.data;
              for (let j = 0; j < this.preferidosData.preferidos.length; j++) {
                this.idsArray[j] = this.preferidosData.preferidos[j].id;
              }
              //console.log(this.idsArray);
            })
            .catch(() => {
              this.preferidosData.preferidos = [];
            });
        }
      } else {
        //tudo bem
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
              this.$router.go(this.$router.currentRoute)
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

    selectConsultor(i, idCorr) {
      this.idCorretor = idCorr;
      // console.log(this.idCorretor);
      this.viewCorr = true;
      Vue.set(this.selecionado, i, !this.selecionado[i]);
    },

    submitLogin(e) {
      if (e.keyCode === 13) {
        this.login();
      } else if (e.keyCode === 27) {
        this.dialogLogin = false;
      }
    },

    loadCorretor() {
      if (this.user.corretor_id_preferido != null) {
        this.$http
          .post("/corretores/" + this.user.corretor_id_preferido + "?tipo=id")
          .then((res) => {
            this.consultorData = res.data;
          })
          .catch(showError);
      }
    },

    loadImovel() {
      this.$http
        .get("/imovel/" + this.slug + "")
        .then((res) => {
          this.imovelData = res.data;
          this.existLinkYtb();
          this.existLinkTour();
          this.existQuantidade();

          setTimeout(() => (this.pageReady = true), 1000);
        })
        .catch(showError);
    },

    searchCorrCreci() {
      if (this.consultarConsultor != "") {
        this.$http
          .post("/corretores/busca", {
            consuta: this.consultarConsultor,
          })
          .then((res) => {
            this.consultorData = res.data;
            // console.log(this.consultorData);
            this.selecionado = this.consultorData.map(() => false);
          })
          .catch(showError);
      } else {
        Vue.toasted.global.defaultError({
          errors: "Digitar o CRECI ou nome do Corretor!",
        });
      }
    },

    verificaFotoCons(img) {
      if (typeof img.url == "string") {
        return img.url;
      } else {
        return this.imgPadraoCorr.src;
      }
    },

    formatValor(valor) {
      let texto = valor.toString();
      texto = texto.replace(/\D/g, "");
      let newTexto = "";
      let quant = texto.length;

      for (var member in texto) {
        if (quant - member == 2) {
          newTexto = newTexto.concat("." + texto[member]);
        } else {
          newTexto = newTexto.concat(texto[member]);
        }
      }
      var numero = parseFloat(newTexto).toFixed(2).split(".");
      numero[0] = numero[0].split(/(?=(?:...)*$)/).join(".");
      return `R$ ${numero.join(",")}`;
    },

    formatDate(date) {
      if (!date) return null;
      const [year, month, day] = date.split("-");
      return `${day}/${month}/${year}`;
    },

    save(date) {
      this.$refs.menu.save(date);
    },

    agendarVisita() {
      this.loading = true;
      var myData = "" + this.dataVisita + " " + this.visitaHora + ":00";

      if (this.viewCorr != true) {
        this.idCorretor = null;
      }

      this.$http
        .post("/imovel/visita/" + this.imovelData.id + "", {
          data: myData,
          is_presencial: this.tipoVisita,
          corretor_id: this.idCorretor,
        })
        .then((res) => {
          this.visitaData = res.data;
          this.loading = false;
          this.dialogAgendar = false;
          Vue.toasted.global.defaultSuccess({
            msg: "Agendamento feito com sucesso!",
          });
        })
        .catch(showError);
    },

    verificBanner(img) {
      if (img) {
        return img.url;
      } else {
        return this.imgPadrao.src;
      }
    },
  },
};
</script>


<style>
#agendarVisita .btn-padrao {
  background-color: #185a9d;
  border: none;
  box-sizing: border-box;
  border-radius: 8px;
  padding: 20px;
  margin-top: 15px;
}
#agendarVisita .btn-padrao span {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 20px;
  line-height: 22px;
  color: #ffffff;
  text-transform: initial;
}
#agendarVisita {
  background-color: #000;
}
#agendarVisita .banner-destaque {
  padding: 100px 0px 0px;
  position: relative;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  z-index: 1;
  height: 90vh;
  display: flex;
  align-items: flex-end;
}
#agendarVisita .banner-destaque:before {
  content: "";
  position: absolute;
  width: 100%;
  height: 100%;
  display: block;
  background: linear-gradient(1.84deg, #000000 7%, rgba(0, 0, 0, 0) 90%);
  left: 0;
  top: 0;
  z-index: -1;
}
#agendarVisita .banner-destaque h1 {
  font-family: "Buda", cursive;
  font-style: normal;
  font-weight: 300;
  font-size: 60px;
  line-height: 75px;
  color: #ffffff;
}
#agendarVisita .banner-destaque h3 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 500;
  font-size: 32px;
  line-height: 35px;
  color: #ffffff;
}
#agendarVisita .banner-destaque .align-right {
  text-align: right;
}
#agendarVisita .banner-destaque .menu-single {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 50px;
}
#agendarVisita .banner-destaque .menu-single ul {
  display: flex;
  padding: 0;
  margin: 0;
  justify-content: space-between;
  list-style: none;
}
#agendarVisita .banner-destaque .menu-single .imovel-menu li {
  margin-left: 15px;
}
#agendarVisita .banner-destaque .menu-single .imovel-menu li p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 20px;
  line-height: 22px;
  color: #ffffff;
  margin: 0 0 0 15px;
  border-bottom: 1px solid transparent;
  transition: 0.5s;
  cursor: pointer;
}
#agendarVisita .banner-destaque .menu-single .imovel-menu li p:hover {
  border-bottom: 1px solid #43cea2;
  transition: 0.5s;
}
#agendarVisita .banner-destaque .menu-single .imovel-menu .divisor-menu {
  border-left: 1px solid #43cea2;
}
#agendarVisita .banner-destaque .menu-single .imovel-actions li {
  margin-right: 20px;
}
#agendarVisita .banner-destaque .menu-single .imovel-actions li .v-btn {
  height: 100%;
  width: 100%;
}
#agendarVisita .banner-destaque .icon-area {
  height: 75px;
  display: flex;
  justify-content: flex-end;
  align-items: center;
}
#agendarVisita .banner-destaque .icon-area .banner-btn {
  border: 1px solid #43cea2;
  box-sizing: border-box;
  border-radius: 8px;
  background-color: transparent;
  margin-left: 20px;
  padding: 10px 35px;
  transition: 0.5s;
}
#agendarVisita .banner-destaque .icon-area .banner-btn span {
  color: #fff;
}
#agendarVisita .banner-destaque .icon-area .btn-circle {
  border-radius: 50%;
  padding: 0;
  height: 45px;
  width: 45px;
}
#agendarVisita .banner-destaque .icon-area .banner-btn:hover {
  background: linear-gradient(
    180deg,
    #43cea2 0%,
    rgba(67, 206, 162, 0) 100%
  ) !important;
  transition: 0.5s;
}
#agendarVisita
  .banner-destaque
  .icon-area
  .banner-btn:not(.v-btn--text):not(.v-btn--outlined):hover:before {
  color: transparent !important;
}
.btnNonePreferidos {
  display: none !important;
}
#agendarVisita .agendar-infos {
  margin: 80px 0;
  padding: 45px 0;
  border-bottom: 1px solid rgba(67, 206, 162, 0.2);
}
#agendarVisita .agendar-infos .box-agendar {
  border: 1px solid rgba(255, 255, 255, 0.1);
  box-sizing: border-box;
  border-radius: 4px;
  padding: 30px 65px;
  text-align: center;
}
#agendarVisita .agendar-infos .box-agendar .align-agendar,
#agendarVisita .agendar-infos .box-agendar .align-agendar .selected-imovel {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
#agendarVisita .agendar-infos .box-agendar .align-agendar .selected-imovel h3 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 22px;
  line-height: 24px;
  color: #ffffff;
}
#agendarVisita .agendar-infos .box-agendar .align-agendar .selected-imovel p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 22px;
  color: #ffffff;
}
#agendarVisita .agendar-infos .box-agendar .align-agendar .selected-imovel img {
  width: 145px;
  height: 135px;
  border-radius: 4px;
  border: 1px solid #ffffff;
  box-sizing: border-box;
  object-fit: cover;
  object-position: center;
}
#agendarVisita
  .agendar-infos
  .box-agendar
  .align-agendar
  .selected-imovel
  .imovel-details {
  text-align: left;
  margin-left: 15px;
}
#agendarVisita .agendar-infos .box-agendar .align-agendar .selected-corretor {
  text-align: center;
}
.cancelarCons {
  padding-right: 5px;
  padding-left: 5px;
  display: inline;
}
.salvarCons {
  padding-right: 5px;
  padding-left: 5px;
  display: inline;
}
#agendarVisita
  .agendar-infos
  .box-agendar
  .align-agendar
  .selected-corretor
  h4 {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 16px;
  line-height: 22px;
  color: #ffffff;
}
#agendarVisita .agendar-infos .box-agendar .align-agendar .selected-corretor p {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 300;
  font-size: 14px;
  line-height: 19px;
  color: #ffffff;
}
#inspire
  #agendarVisita
  .banner-destaque
  .menu-single
  .imovel-actions
  .v-btn__content
  .playImg {
  padding: 10px 15px;
  border: 1px solid #43cea2;
  border-radius: 10px;
}
#inspire
  #agendarVisita
  .banner-destaque
  .menu-single
  .imovel-actions
  .v-btn__content
  .playImg:hover {
  background: linear-gradient(
    180deg,
    #43cea2 0%,
    rgba(67, 206, 162, 0) 100%
  ) !important;
  transition: 0.5s;
}
#inspire
  #agendarVisita
  .banner-destaque
  .menu-single
  .imovel-actions
  .v-btn__content
  .tourImg {
  padding: 0px 5px;
  border: 1px solid #43cea2;
  border-radius: 10px;
}
#inspire
  #agendarVisita
  .banner-destaque
  .menu-single
  .imovel-actions
  .v-btn__content
  .tourImg:hover {
  background: linear-gradient(
    180deg,
    #43cea2 0%,
    rgba(67, 206, 162, 0) 100%
  ) !important;
  transition: 0.5s;
}
#inspire
  #agendarVisita
  .banner-destaque
  .menu-single
  .imovel-actions
  .v-btn__content
  p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 15px;
  color: #ffffff;
  padding: 11px 11px;
  border: 1px solid #43cea2;
  margin-top: 16px;
  border-radius: 10px;
  box-sizing: border-box;
}
#inspire #agendarVisita .container .imovel-actions .v-btn:before {
  color: #43cea2;
  justify-content: center;
  background-color: transparent;
}
#inspire
  #agendarVisita
  .banner-destaque
  .menu-single
  .imovel-actions
  .v-btn__content
  p:hover {
  background: linear-gradient(
    180deg,
    #43cea2 0%,
    rgba(67, 206, 162, 0) 100%
  ) !important;
  transition: 0.5s;
}
#inspire
  #agendarVisita
  .banner-destaque
  .menu-single
  .imovel-actions
  .v-btn__content
  span {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 7px;
  text-align: center;
  color: #ffffff;
}
#agendarVisita
  .agendar-infos
  .box-agendar
  .align-agendar
  .selected-corretor
  img {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  object-fit: cover;
  object-position: top center;
  margin: 10px 0 5px;
}

#app #inspire #agendarVisita .agendar-infos .consultor-title .search-consult {
  margin: 10px 0px;
  display: flex;
}
#app
  #inspire
  #agendarVisita
  .agendar-infos
  .consultor-title
  .search-consult
  h2 {
  margin: 20px 0;
  text-align: left;
  font-family: "Roboto", sans-serif !important;
  font-size: 15px !important;
}
#app #inspire .timePicker .v-radio .primary--text {
  color: rgb(67 206 162) !important;
}
#app #inspire .timePicker .v-radio i {
  color: #f2f2f2 !important;
}

#app #inspire .theme--light.v-card {
  background-color: #000;
}
.consultor-title {
  padding-top: 20px;
}
#agendarVisita .search-consult .btn-search-consult {
  background-color: #43cea2;
  color: #fff;
  width: 35px;
  height: 35px;
  margin: 15px 3px;
}
.box-client {
  background-color: rgba(0, 0, 0, 0.8);
  padding: 50px 45px 95px;
  text-align: center;
  height: 300px;
}
.mudarBack {
  background-color: #43cea2;
}
.scrollDiv {
  max-height: 185px;
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

.consultor-title .card-consultor:hover {
  background-color: #4f4f4f;
}
#agendarVisita .search-consult .v-input__slot {
  border: 1px solid #ffffff;
  box-sizing: border-box;
  border-radius: 29.5px;
  background-color: transparent;
  width: fit-content;
  margin: 0;
}
#agendarVisita .search-consult .v-input {
  width: fit-content;
  flex: initial;
  margin: 15px 10px;
  padding: 0;
}

.loaderBtn {
  color: #43cea2 !important;
}

#agendarVisita .search-consult .v-input input {
  border: 1px solid transparent;
  border-radius: 29.5px;
  text-align: center;
}
#agendarVisita .search-consult .v-input .v-text-field__details {
  display: none;
}
#agendarVisita .search-consult .v-input .v-text-field__slot {
  min-width: 115px;
  width: min-content;
}

.custom-loader {
  animation: loader 1s infinite;
  display: flex;
}
@-moz-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@-webkit-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@-o-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}

#inspire .modal-agendar {
  padding: 15px 25px;
}
#inspire .modal-agendar .v-card__title span {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 500;
  font-size: 32px;
  line-height: 35px;
  text-align: center;
  color: #ffffff;
  border-bottom: 1px solid #43cea2;
  margin-bottom: 15px;
}
#inspire .modal-agendar .v-card__actions .v-btn__content {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: bold;
  font-size: 14px;
  line-height: 22px;
  color: #ffffff;
}
#inspire .modal-agendar .visita-picker .v-input__prepend-outer .v-icon {
  color: #fff;
  font-size: 35px;
}
#inspire .modal-agendar .visita-picker .v-messages__message {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 22px;
  color: #828282;
  padding: 2px 5px;
}

#inspire .modal-agendar .v-input__slot {
  background-color: transparent;
  border-radius: 0;
}
#inspire .modal-agendar .user-dados .v-input input {
  border-bottom: 1px solid #fff;
}
.box-client .information-client .v-input__slot {
  border-bottom: 1px solid #fff;
}
#inspire
  .box-client
  .information-client
  .v-input
  .v-input__control
  .v-input__slot {
  background-color: transparent;
  border-radius: 0;
}
#inspire
  .box-client
  .information-client
  .v-input
  .v-input__control
  .v-input__slot::before {
  border-bottom: 1px solid #fff;
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
#inspire .modal-agendar .v-text-field .v-label {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 14px;
  color: #828282;
}

#inspire .modal-agendar .timePicker {
  margin: 0;
  padding: 5px 0 10px;
}
#inspire .modal-agendar .hourLabel {
  margin-top: 10px;
}
.timePicker input[type="time"]::-webkit-calendar-picker-indicator {
  background: none;
}
.timePicker input[type="time"]::-webkit-datetime-edit-hour-field,
.timePicker input[type="time"]::-webkit-datetime-edit-minute-field {
  background-color: transparent;
  color: #f2f2f2;
}

@media (max-width: 1330px) {
  #agendarVisita .banner-destaque h1 {
    font-size: 40px;
  }
  #agendarVisita .banner-destaque h3 {
    font-size: 24px;
    line-height: 27px;
  }
  #agendarVisita .banner-destaque .menu-single .imovel-actions li .v-btn img {
    width: 100%;
    height: 40px;
    object-fit: contain;
    object-position: center;
  }
  #agendarVisita .banner-destaque .menu-single .imovel-menu li p {
    font-size: 17px;
  }
}
@media (max-width: 768px) {
  #agendarVisita .banner-destaque .menu-single .imovel-menu li {
    margin-left: 10px;
  }
  #agendarVisita .banner-destaque .menu-single .imovel-menu li p {
    font-size: 14px;
    margin-left: 10px;
  }
}
@media (max-width: 500px) {
  #agendarVisita .agendar-infos .box-agendar .align-agendar,
  #agendarVisita .agendar-infos .box-agendar .align-agendar .selected-imovel {
    display: block;
  }
  #agendarVisita .agendar-infos .box-agendar {
    padding: 30px;
  }
  #agendarVisita
    .agendar-infos
    .box-agendar
    .align-agendar
    .selected-imovel
    .imovel-details {
    text-align: center;
    margin-left: 0;
  }
  #agendarVisita .btn-padrao span {
    font-size: 13px;
  }
  #agendarVisita .btn-padrao {
    padding: 15px;
  }
  #agendarVisita .banner-destaque,
  #agendarVisita .banner-destaque .align-right,
  #agendarVisita .basic-infos h2,
  #agendarVisita .basic-infos p {
    text-align: center;
  }
  #agendarVisita .banner-destaque .icon-area,
  #agendarVisita .banner-destaque .menu-single ul {
    justify-content: center;
  }
  #agendarVisita .banner-destaque .menu-single,
  #agendarVisita .basic-infos .icon-list,
  #agendarVisita .banner-destaque .menu-single .imovel-menu ul,
  #financiamnetoPage .financiamento-info .dado-basico {
    display: block;
  }
  #agendarVisita .banner-destaque .menu-single .imovel-menu .divisor-menu {
    border: none;
  }
  #agendarVisita .banner-destaque .menu-single .imovel-menu li {
    margin-left: 0px;
    margin: 10px 0 0px 0px;
  }
  #agendarVisita .banner-destaque .menu-single .imovel-menu li p {
    margin: 0;
    display: inline;
  }
  #agendarVisita .banner-destaque .menu-single .imovel-actions li {
    margin-right: 10px;
    margin-left: 10px;
  }
  #financiamnetoPage .financiamento-info .dado-basico h4 {
    text-align: center;
    padding-bottom: 20px;
  }
  #financiamnetoPage .financiamento-info .box-financiamento {
    padding: 15px;
  }
  #financiamnetoPage .financiamento-info .dado-basico {
    padding: 50px 0px 40px;
  }

  .v-menu__content--fixed {
    left: 0px !important;
    right: 0px;
    margin: auto;
  }
  .v-picker__body {
    width: 260px !important;
  }

  #inspire .modal-agendar .v-card__title span {
    font-size: 19px;
  }
  .modal-agendar .v-card__title {
    display: block;
    text-align: center;
  }
}
</style>