<template>
  <div>
    <offline ref="offline" />
    <v-dialog
      v-model="value"
      persistent
      content-class="dialogDenuncia"
    >
      <v-container>
        <v-row>
          <v-col
            cols="12"
            class="denuncias"
          >
            <!-- Inicio da primeira tela do modal (Abre ao clicar em denuncia no app.) -->
            <div
              v-show="primeiraTela"
              class="firstScreen"
            >
              <h2>Tipo da Denúncia:</h2>
              <v-list-item-group
                v-model="settings"
                class="listItems"
              >
                <v-list-item
                  v-for="(tipos, i) in tiposDenuncia"
                  :key="i"
                >
                  <template>
                    <v-list-item-content @click="openScreen(i)">
                      <!-- Onde vai o nome/titulo da denuncia e subtitulo/descricao -->
                      <v-list-item-title>
                        {{
                          tipos.descricao
                        }}
                      </v-list-item-title>
                    </v-list-item-content>
                    <v-list-item-action
                      class="tiposDenuncia"
                      @click="openScreen(i)"
                    >
                      <v-icon>mdi-chevron-right</v-icon>
                    </v-list-item-action>
                  </template>
                </v-list-item>
                <v-list-item>
                  <template>
                    <v-list-item-content @click="openScreen(indice)">
                      <!-- Onde vai o nome/titulo da denuncia e subtitulo/descricao -->
                      <v-list-item-title>Outros</v-list-item-title>
                    </v-list-item-content>
                    <v-list-item-action
                      class="tiposDenuncia"
                      @click="openScreen(indice)"
                    >
                      <v-icon>mdi-chevron-right</v-icon>
                    </v-list-item-action>
                  </template>
                </v-list-item>
              </v-list-item-group>
              <div class="buttonsFirstScreen">
                <v-btn @click="close">
                  Cancelar
                </v-btn>
              </div>
            </div>
            <!-- Inicio da segunda tela do modal (Abre ao clicar em alguma opcao de denuncia) -->
            <div
              v-show="chooseOther"
              class="inputTitulo"
            >
              <h2>Tipo da denuncia:</h2>
              <v-text-field
                v-model="tituloOutro"
                placeholder="Titulo da Denuncia..."
              />
            </div>
            <div
              v-show="!primeiraTela"
              class="secondScreen"
            >
              <h2>Descreva o ocorrido:</h2>
              <v-textarea
                v-model="complaintText"
                outlined
                rows="4"
                class="textAreaDenuncia pb-3"
                maxlength="300"
                hide-details
                placeholder="Descreva o ocorrido..."
              />
              <span
                class="primary--text ml-3"
              >{{ complaintText.length }} de 300 caracteres.</span>
              <div class="buttonsSecondScreen pt-2">
                <!-- Ao clicar chama metodo para voltar a primeira tela de selecao de tipo de denuncia -->
                <v-btn @click="goBackFirstScreen">
                  Voltar
                </v-btn>
                <!-- Ao clicar chama metodo para enviar denuncia! -->
                <v-btn
                  :loading="loading"
                  @click="sendComplaint"
                >
                  Enviar
                </v-btn>
              </div>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </v-dialog>
  </div>
</template>
    
<script>
import Vue from "vue";
import offline from "./Offline.vue";
export default {
  name: "Modal",
  components: { offline },
  props: {
    posts: {
      type: Array,
      default: null
    }
  },
  data: () => {
    return {
      settings: [],
      value: false,
      tipoReq: "",
      postId: null,
      comentarioId: null,
      usuarioId: null,
      idDenuncia: null,
      tiposDenuncia: [],
      dadosDenuncia: {},
      tipoDaDenuncia: "",
      primeiraTela: true,
      complaintText: "",
      chooseOther: false,
      tituloOutro: "",
      indice: null,
      loading: false,
    };
  },
  mounted() {
    this.openModal();
  },
  methods: {
    openModal() {
      var isOnline = navigator.onLine;
      if (!isOnline) {
        this.$refs.offline.loadPage();
      } else {
        this.$http
          .get("/tipos/denuncia")
          .then((res) => {
            this.tiposDenuncia = res.data;
            this.indice = this.tiposDenuncia.length + 1;
          });
      }
    },
    close() {
      this.value = false;
      this.goBackFirstScreen();
    },
    openDialog() {
      this.value = true;
      this.tipoReq = parseInt(localStorage.getItem("tipoReq"));
      if (this.tipoReq == 1) {
        this.usuarioId = parseInt(localStorage.getItem("usuarioID"));
        this.idDenuncia = this.usuarioId;
      } else if (this.tipoReq == 2) {
        this.postId = parseInt(localStorage.getItem("postID"));
        this.idDenuncia = this.postId;
      } else {
        this.comentarioId = parseInt(localStorage.getItem("comentarioID"));
        this.idDenuncia = this.comentarioId;
      }
    },
    openScreen(index) {
      this.primeiraTela = !this.primeiraTela;
      if (index == this.indice) {
        this.chooseOther = true;
        return (this.tipoDaDenuncia = null);
      } else {
        this.chooseOther = false;
      }
      this.tipoDaDenuncia = this.tiposDenuncia[index].id;
    },
    sendComplaint() {
      this.loading = true;
      if (this.complaintText == "") {
        Vue.toasted.global.defaultError({errors: "Digite algo para realizar a denúncia!"});
        this.loading = false;
      }
      if (this.idDenuncia) {
        this.dadosDenuncia.id = this.idDenuncia;
      }
      if (this.tipoReq) {
        this.dadosDenuncia.tipo = this.tipoReq;
      }
      if (this.complaintText) {
        this.dadosDenuncia.denuncia = this.complaintText;
      }
      if (this.tituloOutro != "") {
        this.dadosDenuncia.descricao_categoria = this.tituloOutro;
      }
      if (this.tipoDaDenuncia != null) {
        this.dadosDenuncia.categoria = this.tipoDaDenuncia;
      }
      this.$http.post("/relata/denuncia", this.dadosDenuncia).then(() => {
        this.loading = false;
        Vue.toasted.global.defaultSuccess({
          msg: "Denúncia realizada com sucesso!",
        });
        this.$emit("removePost");
        this.close();
      });
    },
    goBackFirstScreen() {
      this.complaintText = "";
      this.primeiraTela = !this.primeiraTela;
      this.chooseOther = false;
    },
  },
};
</script>