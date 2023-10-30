<template>
  <section id="selectBank">
    <myHeader />

    <div
      class="selecione-banco"
      :style="{
        'background-image':
          'url(' + require('../../assets/casa-single.png') + ')',
      }"
    >
      <v-container>
        <v-row>
          <v-col class="text-center title-page" cols="12">
            <h2>
              Todas as informações apresentadas, taxas disponíveis e valores de
              parcelas podem sofrer alterações, feitas pelas instituíções
              financeiras.
            </h2>
          </v-col>

          <v-col
            cols="12"
            v-for="(banco, i) in financiamentoData.resultados"
            :key="i"
          >
            <v-expansion-panels class="panel-bancos">
              <v-expansion-panel class="box-bancos">
                <v-expansion-panel-header>
                  <div class="title-banco">
                    <img :src="formatImg(banco.operador)" />
                    <h2>
                      {{ banco.operador }}
                      <template v-if="banco.subProduto"
                        >- {{ banco.subProduto }}</template
                      >
                    </h2>
                  </div>

                  <div class="banco-infos">
                    <div class="banco-values">
                      <h4>Valor do imóvel</h4>
                      <p>{{ formatValor(imovelData.valor) }}</p>
                    </div>
                    <div class="banco-values">
                      <h4>Valor do financiamento</h4>
                      <p>{{ formatValor(banco.valorFinanciado, 2) }}</p>
                    </div>
                    <div class="banco-values">
                      <h4>Prazo</h4>
                      <p>{{ banco.prazo }} meses</p>
                    </div>
                    <div class="banco-values">
                      <h4>Primeira parcela</h4>
                      <p>{{ formatValor2(banco.prestacao) }}</p>
                    </div>
                    <div class="banco-values">
                      <h4>Última parcela</h4>
                      <p>{{ formatValor2(banco.prestacaoFinal) }}</p>
                    </div>
                    <div class="banco-values">
                      <h4>Taxa de juros anual/CET</h4>
                      <p>{{ banco.taxaJurosAnual }}% a.a</p>
                    </div>
                  </div>

                  <div class="btn-banco-action">
                    <v-btn class="btn-padrao btn-open-text">Ver mais</v-btn>
                    <v-btn class="btn-padrao btn-close-icon" icon
                      ><v-icon>mdi-close</v-icon></v-btn
                    >
                  </div>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                  <v-row>
                    <v-col cols="12">
                      <div class="dado-basico">
                        <h4>
                          <v-icon>mdi-map-marker</v-icon>
                          {{ imovelData.bairro }} - n°: {{ imovelData.numero }}
                        </h4>

                        <h4>
                          <v-icon>mdi-currency-usd-circle</v-icon> Valor do
                          imóvel: <b>{{ formatValor(imovelData.valor) }}</b>
                          <br /><span>Percentual de entrada: 20%</span>
                        </h4>
                      </div>
                    </v-col>
                    <v-col offset-md="1" md="10" cols="12">
                      <div class="parcelas-valor">
                        <h2>
                          PARCELAS DO FINANCIAMENTO
                          <v-icon>mdi-information-outline</v-icon>
                        </h2>
                        <p>
                          Conforme o total financiado é pago ao longo dos meses,
                          o valor da parcela diminui.
                        </p>

                        <div class="row arq-relative">
                          <div
                            class="offset-1 text-center col-5 parcela-exemplo"
                          >
                            <h5>PRIMEIRA PARCELA</h5>
                            <div class="dot-circle"></div>
                            <h6>
                              {{
                                informData(
                                  financiamentoData.primeiraParcela.data
                                )
                              }}
                            </h6>
                            <p>
                              <span>{{
                                formatValor(
                                  financiamentoData.primeiraParcela.valor
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
                                informDataFinal(
                                  financiamentoData.primeiraParcela.data
                                )
                              }}
                            </h6>
                            <p>
                              <span>{{
                                formatValor(banco.prestacaoFinal)
                              }}</span>
                            </p>
                          </div>
                        </div>
                      </div>
                    </v-col>

                    <v-col offset-md="2" md="8" cols="12">
                      <div class="box-custos">
                        <h2>
                          PARCELAS DO FINANCIAMENTO
                          <v-icon>mdi-information-outline</v-icon>
                        </h2>
                        <p>
                          Conforme o total financiado é pago ao longo dos meses,
                          o valor da parcela diminui.
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
                              {{ formatValor(banco.prestacao) }}
                            </p>
                          </div>
                          <div class="text-prices">
                            <p class="text-left">Condomínio</p>
                            <p class="text-right">R$ 0,00</p>
                          </div>
                          <div class="text-prices">
                            <p class="text-left">IPTU</p>
                            <p class="text-right">R$ 0,00</p>
                          </div>

                          <div class="text-prices">
                            <p class="text-left"><b>Total por mês</b></p>
                            <p class="text-right">
                              <b>{{ formatValor(banco.prestacao) }}</b>
                            </p>
                          </div>
                        </div>

                        <h2 class="arq-margin">CONDIÇÕES DA SIMULAÇÃO</h2>

                        <div class="box-prices-info">
                          <div class="text-prices">
                            <p class="text-left">Entrada</p>
                            <p class="text-right">
                              {{ formatValor(valorEntrada) }}
                            </p>
                          </div>
                          <div class="text-prices">
                            <p class="text-left">Prazo de financiamento</p>
                            <p class="text-right">
                              {{ convertPrazo(valorPrazo) }} anos
                            </p>
                          </div>
                          <div class="text-prices">
                            <p class="text-left">Taxas de juros</p>
                            <p class="text-right">
                              {{ banco.taxaJurosAnual }}% a.a
                            </p>
                          </div>
                        </div>
                      </div>
                    </v-col>

                    <v-col cols="12">
                      <div class="text-center">
                        <v-btn @click="goNegociacao" class="btn-padrao"
                          >Contratar</v-btn
                        >
                      </div>
                    </v-col>
                  </v-row>
                </v-expansion-panel-content>
              </v-expansion-panel>
            </v-expansion-panels>
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

import moment from "moment";
import "moment/locale/pt-br";

import axios from "axios";

delete axios.defaults.headers.common["USER_EMAIL"];
delete axios.defaults.headers.common["USER_TOKEN"];
delete axios.defaults.headers.common["Authorization"];

export default {
  name: "selecionar-banco",
  data() {
    return {
      imovelData: [],
      financiamentoData: [],
      pageReady: false,
      dataUser: "",
      minValue: "",
      bancoUser: localStorage.getItem("bancoSelecionado"),
      valorPrazo: localStorage.getItem("valorPrazo"),
      valorEntrada: localStorage.getItem("valorEntrada"),
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
  },
  mounted() {
    this.loadImovel();
  },
  methods: {
    goNegociacao() {
      this.$router.push({ path: "/iniciar-negociacao/" + this.id + "" });
    },

    loadImovel() {
      this.$http
        .get("/imovel/" + this.id + "")
        .then((res) => {
          this.imovelData = res.data;
          if (this.user == null) {
            this.dataUser = "01/01/1955";
          } else {
            this.dataUser = this.formatDate(this.user.nascimento);
          }
          // console.log("imovel data valor");
          // console.log(this.imovelData.valor);
          var numVal1 = this.formatValor(this.imovelData.valor, 1);
          // console.log(numVal1);

          var totalValue = numVal1 - this.valorEntrada;
          this.minValue = numVal1 - totalValue;
          // console.log("minimo valor");
          // console.log(this.minValue);

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
        })
        .catch(showError);
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
          // this.financiamentoData = res.data;
          // console.log(this.financiamentoData);

          // setTimeout(() => (this.pageReady = true), 1000);
        })
        .catch(showError);
    },

    formatDate(date) {
      if (!date) return null;
      const [year, month, day] = date.split("-");
      return `${day}/${month}/${year}`;
    },
    formatImg(img) {
      return require("../../assets/banco-" + img + ".png");
    },
    formatValor2(valor) {
      let texto = valor.toString();
      let numVal2 = texto.split(".");
      if (typeof numVal2[1] == "undefined") {
        texto = texto + `00`;
      }
      // console.log(texto);
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
        //   console.log(newTexto);
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
#selectBank .selecione-banco .title-page h2 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 18px;
  line-height: 20px;
  color: #ffffff;
  padding: 25px 0px;
}
#selectBank
  .selecione-banco
  .panel-bancos.v-expansion-panels
  .v-expansion-panel {
  background-color: transparent;
}
#selectBank .selecione-banco .panel-bancos .box-bancos .title-banco {
  display: flex;
  align-items: center;
  padding: 0 20px;
}
#selectBank .selecione-banco .panel-bancos .box-bancos img {
  width: 57px;
  height: 57px;
  border-radius: 8px;
  object-fit: cover;
  object-position: center;
}
#selectBank .selecione-banco .panel-bancos .box-bancos h2 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 22px;
  line-height: 24px;
  color: #ffffff;
  margin-left: 25px;
}
#selectBank .selecione-banco .panel-bancos .box-bancos .banco-infos {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid transparent;
  transition: 0.5s;
  padding: 35px 20px;
}
#selectBank
  .selecione-banco
  .panel-bancos
  .box-bancos
  .banco-infos
  .banco-values {
  display: block;
  text-align: center;
}
#selectBank
  .selecione-banco
  .panel-bancos
  .box-bancos
  .banco-infos
  .banco-values
  h4 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: bold;
  font-size: 18px;
  line-height: 20px;
  color: #ffffff;
  padding-bottom: 5px;
}
#selectBank
  .selecione-banco
  .panel-bancos
  .box-bancos
  .banco-infos
  .banco-values
  p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: lighter;
  font-size: 18px;
  line-height: 20px;
  color: #ffffff;
  margin: 0;
}
#selectBank
  .selecione-banco
  .panel-bancos
  .box-bancos
  .v-expansion-panel-header {
  display: block;
  padding: 50px 0 0;
}
#selectBank
  .selecione-banco
  .panel-bancos
  .box-bancos
  .v-expansion-panel-header
  .v-expansion-panel-header__icon {
  display: none;
}
#selectBank
  .selecione-banco
  .panel-bancos
  .box-bancos
  .v-expansion-panel-header--active
  .banco-infos {
  border-bottom: 1px solid #ffffff;
  transition: 0.5s;
}
#selectBank
  .selecione-banco
  .panel-bancos
  .v-expansion-panel
  .v-expansion-panel-content {
  border-bottom: 1px solid transparent;
}
#selectBank
  .selecione-banco
  .panel-bancos
  .v-expansion-panel--active
  .v-expansion-panel-content {
  border-bottom: 1px solid #ffffff;
  transition: 0.5s;
}
#selectBank
  .selecione-banco
  .panel-bancos
  .v-expansion-panel
  .btn-banco-action {
  display: flex;
  justify-content: flex-end;
  position: relative;
  padding: 40px 0;
}
#selectBank
  .selecione-banco
  .panel-bancos
  .v-expansion-panel
  .btn-banco-action
  .btn-padrao {
  position: absolute;
  right: 0;
  top: 15px;
  bottom: 0;
  margin: 0;
}
#selectBank .selecione-banco .panel-bancos .v-expansion-panel .btn-close-icon {
  opacity: 0;
  transition: 0.5s;
}
#selectBank
  .selecione-banco
  .panel-bancos
  .v-expansion-panel--active
  .btn-close-icon {
  opacity: 1 !important;
  right: 30px !important;
  transition: 0.5s;
  background-color: transparent !important;
}
#selectBank .selecione-banco .panel-bancos .v-expansion-panel .btn-open-text {
  opacity: 1;
  transition: 0.5s;
}
#selectBank
  .selecione-banco
  .panel-bancos
  .v-expansion-panel--active
  .btn-open-text {
  opacity: 0 !important;
  transition: 0.5s;
}

#selectBank .btn-padrao {
  background-color: #185a9d;
  border: none;
  box-sizing: border-box;
  border-radius: 8px;
  padding: 20px 25px;
  margin-top: 65px;
  margin-bottom: 40px;
}
#selectBank .btn-padrao span {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 20px;
  line-height: 22px;
  color: #ffffff;
  text-transform: initial;
}
#selectBank .arq-margin {
  margin: 75px 0px 25px;
}
#selectBank {
  background-color: #000;
}
#selectBank .selecione-banco {
  padding: 120px 0px 50px;
  position: relative;
  background-position: top center;
  background-repeat: no-repeat;
  background-size: contain;
  z-index: 1;
  display: flex;
  align-items: center;
}
#selectBank .selecione-banco:before {
  content: "";
  position: absolute;
  width: 100%;
  height: 100%;
  display: block;
  background: linear-gradient(
    0.89deg,
    #000000 71.22%,
    rgba(0, 0, 0, 0) 142.95%
  );
  left: 0;
  top: 0;
  z-index: -1;
}
#selectBank .selecione-banco .btn-voltar {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 24px;
  line-height: 26px;
  color: #43cea2;
  display: flex;
  align-items: center;
}
#selectBank .selecione-banco .btn-voltar .v-icon {
  font-size: 35px;
  line-height: 26px;
  color: #43cea2;
}
#selectBank .selecione-banco h1 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 32px;
  line-height: 30px;
  color: #fff;
  text-align: center;
  padding-top: 120px;
}
#selectBank .selecione-banco .dado-basico {
  display: flex;
  justify-content: space-between;
  padding: 30px 75px 100px;
}
#selectBank .selecione-banco .dado-basico h4 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 300;
  font-size: 20px;
  line-height: 22px;
  color: #ffffff;
  text-align: left;
}
#selectBank .selecione-banco .dado-basico h4 .v-icon {
  color: #185a9d;
  font-size: 25px;
}
#selectBank .selecione-banco .dado-basico h4 span {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 100;
  font-size: 18px;
  line-height: 20px;
  padding-left: 30px;
  color: #ffffff;
}
#selectBank .selecione-banco .parcelas-valor {
  text-align: center;
}
#selectBank .selecione-banco {
  border-bottom: 1px solid #43cea2;
  padding-bottom: 90px;
}
#selectBank .selecione-banco .parcelas-valor h2,
#selectBank .selecione-banco .box-custos h2 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 22px;
  line-height: 30px;
  color: #ffffff;
  padding-bottom: 10px;
  text-align: center;
}
#selectBank .selecione-banco .parcelas-valor p,
#selectBank .selecione-banco .box-custos p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 18px;
  line-height: 20px;
  color: #ffffff;
  text-align: center;
  margin: 0;
}
#selectBank .selecione-banco .box-custos .box-slider {
  margin: 70px 50px;
}
#selectBank .selecione-banco .box-custos .box-slider .v-slider__thumb-label {
  background-color: transparent !important;
}
#selectBank .selecione-banco .box-custos .box-slider .speech-bubble {
  border: 1px solid #43cea2;
  box-sizing: border-box;
  background-color: transparent;
  border-radius: 0;
  padding: 5px 10px;
}
#selectBank .selecione-banco .box-custos .box-slider .speech-bubble p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 17px;
  text-align: center;
  color: #43cea2;
}
#selectBank .selecione-banco .box-custos .box-slider .speech-bubble:after {
  border: none;
}

#selectBank .selecione-banco .parcelas-valor h5 {
  color: #7e7e7e;
  font-size: 19px;
  font-weight: bold;
  margin: 0;
  padding-bottom: 15px;
  padding-top: 18px;
}
#selectBank .selecione-banco .parcelas-valor .dot-circle {
  width: 15px;
  height: 15px;
  background-color: #7e7e7e;
  border-radius: 50%;
  margin: auto;
}
#selectBank .selecione-banco .parcelas-valor h6 {
  color: #7e7e7e;
  font-size: 17px;
  font-weight: 400;
  text-align: center;
  margin: 0;
  padding-top: 15px;
}

#selectBank .selecione-banco .parcelas-valor p span {
  font-weight: bold;
  color: #7e7e7e;
  font-size: 15px;
  text-align: center;
  margin: 0;
}
#selectBank .selecione-banco .arq-relative {
  position: relative;
  padding: 30px 0px;
}
#selectBank .selecione-banco .border-parcela {
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
#selectBank .selecione-banco .box-custos .box-slider .v-slider:before {
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
#selectBank .selecione-banco .box-custos .box-slider .v-slider:after {
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
#selectBank
  .selecione-banco
  .box-custos
  .box-slider
  .v-slider
  .v-slider__thumb-container {
  z-index: 5;
}
#selectBank .selecione-banco .box-custos .box-slider .v-input {
  position: relative;
}
#selectBank
  .selecione-banco
  .box-custos
  .box-slider
  .v-input
  .v-input__prepend-outer {
  margin: 0;
  position: absolute;
  bottom: 0;
  left: -10px;
}
#selectBank
  .selecione-banco
  .box-custos
  .box-slider
  .v-input
  .v-input__append-outer {
  margin: 0;
  position: absolute;
  bottom: 0;
  right: -10px;
}
#selectBank
  .selecione-banco
  .box-custos
  .box-slider
  .v-input
  .v-input__prepend-outer
  h5,
#selectBank
  .selecione-banco
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
@media (max-width: 500px) {
  #selectBank .selecione-banco .panel-bancos .box-bancos .banco-infos {
    display: block;
  }
  #selectBank .selecione-banco .border-parcela {
    top: -15px;
  }
  #selectBank .selecione-banco .dado-basico {
    display: block;
    padding: 25px 0px 15px;
  }
  #selectBank .selecione-banco .dado-basico h4 {
    text-align: center;
  }
  #selectBank
    .selecione-banco
    .panel-bancos
    .box-bancos
    .banco-infos
    .banco-values {
    padding: 10px 0;
  }
}
</style>