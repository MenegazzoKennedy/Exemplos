<template>
  <section v-if="pageReady == true" id="financiamnetoPage">
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
            <div
              class="imovel-menu align-right"
              v-if="user != null && exist_clientId == true"
            >
              <ul>
                <li class=""><p @click="goSingleImovel">Sobre o imóvel</p></li>
                <li class="divisor-menu">
                  <p @click="goAgendar">Agendar visita</p>
                </li>
                <li class="divisor-menu">
                  <p @click="goNegociacao">Iniciar negociação</p>
                </li>
                <li class="divisor-menu active-page">
                  <p @click="goSimulacao">Simular financiamento</p>
                </li>
              </ul>
            </div>
            <div class="imovel-menu align-right" v-else-if="user == null">
              <ul>
                <li class=""><p @click="goSingleImovel">Sobre o imóvel</p></li>
                <li class="divisor-menu">
                  <p @click="goAgendar">Agendar visita</p>
                </li>
                <li class="divisor-menu">
                  <p @click="goNegociacao">Iniciar negociação</p>
                </li>
                <li class="divisor-menu active-page">
                  <p @click="goSimulacao">Simular financiamento</p>
                </li>
              </ul>
            </div>
            <div class="imovel-menu align-right" v-else>
              <ul>
                <li class=""><p @click="goSingleImovel">Sobre o imóvel</p></li>
                <li class="divisor-menu">
                  <p @click="goNegociacao">Iniciar negociação</p>
                </li>
                <li class="divisor-menu active-page">
                  <p @click="goSimulacao">Simular financiamento</p>
                </li>
              </ul>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </div>

    <div class="financiamento-info">
      <v-container>
        <v-row>
          <v-col cols="12">
            <h2>SIMULAR FINANCIAMENTO DO IMÓVEL</h2>

            <div class="dado-basico">
              <h4>
                <v-icon>mdi-map-marker</v-icon> {{ imovelData.bairro }} - n°:
                {{ imovelData.numero }}
              </h4>

              <h4>
                <v-icon>mdi-currency-usd-circle</v-icon> Valor do imóvel:
                <b>{{ formatValor(imovelData.valor) }}</b>
                <br /><span>Percentual de entrada: 20%</span>
              </h4>
            </div>

            <div class="box-financiamento">
              <h3>
                Quanto você quer pagar de entrada?
                <v-icon>mdi-information-outline</v-icon>
              </h3>
              <p>Considere tambem seu FGTS caso queira utiliza-lo.</p>

              <v-text-field
                v-model="valorFinanciamento"
                type="text"
                @keyup="formatNumber"
                hide-details
                placeholder="Valor"
              ></v-text-field>
              <p class="valueInput">{{ textValue }}</p>

              <v-btn
                @click="simular"
                :disabled="!acceptValue"
                class="btn-cadastro"
                >Simular</v-btn
              >
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
import { showError } from "@/global";
import { mapState } from "vuex";
import myHeader from "../Header/header.vue";
import myFooter from "../Footer/footer.vue";

export default {
  name: "simular-financiamento",
  data() {
    return {
      id: 0,
      slug: "",
      pageReady: false,
      imovelData: [],
      link: "",
      exist_clientId: false,
      dialogYtb: false,
      dialog360: false,
      quantUnidade: 0,
      idsArray: [],
      botaoYtb: false,
      botaoTour: false,
      botaoQuant: false,
      valorFinanciamento: "",
      textValue: "R$",
      imgPadrao: {
        src: require("../../assets/banner-cadastro.png"),
      },
      minValue: "",
      acceptValue: true,
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
    this.id = this.$route.params.id;
    this.slug = this.$route.params.slug;
  },
  mounted() {
    this.loadImovel();
    this.listaPreferidos();
  },
  watch: {
    valorFinanciamento() {
      if (
        this.valorFinanciamento >= this.minValue ||
        this.valorFinanciamento == ""
      ) {
        this.acceptValue = true;
      } else {
        this.acceptValue = false;
      }
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
    formatNumber() {
      this.textValue = new Intl.NumberFormat([], {
        style: "currency",
        currency: "BRL",
      }).format(this.valorFinanciamento);
    },

    loadImovel() {
      this.$http.get("/imovel/" + this.slug + "").then((res) => {
        this.imovelData = res.data;
        // console.log(this.imovelData);

        var numVal1 = this.imovelData.valor;
        // console.log(numVal1);
        var numVal2 = this.formatValor(numVal1, 1);
        numVal1 = parseFloat(numVal2);
        numVal2 = numVal1 * 0.2;
        numVal1 = numVal2.toString();
        numVal2 = numVal1.split(".");
        if (typeof numVal2[1] != "undefined") {
          numVal1 = numVal2[1].slice(0, 2);
          this.minValue = numVal2[0] + "." + numVal1;
          // console.log(this.minValue);
        } else {
          this.minValue = numVal1;
          // console.log(this.minValue);
        }

        setTimeout(() => (this.pageReady = true), 1000);
      });
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
          this.exist_clientId = true;
          this.$http
            .post("/preferido/listar")
            .then((res) => {
              this.preferidosData = res.data;
              for (let j = 0; j < this.preferidosData.preferidos.length; j++) {
                this.idsArray[j] = this.preferidosData.preferidos[j].id;
              }
              ////console.log(this.idsArray);
            })
            .catch(() => {
              this.preferidosData.preferidos = [];
            });
        }
      } else {
        //tudo bem
      }
    },

    simular() {
      if (this.valorFinanciamento == "") {
        this.valorFinanciamento = this.minValue;
        // console.log(this.valorFinanciamento);
        localStorage.setItem("valorEntrada", this.valorFinanciamento);
      } else {
        localStorage.setItem("valorEntrada", this.valorFinanciamento);
      }
      this.$router.push({ path: "/simular-valor/" + this.slug + "" });
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
    goAgendar() {
      this.$router.push({ path: "/agendar-visita/" + this.slug + "" });
    },

    formatValor(valor, tipo) {
      if (tipo == 1) {
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

        return newTexto;
      } else {
        let texto = valor.toString();
        texto = texto.replace(/\D/g, "");
        let newTexto = "";
        let quant = texto.length;

        for (member in texto) {
          if (quant - member == 2) {
            newTexto = newTexto.concat("." + texto[member]);
          } else {
            newTexto = newTexto.concat(texto[member]);
          }
        }
        // console.log(newTexto);
        var numero = parseFloat(newTexto).toFixed(2).split(".");
        numero[0] = numero[0].split(/(?=(?:...)*$)/).join(".");

        return `R$ ${numero.join(",")}`;
      }
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
#financiamnetoPage .btn-padrao {
  background-color: #185a9d;
  border: none;
  box-sizing: border-box;
  border-radius: 8px;
  padding: 22px 25px;
  margin-top: 35px;
}
#financiamnetoPage .btn-padrao span {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 20px;
  line-height: 22px;
  color: #ffffff;
  text-transform: initial;
}
#financiamnetoPage {
  background-color: #000;
}
#financiamnetoPage .banner-destaque {
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
#financiamnetoPage .banner-destaque:before {
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
#financiamnetoPage .banner-destaque h1 {
  font-family: "Buda", cursive;
  font-style: normal;
  font-weight: 300;
  font-size: 60px;
  line-height: 75px;
  color: #ffffff;
}
#financiamnetoPage .banner-destaque h3 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 500;
  font-size: 32px;
  line-height: 35px;
  color: #ffffff;
}
#financiamnetoPage .banner-destaque .align-right {
  text-align: right;
}
#financiamnetoPage .banner-destaque .menu-single {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 50px;
}
#financiamnetoPage .banner-destaque .menu-single ul {
  display: flex;
  padding: 0;
  margin: 0;
  justify-content: space-between;
  list-style: none;
}
#financiamnetoPage .banner-destaque .menu-single .imovel-menu li {
  margin-left: 15px;
}
#financiamnetoPage .banner-destaque .menu-single .imovel-menu li p {
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
#financiamnetoPage .banner-destaque .menu-single .imovel-menu li p:hover {
  border-bottom: 1px solid #43cea2;
  transition: 0.5s;
}
#financiamnetoPage .banner-destaque .menu-single .imovel-menu .divisor-menu {
  border-left: 1px solid #43cea2;
}
#financiamnetoPage .banner-destaque .menu-single .imovel-actions li {
  margin-right: 20px;
}
#financiamnetoPage .banner-destaque .menu-single .imovel-actions li .v-btn {
  height: 100%;
  width: 100%;
}

#financiamnetoPage .banner-destaque .icon-area {
  height: 75px;
  display: flex;
  justify-content: flex-end;
  align-items: center;
}
#financiamnetoPage .banner-destaque .icon-area .banner-btn {
  border: 1px solid #43cea2;
  box-sizing: border-box;
  border-radius: 8px;
  background-color: transparent;
  margin-left: 20px;
  padding: 10px 35px;
  transition: 0.5s;
}
#financiamnetoPage .banner-destaque .icon-area .banner-btn span {
  color: #fff;
}
#financiamnetoPage .banner-destaque .icon-area .btn-circle {
  border-radius: 50%;
  padding: 0;
  height: 45px;
  width: 45px;
}
#financiamnetoPage .banner-destaque .icon-area .banner-btn:hover {
  background: linear-gradient(
    180deg,
    #43cea2 0%,
    rgba(67, 206, 162, 0) 100%
  ) !important;
  transition: 0.5s;
}
#financiamnetoPage
  .banner-destaque
  .icon-area
  .banner-btn:not(.v-btn--text):not(.v-btn--outlined):hover:before {
  color: transparent !important;
}
#financiamnetoPage .financiamento-info {
  border-bottom: 1px solid #43cea2;
  text-align: center;
  display: flex;
  align-items: center;
  padding: 90px 155px;
}
#financiamnetoPage .financiamento-info h2 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 32px;
  line-height: 30px;
  color: #43cea2;
}
#financiamnetoPage .financiamento-info .dado-basico {
  display: flex;
  justify-content: space-between;
  padding: 75px 0 100px;
}
#financiamnetoPage .financiamento-info .dado-basico h4 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 300;
  font-size: 20px;
  line-height: 22px;
  color: #ffffff;
  text-align: left;
}
#financiamnetoPage .financiamento-info .dado-basico h4 .v-icon {
  color: #185a9d;
  font-size: 25px;
}
#financiamnetoPage .financiamento-info .dado-basico h4 span {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 100;
  font-size: 18px;
  line-height: 20px;
  padding-left: 30px;
  color: #ffffff;
}
#financiamnetoPage .financiamento-info .box-financiamento {
  background-color: rgba(26, 25, 25, 0.4);
  padding: 90px;
}
#financiamnetoPage .financiamento-info .box-financiamento h3 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 29px;
  line-height: 30px;
  color: #ffffff;
}
#financiamnetoPage .financiamento-info .box-financiamento h3 .v-icon {
  color: #fff;
  font-size: 16px;
}
#financiamnetoPage .financiamento-info .box-financiamento p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: lighter;
  font-size: 18px;
  line-height: 30px;
  color: #ffffff;
}
#financiamnetoPage .financiamento-info .box-financiamento .v-input__slot {
  background-color: transparent;
  border-radius: 0;
}
#financiamnetoPage .financiamento-info .box-financiamento .v-input {
  width: 30%;
  margin: auto;
  padding: 25px 0 0px;
}
#financiamnetoPage
  .financiamento-info
  .box-financiamento
  .v-input
  .v-text-field__slot {
  border-bottom: 1px solid #fff;
}
#financiamnetoPage .financiamento-info .box-financiamento .v-input input {
  opacity: 0;
}
#financiamnetoPage
  .financiamento-info
  .box-financiamento
  .v-text-field
  > .v-input__control
  > .v-input__slot:after {
  color: #43cea2;
}
#financiamnetoPage .box-financiamento .btn-cadastro {
  background-color: #43cea2;
  border-radius: 8px;
  margin-top: 35px;
}
#financiamnetoPage .box-financiamento .btn-cadastro span {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: bold;
  font-size: 14px;
  line-height: 19px;
  text-align: center;
  color: #000000;
  text-transform: initial;
}
#financiamnetoPage
  .box-financiamento
  .btn-cadastro.v-btn--disabled:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
  background-color: gray !important;
}

#financiamnetoPage
  .financiamento-info
  .box-financiamento
  .v-input
  input::-webkit-outer-spin-button,
#financiamnetoPage
  .financiamento-info
  .box-financiamento
  .v-input
  input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
.btnNonePreferidos {
  display: none !important;
}
#financiamnetoPage
  .financiamento-info
  .box-financiamento
  .v-input
  input[type="number"] {
  -moz-appearance: textfield;
}
#financiamnetoPage .financiamento-info .box-financiamento .valueInput {
  margin-top: -33px;
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 26px;
  line-height: 28px;
  color: #bdbdbd;
}

@media (max-width: 1330px) {
  #financiamnetoPage .banner-destaque h1 {
    font-size: 40px;
  }
  #financiamnetoPage .banner-destaque h3 {
    font-size: 24px;
    line-height: 27px;
  }
  #financiamnetoPage
    .banner-destaque
    .menu-single
    .imovel-actions
    li
    .v-btn
    img {
    width: 100%;
    height: 40px;
    object-fit: contain;
    object-position: center;
  }
  #financiamnetoPage .banner-destaque .menu-single .imovel-menu li p {
    font-size: 17px;
  }
}
@media (max-width: 768px) {
  #financiamnetoPage .financiamento-info .dado-basico {
    display: block;
    padding: 55px 0 40px;
  }
  #financiamnetoPage .banner-destaque .menu-single .imovel-menu li {
    margin-left: 10px;
  }
  #financiamnetoPage .banner-destaque .menu-single .imovel-menu li p {
    font-size: 14px;
    margin-left: 10px;
  }
  #financiamnetoPage .slider-imoveis .slick-track {
    height: 330px;
  }
  #financiamnetoPage .slider-imoveis .box-imovel {
    transition: 0.5s;
    height: 320px;
    z-index: 30;
    border: 1px solid #43cea2;
    box-sizing: border-box;
    border-radius: 0px;
  }
  #financiamnetoPage .slider-imoveis .box-imovel:hover {
    transform: scale(1);
  }
  #financiamnetoPage .slider-imoveis .box-imovel .imovel-infos {
    opacity: 1;
    transition: 0.5s;
    min-height: 200px;
  }
  #financiamnetoPage .slider-imoveis .slick-slider .slick-arrow {
    opacity: 1;
    transition: 0.5s;
  }
  #financiamnetoPage .financiamento-info .box-financiamento {
    padding: 20px;
  }
  #financiamnetoPage .financiamento-info .dado-basico h4 {
    text-align: center;
  }
}
@media (max-width: 500px) {
  #financiamnetoPage .financiamento-info .dado-basico {
    display: block;
    padding: 55px 0 40px;
  }
  #financiamnetoPage .financiamento-info .dado-basico h4 {
    text-align: center;
  }
  #financiamnetoPage .financiamento-info {
    padding: 45px 15px;
  }
  #financiamnetoPage .banner-destaque,
  #financiamnetoPage .banner-destaque .align-right,
  #financiamnetoPage .basic-infos h2,
  #financiamnetoPage .basic-infos p {
    text-align: center;
  }
  #financiamnetoPage .banner-destaque .icon-area,
  #financiamnetoPage .banner-destaque .menu-single ul {
    justify-content: center;
  }
  #financiamnetoPage .banner-destaque .menu-single,
  #financiamnetoPage .basic-infos .icon-list,
  #financiamnetoPage .banner-destaque .menu-single .imovel-menu ul {
    display: block;
  }
  #financiamnetoPage .banner-destaque .menu-single .imovel-menu .divisor-menu {
    border: none;
  }
  #financiamnetoPage .banner-destaque .menu-single .imovel-menu li {
    margin-left: 0px;
    margin: 10px 0 0px 0px;
  }
  #financiamnetoPage .banner-destaque .menu-single .imovel-menu li p {
    margin: 0;
    display: inline;
  }
  #financiamnetoPage .banner-destaque .menu-single .imovel-actions li {
    margin-right: 10px;
    margin-left: 10px;
  }
  #financiamnetoPage .basic-infos .box-financiamento {
    padding: 50px 10px;
  }
  #financiamnetoPage .basic-infos .box-financiamento h2 {
    font-size: 23px;
    line-height: 29px;
  }
  #financiamnetoPage .basic-infos .box-financiamento h2 span {
    font-size: 42px;
    line-height: 45px;
  }
  #financiamnetoPage .basic-infos .box-financiamento p {
    font-size: 14px;
    line-height: 30px;
  }
  #financiamnetoPage .slider-imoveis .slider-area h2 {
    padding: 0;
    text-align: center;
  }
  #financiamnetoPage .financiamento-info .box-financiamento {
    padding: 20px;
  }
  #financiamnetoPage .financiamento-info .box-financiamento .v-input {
    width: 90%;
  }
}
</style>