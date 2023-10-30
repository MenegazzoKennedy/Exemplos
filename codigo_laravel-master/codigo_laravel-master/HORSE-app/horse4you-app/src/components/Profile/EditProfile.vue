<template>
  <section v-if="readyPage == true">
    <myHeader />
    <div
      id="secEditProfile"
    >
      <offline ref="offline" />
      <v-container>
        <v-row>
          <v-col
            cols="12"
            class="editprofile"
          >
            <div class="formatTop">
              <a @click="goBack">{{ gobackEditPerfil }}</a>

              <div class="ImageUser">
                <v-avatar size="68">
                  <img
                    class="preview"
                    :src="userInfo.avatar"
                  >
                </v-avatar>
              </div>

              <v-btn
                :loading="loading"
                @click="salveEdit"
              >
                {{ salveEditPerfil }}
              </v-btn>
            </div>

            <label for="postImage">
              <h2>{{ ctaChangePhoto }}</h2>
              <input
                id="postImage"
                type="file"
                accept="image/*"
                @change="handleSelects"
              >
            </label>

            <div class="formatInput">
              <v-text-field
                v-model="userInfo.name"
                placeholder="Nome"
                outlined
                dense
                append-icon="mdi-square-edit-outline"
              />

              <v-text-field
                v-model="userInfo.descricao"
                placeholder="Descrição do Perfil"
                outlined
                dense
                append-icon="mdi-square-edit-outline"
              />
              <v-combobox
                v-model="tagsFollowed"
                class="tagsUser"
                :items="getTags"
                placeholder="Descrição do Perfil"
                outlined
                multiple
                dense
                chips
                deletable-chips
                @keyup.enter="inputTags"
              />
              <h3>{{ inforProfissionais }}</h3>
              <v-select
                v-model="userInfo.roles[0].id"
                :items="profileStatusValue"
                item-text="status"
                item-value="statusValue"
                dense
                label="Selecione um Perfil"
                outlined
              />

              <v-text-field
                v-model="userInfo.site"
                placeholder="Site"
                outlined
                dense
                append-icon="mdi-square-edit-outline"
              />

              <h3>{{ inforContato }}</h3>

              <v-text-field
                v-model="userInfo.email"
                placeholder="Insira seu Email"
                disabled
                outlined
                dense
                append-icon="mdi-square-edit-outline"
              />

              <v-text-field
                v-model="userInfo.telefone"
                v-mask="'(##) #####-####'"
                placeholder="Telefone"
                outlined
                dense
                append-icon="mdi-square-edit-outline"
              />

              <v-select
                v-model="genero"
                :items="profileGenderValue"
                item-text="status"
                item-value="statusValue"
                label="Selecione um Gênero"
                dense
                outlined
              />

              <v-text-field
                v-model="dataUser"
                placeholder="DD/MM/AA"
                disabled
                outlined
                dense
                append-icon="mdi-square-edit-outline"
              />

              <h3>{{ InforEndereco }}</h3>

              <v-select
                v-model="userInfo.estado"
                item-text="name"
                item-value="id"
                :items="estados"
                label="Selecione um Estado"
                dense
                outlined
                @change="loadCidade"
              />

              <v-select
                v-model="userInfo.cidade"
                item-text="name"
                item-value="id"
                :items="cidades"
                label="Selecione uma Cidade"
                dense
                outlined
                @change="loadBairro"
              />

              <v-select
                v-model="userInfo.bairro"
                item-text="name"
                item-value="id"
                :items="bairros"
                label="Selecione uma Bairro"
                dense
                outlined
              />

              <v-text-field
                v-model="userInfo.endereco"
                placeholder="Rua"
                outlined
                dense
                append-icon="mdi-square-edit-outline"
              />

              <v-text-field
                v-model="userInfo.numero"
                placeholder="Numero"
                outlined
                dense
                append-icon="mdi-square-edit-outline"
              />

              <v-text-field
                v-model="userInfo.cep"
                placeholder="CEP"
                outlined
                dense
                append-icon="mdi-square-edit-outline"
              />
            </div>

            <router-link :to="{ path: '/recover-password' }">
              Alterar senha
            </router-link>
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
import { mapState } from "vuex";
import myHeader from "../Header/header.vue";
import myFooter from "../Footer/footer.vue";
import { showError, userKey } from "@/global";
import offline from "../Modals/Offline.vue";
import LoadPage from "../Modals/LoadPage.vue";

export default {
  components: {
    myHeader,
    myFooter,
    offline,
    LoadPage
  },
  data: () => {
    return {
      loading: false,
      gobackEditPerfil: "Voltar",
      salveEditPerfil: "Salvar",
      ctaChangePhoto: "Alterar foto de perfil",
      inforProfissionais: "Informações profissionais",
      inforContato: "Informações de contato",
      InforEndereco: "Informações de Endereço",
      images: [],
      imageFile: [],
      userInfo: [],
      userEdited: [],
      tagsFollowed: [],
      getTags: [],
      dataUser: "",
      readyPage: false,
      estados: [],
      cidades: [],
      bairros: [],
      profileStatusValue: [
        {
          status: "Perfil Pessoal",
          statusValue: 3,
        },
        {
          status: "Perfil Profissional",
          statusValue: 4,
        },
        {
          status: "Perfil Empressarial",
          statusValue: 5,
        },
      ],
      role: {
        status: "",
        statusValue: 0,
      },
      genero: {
        status: "",
        statusValue: "",
      },
      profileGenderValue: [
        {
          status: "Masculino",
          statusValue: "masculino",
        },
        {
          status: "Feminino",
          statusValue: "feminino",
        },
        {
          status: "Outros",
          statusValue: "outros",
        },
      ],
    };
  },
  computed: {
    ...mapState(["user"]),
    currentPage() {
      return this.$route.path;
    },
  },
  watch: {
    genero() {
      this.userInfo.genero = this.genero;
    },
  },
  mounted() {
    this.loadMyInfo();
    this.loadEstados();
    this.carregaTags();
  },
  methods: {
    inputTags() {
      if (this.getTags.length > 10) {
        Vue.toasted.global.defaultError({ errors: "Limite de tags atingido!" });
        this.nameTags.length = 9;
      }
    },
    carregaTags() {
      this.$http.get("/tags").then((res) => {
        for (let i = 0; i < res.data.length; i++) {
          this.getTags[i] = res.data[i].tag;
        }
        setTimeout(() => (this.readyPage = true), 1000);
      });
    },
    formatDate() {
      if (!this.userInfo.aniversario) return null;

      const [year, month, day] = this.userInfo.aniversario.split("-");
      this.dataUser = `${day}/${month}/${year}`;
    },
    goBack() {
      this.$router.push({ path: "/profile" });
    },
    loadMyInfo() {
      var isOnline = navigator.onLine;
      if (!isOnline) {
        this.$refs.offline.loadPage();
      } else {
        this.$http
          .post("/auth/me?user=me")
          .then((res) => {
            this.userInfo = res.data;
            if (this.userInfo.estado) {
              this.userInfo.estado = this.userInfo.estado.id;
            }
            if (this.userInfo.cidade) {
              this.userInfo.cidade = this.userInfo.cidade.id;
              this.loadCidade();
            }
            if (this.userInfo.bairro) {
              this.userInfo.bairro = this.userInfo.bairro.id;
              this.loadBairro();
            }
            this.genero = this.userInfo.genero;
            for (let i = 0; i < this.userInfo.tags.length; i++) {
              this.tagsFollowed[i] = this.userInfo.tags[i].tag;
            }
            this.formatDate();
          })
          .catch(showError);
      }
    },
    handleSelects(e) {
      this.images = "";
      let fileList = Array.prototype.slice.call(e.target.files);

      this.imageFile = e.target.files[0];

      fileList.forEach((f) => {
        if (!f.type.match("image.*")) {
          return;
        }

        let reader = new FileReader();
        let that = this;

        reader.onload = function (e) {
          that.userInfo.avatar = e.target.result;
        };
        reader.readAsDataURL(f);
      });
    },

    salveEdit() {
      this.loading = true;
      setTimeout(() => (this.loading = false), 2000);

      this.$http
        .post("/profile/update/" + this.user.id, {
          id: this.userInfo.id,
          name: this.userInfo.name,
          nick: this.userInfo.nick,
          descricao: this.userInfo.descricao,
          site: this.userInfo.site,
          endereco: this.userInfo.endereco,
          telefone: this.userInfo.telefone,
          genero: this.userInfo.genero,
          perfil: this.userInfo.roles[0].id,
          estado: this.userInfo.estado,
          bairro: this.userInfo.bairro,
          cidade: this.userInfo.cidade,
          numero: this.userInfo.numero,
          cep: this.userInfo.cep,
          tags: this.tagsFollowed,
        })
        .then((res) => {
          this.userEdited = res.data;
          this.$store.commit("setUser", res.data);
          localStorage.setItem(userKey, JSON.stringify(res.data));
          this.profileImg();
        })
        .catch(showError);
    },
    profileImg() {
      if (this.imageFile != "") {
        var postData = new FormData();
        postData.append("arquivo", this.imageFile);

        this.$http
          .post("/profile/avatar/update", postData)
          .then(() => {
            this.loading = false;
            this.$router.replace("/profile");
          })
          .catch(showError);
      } else {
        this.$router.replace("/profile");
        this.loading = false;
      }
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
        .get("/localidades/cidades/" + this.userInfo.estado + "")
        .then((res) => {
          const loadCidade = res.data;
          this.cidades = loadCidade[0].cidades;
        })
        .catch(showError);
    },
    loadBairro() {
      this.$http
        .get("/localidades/" + this.userInfo.cidade + "/locaisBairros")
        .then((res) => {
          const loadBairro = res.data;
          this.bairros = loadBairro[0].bairros;
        })
        .catch(showError);
    },
  },
};
</script>