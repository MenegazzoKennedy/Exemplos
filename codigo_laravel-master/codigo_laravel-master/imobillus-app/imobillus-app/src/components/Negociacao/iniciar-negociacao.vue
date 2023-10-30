<template>
  <section v-if="pageReady == true" id="negociacaoImovel">
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
                <li class="divisor-menu active-page">
                  <p @click="goNegociacao">Iniciar negociação</p>
                </li>
                <li class="divisor-menu">
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
                <li class="divisor-menu active-page">
                  <p @click="goNegociacao">Iniciar negociação</p>
                </li>
                <li class="divisor-menu">
                  <p @click="goSimulacao">Simular financiamento</p>
                </li>
              </ul>
            </div>
            <div class="imovel-menu align-right" v-else>
              <ul>
                <li class=""><p @click="goSingleImovel">Sobre o imóvel</p></li>
                <li class="divisor-menu active-page">
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

    <template v-if="is_loged == true">
      <div class="agendar-infos">
        <v-container>
          <v-row>
            <v-col cols="12">
              <h2>NEGOCIAÇÃO</h2>
            </v-col>
          </v-row>
        </v-container>

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
                      <p>
                        Valor do imóvel: {{ formatValor(imovelData.valor) }}
                      </p>
                    </div>
                  </div>

                  <div
                    v-if="
                      is_loged == true &&
                      this.user.corretor_id_preferido != null
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
                        <h2>{{ consultor.name }}</h2>
                        <h4>CRECI - {{ consultor.creci }}</h4>
                      </div>
                    </div>
                  </v-container>
                </div>
              </div>
            </v-col>

            <v-col class="text-center" cols="12">
              <v-btn @click="dialogUnidade = true" class="btn-padrao"
                >Trocar unidade</v-btn
              >
            </v-col>
          </v-row>
        </v-container>
      </div>

      <v-dialog v-model="dialogUnidade" max-width="600px">
        <v-card class="modal-unidade">
          <v-card-title>
            <span>Nova Unidade</span>
          </v-card-title>
          <v-card-text>
            <div class="search-consult2" v-show="!corretorSelecionado">
              <v-text-field
                placeholder="CRECI"
                rounded
                v-model="corrCreci"
                class="creciDoCorr"
              ></v-text-field>
              <v-btn
                @click="searchCorrCreci"
                icon
                class="btn-search-consult2"
                :disabled="!corrCreci"
              >
                <v-icon>mdi-magnify</v-icon>
              </v-btn>
            </div>
            <v-text-field
              placeholder="Digite as informações de troca"
              rounded
              v-model="infNovaUnidade"
              class="unidadeNova"
            ></v-text-field>
          </v-card-text>
          <v-card-actions>
            <v-btn text @click="dialogUnidade = false">Cancelar</v-btn>

            <v-btn text @click="enviarUni" :loading="loading" class="loaderBtn"
              >Enviar</v-btn
            >
          </v-card-actions>
        </v-card>
      </v-dialog>

      <div class="slider-informacoes">
        <v-container>
          <v-row>
            <v-col cols="12">
              <div class="sliderInfos">
                <VueSlickCarousel
                  :arrows="true"
                  :dots="false"
                  v-bind="settings"
                >
                  <div class="text-infos">
                    <p>{{ imovelData.detalhes }}</p>
                  </div>

                  <div class="text-infos">
                    <p>
                      {{ imovelData.detalhes }}
                    </p>
                  </div>

                  <div class="text-infos">
                    <p>
                      {{ imovelData.detalhes }}
                    </p>
                  </div>
                </VueSlickCarousel>
              </div>
            </v-col>
          </v-row>
        </v-container>
      </div>

      <div class="basic-infos">
        <v-container>
          <v-row>
            <v-col cols="12">
              <div class="icon-list">
                <template v-for="(infos, i) in imovelData.caracteristicas">
                  <div
                    v-if="
                      infos.is_coord == 0 &&
                      infos.descricao != 'longitude' &&
                      infos.descricao != 'latitude' &&
                      infos.icone != null
                    "
                    class="box-icon"
                    :key="i"
                  >
                    <img :src="formatImg(infos.icone)" />
                    <p>{{ infos.descricao }}</p>
                    <p>
                      <span>{{ infos.valor }}</span>
                    </p>
                  </div>
                </template>
              </div>

              <div class="other-infos">
                <v-checkbox v-model="pcdCheck">
                  <template v-slot:label>
                    <div>
                      <p class="labelpcd">
                        Sou PCD <v-icon>mdi-wheelchair-accessibility</v-icon>
                      </p>
                    </div>
                  </template>
                </v-checkbox>

                <div class="negociacao-btn">
                  <v-btn @click="meFinanciar" class="btn-padrao"
                    >Quero financiar</v-btn
                  >
                  <v-btn @click="mePagar" class="btn-padrao"
                    >Pagamento à vista</v-btn
                  >
                  <v-btn @click="meJatenho" class="btn-padrao"
                    >Já possuo financiamento</v-btn
                  >
                </div>
              </div>

              <v-dialog v-model="dialogNegociacao" max-width="600px" persistent>
                <v-card class="modal-agendar">
                  <v-card-title>
                    <span>Negociação</span>
                  </v-card-title>

                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col cols="12">
                          <h4>Arquivos necessários</h4>
                          <ul class="arquivos-view">
                            <li>
                              <h5>Comprovante de residência</h5>
                              <h5>Certidão Civil</h5>
                              <h5>PDC - Laudo</h5>
                              <h5>Extrato 3 a 6 meses</h5>
                              <h5>Saldo FGTS</h5>
                              <h5>3 Ultimos Holerite</h5>
                              <h5>Carteira de Identidade</h5>
                            </li>
                          </ul>

                          <label for="archivePost">
                            <h4 class="labelUpload">
                              Enviar arquivos <v-icon>mdi-folder-upload</v-icon>
                            </h4>
                          </label>

                          <input
                            id="archivePost"
                            type="file"
                            accept="application/pdf"
                            multiple
                            @change="handleSelects"
                            name="files[]"
                          />

                          <ul class="arquivos-view">
                            <template v-for="(arq, i) in arquivos">
                              <li :key="i">
                                <p @click="openPDF(arq)">Arquivo {{ i + 1 }}</p>
                              </li>
                            </template>
                          </ul>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card-text>

                  <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn text @click="closeDialog">Cancelar</v-btn>

                    <v-btn text @click="uploadArquivos">Enviar</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-col>
          </v-row>
        </v-container>
      </div>
    </template>

    <template v-else>
      <v-container>
        <v-row>
          <v-col cols="12" class="text-center noLoged">
            <v-btn class="btn-padrao" @click="dialogLogin = true"
              >Necessário Fazer Login</v-btn
            >
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
          </v-col>
        </v-row>
      </v-container>
    </template>

    <myFooter />
  </section>
</template>

<script>
import Vue from "vue";
import { mapState } from "vuex";
import myHeader from "../Header/header.vue";
import myFooter from "../Footer/footer.vue";
import { userKey, showError } from "@/global";

export default {
  name: "single-imovel",
  data() {
    return {
      id: 0,
      slug: "",
      idsArray: [],
      loged_user: JSON.parse(localStorage.getItem(userKey)),
      is_loged: false,
      exist_clientId: false,
      link: "",
      dialogYtb: false,
      dialog360: false,
      quantUnidade: 0,
      botaoYtb: false,
      botaoTour: false,
      botaoQuant: false,
      pageReady: false,
      loading: false,
      emailRules: [
        (v) => !!v || "O Email é obrigatório",
        (v) => /.+@.+\..+/.test(v) || "Email precisa ser válido",
      ],
      unidadeData: [],
      dialogUnidade: false,
      imgPadraoCorr: {
        src: require("../../assets/icone_corretor.png"),
      },
      viewCorr: false,
      dialogLogin: false,
      pcdCheck: false,
      selecionado: false,
      clientMenu: false,
      imovelData: [],
      consultorData: [],
      corretorSelecionado: false,
      userCliente: JSON.parse(localStorage.getItem(userKey)),
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
      dialogNegociacao: false,
      consultarConsultor: "",
      tipoAction: "",
      corrCreci: "",
      infNovaUnidade: "",
      corretorID: "",
      arquivos: [],
      arquivosFile: [],
      fileData: [],

      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
      },
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
  methods: {
    openPDF(pdf) {
      var win = window.open();
      win.document.write(
        '<iframe src="' +
          pdf +
          '" frameborder="0" style="border:0; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%;" allowfullscreen></iframe>'
      );
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

    divSelecionada(i) {
      for (let j = 0; j < this.consultorData.length; j++) {
        if (this.corretorID == this.consultorData[i].id) {
          return this.selecionado[i];
        } else {
          return (this.selecionado[i] = false);
        }
      }
    },

    submitLogin(e) {
      if (e.keyCode === 13) {
        this.login();
      } else if (e.keyCode === 27) {
        this.dialogLogin = false;
      }
    },

    selectConsultor(i, idCorr) {
      this.corretorID = idCorr;
      Vue.set(this.selecionado, i, !this.selecionado[i]);
    },

    verificaFotoCons(img) {
      if (typeof img.url == "string") {
        return img.url;
      } else {
        return this.imgPadraoCorr.src;
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

    searchCorrCreci() {
      if (this.consultarConsultor != "") {
        this.$http
          .post("/corretores/busca", {
            consuta: this.consultarConsultor,
          })
          .then((res) => {
            this.consultorData = res.data;
            this.selecionado = this.consultorData.map(() => false);
            this.viewCorr = true;
          })
          .catch(showError);
      } else {
        Vue.toasted.global.defaultError({
          errors: "Digitar o CRECI ou nome do Corretor!",
        });
      }
    },

    enviarUni() {
      this.loading = true;
      var mensagemUnidade = this.infNovaUnidade;

      if (this.viewCorr == true) {
        this.corretorID = this.consultorData.corretor_id;
      } else {
        this.corretorID = null;
      }

      if (this.userCliente.cliente_id) {
        this.$http
          .post("/produto/solicitacao", {
            mensagem: mensagemUnidade,
            id_imovel: this.imovelData.id,
            id_corretor: this.corretorID,
          })
          .then((res) => {
            this.loading = false;
            this.unidadeData = res.data;
            this.dialogUnidade = false;
            Vue.toasted.global.defaultSuccess({
              msg: "Informações enviadas com Sucesso! Aguarde retorno do corretor...",
            });
          })
          .catch(showError);
      } else {
        Vue.toasted.global.defaultError({
          errors: "Necessário ser cliente para realizar ação!",
        });
      }
    },

    handleSelects(e) {
      let fileList = Array.prototype.slice.call(e.target.files);
      this.arquivosFile = e.target.files;

      Array.from(fileList).forEach((f) => {
        const reader = new FileReader();
        reader.onload = () => {
          this.arquivos.push(reader.result);
        };
        reader.readAsDataURL(f);
      });
    },
    uploadArquivos() {
      var postData = new FormData();

      for (const i of Object.keys(this.arquivosFile)) {
        postData.append("files[]", this.arquivosFile[i]);
      }

      postData.append("imovel_id", this.imovelData.id);
      postData.append("corretor_id", this.consultorData.user_id);
      postData.append("tipo_negociacao", this.tipoAction);

      this.$http
        .post("/negociacao", postData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          this.fileData = res.data;
          this.dialogNegociacao = false;
          Vue.toasted.global.defaultSuccess({
            msg: "Upload feito com sucesso!",
          });
        })
        .catch(showError);
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

    goImovelList() {
      this.$router.push({ path: "/lista-imoveis" });
    },

    formatImg(img) {
      return require("../../assets/" + img + ".png");
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

    verificBanner(img) {
      if (img) {
        return img.url;
      } else {
        return this.imgPadrao.src;
      }
    },

    meJatenho() {
      this.tipoAction = "JaPossuoFinanciamento";
      this.dialogNegociacao = true;
    },

    mePagar() {
      this.tipoAction = "PagamentoaVista";
      this.dialogNegociacao = true;
    },

    meFinanciar() {
      this.tipoAction = "QueroFinanciar";
      this.dialogNegociacao = true;
    },
    closeDialog() {
      this.tipoAction = "";
      this.dialogNegociacao = false;
    },
  },
};
</script>

<style>
#archivePost {
  display: none;
}
.labelUpload {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 19px;
  line-height: 23px;
  color: #ffffff;
  cursor: pointer;
}
.labelUpload .v-icon {
  color: #43cea2;
}

#negociacaoImovel .noLoged {
  margin: 60px 0px;
}
#negociacaoImovel .noLoged h2 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 22px;
  line-height: 30px;
  text-align: center;
  color: #ffffff;
}

#negociacaoImovel .align-agendar .search-consult,
.modal-unidade .search-consult2 {
  margin: 25px 0px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.modal-unidade .search-consult2 .btn-search-consult2 {
  background-color: #43cea2;
  color: #fff;
  width: 35px;
  height: 35px;
}

#negociacaoImovel .align-agendar .search-consult .v-input__slot {
  border: 1px solid #ffffff;
  box-sizing: border-box;
  border-radius: 29.5px;
  background-color: transparent;
  width: fit-content;
  margin: 0;
}
.mudarBack {
  background-color: #43cea2;
}
.scrollDiv {
  max-height: 195px;
  overflow-y: auto;
}

.consultor-title .search-consult h2 {
  font-family: "Roboto", sans-serif !important;
  font-size: 16px !important;
  color: #ffffff !important;
  font-weight: 500 !important;
}

#app
  #inspire
  #negociacaoImovel
  .agendar-infos
  .box-agendar
  .consultor-title
  .scrollDiv
  .card-consultor {
  border: 0.5px solid #ffffff;
  box-sizing: border-box;
  border-radius: 8px;
  display: flex;
  align-items: center;
  padding: 10px 15px;
  width: 100%;
  margin: 10px auto 0;
}

#app
  #inspire
  #negociacaoImovel
  .agendar-infos
  .box-agendar
  .consultor-title
  .scrollDiv
  .card-consultor
  img {
  width: 65px;
  height: 60px;
  object-fit: cover;
  object-position: center;
  border-radius: 50%;
}

#app
  #inspire
  #negociacaoImovel
  .agendar-infos
  .box-agendar
  .consultor-title
  .scrollDiv
  .card-consultor
  .text-infos {
  display: block;
  text-align: left;
  margin: 10px 10px;
}
#app
  #inspire
  #negociacaoImovel
  .agendar-infos
  .box-agendar
  .consultor-title
  .scrollDiv
  .card-consultor
  .text-infos
  h2 {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 15px;
  line-height: 23px;
  color: #ffffff;
  margin: 1px 0;
}
#app
  #inspire
  #negociacaoImovel
  .agendar-infos
  .box-agendar
  .consultor-title
  .scrollDiv
  .card-consultor
  .text-infos
  h4 {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 300;
  font-size: 13px;
  line-height: 20px;
  color: #ffffff;
}

#app
  #inspire
  #negociacaoImovel
  .agendar-infos
  .box-agendar
  .consultor-title
  .scrollDiv
  .card-consultor:hover {
  background-color: #4f4f4f;
}
#inspire .modal-unidade .search-consult2 .creciDoCorr .v-input__slot {
  border: 1px solid #ffffff;
  box-sizing: border-box;
  border-radius: 29.5px;
  background-color: transparent;
  margin: 0;
  width: 80%;
}

.unidadeNova .v-input__slot {
  border: 1px solid #ffffff;
  box-sizing: border-box;
  border-radius: 29.5px;
  background-color: transparent;
  margin: 0;
}
#negociacaoImovel .align-agendar .search-consult .v-input {
  width: fit-content;
  flex: initial;
  margin: 5px 10px;
  padding: 0;
}
#inspire .theme--light.v-input,
.theme--light.v-input input,
.theme--light.v-input textarea {
  color: #f2f2f2 !important;
  font-size: 14px;
  font-family: "Open Sans", sans-serif;
  flex: unset;
}
#negociacaoImovel .align-agendar .search-consult .v-input input,
.v-input input {
  border: 1px solid transparent;
  border-radius: 29.5px;
  text-align: center;
}
#negociacaoImovel
  .align-agendar
  .search-consult
  .v-input
  .v-text-field__details {
  display: none;
}
#negociacaoImovel .align-agendar .search-consult .v-input .v-text-field__slot {
  min-width: 115px;
  width: min-content;
}

#negociacaoImovel .btn-padrao {
  background-color: #185a9d;
  border: none;
  box-sizing: border-box;
  border-radius: 8px;
  padding: 20px 15px;
  margin-top: 35px;
}
#negociacaoImovel .btn-padrao span {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 20px;
  line-height: 22px;
  color: #ffffff;
  text-transform: initial;
}
#negociacaoImovel {
  background-color: #000;
}
#negociacaoImovel .banner-destaque {
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
#negociacaoImovel .banner-destaque:before {
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
#inspire #negociacaoImovel .container .imovel-actions .v-btn:before {
  color: #43cea2;
  justify-content: center;
  background-color: transparent;
}
#negociacaoImovel .banner-destaque h1 {
  font-family: "Buda", cursive;
  font-style: normal;
  font-weight: 300;
  font-size: 60px;
  line-height: 75px;
  color: #ffffff;
}
#negociacaoImovel .banner-destaque h3 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 500;
  font-size: 32px;
  line-height: 35px;
  color: #ffffff;
}
#negociacaoImovel .banner-destaque .align-right {
  text-align: right;
}
#negociacaoImovel .banner-destaque .menu-single {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 50px;
}
#negociacaoImovel .banner-destaque .menu-single ul {
  display: flex;
  padding: 0;
  margin: 0;
  justify-content: space-between;
  list-style: none;
}
#negociacaoImovel .banner-destaque .menu-single .imovel-menu li {
  margin-left: 15px;
}
#inspire
  #negociacaoImovel
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
  #negociacaoImovel
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
  #negociacaoImovel
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
  #negociacaoImovel
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
  #negociacaoImovel
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
  #negociacaoImovel
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
  #negociacaoImovel
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
#negociacaoImovel .banner-destaque .menu-single .imovel-menu li p {
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
#negociacaoImovel .banner-destaque .menu-single .imovel-menu li p:hover {
  border-bottom: 1px solid #43cea2;
  transition: 0.5s;
}
#negociacaoImovel .banner-destaque .menu-single .imovel-menu .divisor-menu {
  border-left: 1px solid #43cea2;
}
#negociacaoImovel .banner-destaque .menu-single .imovel-actions li {
  margin-right: 20px;
}
#negociacaoImovel .banner-destaque .menu-single .imovel-actions li .v-btn {
  height: 100%;
  width: 100%;
}

#negociacaoImovel .basic-infos {
  padding-top: 35px;
}
#negociacaoImovel .basic-infos h2 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 22px;
  line-height: 30px;
  text-align: center;
  color: #ffffff;
  margin: 80px 0 25px;
}
#negociacaoImovel .basic-infos h4 {
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
#negociacaoImovel .basic-infos h4 .v-icon {
  color: #43cea2;
  margin-right: 10px;
}
#negociacaoImovel .basic-infos p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: lighter;
  font-size: 22px;
  line-height: 26px;
  text-align: justify;
  color: #ffffff;
}
.v-dialog .box-client {
  background-color: rgba(0, 0, 0, 0.8);
  padding: 50px 45px 95px;
  text-align: center;
  height: 300px;
}
#negociacaoImovel .basic-infos .other-infos p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 20px;
  line-height: 26px;
  color: #ffffff;
  display: flex;
  text-align: center;
  align-items: center;
  margin: 0;
}
#negociacaoImovel .basic-infos .other-infos .labelpcd .v-icon {
  color: #43cea2 !important;
  font-size: 25px;
  padding-left: 5px;
}
#negociacaoImovel .basic-infos .other-infos .v-messages {
  display: none;
}
#negociacaoImovel .basic-infos .other-infos .v-input--checkbox {
  width: fit-content;
  margin: auto;
}
#negociacaoImovel .basic-infos .other-infos .v-input__slot {
  background-color: transparent;
}
#negociacaoImovel .basic-infos .other-infos .v-input__slot .v-icon {
  color: #fff;
}

#negociacaoImovel .basic-infos .other-infos .negociacao-btn {
  display: flex;
  justify-content: center;
  align-items: center;
}
#negociacaoImovel .basic-infos .other-infos .negociacao-btn .v-btn {
  margin: 50px 25px 0;
}

#negociacaoImovel .banner-destaque .icon-area {
  height: 75px;
  display: flex;
  justify-content: flex-end;
  align-items: center;
}
#negociacaoImovel .banner-destaque .icon-area .banner-btn {
  border: 1px solid #43cea2;
  box-sizing: border-box;
  border-radius: 8px;
  background-color: transparent;
  margin-left: 20px;
  padding: 10px 35px;
  transition: 0.5s;
}
#negociacaoImovel .banner-destaque .icon-area .banner-btn span {
  color: #fff;
}
#negociacaoImovel .banner-destaque .icon-area .btn-circle {
  border-radius: 50%;
  padding: 0;
  height: 45px;
  width: 45px;
}
#negociacaoImovel .banner-destaque .icon-area .banner-btn:hover {
  background: linear-gradient(
    180deg,
    #43cea2 0%,
    rgba(67, 206, 162, 0) 100%
  ) !important;
  transition: 0.5s;
}
#negociacaoImovel .basic-infos .icon-list {
  display: flex;
  justify-content: space-evenly;
  padding: 20px 0;
}
#negociacaoImovel .basic-infos .icon-list .box-icon {
  margin: 25px 0;
}
#negociacaoImovel .basic-infos .icon-list img {
  width: 100%;
  height: 35px;
  object-fit: contain;
  object-position: center;
  margin: auto;
}
#negociacaoImovel .basic-infos .icon-list p {
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
#negociacaoImovel .basic-infos .icon-list p span {
  font-weight: 200;
}

#negociacaoImovel .agendar-infos {
  margin: 50px 0 80px;
  padding: 0;
}
#negociacaoImovel .agendar-infos h2 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 32px;
  line-height: 26px;
  text-align: center;
  color: #ffffff;
  margin: 60px 0;
}

.loaderBtn {
  color: #43cea2 !important;
}

#negociacaoImovel .agendar-infos .box-agendar {
  border: 1px solid rgba(255, 255, 255, 0.1);
  box-sizing: border-box;
  border-radius: 4px;
  padding: 30px 65px;
  text-align: center;
}
#negociacaoImovel .agendar-infos .box-agendar .align-agendar,
#negociacaoImovel .agendar-infos .box-agendar .align-agendar .selected-imovel {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
#negociacaoImovel
  .agendar-infos
  .box-agendar
  .align-agendar
  .selected-imovel
  h3 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 22px;
  line-height: 24px;
  color: #ffffff;
}
#negociacaoImovel
  .agendar-infos
  .box-agendar
  .align-agendar
  .selected-imovel
  p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 22px;
  color: #ffffff;
}
#negociacaoImovel
  .agendar-infos
  .box-agendar
  .align-agendar
  .selected-imovel
  img {
  width: 145px;
  height: 135px;
  border-radius: 4px;
  border: 1px solid #ffffff;
  box-sizing: border-box;
  object-fit: cover;
  object-position: center;
}
#negociacaoImovel
  .agendar-infos
  .box-agendar
  .align-agendar
  .selected-imovel
  .imovel-details {
  text-align: left;
  margin-left: 15px;
}
#negociacaoImovel
  .agendar-infos
  .box-agendar
  .align-agendar
  .selected-corretor {
  text-align: center;
}
#negociacaoImovel
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
#negociacaoImovel
  .agendar-infos
  .box-agendar
  .align-agendar
  .selected-corretor
  p {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 300;
  font-size: 14px;
  line-height: 19px;
  color: #ffffff;
}
#negociacaoImovel
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
#negociacaoImovel .slider-informacoes .sliderInfos {
  background: rgba(26, 25, 25, 0.4);
  border-radius: 8px;
  padding: 40px 50px;
}
#negociacaoImovel .slider-informacoes .sliderInfos .text-infos p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 26px;
  text-align: justify;
  color: #ffffff;
  margin: 0;
  padding: 10px 25px;
}
#negociacaoImovel .slider-informacoes .sliderInfos .slick-arrow {
  height: 80px;
  width: 40px;
}
.btnNonePreferidos {
  display: none !important;
}
#negociacaoImovel .slider-informacoes .sliderInfos .slick-prev:before {
  content: "\f053";
  font-family: "FontAwesome";
  color: rgba(255, 255, 255, 0.1);
  font-size: 50px;
}
#negociacaoImovel .slider-informacoes .sliderInfos .slick-next:before {
  content: "\f054";
  font-family: "FontAwesome";
  color: rgba(255, 255, 255, 0.1);
  font-size: 50px;
}

#app
  #inspire
  #negociacaoImovel
  .agendar-infos
  .box-agendar
  .consultor-title
  .search-consult {
  margin: 10px 0px;
  display: flex;
}

#app
  #inspire
  #negociacaoImovel
  .agendar-infos
  .box-agendar
  .consultor-title
  .search-consult
  h2 {
  margin: 20px 0;
  text-align: left;
}

#app
  #inspire
  #negociacaoImovel
  .agendar-infos
  .box-agendar
  .consultor-title
  .search-consult
  .v-input__slot {
  border: 1px solid #ffffff;
  box-sizing: border-box;
  border-radius: 29.5px;
  background-color: transparent;
  width: fit-content;
  margin: 0 10px;
}

#app
  #inspire
  #negociacaoImovel
  .agendar-infos
  .box-agendar
  .consultor-title
  .search-consult
  .btn-search-consult {
  background-color: #43cea2;
  color: #fff;
  width: 35px;
  height: 35px;
  margin: 15px 3px;
}

#inspire .modal-unidade {
  padding: 15px 25px;
}

#inspire .modal-unidade .v-card__title span {
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

#inspire .modal-unidade .v-card__actions .v-btn__content {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: bold;
  font-size: 14px;
  line-height: 22px;
  color: #ffffff;
}

#inspire .modal-agendar {
  padding: 15px 25px;
}
#inspire .modal-agendar .arquivos-view {
  list-style: none;
  margin-bottom: 20px;
}
#inspire .modal-agendar .arquivos-view li p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 16px;
  line-height: 22px;
  color: #ffffff;
  margin: 0;
  padding: 1px 0;
  cursor: pointer;
}
#inspire .modal-agendar .arquivos-view li h5 {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 13px;
  line-height: 19px;
  color: #ffffff;
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

@media (max-width: 1330px) {
  #negociacaoImovel .banner-destaque h1 {
    font-size: 40px;
  }
  #negociacaoImovel .banner-destaque h3 {
    font-size: 24px;
    line-height: 27px;
  }
  #negociacaoImovel
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
  #negociacaoImovel .banner-destaque .menu-single .imovel-menu li p {
    font-size: 17px;
  }
}
@media (max-width: 768px) {
  #negociacaoImovel .banner-destaque .menu-single .imovel-menu li {
    margin-left: 10px;
  }
  #negociacaoImovel .banner-destaque .menu-single .imovel-menu li p {
    font-size: 14px;
    margin-left: 10px;
  }
}
@media (max-width: 500px) {
  #negociacaoImovel .basic-infos .other-infos .negociacao-btn .v-btn {
    margin: 50px 0px 0;
    padding: 20px 10px;
  }
  #negociacaoImovel .basic-infos .other-infos .negociacao-btn {
    display: block;
    text-align: center;
  }
  #negociacaoImovel .slider-informacoes .sliderInfos {
    padding: 40px 20px;
  }
  #negociacaoImovel .slider-informacoes .sliderInfos .text-infos p {
    font-size: 14px;
    padding: 10px 20px;
  }
  #negociacaoImovel .agendar-infos .box-agendar .align-agendar,
  #negociacaoImovel
    .agendar-infos
    .box-agendar
    .align-agendar
    .selected-imovel {
    display: block;
  }
  #negociacaoImovel
    .agendar-infos
    .box-agendar
    .align-agendar
    .selected-imovel
    .imovel-details {
    text-align: center;
    margin-left: 0;
  }
  #negociacaoImovel .agendar-infos .box-agendar {
    padding: 30px;
  }
  #negociacaoImovel .banner-destaque,
  #negociacaoImovel .banner-destaque .align-right,
  #negociacaoImovel .basic-infos h2,
  #negociacaoImovel .basic-infos p {
    text-align: center;
  }
  #negociacaoImovel .banner-destaque .icon-area,
  #negociacaoImovel .banner-destaque .menu-single ul {
    justify-content: center;
  }
  #negociacaoImovel .banner-destaque .menu-single,
  #negociacaoImovel .basic-infos .icon-list,
  #negociacaoImovel .banner-destaque .menu-single .imovel-menu ul {
    display: block;
  }
  #negociacaoImovel .banner-destaque .menu-single .imovel-menu .divisor-menu {
    border: none;
  }
  #negociacaoImovel .banner-destaque .menu-single .imovel-menu li {
    margin-left: 0px;
    margin: 10px 0 0px 0px;
  }
  #negociacaoImovel .banner-destaque .menu-single .imovel-menu li p {
    margin: 0;
    display: inline;
  }
  #negociacaoImovel .banner-destaque .menu-single .imovel-actions li {
    margin-right: 10px;
    margin-left: 10px;
  }
  #inspire .modal-agendar .v-card__title span {
    font-size: 26px;
  }
}
</style>