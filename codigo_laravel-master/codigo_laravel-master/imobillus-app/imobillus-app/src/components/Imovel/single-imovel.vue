<template>
  <section v-if="pageReady == true" id="imovelSingle">
    <myHeader />

    <div
      class="banner-destaque"
      :style="{
        'background-image': 'url(' + verificBanner(imovelData.midias[0]) + ')',
      }"
      :class="'imovel' + imovelData.id"
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
                <li class="active-page">
                  <p @click="goSingleImovel">Sobre o imóvel</p>
                </li>
                <li class="divisor-menu">
                  <p @click="goAgendar">Agendar visita</p>
                </li>
                <li class="divisor-menu">
                  <p @click="goNegociacao">Iniciar negociação</p>
                </li>
                <li class="divisor-menu">
                  <p @click="goSimulacao">Simular financiamento</p>
                </li>
              </ul>
            </div>
            <div class="imovel-menu align-right" v-else-if="user == null">
              <ul>
                <li class="active-page">
                  <p @click="goSingleImovel">Sobre o imóvel</p>
                </li>
                <li class="divisor-menu">
                  <p @click="goAgendar">Agendar visita</p>
                </li>
                <li class="divisor-menu">
                  <p @click="goNegociacao">Iniciar negociação</p>
                </li>
                <li class="divisor-menu">
                  <p @click="goSimulacao">Simular financiamento</p>
                </li>
              </ul>
            </div>
            <div class="imovel-menu align-right" v-else>
              <ul>
                <li class="active-page">
                  <p @click="goSingleImovel">Sobre o imóvel</p>
                </li>
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

    <div class="basic-infos">
      <v-container>
        <v-row>
          <v-col cols="12">
            <h2>SOBRE O IMÓVEL</h2>
            <p>{{ imovelData.descricao }}</p>

            <div class="icon-list">
              <template v-for="(infos, i) in imovelData.caracteristicas">
                <div
                  v-if="infos.is_coord != 1 && infos.icone != null"
                  class="box-icon"
                  :key="i"
                >
                  <img :src="formatImg(infos.icone)" />
                  <p>{{ infos.descricao }}</p>
                  <p v-if="infos.quantidade == null">
                    <span>
                      {{ formatValorIcone(infos.valor) }}
                    </span>
                  </p>
                  <p v-if="infos.valor == null">
                    <span>
                      {{ formatValorIcone(infos.quantidade) }}
                    </span>
                  </p>
                </div>
              </template>
            </div>

            <h2>DETALHES DO IMÓVEL</h2>
            <p>{{ imovelData.detalhes }}</p>

            <h2>GALERIA DE FOTOS</h2>
            <VueSlickCarousel :arrows="true" :dots="false" v-bind="settings">
              <template v-for="(fotos, i) in imovelData.midias">
                <div :key="i" class="galeriaFotos" @click="openImg = true">
                  <img :src="fotos.url" />
                </div>
                <v-dialog :key="i" v-model="openImg" max-width="762px">
                  <img :src="fotos.url" />
                </v-dialog>
              </template>
            </VueSlickCarousel>

            <h2 v-if="imovelData.cep != null">LOCALIZAÇÃO</h2>
            <h4>
              <v-icon>mdi-map-marker</v-icon>
              <p v-show="imovelData.logradouro != null">
                {{ imovelData.logradouro }}
              </p>
              <p v-show="imovelData.numero != null">
                , n°: {{ imovelData.numero }}
              </p>
              <p v-show="imovelData.bairro != null">
                , {{ imovelData.bairro }}
              </p>
              <p v-show="imovelData.cep != null">, CEP {{ imovelData.cep }}</p>
            </h4>

            <div class="imovel-map" v-if="imovelData.cep != null">
              <GoogleMap
                :latitude="latitude"
                :longitude="longitude"
                :apiKey="apiKey"
                :zoom="14"
                with-marker
                :locations="locations"
              />
            </div>

            <div class="box-financiamento">
              <h2>Financie esse imóvel<br />em até <span>20.000,00</span></h2>
              <p>(NA PRIMEIRA PARCELA)</p>

              <v-btn @click="goSimulacao(imovelData.slug)" class="btn-padrao"
                >Faça sua simulação</v-btn
              >
            </div>
          </v-col>
        </v-row>
      </v-container>
    </div>

    <div class="slider-imoveis">
      <v-container fluid>
        <v-row>
          <v-col v-if="sliderReady == true" cols="12" class="slider-area">
            <h2>Semelhante a este imóvel</h2>

            <VueSlickCarousel :arrows="true" :dots="false" v-bind="settings">
              <template v-for="(semelhante, i) in semelhantesData[0].produto">
                <div v-if="semelhante.id != id" :key="i">
                  <div class="box-imovel" :class="'imovel' + semelhante.id">
                    <img
                      class="imagemPointer"
                      @click="goImovel(semelhante.slug)"
                      :src="verificBanner(semelhante.midias[0])"
                    />

                    <div class="imovel-infos">
                      <h3>{{ semelhante.titulo }}</h3>
                      <h5>{{ formatValor(semelhante.valor) }}</h5>

                      <p>{{ semelhante.descricao }}</p>

                      <div class="icon-list">
                        <template
                          v-for="(infos, i) in semelhante.caracteristicas"
                        >
                          <div
                            v-if="infos.is_coord != 1 && infos.icone != null"
                            class="box-icon"
                            :key="i"
                          >
                            <img :src="formatImgSlide(infos.icone)" />
                            <p v-if="infos.quantidade == null">
                              {{ formatValorIcone(infos.valor) }}
                            </p>
                            <p v-if="infos.valor == null">
                              {{ formatValorIcone(infos.quantidade) }}
                            </p>
                          </div>
                        </template>
                      </div>

                      <div class="banner-actions">
                        <div
                          class="btnPreferidos"
                          v-if="
                            idsArray.find((element) => element == semelhante.id)
                          "
                        >
                          <v-btn
                            icon
                            class="banner-btn btn-circle btnNonePreferidos"
                            @click="btnPreferido(semelhante.id)"
                            ><v-icon>mdi-plus</v-icon></v-btn
                          >
                          <v-btn
                            icon
                            class="banner-btn btn-circle"
                            @click="btnPreferido(semelhante.id)"
                          >
                            <v-icon>mdi-minus</v-icon>
                          </v-btn>
                        </div>
                        <div class="btnPreferidos" v-else>
                          <v-btn
                            icon
                            class="banner-btn btn-circle"
                            @click="btnPreferido(semelhante.id)"
                            ><v-icon>mdi-plus</v-icon></v-btn
                          >
                          <v-btn
                            icon
                            class="banner-btn btn-circle btnNonePreferidos"
                            @click="btnPreferido(semelhante.id)"
                          >
                            <v-icon>mdi-minus</v-icon>
                          </v-btn>
                        </div>
                        <v-btn
                          icon
                          class="banner-btn btn-circle btn-share"
                          @click="copiarLinkSemelhante(semelhante.slug)"
                          ><v-icon>mdi-share-variant</v-icon></v-btn
                        >

                        <v-btn
                          @click="goImovel(semelhante.slug)"
                          icon
                          class="banner-btn btn-circle btn-imovel-link"
                          ><v-icon>mdi-chevron-right</v-icon></v-btn
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </template>
            </VueSlickCarousel>
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
import { showError } from "@/global";
import myHeader from "../Header/header.vue";
import myFooter from "../Footer/footer.vue";

import GoogleMap from "vue-maps";

export default {
  name: "single-imovel",
  data() {
    return {
      openImg: false,
      botaoYtb: false,
      botaoTour: false,
      exist_clientId: false,
      botaoQuant: false,
      quantUnidade: 0,
      link: "",
      dialogYtb: false,
      dialog360: false,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 1,
        infinite: false,
        responsive: [
          {
            breakpoint: 800,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1,
            },
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
            },
          },
        ],
      },

      latitude: -23.585097,
      longitude: -46.6442079,
      apiKey: "AIzaSyCZolq_94i0pFyfi5DwAunlaM2KZ00KtZ0",
      locations: [
        {
          title: "",
          latitude: 0,
          longitude: 0,
        },
      ],
      pageReady: false,
      sliderReady: false,
      idsArray: [],
      imovelCategory: "",
      preferidoId: "",
      id: 0,
      slug: "",
      imovelData: [],
      semelhantesData: [],
      imgPadrao: {
        src: require("../../assets/banner-cadastro.png"),
      },
    };
  },
  components: {
    myHeader,
    myFooter,
    GoogleMap,
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
  methods: {
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

    preferidoBtn() {
      Vue.toasted.global.defaultError({ errors: "Função em desenvolvimento!" });
    },

    verificBanner(img) {
      if (img) {
        return img.url;
      } else {
        return this.imgPadrao.src;
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
          this.exist_clientId = true;
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

    loadImovel() {
      this.$http
        .get("/imovel/" + this.slug + "")
        .then((res) => {
          this.imovelData = res.data;
          // console.log(this.imovelData);
          this.existLinkYtb();
          this.existLinkTour();
          this.existQuantidade();
          this.locations[0].title = this.imovelData.titulo;
          this.imovelCategory = this.imovelData.categorias[0].slug;
          for (let i = 0; i < this.imovelData.caracteristicas.length; i++) {
            if (
              this.imovelData.caracteristicas[i].is_coord == 1 &&
              this.imovelData.caracteristicas[i].descricao == "longitude"
            ) {
              this.longitude = this.imovelData.caracteristicas[i].valor;
            }
            if (
              this.imovelData.caracteristicas[i].is_coord == 1 &&
              this.imovelData.caracteristicas[i].descricao == "latitude"
            ) {
              this.latitude = this.imovelData.caracteristicas[i].valor;
            }
          }
          this.locations[0].latitude = this.latitude;
          this.locations[0].longitude = this.longitude;
          setTimeout(
            () => (this.loadImovelSemelhante(), (this.pageReady = true)),
            1000
          );
        })
        .catch(showError);
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

    copiarLinkSemelhante(slug) {
      var dummy = document.createElement("input"),
        text = location.host + this.$router.history.base + "/imovel/" + slug;

      document.body.appendChild(dummy);
      dummy.value = text;
      dummy.select();
      document.execCommand("copy");
      document.body.removeChild(dummy);
      Vue.toasted.global.defaultSuccess({
        msg: "Link copiado com sucesso!",
      });
    },

    loadImovelSemelhante() {
      this.$http
        .get("/categorias/" + this.imovelCategory + "")
        .then((res) => {
          this.semelhantesData = res.data;

          setTimeout(() => (this.sliderReady = true), 1000);
        })
        .catch(showError);
    },
    formatValor(valor) {
      // return new Intl.NumberFormat([], {
      //   style: "currency",
      //   currency: "BRL",
      // }).format(valor);

      let texto = valor.toString();
      0;
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

    formatValorIcone(valor) {
      return new Intl.NumberFormat([]).format(valor);
    },

    goImovel(slug) {
      this.$router.push({ path: "/imovel/" + slug + "" });

      setTimeout(() => this.$router.go(this.$router.currentRoute), 600);
    },

    formatImg(img) {
      return require("../../assets/" + img + ".png");
    },
    formatImgSlide(img) {
      return require("../../assets/" + img + "-a.png");
    },
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
  },
};
</script>


<style>
#imovelSingle .btn-padrao {
  background-color: #185a9d;
  border: none;
  box-sizing: border-box;
  border-radius: 8px;
  padding: 22px 25px;
  margin-top: 35px;
}
#imovelSingle .btn-padrao span {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 20px;
  line-height: 22px;
  color: #ffffff;
  text-transform: initial;
}
#imovelSingle {
  background-color: #000;
}
#imovelSingle .banner-destaque {
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
#imovelSingle .banner-destaque:before {
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
#imovelSingle .banner-destaque h1 {
  font-family: "Buda", cursive;
  font-style: normal;
  font-weight: 300;
  font-size: 60px;
  line-height: 75px;
  color: #ffffff;
}
#imovelSingle .banner-destaque h3 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 500;
  font-size: 32px;
  line-height: 35px;
  color: #ffffff;
}
#imovelSingle .banner-destaque .align-right {
  text-align: right;
}
#imovelSingle .banner-destaque .menu-single {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 50px;
}
#imovelSingle .banner-destaque .menu-single ul {
  display: flex;
  padding: 0;
  margin: 0;
  justify-content: space-between;
  list-style: none;
}
#imovelSingle .banner-destaque .menu-single .imovel-menu li {
  margin-left: 15px;
}
#imovelSingle .banner-destaque .menu-single .imovel-menu li p {
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
#imovelSingle .banner-destaque .menu-single .imovel-menu li p:hover {
  border-bottom: 1px solid #43cea2;
  transition: 0.5s;
}
#imovelSingle .banner-destaque .menu-single .imovel-menu .divisor-menu {
  border-left: 1px solid #43cea2;
}
#imovelSingle .banner-destaque .menu-single .imovel-actions li {
  margin-right: 20px;
}
#imovelSingle .banner-destaque .menu-single .imovel-actions li .v-btn {
  width: 100%;
}
#imovelSingle .basic-infos h2 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 22px;
  line-height: 30px;
  text-align: center;
  color: #ffffff;
  margin: 80px 0 25px;
}
#imovelSingle .basic-infos h4 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: lighter;
  font-size: 22px;
  line-height: 24px;
  text-align: center;
  color: #ffffff;
  display: flex;
  justify-content: center;
  align-items: center;
}
#imovelSingle .basic-infos h4 .v-icon {
  color: #43cea2;
  margin-right: 10px;
}
#imovelSingle .basic-infos p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: lighter;
  margin-bottom: 0px;
  font-size: 22px;
  line-height: 26px;
  text-align: justify;
  color: #ffffff;
}

#imovelSingle .banner-destaque .icon-area {
  height: 75px;
  display: flex;
  justify-content: flex-end;
  align-items: center;
}
#imovelSingle .banner-destaque .icon-area .banner-btn {
  border: 1px solid #43cea2;
  box-sizing: border-box;
  border-radius: 8px;
  background-color: transparent;
  margin-left: 20px;
  padding: 10px 35px;
  transition: 0.5s;
}
#imovelSingle .banner-destaque .icon-area .banner-btn span {
  color: #fff;
}
#imovelSingle .banner-destaque .icon-area .btn-circle {
  border-radius: 50%;
  padding: 0;
  height: 45px;
  width: 45px;
}
#imovelSingle .banner-destaque .icon-area .banner-btn:hover {
  background: linear-gradient(
    180deg,
    #43cea2 0%,
    rgba(67, 206, 162, 0) 100%
  ) !important;
  transition: 0.5s;
}
#imovelSingle
  .banner-destaque
  .icon-area
  .banner-btn:not(.v-btn--text):not(.v-btn--outlined):hover:before {
  color: transparent !important;
}

#imovelSingle .slider-imoveis {
  position: relative;
  z-index: 5;
  border-bottom: 1px solid #43cea2;
  padding-bottom: 90px;
}
#imovelSingle .slider-imoveis .box-imovel {
  height: 150px;
  margin: 0 3px;
  border-radius: 4px;
  position: relative;
  transition: 0.5s;
  top: 0;
}
#imovelSingle .slider-imoveis .box-imovel:hover {
  -ms-transform: scale(1.4);
  transform: scale(1.4);
  transition: 0.5s;
  height: 320px;
  z-index: 30;
  border: 1px solid #43cea2;
  box-sizing: border-box;
  border-radius: 0px;
}
#imovelSingle .slider-imoveis .box-imovel img {
  width: 100%;
  height: 150px;
  border-radius: 4px;
  object-fit: cover;
  object-position: center;
  transition: 0.5s;
  position: relative;
}
#imovelSingle .slider-imoveis .box-imovel:hover img {
  transition: 0.5s;
  border-radius: 0;
  filter: brightness(0.7);
}
#imovelSingle .slider-imoveis .box-imovel .imovel-infos {
  position: absolute;
  bottom: 0;
  background: linear-gradient(
    rgba(0, 0, 0, 0) 0%,
    rgba(0, 0, 0, 0) -2%,
    rgba(0, 0, 0, 1) 12%,
    #000 100%
  );
  left: 0;
  right: 0;
  opacity: 0;
  transition: 0.5s;
  padding: 5px 25px;
}
#imovelSingle .slider-imoveis .box-imovel .imovel-infos .icon-list {
  display: flex;
  padding-top: 15px;
}
#imovelSingle .slider-imoveis .box-imovel .imovel-infos .icon-list .box-icon {
  width: 30px;
  position: relative;
}
#imovelSingle .slider-imoveis .box-imovel .imovel-infos .icon-list img {
  width: 100%;
  height: 11px;
  object-fit: contain;
  object-position: center;
  margin: auto;
}
#imovelSingle .slider-imoveis .box-imovel .imovel-infos .icon-list p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: bold;
  font-size: 9px;
  line-height: 30px;
  text-align: center;
  color: #ffffff;
  padding: 0;
}
#imovelSingle .slider-imoveis .box-imovel .imovel-infos h3 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: bold;
  font-size: 12px;
  line-height: 15px;
  color: #ffffff;
}
#imovelSingle .slider-imoveis .box-imovel .imovel-infos h5 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: bold;
  font-size: 11px;
  line-height: 15px;
  color: #43cea2;
}
#imovelSingle .slider-imoveis .box-imovel .imovel-infos p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 100;
  font-size: 10px;
  line-height: 12px;
  color: #ffffff;
  margin: 0;
  padding: 13px 0px 0px 0px;
  text-align: justify;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
}
#imovelSingle .slider-imoveis .box-imovel .imovel-infos .banner-actions {
  display: flex;
  justify-content: center;
  margin-top: 10px;
  margin-bottom: 20px;
}
#imovelSingle
  .slider-imoveis
  .box-imovel
  .imovel-infos
  .banner-actions
  .btn-share
  .v-icon {
  font-size: 14px !important;
  margin: 0px 0px 0px -2px !important;
}
#imovelSingle
  .slider-imoveis
  .box-imovel
  .imovel-infos
  .banner-actions
  .banner-btn {
  border: 1px solid #43cea2;
  box-sizing: border-box;
  border-radius: 8px;
  padding: 2px 11px;
}
.btnNonePreferidos {
  display: none !important;
}
#imovelSingle
  .slider-imoveis
  .box-imovel
  .imovel-infos
  .banner-actions
  .banner-btn
  span {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 10px;
  line-height: 12px;
  color: #ffffff;
}
#imovelSingle
  .slider-imoveis
  .box-imovel
  .imovel-infos
  .banner-actions
  .btn-circle {
  border-radius: 50%;
  padding: 0;
  height: 26px;
  width: 26px;
  background-color: transparent;
  color: #43cea2;
  margin-left: 10px;
}
#inspire #imovelSingle .container .imovel-actions .v-btn:before {
  color: #43cea2;
  justify-content: center;
  background-color: transparent;
}
#imovelSingle
  .slider-imoveis
  .box-imovel
  .imovel-infos
  .banner-actions
  .btn-imovel-link {
  border: 1px solid rgba(255, 255, 255, 0.4);
  color: rgba(255, 255, 255, 0.4);
  height: 20px;
  width: 20px;
  position: absolute;
  bottom: 10px;
  right: 20px;
}
#imovelSingle
  .slider-imoveis
  .box-imovel
  .imovel-infos
  .banner-actions
  .btn-imovel-link:hover {
  border: 1px solid #fff;
}
#imovelSingle
  .slider-imoveis
  .box-imovel
  .imovel-infos
  .banner-actions
  .btn-imovel-link
  span {
  color: rgba(255, 255, 255, 0.4);
}
#imovelSingle
  .slider-imoveis
  .box-imovel
  .imovel-infos
  .banner-actions
  .btn-imovel-link
  span
  .v-icon {
  font-size: 14px;
}
#imovelSingle
  .slider-imoveis
  .box-imovel
  .imovel-infos
  .banner-actions
  .btn-imovel-link
  span:hover {
  color: #fff;
}
#imovelSingle .slider-imoveis .box-imovel:hover .imovel-infos {
  opacity: 1;
  transition: 0.5s;
}
#imovelSingle .slider-imoveis .slick-slide {
  opacity: 0.3;
  transition: 0.5s;
}
#imovelSingle .slider-imoveis .slick-active {
  opacity: 1 !important;
  transition: 0.5s;
}
#imovelSingle .slider-imoveis .slick-arrow {
  top: 0;
  bottom: 0;
  height: 100%;
  width: 50px;
  z-index: 25;
  transform: unset;
  opacity: 0;
  transition: 0.5s;
}
#imovelSingle .slider-imoveis .slick-slider:hover .slick-arrow {
  opacity: 1;
  transition: 0.5s;
}
#imovelSingle .slider-imoveis .slick-prev {
  left: -55px;
}
#imovelSingle .slider-imoveis .slick-next {
  right: -55px;
}
#imovelSingle .slider-imoveis .slick-disabled {
  opacity: 0 !important;
}
#imovelSingle .slider-imoveis .slick-prev:before {
  content: "\f053";
  font-family: "FontAwesome";
}
#imovelSingle .slider-imoveis .slick-next:before {
  content: "\f054";
  font-family: "FontAwesome";
}
#imovelSingle .slider-imoveis .slick-prev:before,
#imovelSingle .slider-imoveis .slick-next:before {
  color: rgba(255, 255, 255, 0.6);
  font-size: 35px;
}
#imovelSingle .slider-imoveis .slick-track {
  height: 150px;
}
#imovelSingle .slider-imoveis .slider-area {
  padding: 0 60px;
}
#imovelSingle .slider-imoveis .slider-area:hover {
  z-index: 100;
}
#imovelSingle .slider-imoveis .slider-area h2 {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 24px;
  line-height: 33px;
  color: #ffffff;
  padding-bottom: 5px;
  padding-left: 0px;
  padding-right: 50px;
  margin-top: 65px;
}
#imovelSingle .slider-imoveis .slider-area .slick-list {
  overflow: visible !important;
}
#imovelSingle .slider-imoveis .slider-area .slick-slider {
  z-index: 15;
}
#imovelSingle .slider-imoveis .box-imovel .imovel-infos .icon-list {
  display: flex;
  padding-top: 15px;
}
#imovelSingle .basic-infos .icon-list {
  display: flex;
  justify-content: space-evenly;
  padding: 20px 0;
}
#imovelSingle .slider-imoveis .box-imovel .imovel-infos .icon-list .box-icon {
  width: 30px;
}
#imovelSingle .slider-imoveis .box-imovel .imagemPointer {
  cursor: pointer;
}
#imovelSingle .slider-imoveis .box-imovel .imovel-infos .icon-list img {
  width: 100%;
  height: 11px;
  object-fit: contain;
  object-position: center;
  margin: auto;
}
#imovelSingle .basic-infos .icon-list img {
  width: 100%;
  height: 35px;
  object-fit: contain;
  object-position: center;
  margin: auto;
}
.iframeTour {
  width: 100%;
  height: 80vh;
}
#imovelSingle .slider-imoveis .box-imovel .imovel-infos .icon-list p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: bold;
  font-size: 9px;
  line-height: 30px;
  text-align: center;
  color: #ffffff;
  padding: 0;
}
#imovelSingle .basic-infos .icon-list p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 16px;
  line-height: 20px;
  text-align: center;
  color: #ffffff;
  margin: 0;
  padding: 0;
}
#imovelSingle .basic-infos .icon-list p span {
  font-weight: 200;
}
#imovelSingle .basic-infos .imovel-map {
  margin: 50px 0px 25px;
}
#imovelSingle .basic-infos .imovel-map #map,
#imovelSingle .basic-infos .imovel-map .map {
  height: 60vh;
  width: 100%;
}
#imovelSingle .basic-infos .box-financiamento {
  background: rgba(130, 130, 130, 0.1);
  border-radius: 20px;
  text-align: center;
  padding: 60px 25px;
  margin: 75px 0 15px;
}
#imovelSingle .basic-infos .box-financiamento h2 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 500;
  font-size: 36px;
  line-height: 50px;
  color: #ffffff;
  margin: 0;
  padding: 0;
}
#inspire .v-dialog__content .v-dialog img {
  height: 400px;
}
#imovelSingle .basic-infos .box-financiamento h2 span {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 50px;
  line-height: 30px;
  color: #43cea2;
  margin: 0;
  padding: 0;
}
#inspire
  #imovelSingle
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
  #imovelSingle
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
  #imovelSingle
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
  #imovelSingle
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
  #imovelSingle
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
#inspire
  #imovelSingle
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
  #imovelSingle
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
#imovelSingle .basic-infos .box-financiamento p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 18px;
  line-height: 30px;
  text-align: center;
  color: #ffffff;
  margin: 0;
  padding: 0;
}
#imovelSingle .basic-infos .slick-slider .galeriaFotos img {
  width: 100%;
  height: 150px;
}

@media (max-width: 1330px) {
  #imovelSingle .banner-destaque h1 {
    font-size: 40px;
  }
  #imovelSingle .banner-destaque h3 {
    font-size: 24px;
    line-height: 27px;
  }
  #imovelSingle .banner-destaque .menu-single .imovel-actions li .v-btn img {
    width: 100%;
    height: 40px;
    object-fit: contain;
    object-position: center;
  }
  #imovelSingle .banner-destaque .menu-single .imovel-menu li p {
    font-size: 17px;
  }
}
@media (max-width: 768px) {
  #imovelSingle .banner-destaque .menu-single .imovel-menu li {
    margin-left: 10px;
  }
  #imovelSingle .banner-destaque .menu-single .imovel-menu li p {
    font-size: 14px;
    margin-left: 10px;
  }
  #imovelSingle .slider-imoveis .slick-track {
    height: 330px;
  }
  #imovelSingle .slider-imoveis .box-imovel {
    transition: 0.5s;
    height: 320px;
    z-index: 30;
    border: 1px solid #43cea2;
    box-sizing: border-box;
    border-radius: 0px;
  }
  #imovelSingle .slider-imoveis .box-imovel:hover {
    transform: scale(1);
  }
  #imovelSingle .slider-imoveis .box-imovel .imovel-infos {
    opacity: 1;
    transition: 0.5s;
    min-height: 200px;
  }
  #imovelSingle .slider-imoveis .slick-slider .slick-arrow {
    opacity: 1;
    transition: 0.5s;
  }
}
@media (max-width: 500px) {
  #imovelSingle .banner-destaque,
  #imovelSingle .banner-destaque .align-right,
  #imovelSingle .basic-infos h2,
  #imovelSingle .basic-infos p {
    text-align: center;
  }
  #imovelSingle .banner-destaque .icon-area,
  #imovelSingle .banner-destaque .menu-single ul {
    justify-content: center;
  }
  #imovelSingle .banner-destaque .menu-single,
  #imovelSingle .basic-infos .icon-list,
  #imovelSingle .banner-destaque .menu-single .imovel-menu ul {
    display: block;
  }
  #imovelSingle .banner-destaque .menu-single .imovel-menu .divisor-menu {
    border: none;
  }
  #imovelSingle .banner-destaque .menu-single .imovel-menu li {
    margin-left: 0px;
    margin: 10px 0 0px 0px;
  }
  #imovelSingle .banner-destaque .menu-single .imovel-menu li p {
    margin: 0;
    display: inline;
  }
  #imovelSingle .banner-destaque .menu-single .imovel-actions li {
    margin-right: 10px;
    margin-left: 10px;
  }
  #imovelSingle .basic-infos .box-financiamento {
    padding: 50px 10px;
  }
  #imovelSingle .basic-infos .box-financiamento h2 {
    font-size: 23px;
    line-height: 29px;
  }
  #imovelSingle .basic-infos .box-financiamento h2 span {
    font-size: 42px;
    line-height: 45px;
  }
  #imovelSingle .basic-infos .box-financiamento p {
    font-size: 14px;
    line-height: 30px;
  }
  #imovelSingle .slider-imoveis .slider-area h2 {
    padding: 0;
    text-align: center;
  }
}
</style>