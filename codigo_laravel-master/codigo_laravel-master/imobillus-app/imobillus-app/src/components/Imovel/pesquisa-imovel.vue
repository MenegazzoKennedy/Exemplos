<template>
  <section v-if="pageReady == true" id="imoveisList">
    <myHeader />

    <div class="banner-home">
      <v-container>
        <v-row>
          <v-col cols="12">
            <div class="banner-title">
              <h1>O resultado da pesquisa para: {{ this.$route.query.s }}</h1>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </div>

    <div class="slider-imoveis">
      <v-container fluid>
        <v-row>
          <v-col
            v-for="(imovel, i) in imoveisData"
            :key="i"
            cols="12"
            class="slider-area"
          >
            <template v-if="i < 7 && imovel.produto.length != 0">
              <h2>{{ imovel.descricao }}</h2>
              <VueSlickCarousel :arrows="true" :dots="false" v-bind="settings">
                <div v-for="(produto, i) in imovel.produto" :key="i">
                  <div class="box-imovel" :class="'imovel' + produto.id">
                    <img :src="verificBanner(produto.midias[0])" />

                    <div class="imovel-infos">
                      <h3>{{ produto.titulo }}</h3>
                      <h5>{{ formatValor(produto.valor) }}</h5>

                      <p>{{ produto.descricao }}</p>

                      <div class="icon-list">
                        <template v-for="(infos, i) in imovel.caracteristicas">
                          <div
                            v-if="infos.is_coord != 1 && infos.icone != null"
                            class="box-icon"
                            :key="i"
                          >
                            <img :src="formatImg(infos.icone)" />
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
                            idsArray.find((element) => element == produto.id)
                          "
                        >
                          <v-btn
                            icon
                            class="banner-btn btn-circle btnNonePreferidos"
                            @click="btnPreferido(produto.id)"
                            ><v-icon>mdi-plus</v-icon></v-btn
                          >
                          <v-btn
                            icon
                            class="banner-btn btn-circle"
                            @click="btnPreferido(produto.id)"
                          >
                            <v-icon>mdi-minus</v-icon>
                          </v-btn>
                        </div>
                        <div class="btnPreferidos" v-else>
                          <v-btn
                            icon
                            class="banner-btn btn-circle"
                            @click="btnPreferido(produto.id)"
                            ><v-icon>mdi-plus</v-icon></v-btn
                          >
                          <v-btn
                            icon
                            class="banner-btn btn-circle btnNonePreferidos"
                            @click="btnPreferido(produto.id)"
                          >
                            <v-icon>mdi-minus</v-icon>
                          </v-btn>
                        </div>
                        <v-btn
                          icon
                          class="banner-btn btn-circle btn-share"
                          @click="copiarLink(produto.slug)"
                          ><v-icon>mdi-share-variant</v-icon></v-btn
                        >

                        <v-btn
                          @click="goImovel(produto.slug)"
                          icon
                          class="banner-btn btn-circle btn-imovel-link"
                          ><v-icon>mdi-chevron-right</v-icon></v-btn
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </VueSlickCarousel>
            </template>
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
import { showError } from "@/global";

export default {
  name: "pesquisa-imoveis",
  data() {
    return {
      settingsBanner: {
        fade: true,
        infinite: true,
        speed: 3000,
        autoplay: true,
        autoplaySpeed: 10000,
        slidesToShow: 1,
        slidesToScroll: 1,
      },
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
      imoveisData: [],
      idsArray: [],
      preferidosData: [],
      pageReady: false,
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

  mounted() {
    this.loadImovelList();
    this.listaPreferidos();
  },
  methods: {
    goImovel(slug) {
      this.$router.push({ path: "/imovel/" + slug + "" });
    },

    copiarLink(slug) {
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

    btnPreferido(id) {
      // btnNonePreferidos  .classList.add
      if (this.user != null) {
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
        })
        .catch(showError);
    },

    listaPreferidos() {
      if (this.user != null || this.user.cliente_id) {
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
      } else {
        //tudo bem
      }
    },

    verificBanner(img) {
      if (img) {
        return img.url;
      } else {
        return this.imgPadrao.src;
      }
    },

    loadImovelList() {
      this.$http
        .post("/imovel/pesquisa/solo", {
          Pesquisa: this.$route.query.s,
        })
        .then((res) => {
          this.imoveisData = res.data;
          // console.log(this.imoveisData);

          setTimeout(() => (this.pageReady = true), 1000);
        })
        .catch(showError);
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
    formatValorIcone(valor) {
      return new Intl.NumberFormat([]).format(valor);
    },
    formatImg(img) {
      return require("../../assets/" + img + "-a.png");
    },
  },
};
</script>

<style>
#imoveisList {
  background-color: #000;
}
#imoveisList .banner-home {
  background-image: url("../../assets/banner-home.png");
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
  height: 30vh;
  padding: 100px 0px;
  z-index: 1;
  display: flex;
  align-items: center;
}
#imoveisList .banner-home:before {
  content: "";
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  z-index: -1;
  background-image: url("../../assets/banner-filter.png");
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
#imoveisList .banner-home .banner-title {
  margin-top: 45px;
}
#imoveisList .banner-destaque {
  margin-bottom: -65px;
}
#imoveisList .banner-destaque .banner-imovel {
  padding: 100px 20px;
  position: relative;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  z-index: 1;
  height: 80vh;
  display: flex;
  align-items: center;
}
#imoveisList .banner-destaque .banner-imovel:after {
  content: "";
  position: absolute;
  display: block;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgb(0, 0, 0);
  background: linear-gradient(
    0deg,
    rgba(0, 0, 0, 1) 2%,
    rgba(0, 0, 0, 0.9192051820728291) 7%,
    rgba(0, 0, 0, 0.6362920168067228) 35%,
    rgba(191, 195, 193, 0) 100%
  );
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  z-index: -1;
}
#imoveisList .banner-destaque .banner-imovel:before {
  content: "";
  position: absolute;
  display: block;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url("../../assets/slider-filter.png");
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  z-index: -1;
}
#imoveisList .banner-destaque .banner-imovel .alignRight {
  text-align: right;
}
#imoveisList .banner-destaque .banner-imovel .alignRight .banner-actions {
  display: flex;
  justify-content: flex-end;
  position: relative;
}
#imoveisList .banner-destaque .banner-imovel h1 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 400;
  font-size: 50px;
  line-height: 65px;
  color: #ffffff;
  padding-bottom: 0px;
}
#imoveisList .banner-destaque .banner-imovel h3 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 300;
  font-size: 27px;
  line-height: 33px;
  color: #ffffff;
  padding-bottom: 18px;
}
#imoveisList .banner-destaque .banner-imovel p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 17px;
  line-height: 24px;
  color: #ffffff;
}
#imoveisList .banner-destaque .banner-imovel .banner-actions {
  display: flex;
}
#imoveisList .banner-destaque .banner-imovel .banner-actions .banner-btn {
  border: 1px solid #43cea2;
  box-sizing: border-box;
  border-radius: 8px;
  background-color: transparent;
  margin-right: 20px;
  padding: 10px 35px;
  transition: 0.5s;
}
#imoveisList .banner-destaque .banner-imovel .banner-btn span {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 20px;
  line-height: 22px;
  text-transform: initial;
  color: #ffffff;
}
#imoveisList .banner-destaque .banner-imovel .banner-actions .btn-circle {
  border-radius: 50%;
  padding: 0;
  height: 45px;
  width: 45px;
}
#imoveisList .banner-destaque .banner-imovel .banner-actions .banner-btn:hover {
  background: linear-gradient(
    180deg,
    #43cea2 0%,
    rgba(67, 206, 162, 0) 100%
  ) !important;
  transition: 0.5s;
}
#imoveisList
  .banner-destaque
  .banner-imovel
  .banner-actions
  .banner-btn:not(.v-btn--text):not(.v-btn--outlined):hover:before {
  color: transparent !important;
}

#imoveisList .slider-imoveis {
  position: relative;
  z-index: 5;
}
#imoveisList .slider-imoveis .box-imovel {
  height: 150px;
  margin: 0 3px;
  border-radius: 4px;
  position: relative;
  transition: 0.5s;
  top: 0;
}
#imoveisList .slider-imoveis .box-imovel:hover {
  -ms-transform: scale(1.4);
  transform: scale(1.4);
  transition: 0.5s;
  height: 320px;
  z-index: 30;
  border: 1px solid #43cea2;
  box-sizing: border-box;
  border-radius: 0px;
}
#imoveisList .slider-imoveis .box-imovel img {
  width: 100%;
  height: 150px;
  border-radius: 4px;
  object-fit: cover;
  object-position: center;
  transition: 0.5s;
  position: relative;
}
#imoveisList .slider-imoveis .box-imovel:hover img {
  transition: 0.5s;
  border-radius: 0;
  filter: brightness(0.7);
}
#imoveisList .slider-imoveis .box-imovel .imovel-infos {
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
#imoveisList .slider-imoveis .box-imovel .imovel-infos h3 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: bold;
  font-size: 12px;
  line-height: 15px;
  color: #ffffff;
}
.btnNonePreferidos {
  display: none !important;
}
#imoveisList .slider-imoveis .box-imovel .imovel-infos h5 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: bold;
  font-size: 11px;
  line-height: 15px;
  color: #43cea2;
}
#imoveisList .slider-imoveis .box-imovel .imovel-infos p {
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
#imoveisList .slider-imoveis .box-imovel .imovel-infos .banner-actions {
  display: flex;
  justify-content: center;
  margin-top: 10px;
  margin-bottom: 20px;
}
#imoveisList
  .slider-imoveis
  .box-imovel
  .imovel-infos
  .banner-actions
  .btn-share
  .v-icon {
  font-size: 14px !important;
  margin: 0px 0px 0px -2px !important;
}
#imoveisList
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
#imoveisList
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
#imoveisList
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
#imoveisList
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
#imoveisList
  .slider-imoveis
  .box-imovel
  .imovel-infos
  .banner-actions
  .btn-imovel-link:hover {
  border: 1px solid #fff;
}
#imoveisList
  .slider-imoveis
  .box-imovel
  .imovel-infos
  .banner-actions
  .btn-imovel-link
  span {
  color: rgba(255, 255, 255, 0.4);
}
#imoveisList
  .slider-imoveis
  .box-imovel
  .imovel-infos
  .banner-actions
  .btn-imovel-link
  span
  .v-icon {
  font-size: 14px;
}
#imoveisList
  .slider-imoveis
  .box-imovel
  .imovel-infos
  .banner-actions
  .btn-imovel-link
  span:hover {
  color: #fff;
}
#imoveisList .slider-imoveis .box-imovel:hover .imovel-infos {
  opacity: 1;
  transition: 0.5s;
  min-height: 200px;
}
#imoveisList .slider-imoveis .slick-slide {
  opacity: 0.3;
  transition: 0.5s;
}
#imoveisList .slider-imoveis .slick-active {
  opacity: 1 !important;
  transition: 0.5s;
}
#imoveisList .slider-imoveis .slick-arrow {
  top: 0;
  bottom: 0;
  height: 100%;
  width: 50px;
  z-index: 25;
  transform: unset;
  opacity: 0;
  transition: 0.5s;
}
#imoveisList .slider-imoveis .slick-slider:hover .slick-arrow {
  opacity: 1;
  transition: 0.5s;
}
#imoveisList .slider-imoveis .slick-prev {
  left: -55px;
}
#imoveisList .slider-imoveis .slick-next {
  right: -55px;
}
#imoveisList .slider-imoveis .slick-disabled {
  opacity: 0 !important;
}
#imoveisList .slider-imoveis .slick-prev:before {
  content: "\f053";
  font-family: "FontAwesome";
}
#imoveisList .slider-imoveis .slick-next:before {
  content: "\f054";
  font-family: "FontAwesome";
}
#imoveisList .slider-imoveis .slick-prev:before,
#imoveisList .slider-imoveis .slick-next:before {
  color: rgba(255, 255, 255, 0.6);
  font-size: 35px;
}
#imoveisList .slider-imoveis .slick-track {
  height: 150px;
}
#imoveisList .slider-imoveis .slider-area {
  padding: 0 60px;
}
#imoveisList .slider-imoveis .slider-area:hover {
  z-index: 100;
}
#imoveisList .slider-imoveis .slider-area h2 {
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
#imoveisList .slider-imoveis .slider-area .slick-list {
  overflow: visible !important;
}
#imoveisList .slider-imoveis .slider-area .slick-slider {
  z-index: 15;
}

#imoveisList .slider-imoveis .box-imovel .imovel-infos .icon-list {
  display: flex;
  padding-top: 15px;
}
#imoveisList .slider-imoveis .box-imovel .imovel-infos .icon-list .box-icon {
  width: 29px;
  position: relative;
}
#imoveisList .slider-imoveis .box-imovel .imovel-infos .icon-list img {
  width: 100%;
  height: 11px;
  object-fit: contain;
  object-position: center;
  margin: auto;
}
#imoveisList .slider-imoveis .box-imovel .imovel-infos .icon-list p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: bold;
  font-size: 9px;
  line-height: 30px;
  text-align: center;
  color: #ffffff;
  padding: 0;
}

@media (max-width: 768px) {
  #imoveisList .banner-destaque .banner-imovel .banner-actions,
  #imoveisList .banner-destaque .banner-imovel .alignRight .banner-actions {
    justify-content: center;
  }
  #imoveisList .banner-destaque .banner-imovel,
  #imoveisList .banner-destaque .banner-imovel .alignRight {
    text-align: center;
  }
  #imoveisList .slider-imoveis .slick-track {
    height: 330px;
  }
  #imoveisList .slider-imoveis .box-imovel {
    transition: 0.5s;
    height: 320px;
    z-index: 30;
    border: 1px solid #43cea2;
    box-sizing: border-box;
    border-radius: 0px;
  }
  #imoveisList .slider-imoveis .box-imovel:hover {
    transform: scale(1);
  }
  #imoveisList .slider-imoveis .box-imovel .imovel-infos {
    opacity: 1;
    transition: 0.5s;
    min-height: 200px;
  }
  #imoveisList .slider-imoveis .slick-slider .slick-arrow {
    opacity: 1;
    transition: 0.5s;
  }
}
</style>
