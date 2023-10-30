<template>
  <section v-if="pageReady == true && apresentarBanner" id="imoveisList">
    <myHeader />

    <div class="banner-destaque">
      <v-container fluid class="nopadding">
        <v-row class="nomargin">
          <v-col cols="12" class="nopadding">
            <VueSlickCarousel
              :arrows="false"
              :dots="false"
              v-bind="settingsBanner"
            >
              <div v-for="(destaque, i) in destaqueData" :key="i">
                <div
                  class="banner-imovel"
                  :class="'imovel' + destaque.id"
                  :style="{
                    'background-image':
                      'url(' + verificBanner(destaque.midias[0]) + ')',
                  }"
                >
                  <v-container fluid>
                    <v-row class="nomargin">
                      <v-col v-if="i % 2 === 0" md="6" class="nopadding">
                        <h1>{{ destaque.titulo }}</h1>
                        <h3>{{ destaque.bairro }}</h3>
                        <p>{{ destaque.descricao }}</p>

                        <div class="banner-actions">
                          <router-link
                            class="banner-btn"
                            :to="'/imovel/' + destaque.slug"
                          >
                            <span>Ver mais</span>
                          </router-link>
                          <div
                            class="btnPreferidos"
                            v-if="
                              idsArray.find((element) => element == destaque.id)
                            "
                          >
                            <v-btn
                              icon
                              class="banner-btn btn-circle btnNonePreferidos"
                              @click="btnPreferido(destaque.id)"
                              ><v-icon>mdi-plus</v-icon></v-btn
                            >
                            <v-btn
                              icon
                              class="banner-btn btn-circle"
                              @click="btnPreferido(destaque.id)"
                            >
                              <v-icon>mdi-minus</v-icon>
                            </v-btn>
                          </div>
                          <div class="btnPreferidos" v-else>
                            <v-btn
                              icon
                              class="banner-btn btn-circle"
                              @click="btnPreferido(destaque.id)"
                              ><v-icon>mdi-plus</v-icon></v-btn
                            >
                            <v-btn
                              icon
                              class="banner-btn btn-circle btnNonePreferidos"
                              @click="btnPreferido(destaque.id)"
                            >
                              <v-icon>mdi-minus</v-icon>
                            </v-btn>
                          </div>
                        </div>
                      </v-col>
                      <v-col
                        v-else
                        offset-md="6"
                        md="6"
                        class="nopadding alignRight"
                      >
                        <h1>{{ destaque.titulo }}</h1>
                        <h3>{{ destaque.bairro }}</h3>
                        <p>{{ destaque.descricao }}</p>

                        <div class="banner-actions">
                          <div
                            class="btnPreferidos"
                            v-if="
                              idsArray.find((element) => element == destaque.id)
                            "
                          >
                            <v-btn
                              icon
                              class="banner-btn btn-circle btnNonePreferidos"
                              @click="btnPreferido(destaque.id)"
                              ><v-icon>mdi-plus</v-icon></v-btn
                            >
                            <v-btn
                              icon
                              class="banner-btn btn-circle"
                              @click="btnPreferido(destaque.id)"
                            >
                              <v-icon>mdi-minus</v-icon>
                            </v-btn>
                          </div>
                          <div class="btnPreferidos" v-else>
                            <v-btn
                              icon
                              class="banner-btn btn-circle"
                              @click="btnPreferido(destaque.id)"
                              ><v-icon>mdi-plus</v-icon></v-btn
                            >
                            <v-btn
                              icon
                              class="banner-btn btn-circle btnNonePreferidos"
                              @click="btnPreferido(destaque.id)"
                            >
                              <v-icon>mdi-minus</v-icon>
                            </v-btn>
                          </div>
                          <router-link
                            class="banner-btn"
                            :to="'/imovel/' + destaque.slug"
                          >
                            <span>Ver mais</span>
                          </router-link>
                        </div>
                      </v-col>
                    </v-row>
                  </v-container>
                </div>
              </div>
            </VueSlickCarousel>
          </v-col>
        </v-row>
      </v-container>
    </div>

    <v-btn @click="filtrosBusca = true" class="btnFiltrar">Filtrar</v-btn>
    <v-dialog
      v-model="filtrosBusca"
      max-width="900px"
      persistent
      class="tam-box-filtro"
    >
      <div class="box-filter">
        <h2>FILTROS</h2>
        <v-row class="rowPesquisa">
          <v-col cols="12" class="col-paddin-filtro">
            <v-text-field
              v-model="pesquisaData.pesquisa"
              label="Pesquisa"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="4" class="col-paddin-filtro">
            <v-select
              v-model="pesquisaData.estado"
              @change="loadCidade"
              class="user-select"
              label="Estado"
              :items="estados"
              item-text="name"
              item-value="id"
              append-icon="fas fa-angle-down"
            ></v-select>
          </v-col>
          <v-col cols="12" md="3" sm="4" class="col-paddin-filtro">
            <v-select
              v-model="pesquisaData.cidade"
              @change="loadBairro"
              class="user-select"
              label="Cidade"
              :items="cidades"
              item-text="name"
              item-value="id"
              append-icon="fas fa-angle-down"
            ></v-select>
          </v-col>
          <v-col cols="12" md="3" sm="4" class="col-paddin-filtro">
            <v-select
              v-model="pesquisaData.bairro"
              multiple
              class="user-select localeSelect"
              label="Bairros"
              :items="bairros"
              item-text="name"
              item-value="id"
              append-icon="fas fa-angle-down"
            ></v-select>
          </v-col>
          <v-col cols="12" md="3" sm="4" class="col-paddin-filtro">
            <v-select
              v-model="pesquisaData.regiao"
              multiple
              class="user-select localeSelect"
              label="Regiões"
              :items="regiaoData"
              item-text="name"
              item-value="id"
              append-icon="fas fa-angle-down"
            ></v-select>
          </v-col>
          <v-col cols="12" md="3" sm="4" class="col-paddin-filtro">
            <v-text-field label="Cep" v-model="pesquisaData.cep"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="4" class="col-paddin-filtro">
            <v-text-field
              label="AreaUtil"
              type="number"
              v-model="pesquisaData.areaUtil"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="4" class="col-paddin-filtro">
            <v-select
              :items="items"
              label="Banheiros"
              v-model="pesquisaData.banheiros"
            ></v-select>
          </v-col>
          <v-col cols="12" md="3" sm="4" class="col-paddin-filtro">
            <v-select
              :items="items"
              label="Garagem"
              v-model="pesquisaData.garagem"
            ></v-select>
          </v-col>
          <v-col cols="12" md="3" sm="4" class="col-paddin-filtro">
            <v-select
              :items="items"
              label="Lavanderia"
              v-model="pesquisaData.lavanderia"
            ></v-select>
          </v-col>
          <v-col cols="12" md="3" sm="4" class="col-paddin-filtro">
            <v-select
              :items="items"
              label="Quartos"
              v-model="pesquisaData.quartos"
            ></v-select>
          </v-col>
          <v-col cols="12" md="3" sm="4" class="col-paddin-filtro">
            <v-select
              :items="items"
              label="Suites"
              v-model="pesquisaData.suites"
            ></v-select>
          </v-col>
          <v-col cols="12" md="3" sm="4" class="col-paddin-filtro">
            <v-select
              :items="items"
              label="Unidades"
              v-model="pesquisaData.unidades"
            ></v-select>
          </v-col>
          <v-col cols="12" md="3" sm="4" class="col-paddin-filtro">
            <v-text-field
              label="ValorMax"
              type="number"
              class="valorMaxClass"
              v-model="pesquisaData.valorMax"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="4" class="col-paddin-filtro">
            <v-text-field
              label="ValorMin"
              type="number"
              class="valorMinClass"
              v-model="pesquisaData.valorMin"
            ></v-text-field>
          </v-col>
        </v-row>
        <div class="divForaFiltroBtn">
          <v-btn @click="limparBusca" class="limparFiltroBtn">Limpar</v-btn>
        </div>
        <div class="divForaBtn">
          <v-btn @click="filtrosBusca = false" class="cancelarFiltroBtn"
            >Cancelar</v-btn
          >
        </div>
        <div class="divForaBuscaBtn">
          <v-btn
            @click="goSelectBusca"
            :loading="loading"
            class="buscarBtnFiltro"
            >Buscar</v-btn
          >
        </div>
      </div>
    </v-dialog>

    <v-container v-show="semResultado">
      <v-row>
        <v-col cols="12">
          <div class="banner-title">
            <h1>Não há imóveis para esta pesquisa!</h1>
          </div>
        </v-col>
      </v-row>
    </v-container>
    <div class="slider-imoveis" v-show="!semResultado">
      <v-container fluid>
        <v-row>
          <v-col
            v-if="
              user != null &&
              !semResultado &&
              preferidosData.preferidos.length > 0
            "
            cols="12"
            class="slider-area-preferidos"
            v-show="soCliente"
          >
            <h2>Minha lista</h2>

            <VueSlickCarousel
              :arrows="true"
              :dots="false"
              v-bind="settings"
              id="sliderId"
              v-if="user.cliente_id"
            >
              <div v-for="(preferido, i) in preferidosData.preferidos" :key="i">
                <div class="box-imovel" :class="'imovel' + preferido.id">
                  <img
                    class="imagemPointer"
                    @click="goImovel(preferido.slug)"
                    :src="verificBanner(preferido.midias[0])"
                  />

                  <div class="imovel-infos">
                    <h3>{{ preferido.titulo }}</h3>
                    <h5>{{ formatValor(preferido.valor) }}</h5>

                    <p>{{ preferido.descricao }}</p>

                    <div class="icon-list">
                      <template v-for="(infos, j) in preferido.caracteristicas">
                        <div
                          v-if="infos.is_coord != 1 && infos.icone != null"
                          class="box-icon"
                          :key="j"
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
                      <div class="btnPreferidos">
                        <v-btn
                          icon
                          class="banner-btn btn-circle"
                          @click="btnPreferido(preferido.id)"
                        >
                          <v-icon>mdi-minus</v-icon>
                        </v-btn>
                        <v-btn
                          icon
                          class="banner-btn btn-circle btnNonePreferidos"
                          @click="btnPreferido(preferido.id)"
                        >
                          <v-icon>mdi-minus</v-icon>
                        </v-btn>
                      </div>
                      <v-btn
                        icon
                        class="banner-btn btn-circle btn-share"
                        @click="copiarLink(preferido.slug)"
                        ><v-icon>mdi-share-variant</v-icon></v-btn
                      >

                      <v-btn
                        @click="goImovel(preferido.slug)"
                        icon
                        class="banner-btn btn-circle btn-imovel-link"
                        ><v-icon>mdi-chevron-right</v-icon></v-btn
                      >
                    </div>
                  </div>
                </div>
              </div>
            </VueSlickCarousel>
          </v-col>
          <v-col
            v-for="(imovel, i) in imoveisData"
            :key="i"
            cols="12"
            class="slider-area"
            v-show="imovel.produto.length > 0"
          >
            <template>
              <h2>{{ imovel.descricao }}</h2>

              <VueSlickCarousel :arrows="true" :dots="false" v-bind="settings">
                <div v-for="(produto, i) in imovel.produto" :key="i">
                  <div class="box-imovel" :class="'imovel' + produto.id">
                    <img
                      class="imagemPointer"
                      @click="goImovel(produto.slug)"
                      :src="verificBanner(produto.midias[0])"
                    />

                    <div class="imovel-infos">
                      <h3>{{ produto.titulo }}</h3>
                      <h5>{{ formatValor(produto.valor) }}</h5>

                      <p>{{ produto.descricao }}</p>

                      <div class="icon-list">
                        <template v-for="(infos, j) in produto.caracteristicas">
                          <div
                            v-if="infos.is_coord != 1 && infos.icone != null"
                            class="box-icon"
                            :key="j"
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
  name: "imovel-lista",
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
      destaqueData: [],
      estados: [],
      soCliente: false,
      apresentarBanner: true,
      semResultado: false,
      idsArray: [],
      preferidoId: "",
      preferidosData: [],
      regiaoData: [],
      cidades: [],
      bairros: [],
      items: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10+"],
      pesquisaData: {
        pesquisa: "",
        estado: "",
        cidade: "",
        bairro: [],
        regiao: [],
        cep: "",
        areaUtil: "",
        banheiros: "",
        garagem: "",
        lavanderia: "",
        quartos: "",
        suites: "",
        unidades: "",
        valorMax: "",
        valorMin: "",
      },
      pesquisaDados: {},
      filtrosBusca: false,
      preferidoBtn: true,
      loading: false,
      preferidoBtnDestaque: true,
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
    this.listaPreferidos();
    this.loadImovelList();
    this.loadImovelDestaque();
    this.loadEstados();
  },
  methods: {
    async restartImg() {
      this.apresentarBanner = false;
      await this.$nextTick(() => {
        this.apresentarBanner = true;
        //console.log(this.apresentarBanner);
      });
      this.listaPreferidos();
    },
    listaPreferidos() {
      if (this.user != null) {
        // console.log(this.user);
        if (this.user.cliente_id) {
          this.$http
            .post("/preferido/listar")
            .then((res) => {
              this.preferidosData = res.data;
              // console.log(this.preferidosData);
              for (let j = 0; j < this.preferidosData.preferidos.length; j++) {
                this.idsArray[j] = this.preferidosData.preferidos[j].id;
              }
              ////console.log(this.idsArray);
            })
            .catch(() => {
              this.preferidosData.preferidos = [];
            });
        }
      }
    },
    goImovel(slug) {
      this.$router.push({ path: "/imovel/" + slug + "" });
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

    verificBanner(img) {
      if (img) {
        return img.url;
      } else {
        return this.imgPadrao.src;
      }
    },

    loadImovelDestaque() {
      this.$http
        .get("/imoveis/destaque")
        .then((res) => {
          this.destaqueData = res.data;
        })
        .catch(showError);
    },

    goSelectBusca() {
      this.loading = true;

      if (this.pesquisaData.pesquisa) {
        this.pesquisaDados.Pesquisa = this.pesquisaData.pesquisa;
        // console.log(this.pesquisaData.pesquisa);
      }

      if (this.pesquisaData.estado) {
        this.pesquisaDados.Estado = this.pesquisaData.estado;
        // console.log(this.pesquisaData.estado);
      }

      if (this.pesquisaData.cidade) {
        this.pesquisaDados.Cidade = this.pesquisaData.cidade;
        // console.log(this.pesquisaData.cidade);
      }

      if (this.pesquisaData.bairro.length > 0) {
        this.pesquisaDados.Bairro = [this.pesquisaData.bairro];
      }

      if (this.pesquisaData.regiao.length > 0) {
        this.pesquisaDados.Regiao = [this.pesquisaData.regiao];
      }

      if (this.pesquisaData.cep) {
        this.pesquisaDados.Cep = this.pesquisaData.cep;
      }

      if (this.pesquisaData.garagem) {
        this.pesquisaDados.Garagem = this.pesquisaData.garagem;
      }

      if (this.pesquisaData.banheiros) {
        this.pesquisaDados.Banheiros = this.pesquisaData.banheiros;
      }

      if (this.pesquisaData.areaUtil) {
        this.pesquisaDados.AreaUtil = this.pesquisaData.areaUtil;
      }

      if (this.pesquisaData.lavanderia) {
        this.pesquisaDados.Lavanderia = this.pesquisaData.lavanderia;
      }

      if (this.pesquisaData.quartos) {
        this.pesquisaDados.Quartos = this.pesquisaData.quartos;
      }

      if (this.pesquisaData.suites) {
        this.pesquisaDados.Suites = this.pesquisaData.suites;
      }

      if (this.pesquisaData.unidades) {
        this.pesquisaDados.Unidades = this.pesquisaData.unidades;
      }

      if (this.pesquisaData.valorMax) {
        this.pesquisaDados.ValorMax = this.pesquisaData.valorMax;
      }

      if (this.pesquisaData.valorMin) {
        this.pesquisaDados.ValorMin = this.pesquisaData.valorMin;
      }

      //console.log(this.pesquisaDados);

      /*{
          Estado: this.pesquisaData.estado,
          Cidade: this.pesquisaData.cidade,
          Bairro: this.pesquisaData.bairro,
          Cep: this.pesquisaData.cep,
          AreaUtil: parseInt(this.pesquisaData.areaUtil),
          Banheiros: parseInt(this.pesquisaData.banheiros),
          Garagem: parseInt(this.pesquisaData.garagem),
          Lavanderia: parseInt(this.pesquisaData.lavanderia),
          Quartos: parseInt(this.pesquisaData.quartos),
          Suites: parseInt(this.pesquisaData.suites),
          Unidades: parseInt(this.pesquisaData.unidades),
          ValorMax: this.pesquisaData.valorMax,
          ValorMin: this.pesquisaData.valorMin,
          Tipo: "pesquisa",
        }*/

      this.$http
        .post("/imovel/pesquisa/filtro", this.pesquisaDados)
        .then((res) => {
          this.imoveisData = res.data;
          // console.log(this.imoveisData);
          // console.log(this.imoveisData.length);
          let contador = 0;
          for (let j = 0; j < this.imoveisData.length; j++) {
            // console.log(this.imoveisData[j].produto.length);
            if (this.imoveisData[j].produto.length > 0) {
              contador += 1;
            }
          }
          if (contador == 0) {
            this.semResultado = true;
          }
          // console.log(this.pesquisaDados);
          this.loading = false;
          this.filtrosBusca = false;
          this.restartImg();
        });
    },

    loadEstados() {
      this.$http
        .get("/localidades/estados")
        .then((res) => {
          this.estados = res.data;
        })
        .catch(showError);
    },

    loadCidade() {
      this.$http
        .get("/localidades/cidades/" + this.pesquisaData.estado + "")
        .then((res) => {
          const loadCidade = res.data;
          this.cidades = loadCidade[0].cidades;
        })
        .catch(showError);
    },
    loadBairro() {
      this.$http
        .get("/localidades/" + this.pesquisaData.cidade + "/locaisBairros")
        .then((res) => {
          const loadBairro = res.data;
          this.bairros = loadBairro[0].bairros;
          this.regiaoData = loadBairro[0].regioes;
        })
        .catch(showError);
    },

    loadImovelList() {
      this.$http.get("/categorias/all").then((res) => {
        this.imoveisData = res.data;
        console.log(this.imoveisData);
        if (this.user != null) {
          if (this.user.cliente_id) {
            this.soCliente = true;
          }
        }

        setTimeout(() => (this.pageReady = true), 1000);
      });
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

    limparBusca() {
      this.loading = true;
      this.$http
        .get("/categorias/all")
        .then((res) => {
          this.imoveisData = res.data;
          // console.log(this.imoveisData);
          this.loading = false;
          this.restartImg();

          setTimeout(() => (this.pageReady = true), 1000);
        })
        .catch(showError);
      this.filtrosBusca = false;
      this.pesquisaDados = {};
      this.pesquisaData.pesquisa = "";
      this.pesquisaData.estado = "";
      this.pesquisaData.cidade = "";
      this.pesquisaData.bairro = [];
      this.pesquisaData.regiao = [];
      this.pesquisaData.areaUtil = "";
      this.pesquisaData.cep = "";
      this.pesquisaData.banheiros = "";
      this.pesquisaData.garagem = "";
      this.pesquisaData.quartos = "";
      this.pesquisaData.suites = "";
      this.pesquisaData.unidades = "";
      this.pesquisaData.valorMin = "";
      this.pesquisaData.valorMax = "";
      this.restartImg();
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
#imoveisList .banner-destaque {
  margin-bottom: 30px;
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
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
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

#imoveisList .slider-area-preferidos,
#imoveisList .slider-imoveis {
  position: relative;
  z-index: 5;
}
#imoveisList .slider-area-preferidos .box-imovel-preferidos,
#imoveisList .slider-imoveis .box-imovel {
  height: 150px;
  margin: 0 3px;
  border-radius: 4px;
  position: relative;
  transition: 0.5s;
  top: 0;
}
#imoveisList .slider-area-preferidos .box-imovel-preferidos:hover,
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
#imoveisList .slider-area-preferidos .box-imovel-preferidos img,
#imoveisList .slider-imoveis .box-imovel img {
  width: 100%;
  height: 150px;
  border-radius: 4px;
  object-fit: cover;
  object-position: center;
  transition: 0.5s;
  position: relative;
}
#imoveisList .slider-area-preferidos .box-imovel-preferidos:hover img,
#imoveisList .slider-imoveis .box-imovel:hover img {
  transition: 0.5s;
  border-radius: 0;
  filter: brightness(0.7);
}
#imoveisList
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos,
#imoveisList .slider-imoveis .box-imovel .imovel-infos {
  position: absolute;
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
  height: 0;
}
#imoveisList
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos
  h3,
#imoveisList .slider-imoveis .box-imovel .imovel-infos h3 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: bold;
  font-size: 12px;
  line-height: 15px;
  color: #ffffff;
}
#imoveisList
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos
  h5,
#imoveisList .slider-imoveis .box-imovel .imovel-infos h5 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: bold;
  font-size: 11px;
  line-height: 15px;
  color: #43cea2;
}
#imoveisList
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos
  p,
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
#imoveisList
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos
  .banner-actions-preferidos,
#imoveisList .slider-imoveis .box-imovel .imovel-infos .banner-actions {
  display: flex;
  justify-content: center;
  margin-top: 10px;
  margin-bottom: 20px;
}
#imoveisList
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos
  .banner-actions-preferidos
  .btn-share-preferidos
  .v-icon,
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
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos
  .banner-actions-preferidos
  .banner-btn-preferidos,
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
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos
  .banner-actions-preferidos
  .banner-btn-preferidos
  span,
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
#imoveisList .btnFiltrar {
  background-color: #43cea2;
  border-radius: 2px;
  z-index: 10;
  position: absolute;
  right: 16px;
}
#imoveisList .btnFiltrar:hover {
  background-color: #43cec5;
  border-radius: 2px;
}
#imoveisList
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos
  .banner-actions-preferidos
  .btn-circle-preferidos,
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
#inspire .v-dialog .box-filter .valorMaxClass .v-input__control .v-input__slot {
  width: 100%;
  padding-left: 5px;
}
#inspire .v-dialog .box-filter .valorMinClass .v-input__control .v-input__slot {
  width: 100%;
}
#inspire .v-dialog .box-filter .divForaBuscaBtn,
#inspire .v-dialog .box-filter .divForaFiltroBtn,
#inspire .v-dialog .box-filter .divForaBtn {
  padding-right: 5px;
  padding-left: 5px;
  display: inline;
}

#inspire .v-dialog .box-filter .cancelarFiltroBtn,
#inspire .v-dialog .box-filter .limparFiltroBtn {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 200;
  font-size: 16px;
  line-height: 27px;
  color: #000;
  text-transform: initial;
  margin-top: 45px;
  border-radius: 2px;
}
#inspire .v-dialog .box-filter .cancelarFiltroBtn::before,
#inspire .v-dialog .box-filter .limparFiltroBtn::before {
  background-color: #615856;
}
#inspire .v-dialog .box-filter .buscarBtnFiltro {
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
#inspire .v-dialog .box-filter .buscarBtnFiltro:hover {
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
#inspire
  .v-dialog
  .box-filter
  .rowPesquisa
  .v-input
  .v-input__control
  .v-input__slot {
  width: 100% !important;
}
#imoveisList
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos
  .banner-actions-preferidos
  .btn-imovel-link-preferidos,
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
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos
  .banner-actions-preferidos
  .btn-imovel-link-preferidos:hover,
#imoveisList
  .slider-imoveis
  .box-imovel
  .imovel-infos
  .banner-actions
  .btn-imovel-link:hover {
  border: 1px solid #fff;
}
#app #inspire .v-dialog .box-filter {
  background-color: rgba(0, 0, 0, 1.5);
  padding: 50px 45px 95px;
  text-align: center;
}
#app #inspire .v-dialog .box-filter .v-input .v-input__control .v-input__slot {
  width: 125px;
}
#app
  #inspire
  .v-dialog
  .box-filter
  .v-input
  .v-input__control
  .v-input__slot
  .v-select__slot {
  padding: 0 10px;
}
#app
  #inspire
  .v-dialog
  .box-filter
  .v-input
  .v-input__control
  .v-input__slot
  .v-select__slot
  .v-select__selections
  .v-select__selection {
  color: #fff;
}
#imoveisList
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos
  .banner-actions-preferidos
  .btn-imovel-link-preferidos
  span,
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
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos
  .banner-actions-preferidos
  .btn-imovel-link-preferidos
  span
  .v-icon
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
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos
  .banner-actions-preferidos
  .btn-imovel-link-preferidos
  span:hover,
#imoveisList
  .slider-imoveis
  .box-imovel
  .imovel-infos
  .banner-actions
  .btn-imovel-link
  span:hover {
  color: #fff;
}
#imoveisList
  .slider-area-preferidos
  .box-imovel-preferidos:hover
  .imovel-infos-preferidos,
#imoveisList .slider-imoveis .box-imovel:hover .imovel-infos {
  opacity: 1;
  transition: 0.5s;
  min-height: 200px;
}
#imoveisList .slider-area-preferidos .box-imovel-preferidos .imagemPointer,
#imoveisList .slider-imoveis .box-imovel .imagemPointer {
  cursor: pointer;
}
.btnNonePreferidos {
  display: none !important;
}
#imoveisList .slider-area-preferidos .slick-slide,
#imoveisList .slider-imoveis .slick-slide {
  opacity: 0.3;
  transition: 0.5s;
}
#imoveisList .slider-area-preferidos .slick-active,
#imoveisList .slider-imoveis .slick-active {
  opacity: 1 !important;
  transition: 0.5s;
}
#imoveisList .slider-area-preferidos .slick-arrow,
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
#imoveisList .slider-area-preferidos .slick-slider:hover .slick-arrow,
#imoveisList .slider-imoveis .slick-slider:hover .slick-arrow {
  opacity: 1;
  transition: 0.5s;
}
#imoveisList .slider-area-preferidos .slick-prev,
#imoveisList .slider-imoveis .slick-prev {
  left: -55px;
}
#imoveisList .slider-area-preferidos .slick-next,
#imoveisList .slider-imoveis .slick-next {
  right: -55px;
}
#imoveisList .slider-area-preferidos .slick-disabled,
#imoveisList .slider-imoveis .slick-disabled {
  opacity: 0 !important;
}
#imoveisList .slider-area-preferidos .slick-prev:before,
#imoveisList .slider-imoveis .slick-prev:before {
  content: "\f053";
  font-family: "FontAwesome";
}
#imoveisList .slider-area-preferidos .slick-next:before,
#imoveisList .slider-imoveis .slick-next:before {
  content: "\f054";
  font-family: "FontAwesome";
}
#imoveisList .slider-area-preferidos .slick-prev:before,
#imoveisList .slider-area-preferidos .slick-next:before,
#imoveisList .slider-imoveis .slick-prev:before,
#imoveisList .slider-imoveis .slick-next:before {
  color: rgba(255, 255, 255, 0.6);
  font-size: 35px;
}
#imoveisList .slider-area-preferidos .slick-track,
#imoveisList .slider-imoveis .slick-track {
  height: 150px;
}
#imoveisList .slider-area-preferidos,
#imoveisList .slider-imoveis .slider-area {
  padding: 0 60px;
  min-height: 230px;
}
#imoveisList .slider-area-preferidos:hover,
#imoveisList .slider-imoveis .slider-area:hover {
  z-index: 100;
}
#imoveisList .slider-area-preferidos h2,
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
  margin-top: 20px;
}
#imoveisList .slider-area-preferidos .slick-list,
#imoveisList .slider-imoveis .slider-area .slick-list {
  overflow: visible !important;
}
#imoveisList .slider-area-preferidos .slick-slider,
#imoveisList .slider-imoveis .slider-area .slick-slider {
  z-index: 15;
}
#imoveisList
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos
  .icon-list-preferidos,
#imoveisList .slider-imoveis .box-imovel .imovel-infos .icon-list {
  display: flex;
  padding-top: 15px;
}
#imoveisList
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos
  .icon-list-preferidos
  .box-icon-preferidos,
#imoveisList .slider-imoveis .box-imovel .imovel-infos .icon-list .box-icon {
  width: 29px;
  position: relative;
}
#imoveisList
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos
  .icon-list-preferidos
  img,
#imoveisList .slider-imoveis .box-imovel .imovel-infos .icon-list img {
  width: 100%;
  height: 11px;
  object-fit: contain;
  object-position: center;
  margin: auto;
}
#imoveisList
  .slider-area-preferidos
  .box-imovel-preferidos
  .imovel-infos-preferidos
  .icon-list-preferidos
  p,
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
@media (max-width: 1024px) {
  #imoveisList .banner-destaque .banner-imovel h1 {
    font-size: 40px;
  }
}

@media (max-width: 768px) {
  #imoveisList .imovel-infos-preferidos .banner-actions-preferidos,
  #imoveisList .imovel-infos-preferidos .alignRight .banner-actions-preferidos,
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
  #imoveisList
    .slider-area-preferidos
    .box-imovel-preferidos
    .imovel-infos-preferidos,
  #imoveisList .slider-imoveis .box-imovel .imovel-infos {
    opacity: 1;
    transition: 0.5s;
    min-height: 200px;
  }
  #imoveisList .slider-imoveis .slick-slider .slick-arrow {
    opacity: 1;
    transition: 0.5s;
  }
  #imoveisList .slider-area-preferidos,
  #imoveisList .slider-imoveis .slider-area {
    padding: 0 20px;
  }
  #imoveisList
    .slider-area-preferidos
    .box-imovel-preferidos
    .imovel-infos-preferidos,
  #imoveisList .slider-imoveis .box-imovel .imovel-infos {
    padding: 5px 15px;
  }
}
@media (max-width: 576px) {
  #imoveisList .banner-destaque .banner-imovel h1 {
    line-height: 40px;
  }
  #app #inspire .v-dialog {
    margin: 0;
    height: 100%;
    max-height: unset;
  }
  #app #inspire .v-dialog .box-filter {
    background-color: rgba(0, 0, 0, 0.88);
  }
  #inspire .v-dialog .box-filter .rowPesquisa .col-paddin-filtro {
    padding-top: 0;
    padding-bottom: 0;
  }
}
</style>
