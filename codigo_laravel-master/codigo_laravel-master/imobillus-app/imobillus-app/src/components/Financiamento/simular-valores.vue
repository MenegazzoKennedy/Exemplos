<template>
  <section v-if="pageReady == true" id="simularValor">
    <myHeader />

    <div
      class="banner-destaque"
      :style="{
        'background-image': 'url(' + verificBanner(imovelData.midias[0]) + ')',
      }"
    >
      <v-container>
        <v-row>
          <v-col cols="12">
            <a class="btn-voltar" @click="goBack">
              <v-icon>mdi-chevron-left</v-icon>
              Voltar
            </a>
            <h1>SIMULAR FINANCIAMENTO DO IMÓVEL</h1>

            <div class="dado-basico">
              <h4>
                <v-icon>mdi-map-marker</v-icon> {{ imovelData.bairro }} - n°:
                {{ imovelData.numero }}
              </h4>

              <h4>
                <v-icon>mdi-currency-usd-circle</v-icon> Valor do imóvel:
                <b>{{ formatValor(imovelData.valor) }}</b> <br /><span
                  >Percentual de entrada: 20%</span
                >
              </h4>
            </div>
          </v-col>
          <v-col offset-md="1" md="10">
            <div class="parcelas-valor">
              <h2>
                PARCELAS DO FINANCIAMENTO
                <v-icon>mdi-information-outline</v-icon>
              </h2>
              <p>
                Conforme o total financiado é pago ao longo dos meses, o valor
                da parcela diminui.
              </p>

              <div class="row arq-relative">
                <div class="offset-1 text-center col-5 parcela-exemplo">
                  <h5>PRIMEIRA PARCELA</h5>
                  <div class="dot-circle"></div>
                  <h6>
                    {{ informData(financiamentoData.primeiraParcela.data) }}
                  </h6>
                  <p>
                    <span>{{
                      formatValor(
                        financiamentoData.primeiraParcela.valor.toString(),
                        2
                      )
                    }}</span>
                  </p>
                </div>

                <div class="border-parcela"></div>

                <div class="text-center col-5 parcela-exemplo">
                  <h5>ÚLTIMA PARCELA</h5>
                  <div class="dot-circle"></div>
                  <h6>
                    {{
                      informDataFinal(financiamentoData.primeiraParcela.data)
                    }}
                  </h6>
                  <p>
                    <span>{{
                      formatValor(bancoSelecionado.prestacaoFinal.toString(), 2)
                    }}</span>
                  </p>
                </div>
              </div>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </div>

    <div class="simular-custos">
      <v-container>
        <v-row>
          <v-col offset-md="2" md="8">
            <div class="box-custos">
              <h2>
                PARCELAS DO FINANCIAMENTO
                <v-icon>mdi-information-outline</v-icon>
              </h2>
              <p>
                Conforme o total financiado é pago ao longo dos meses, o valor
                da parcela diminui.
              </p>

              <!-- <div class="box-slider">
                                <v-slider
                                v-model="valueTeam"
                                persistent-hint
                                background-color="transparent"
                                min="2021"
                                :max="2040"
                                step="1"
                                color="#43CEA2"
                                track-color="#185A9D"
                                track-fill-color="#43CEA2"
                                thumb-label="always">
                                    <template v-slot:prepend>
                                        <h5>2021</h5>
                                    </template>

                                    <template v-slot:thumb-label="{}">
                                        <div class="speech-bubble">
                                            <p>{{valueTeam}}</p>
                                        </div>
                                    </template>

                                    <template v-slot:append>
                                        <h5>2040</h5>
                                    </template>
                                </v-slider>
                            </div> -->

              <div class="box-prices-info">
                <div class="text-prices">
                  <p class="text-left">Parcelas</p>
                  <p class="text-right">
                    {{ formatValor2(bancoSelecionado.prestacao.toString()) }}
                  </p>
                </div>
                <div class="text-prices">
                  <p class="text-left">Condomínio</p>
                  <p class="text-right">R$ 0</p>
                </div>
                <div class="text-prices">
                  <p class="text-left">IPTU</p>
                  <p class="text-right">R$ 0</p>
                </div>

                <div class="text-prices">
                  <p class="text-left"><b>Total por mês</b></p>
                  <p class="text-right">
                    <b>{{
                      formatValor2(bancoSelecionado.prestacao.toString())
                    }}</b>
                  </p>
                </div>
              </div>

              <h2 class="arq-margin">CONDIÇÕES DA SIMULAÇÃO</h2>

              <div class="box-prices-info">
                <div class="text-prices">
                  <p class="text-left">Entrada</p>
                  <p class="text-right">
                    {{ formatValor2(valorEntrada) }}
                  </p>
                </div>
                <div class="text-prices">
                  <p class="text-left">Prazo de financiamento</p>
                  <p class="text-right">
                    {{ convertPrazo(bancoSelecionado.prazo) }} anos
                  </p>
                </div>
                <div class="text-prices">
                  <p class="text-left">Taxas de juros</p>
                  <p class="text-right">
                    {{ bancoSelecionado.taxaJurosAnual }}% a.a
                  </p>
                </div>
              </div>
            </div>
          </v-col>

          <v-col cols="12">
            <div class="price-dados">
              <div class="box-prices">
                <h4>Quanto você quer pagar de entrada?</h4>
                <v-text-field
                  type="number"
                  v-model="newEntrada"
                  @keyup="formatNumber"
                  hide-details
                  placeholder="R$"
                ></v-text-field>
                <p>{{ textEntrada }}</p>
              </div>

              <div class="box-prices">
                <h4>em quanto tempo quer terminar de pagar?</h4>
                <v-text-field
                  v-model="tempoPagar"
                  @blur="formatTempo"
                  @focus="formatTempoini"
                  hide-details
                  placeholder="anos"
                  class="quantAnos"
                ></v-text-field>
              </div>

              <!-- <div class="box-prices">
                                <h4>taxa de juros</h4>
                                <v-text-field hide-details placeholder="%"></v-text-field>
                            </div> -->
            </div>

            <div class="text-center">
              <v-btn
                @click="recalculeInfo"
                :disabled="!acceptValue"
                class="btn-padrao"
                >Recalcular</v-btn
              >
              <v-btn @click="goNegociacao" class="btn-padrao">Contratar</v-btn>
              <v-btn @click="goBank" class="btn-padrao">Outras opções</v-btn>
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
import myHeader from "../Header/header.vue";
import myFooter from "../Footer/footer.vue";

import moment from "moment";
import "moment/locale/pt-br";

import axios from "axios";

delete axios.defaults.headers.common["USER_EMAIL"];
delete axios.defaults.headers.common["USER_TOKEN"];
delete axios.defaults.headers.common["Authorization"];

export default {
  name: "simular-valor",
  data() {
    return {
      id: 0,
      slug: "",
      nowData: new Date().getFullYear(),
      pageReady: false,
      acceptValue: false,
      imovelData: [],
      financiamentoData: [],
      valorEntrada: localStorage.getItem("valorEntrada"),
      valueTeam: 2021,
      valorPrazo: "",
      minValue: "",
      dataUser: "",
      tempoPagar: "",
      bancoUser: "",
      newEntrada: "",
      textEntrada: "R$",
      bancoSelecionado: [],

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
  },
  watch: {
    newEntrada() {
      if (this.newEntrada > this.minValue) {
        this.acceptValue = true;
      } else {
        this.acceptValue = false;
      }
    },
  },
  methods: {
    formatTempo() {
      let novoValor = this.tempoPagar.replace(/[^0-9]+/g, "");
      novoValor = novoValor + " anos";
      this.tempoPagar = novoValor;
    },
    formatTempoini() {
      let novoValor = this.tempoPagar.replace(/[^0-9]+/g, "");
      this.tempoPagar = novoValor;
    },
    goBack() {
      this.$router.push({ path: "/simular-financiamento/" + this.slug + "" });
    },
    goNegociacao() {
      this.$router.push({ path: "/iniciar-negociacao/" + this.slug + "" });
    },

    formatNumber() {
      this.textEntrada = new Intl.NumberFormat([], {
        style: "currency",
        currency: "BRL",
      }).format(this.newEntrada);
    },

    loadImovel() {
      this.$http.get("/imovel/" + this.slug + "").then((res) => {
        this.imovelData = res.data;
        if (this.user == null) {
          this.dataUser = "01/01/1955";
        } else {
          this.dataUser = this.formatDate(this.user.nascimento);
        }
        console.log("imovel data valor");
        console.log(this.imovelData.valor);
        var numVal1 = this.formatValor(this.imovelData.valor, 1);
        // console.log(numVal1);

        var totalValue = numVal1 - this.valorEntrada;
        this.minValue = numVal1 - totalValue;
        // console.log("minimo valor");
        console.log(this.minValue);

        var bankuser = localStorage.getItem("bancoSelecionado");

        if (bankuser == null) {
          this.bancoUser = "Itaú";
          localStorage.setItem("bancoSelecionado", "Itaú");
        } else {
          this.bancoUser = bankuser;
        }

        var mePrazo = localStorage.getItem("valorPrazo");

        if (mePrazo == null) {
          this.valorPrazo = 360;
        } else {
          this.valorPrazo = mePrazo * 12;
        }

        this.loadFinanciamento();
      });
    },
    formatValor2(valor) {
      let texto = valor.toString();
      let numVal2 = texto.split(".");
      if (typeof numVal2[1] == "undefined") {
        texto = texto + `00`;
      }
      return this.formatValor(texto);
    },
    formatValor(valor, tipo) {
      // console.log(valor);
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
      } else if (tipo == 2) {
        return new Intl.NumberFormat([], {
          style: "currency",
          currency: "BRL",
        }).format(valor);
        // let texto = valor.toString();
        // let teste = texto.indexOf(`.`);
        // if (teste == -1) {
        //   texto = `R$ ` + texto + `,00`;
        //   return texto;
        // } else {
        //   texto = texto.replace(/\D/g, "");
        //   let newTexto = "";
        //   let quant = texto.length;

        //   for (member in texto) {
        //     if (quant - member == 2) {
        //       newTexto = newTexto.concat("." + texto[member]);
        //     } else {
        //       newTexto = newTexto.concat(texto[member]);
        //     }
        //   }
        //   // console.log(newTexto);
        //   var numero = parseFloat(newTexto).toFixed(2).split(".");
        //   numero[0] = numero[0].split(/(?=(?:...)*$)/).join(".");

        //   return `R$ ${numero.join(",")}`;
        // }
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

    loadFinanciamento() {
      var numVal1 = this.formatValor(this.imovelData.valor, 1);
      var valorFinanciado = numVal1 - parseFloat(this.valorEntrada);
      // console.log(parseFloat(this.valorEntrada));
      // console.log("valor financiado");
      // console.log(valorFinanciado);
      if (this.user == null) {
        this.valorPrazo = 168;
      }

      axios
        .post("https://api-partner.credihome.com.br/staging/simulador", {
          valorImovel: numVal1,
          valorFinanciado: valorFinanciado,
          prazo: this.valorPrazo,
          produto: "mortgage",
          dataNascimento: this.dataUser,
          carencia: 0,
          esconderParcelas: true,
          calcularOutrosOperadores: true,
          exibirNomesOperadores: true,
          parseBankName: true,
          empresa: this.bancoUser,
          financiarAnaliseJuridica: true,
          financiarAvaliacaoImovel: true,
          financiarIOF: false,
          financiarITBI: true,
          financiarTaxaCadastro: true,
          financiarTaxaCartorio: false,
          refId: "adh123",
        })
        .then((res) => {
          this.financiamentoData = res.data;
          console.log(this.financiamentoData);

          for (let i = 0; i < this.financiamentoData.resultados.length; i++) {
            if (
              this.financiamentoData.resultados[i].operador == this.bancoUser
            ) {
              this.bancoSelecionado = this.financiamentoData.resultados[i];
              // console.log(this.bancoSelecionado);
            }
          }

          setTimeout(() => (this.pageReady = true), 1000);
        })
        .catch((e) => {
          Vue.toasted.global.defaultError({
            errors: e.response.data.errorMessage[0],
          });

          setTimeout(() => this.$router.go(-1), 1000);
        });
    },

    recalculeInfo() {
      localStorage.setItem("valorEntrada", this.newEntrada);
      let novoValor = this.tempoPagar.replace(/[^0-9]+/g, "");
      localStorage.setItem("valorPrazo", novoValor);

      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;

      setTimeout(() => this.$router.go(this.$router.currentRoute), 600);
    },

    goBank() {
      this.$router.push({ path: "/selecionar-banco/" + this.slug + "" });
    },

    verificBanner(img) {
      if (img) {
        return img.url;
      } else {
        return this.imgPadrao.src;
      }
    },

    formatDate(date) {
      if (!date) return null;
      const [year, month, day] = date.split("-");
      return `${day}/${month}/${year}`;
    },

    informData(data) {
      if (!data) return null;
      const newData = data.split("/");
      var formattedMonth = moment(newData[1], "MM").format("MMMM");
      return `${formattedMonth} DE ${newData[2]}`;
    },
    informDataFinal(data) {
      if (!data) return null;

      const newData = data.split("/");

      var prazoAno = localStorage.getItem("valorPrazo");
      if (prazoAno == null) {
        prazoAno = 30;
      }
      var newMonth = newData[1] - 1;
      var newYear = parseInt(newData[2]) + prazoAno;
      var formattedMonth = moment(newMonth, "MM").format("MMMM");

      return `${formattedMonth} DE ${newYear}`;
    },

    convertPrazo(prazo) {
      return prazo / 12;
    },
  },
};
</script>

<style>
#inspire .theme--light.quantAnos input {
  color: rgb(130 130 130) !important;
  text-align: center;
}
#simularValor .v-input input::-webkit-outer-spin-button,
#simularValor .v-input input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
#simularValor .v-input input[type="number"] {
  -moz-appearance: textfield;
}

#simularValor .box-prices .v-input input[type="number"] {
  opacity: 0;
}
#simularValor .box-prices p {
  margin-top: -25px;
  margin-bottom: 0;

  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 18px;
  line-height: 20px;
  color: #828282;
}

#simularValor
  .btn-padrao.v-btn--disabled:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
  background-color: gray !important;
}

#simularValor .btn-padrao {
  background-color: #185a9d;
  border: none;
  box-sizing: border-box;
  border-radius: 8px;
  padding: 20px 25px;
  margin: 65px 25px 0px;
}
#simularValor .btn-padrao span {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 20px;
  line-height: 22px;
  color: #ffffff;
  text-transform: initial;
}
#simularValor .arq-margin {
  margin: 75px 0px 25px;
}
#simularValor {
  background-color: #000;
}
#simularValor .banner-destaque {
  margin-bottom: 50px;
  padding-top: 120px;
  position: relative;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  z-index: 1;
  display: flex;
  align-items: center;
}
#simularValor .banner-destaque:before {
  content: "";
  position: absolute;
  width: 100%;
  height: 100%;
  display: block;
  background: linear-gradient(
    0.89deg,
    #000000 43.22%,
    rgba(0, 0, 0, 0) 142.95%
  );
  left: 0;
  top: 0;
  z-index: -1;
}
#simularValor .banner-destaque .btn-voltar {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 24px;
  line-height: 26px;
  color: #43cea2;
  display: flex;
  align-items: center;
}
#simularValor .banner-destaque .btn-voltar .v-icon {
  font-size: 35px;
  line-height: 26px;
  color: #43cea2;
}
#simularValor .banner-destaque h1 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 32px;
  line-height: 30px;
  color: #fff;
  text-align: center;
  padding-top: 120px;
}
#simularValor .banner-destaque .dado-basico {
  display: flex;
  justify-content: space-between;
  padding: 75px 75px 100px;
}
#simularValor .banner-destaque .dado-basico h4 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 300;
  font-size: 20px;
  line-height: 22px;
  color: #ffffff;
  text-align: left;
}
#simularValor .banner-destaque .dado-basico h4 .v-icon {
  color: #185a9d;
  font-size: 25px;
}
#simularValor .banner-destaque .dado-basico h4 span {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 100;
  font-size: 18px;
  line-height: 20px;
  padding-left: 30px;
  color: #ffffff;
}
#simularValor .banner-destaque .parcelas-valor {
  text-align: center;
}
#simularValor .simular-custos {
  border-bottom: 1px solid #43cea2;
  padding-bottom: 90px;
}
#simularValor .banner-destaque .parcelas-valor h2,
#simularValor .simular-custos .box-custos h2 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 22px;
  line-height: 30px;
  color: #ffffff;
  padding-bottom: 10px;
  text-align: center;
}
#simularValor .banner-destaque .parcelas-valor p,
#simularValor .simular-custos .box-custos p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 18px;
  line-height: 20px;
  color: #ffffff;
  text-align: center;
  margin: 0;
}
#simularValor .simular-custos .box-custos p {
  margin-bottom: 35px;
}
#simularValor .simular-custos .box-custos .box-slider {
  margin: 70px 50px;
}
#simularValor .simular-custos .box-custos .box-slider .v-slider__thumb-label {
  background-color: transparent !important;
}
#simularValor .simular-custos .box-custos .box-slider .speech-bubble {
  border: 1px solid #43cea2;
  box-sizing: border-box;
  background-color: transparent;
  border-radius: 0;
  padding: 5px 10px;
}
#simularValor .simular-custos .box-custos .box-slider .speech-bubble p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 17px;
  text-align: center;
  color: #43cea2;
}
#simularValor .simular-custos .box-custos .box-slider .speech-bubble:after {
  border: none;
}

#simularValor .banner-destaque .parcelas-valor h5 {
  color: #7e7e7e;
  font-size: 19px;
  font-weight: bold;
  margin: 0;
  padding-bottom: 15px;
  padding-top: 18px;
}
#simularValor .banner-destaque .parcelas-valor .dot-circle {
  width: 15px;
  height: 15px;
  background-color: #7e7e7e;
  border-radius: 50%;
  margin: auto;
}
#simularValor .banner-destaque .parcelas-valor h6 {
  color: #7e7e7e;
  font-size: 17px;
  font-weight: 400;
  text-align: center;
  margin: 0;
  padding-top: 15px;
  text-transform: uppercase;
}

#simularValor .banner-destaque .parcelas-valor p span {
  font-weight: bold;
  color: #7e7e7e;
  font-size: 15px;
  text-align: center;
  margin: 0;
}
#simularValor .banner-destaque .arq-relative {
  position: relative;
  padding: 30px 0px;
}
#simularValor .banner-destaque .border-parcela {
  width: 42%;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
  height: 2px;
  background-color: #7e7e7e;
}
#simularValor .simular-custos .box-custos .box-slider .v-slider:before {
  content: "";
  position: absolute;
  display: block;
  width: 14px;
  height: 14px;
  background-color: #43cea2;
  border-radius: 50%;
  left: -7px;
  top: 0;
  bottom: 0;
  margin: auto;
  z-index: 0;
}
#simularValor .simular-custos .box-custos .box-slider .v-slider:after {
  content: "";
  position: absolute;
  display: block;
  width: 14px;
  height: 14px;
  background-color: #185a9d;
  border-radius: 50%;
  right: -7px;
  top: 0;
  bottom: 0;
  margin: auto;
  z-index: 0;
}
#simularValor
  .simular-custos
  .box-custos
  .box-slider
  .v-slider
  .v-slider__thumb-container {
  z-index: 5;
}
#simularValor .simular-custos .box-custos .box-slider .v-input {
  position: relative;
}
#simularValor
  .simular-custos
  .box-custos
  .box-slider
  .v-input
  .v-input__prepend-outer {
  margin: 0;
  position: absolute;
  bottom: 0;
  left: -10px;
}
#simularValor
  .simular-custos
  .box-custos
  .box-slider
  .v-input
  .v-input__append-outer {
  margin: 0;
  position: absolute;
  bottom: 0;
  right: -10px;
}
#simularValor
  .simular-custos
  .box-custos
  .box-slider
  .v-input
  .v-input__prepend-outer
  h5,
#simularValor
  .simular-custos
  .box-custos
  .box-slider
  .v-input
  .v-input__append-outer
  h5 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 17px;
  text-align: center;
  color: #43cea2;
}

#simularValor .simular-custos .box-custos .box-prices-info {
  margin: 0 50px;
}
#simularValor .simular-custos .box-custos .box-prices-info .text-prices {
  display: flex;
  justify-content: space-between;
}
#simularValor .simular-custos .box-custos .box-prices-info .text-prices p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 18px;
  line-height: 20px;
  color: #ffffff;
  margin: 0;
  padding: 4px 0;
}
#simularValor .simular-custos .price-dados {
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 80px 0px 25px;
}
#simularValor .simular-custos .price-dados .box-prices {
  border: 1px solid #185a9d;
  box-sizing: border-box;
  border-radius: 8px;
  padding: 15px 25px 25px;
  margin: 0 15px;
  text-align: center;
}
#simularValor .simular-custos .price-dados .box-prices h4 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 14px;
  line-height: 30px;
  text-transform: uppercase;
  color: #ffffff;
}

#simularValor .simular-custos .price-dados .box-prices .v-input__slot {
  background-color: transparent;
  border-radius: 0;
}
#simularValor .simular-custos .price-dados .box-prices .v-input {
  width: 50%;
  margin: auto;
  padding: 0px;
}
#simularValor
  .simular-custos
  .price-dados
  .box-prices
  .v-input
  .v-text-field__slot {
  border-bottom: 1px solid #185a9d;
}

@media (max-width: 500px) {
  #simularValor .banner-destaque .dado-basico {
    display: block;
    padding: 55px 0px 50px;
  }
  #simularValor .simular-custos .box-custos .box-prices-info .text-prices,
  #simularValor .simular-custos .price-dados {
    display: block;
  }
  #simularValor .banner-destaque .dado-basico h4 {
    text-align: center;
  }
  #simularValor .simular-custos .price-dados .box-prices {
    margin: 25px 15px;
  }
}
</style>