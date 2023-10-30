
<template>
  <section v-if="pageReady == true">
    <myHeader />
    <div
      id="search"
      v-scroll="handleScroll"
    >
      <offline ref="offline" />
      <v-container>
        <v-row>
          <v-col
            cols="12"
            class="pt-0"
          >
            <div class="title mb-5">
              <a
                class="leftBtn ml-3"
                @click="goBack"
              >{{ gobackBusca }}</a>
              <h2>{{ titleBusca }}</h2>
            </div>

            <div class="searchConfig">
              <v-text-field
                v-model="searchValue"
                placeholder="Digite aqui para pesquisar"
                flat
                outlined
                dense
                append-icon="mdi-account-search"
                :disabled="noLocation"
                @keyup.enter="clica"
                @click:append="clica"
              >
                <v-icon>mdi-account-search</v-icon>
              </v-text-field>
              <!-- <p>Página em desenvolvimento...</p> -->
              <h2>{{ subDescricao }}</h2>
              <p
                v-if="noUserLocation"
                class="text-body-1 font-weight-medium"
              >
                Não há usuários próximos a sua localização.
              </p>
              <p
                v-if="noData"
                class="text-body-1 font-weight-medium"
              >
                Não há resultados para esta busca!
              </p>
              <div
                v-if="noLocation"
                class="noLocation"
              >
                <p class="text-body-1 font-weight-medium">
                  Necessário realizar o cadastro de endereço para realizar buscas!
                </p>
                <v-btn @click="goEditProfile">
                  Cadastrar Endereço
                </v-btn>
              </div>
              <v-progress-circular
                v-show="loading"
                indeterminate
                color="primary"
                class="primaryLoader"
              />
              <div
                v-for="(user, i) in userSearch"
                :key="i"
                class="newsearch"
                @click="goUserProfile(user.id)"
              >
                <div class="formatSearch">
                  <v-avatar
                    size="70"
                    color="#EE6C4D"
                    class="my-auto"
                  >
                    <img
                      :src="user.avatar"
                      :alt="user.name"
                    >
                  </v-avatar>
                  <div class="textUserSearch">
                    <h3>{{ user.name }}</h3>
                    <h6>{{ user.role }}</h6>
                    <h6>{{ lastDistance }}km</h6>
                  </div>
                </div>
                <v-btn
                  icon
                  class="btnGoUserProfile my-auto"
                >
                  <img
                    src="../../assets/seta.png"
                    alt="seta"
                  >
                </v-btn>
              </div>
              <div
                v-if="!firstReq"
                class="loaderPost"
              >
                <v-progress-circular
                  v-observe-visibility="visibilityChanged"
                  indeterminate
                  class="mx-auto mb-10"
                  color="orange darken-3"
                  :style="`display: ${computedDisplay}`"
                />
              </div>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </div>
    <myFooter />
  </section>
  <section v-else>
    <loadPage />
  </section>
</template>

<script>
import Vue from "vue";
import { showError } from "@/global";
import { mapState } from "vuex";
import myHeader from "../Header/header.vue";
import myFooter from "../Footer/footer.vue";
import VueObserveVisibility from "vue-observe-visibility";
import offline from "../Modals/Offline.vue";
import LoadPage from "../Modals/LoadPage.vue";

Vue.use(VueObserveVisibility);

Vue.directive("scroll", {
  inserted: function (el, binding) {
    let f = function (evt) {
      if (binding.value(evt, el)) {
        window.removeEventListener("scroll", f);
      }
    };
    window.addEventListener("scroll", f);
  },
});

export default {
  components: {
    myHeader,
    myFooter,
    offline,
    LoadPage
  },
  data: () => {
    return {
      pageReady: false,
      searchValue: "",
      quant: 1,
      lastDistance: 0,
      gobackBusca: "Voltar",
      titleBusca: "Buscar",
      subDescricao: "Resultado da busca",
      userSearch: [],
      firstReq: true,
      loading: false,
      tam: true,
      tam2: true,
      tam3: true,
      vazio: false,
      display: "block",
      isVisible: true,
      aplicouPesquisa: false,
      noData: false,
      noLocation: false,
      noUserLocation: false
    };
  },
  computed: {
    ...mapState(["user"]),
    currentPage() {
      return this.$route.path;
    },
    computedDisplay() {
      return this.display;
    },
  },
  mounted() {
    this.haveLocation();
  },
  created() {
    window.addEventListener("scroll", this.handleScroll);
  },
  destroyed() {
    window.removeEventListener("scroll", this.handleScroll);
  },
  methods: {
    visibilityChanged(isVisible) {
      this.isVisible = isVisible;
    },
    handleScroll() {
      if (this.aplicouPesquisa) {
        if (this.isVisible) {
          if (this.tam) {
            if (this.tam2) {
              if (this.tam3) {
                this.tam = false;
                this.tam2 = false;
                this.tam3 = false;
                this.appendLoadPage();
              } else {
                this.tam3 = true;
              }
            } else {
              this.tam2 = true;
            }
          }
        }
      }
    },
    appendLoadPage() {
      if (!this.tam) {
        this.loadUsers();
        this.tam = true;
      }
    },
    goBack() {
      this.$router.go(-1);
    },
    loadPage() {
      var isOnline = navigator.onLine;
      if (!isOnline) {
        this.$refs.offline.loadPage();
      } else {
        this.loading = true;
        this.$http
          .post("/usuario/distancia", {
            ultimaDistancia: 0,
            pagina: this.quant,
            is_first: 1,
            consulta: "",
          })
          .then((res) => {
            this.userSearch = res.data.data;
            if (this.userSearch.length == 0) {
              this.noUserLocation = true;
            }
            this.lastDistance = res.data.ultimaDistancia;

            this.loading = false;
          })
          .catch((err) => {
            showError(err);
          });
        setTimeout(() => {
          this.pageReady = true;
        }, 1000);
      }
    },
    goUserProfile(id) {
      this.$router.push({ path: "/view-profile/" + id });
    },
    clica() {
      this.aplicouPesquisa = true;
      this.quant = 0;
      this.firstReq = false;
      this.userSearch = [];
      this.loadUsers();
    },
    loadUsers() {
      this.quant++;
      this.$http
        .post("/usuario/distancia", {
          ultimaDistancia: this.lastDistance,
          pagina: this.quant,
          is_first: 0,
          consulta: this.searchValue,
        })
        .then((res) => {
          if (res.data.data) {
            if (res.data.data.length > 0 && res.data.data.length < 20) {
              this.userSearch = this.userSearch.concat(res.data.data);
              this.vazio = true;
              this.display = "none";
              this.noData = false;
            } else {
              this.userSearch = this.userSearch.concat(res.data.data);
              this.noData = false;
            }
          } else {
            this.vazio = true;
            this.display = "none";
            this.noData = true;
          }
          this.lastDistance = res.data.ultimaDistancia;
        })
        .catch((err) => {
          showError(err);
        });
    },
    haveLocation() {
      if (this.user.cidade) {
        this.loadPage();
      } else {
        this.pageReady = true;
        this.noLocation = true;
        this.noData = false;
        this.noUserLocation = false;
      }
    },
    goEditProfile() {
      this.$router.push({ path: "/edit-profile" });
    }
  },
};
</script>