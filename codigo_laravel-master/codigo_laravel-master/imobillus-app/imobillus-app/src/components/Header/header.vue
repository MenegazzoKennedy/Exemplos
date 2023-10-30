<template>
  <div id="arqHeader" :class="scrolled ? 'header-scroll' : ''">
    <v-container>
      <v-row>
        <v-col cols="12">
          <div class="boxHeader desktop-header">
            <div
              class="main-menu"
              :class="
                searchOpen ? 'arq-none' : '' || listMenu ? 'main-menu-open' : ''
              "
            >
              <div class="btnMenu">
                <div
                  class="hamburger"
                  @click="openMenu"
                  :class="hamburgerOpen ? 'hamburger--is-open' : ''"
                >
                  <div class="hamburger__item hamburger__item--first"></div>
                  <div class="hamburger__item hamburger__item--middle"></div>
                  <div class="hamburger__item hamburger__item--last"></div>
                </div>
                <span :class="textMenu ? 'text-menu' : ''">MENU</span>
              </div>

              <ul :class="listMenu ? 'list-menu' : ''">
                <template v-for="(menu, i) in headerMenu">
                  <li :class="i > 0 ? 'menu-borde' : ''" :key="i">
                    <router-link :to="menu.link">{{ menu.name }}</router-link>
                  </li>
                </template>
              </ul>
            </div>

            <div class="logo-header">
              <router-link to="/">
                <img contain src="../../assets/logo-header.png" />
              </router-link>
            </div>

            <div class="actions-menu">
              <div
                class="client-area"
                :class="
                  searchOpen ? 'arq-none' : '' || listMenu ? 'arq-none' : ''
                "
              >
                <v-menu
                  v-if="is_loged == false"
                  v-model="clientMenu"
                  content-class="client-menu"
                  transition="slide-y-transition"
                  bottom
                  :offset-y="true"
                  :close-on-content-click="false"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <h3 v-bind="attrs" v-on="on">ÁREA DO CLIENTE</h3>
                  </template>

                  <v-card>
                    <div class="box-client">
                      <v-text-field
                        v-model="userData.email"
                        :rules="emailRules"
                        @keyup="lowercase"
                        label="Email"
                        required
                      ></v-text-field>
                      <v-text-field
                        v-model="userData.password"
                        type="password"
                        label="Senha"
                        v-on:keyup="submitLogin"
                      ></v-text-field>

                      <v-btn
                        class="btn-login"
                        @click="login"
                        :loading="loading"
                        rounded
                        >Acessar</v-btn
                      >

                      <router-link to="/recuperar-senha"
                        >Esqueceu a senha?</router-link
                      >

                      <router-link to="/cadastro"
                        >Não possuo cadastro</router-link
                      >

                      <p v-show="false">Entrar com Facebook</p>
                      <p v-show="false">Entrar com Google</p>
                    </div>
                  </v-card>
                </v-menu>

                <v-menu
                  v-else
                  v-model="clientMenu"
                  content-class="client-menu"
                  transition="slide-y-transition"
                  bottom
                  :offset-y="true"
                  :close-on-content-click="false"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <h3 v-bind="attrs" v-on="on">Olá, {{ loged_user.name }}</h3>
                  </template>

                  <v-card>
                    <div class="box-client-logado">
                      <router-link to="/meu-perfil">Meu perfil</router-link>

                      <v-btn
                        class="btn-login"
                        @click="logout"
                        :loading="loading"
                        rounded
                        >Sair</v-btn
                      >
                    </div>
                  </v-card>
                </v-menu>
              </div>
              <div
                class="search-box"
                :class="searchOpen ? 'search-box-open' : ''"
              >
                <div class="search-input">
                  <div
                    class="search-area"
                    :class="searchOpen ? 'search-open' : ''"
                  >
                    <v-text-field
                      flat
                      solo
                      shaped
                      placeholder="Digite o nome do imóvel"
                      v-model="buscaGeral"
                      v-on:keyup="submitBusca"
                    ></v-text-field>
                    <v-btn class="btn-search-find" tile @click="buscarIm"
                      >BUSCAR</v-btn
                    >
                  </div>
                </div>
                <v-btn class="btn-search-open" icon rounded @click="openSearch">
                  <v-icon v-if="searchOpen == false">mdi-magnify</v-icon>
                  <v-icon v-else>mdi-close</v-icon>
                </v-btn>
              </div>
            </div>
          </div>

          <div class="mobile-header">
            <div class="header-top">
              <v-btn class="mobile-btn" icon @click="dialogMenu = true">
                <v-icon>mdi-menu</v-icon>
              </v-btn>

              <router-link to="/">
                <img contain src="../../assets/logo-header.png" />
              </router-link>
            </div>

            <v-dialog
              v-model="dialogMenu"
              content-class="mobileHeader"
              transition="slide-x-transition"
              fullscreen
            >
              <v-card class="mobile-menu">
                <div class="top-mobile">
                  <v-btn class="mobile-btn" icon @click="dialogMenu = false">
                    <v-icon>mdi-close</v-icon>
                  </v-btn>

                  <router-link to="/">
                    <img contain src="../../assets/logo-header.png" />
                  </router-link>
                </div>

                <v-card-text class="menu-mobile">
                  <div>
                    <ul class="list-mobile">
                      <li v-for="(menu, i) in headerMenu" :key="i">
                        <router-link :to="menu.link">{{
                          menu.name
                        }}</router-link>
                      </li>
                    </ul>

                    <div class="client-mobile" v-if="is_loged == false">
                      <h3>ÁREA DO CLIENTE</h3>

                      <div>
                        <div class="box-client">
                          <v-text-field
                            v-model="userData.email"
                            :rules="emailRules"
                            @keyup="lowercase"
                            label="Email"
                            required
                          ></v-text-field>
                          <v-text-field
                            v-model="userData.password"
                            type="password"
                            label="Senha"
                          ></v-text-field>

                          <v-btn
                            class="btn-login"
                            @click="login"
                            :loading="loading"
                            rounded
                            >Acessar</v-btn
                          >

                          <router-link to="/recuperar-senha"
                            >Esqueceu a senha?</router-link
                          >

                          <router-link to="/cadastro"
                            >Não possuo cadastro</router-link
                          >

                          <p v-show="false">Entrar com Facebook</p>
                          <p v-show="false">Entrar com Google</p>
                        </div>
                      </div>
                    </div>

                    <div class="client-mobile" v-else>
                      <h3>Olá, {{ loged_user.name }}</h3>

                      <div>
                        <div class="box-client">
                          <v-btn
                            class="btn-login"
                            @click="logout"
                            :loading="loading"
                            rounded
                            >Sair</v-btn
                          >
                        </div>
                      </div>
                    </div>

                    <div class="search-input">
                      <div
                        class="search-area"
                        :class="searchOpen ? 'search-open' : ''"
                      >
                        <v-text-field
                          flat
                          solo
                          shaped
                          v-model="buscaGeral"
                          placeholder="Digite o nome do imóvel ou cidade"
                        ></v-text-field>
                        <v-btn
                          class="btn-search-find"
                          tile
                          @click="$router.push('/pesquisa-imoveis')"
                          >BUSCAR</v-btn
                        >
                      </div>
                    </div>
                  </div>
                </v-card-text>
              </v-card>
            </v-dialog>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<style>
/* MOBILE */
#inspire .mobile-header {
  display: none;
}
#inspire .mobile-header .header-top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 0px;
}
#inspire .mobileHeader .mobile-btn span,
#inspire .mobile-header .mobile-btn span {
  color: #fff;
}
#inspire .mobile-header a {
  height: 40px;
}
#inspire .mobile-header img {
  width: 100%;
  height: 40px;
  object-fit: contain;
  object-position: center;
}
#inspire .mobileHeader .mobile-menu {
  border-radius: 0;
}
#inspire .mobileHeader .mobile-menu .top-mobile {
  height: auto !important;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 15px;
  background-color: #000;
  border-bottom: 1px solid #43cea2;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
}
#inspire .mobileHeader .mobile-menu .top-mobile a {
  height: 40px;
}
#inspire .mobileHeader .mobile-menu .top-mobile img {
  width: 100%;
  height: 40px;
  object-fit: contain;
  object-position: center;
}

#inspire .mobileHeader .menu-mobile {
  text-align: center;
  margin-top: 50px;
}
#inspire .mobileHeader .menu-mobile .list-mobile {
  list-style: none;
  padding: 25px 0;
}
#inspire .mobileHeader .menu-mobile .list-mobile li {
  padding: 8px 0px;
}
#inspire .mobileHeader .menu-mobile .list-mobile li a {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 15px;
  line-height: 17px;
  color: #ffffff;
  text-transform: uppercase;
  border-bottom: 1px solid #43cea2;
}

#inspire .mobileHeader .menu-mobile .client-mobile .v-text-field__details {
  display: none;
}
#inspire .mobileHeader .menu-mobile .client-mobile .v-input__slot {
  background-color: transparent;
  border-radius: 0;
  border-bottom: 1px solid #fff;
  padding: 2px 5px;
}
#inspire .mobileHeader .menu-mobile .client-mobile .v-text-field__slot label {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 13px;
  line-height: 20px;
  color: #7a6767;
}

#inspire .mobileHeader .menu-mobile .client-mobile .btn-login {
  border: 1px solid #43cea2;
  box-sizing: border-box;
  border-radius: 20px;
  background-color: transparent;
  padding: 8px 12px;
  height: auto;
  margin: 25px 0 0;
}
#inspire .mobileHeader .menu-mobile .client-mobile .btn-login span {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 10px;
  line-height: 11px;
  color: #fffcfc;
  text-transform: capitalize;
}
#inspire .mobileHeader .menu-mobile .client-mobile a {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 13px;
  line-height: 11px;
  color: #fffcfc;
  width: fit-content;
  border-bottom: 1px solid #185a9d;
  margin: 25px auto 30px;
  display: block;
}
#inspire .mobileHeader .menu-mobile .client-mobile p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 400;
  font-size: 12px;
  line-height: 10px;
  color: #fffcfc;
  padding-bottom: 14px;
  margin: 0;
}
#inspire .mobileHeader .menu-mobile .search-input {
  margin: 25px 0;
}

#inspire .mobileHeader .menu-mobile .search-input .search-area {
  width: 100%;
  display: block;
}
#inspire .mobileHeader .menu-mobile .search-input .search-area .v-input__slot {
  border-radius: 0;
  min-height: 36px;
  top: 7px;
  border: 0.5px solid #fff;
}
#inspire .mobileHeader .menu-mobile .search-input .btn-search-find {
  text-transform: initial;
  background: linear-gradient(180deg, #43cea2 0%, rgba(67, 206, 162, 0) 100%);
  border: 0.5px solid #43cea2;
  box-sizing: border-box;
  color: #fff;
  display: block;
  width: 100%;
}

/* DESKTOP */
#arqHeader {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 10;
  background-color: transparent;
  -webkit-transition: 0.5s;
  transition: 0.5s;
}
#arqHeader.header-scroll {
  background-color: #000;
  -webkit-transition: 0.5s;
  transition: 0.5s;
}
#arqHeader .arq-none {
  width: 0 !important;
  -webkit-transition: all 600ms linear;
  transition: all 600ms linear;
  opacity: 0 !important;
}
#arqHeader .boxHeader {
  padding: 5px 0px 15px;
  justify-content: space-between;
  -webkit-transition: all 600ms linear;
  transition: all 600ms linear;
  display: flex;
  position: relative;
  align-items: center;
}
#arqHeader .boxHeader .btnMenu {
  display: block;
  margin-top: 18px;
}
#arqHeader .boxHeader .btnMenu span {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 12px;
  line-height: 16px;
  color: #ffffff;
}
#arqHeader .boxHeader .main-menu {
  display: flex;
  align-items: center;
  transition: all 600ms linear;
  -webkit-transition: all 600ms linear;
  width: 100%;
  overflow: hidden;
}
#arqHeader .boxHeader .main-menu .menu-borde {
  border-left: 0.5px solid #43cea2;
}
#arqHeader .boxHeader .main-menu ul a {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 14px;
  line-height: 16px;
  text-align: center;
  color: #ffffff;
  text-transform: uppercase;
  white-space: nowrap;
}
#arqHeader .boxHeader .main-menu.main-menu-open {
  width: 1000% !important;
  -webkit-transition: all 600ms linear;
  transition: all 600ms linear;
}
#arqHeader .boxHeader .logo-header {
  display: flex;
  align-items: center;
  justify-content: center;
  -webkit-transition: all 600ms linear;
  transition: all 600ms linear;
}
#arqHeader .boxHeader .logo-header img {
  width: 205px;
  height: 37px;
  margin-top: 10px;
  object-fit: contain;
  object-position: center;
}
#arqHeader .boxHeader .btnMenu span {
  color: #fff;
  font-size: 12px;
  font-weight: 300;
  width: 40px;
  text-align: center;
  display: block;
  position: relative;
  top: 0px;
  transition-duration: 0.5s;
  transition-property: top opacity;
}
#arqHeader .boxHeader .btnMenu .text-menu {
  opacity: 0;
  top: -5px;
  transition-duration: 0.5s;
  transition-property: top opacity;
}
#arqHeader .boxHeader ul {
  display: flex;
  list-style: none;
  padding: 0;
  margin: 0;
  width: 0;
  overflow: hidden;
  -webkit-transition: all 600ms linear;
  transition: all 600ms linear;
  position: relative;
  justify-content: space-evenly;
  margin: 0px 40px 0 0;
}
#arqHeader .boxHeader .list-menu {
  width: 100%;
  -webkit-transition: all 600ms linear;
  transition: all 600ms linear;
}
#arqHeader .boxHeader ul li {
  padding: 0 15px;
  width: 100%;
  text-align: center;
}

#arqHeader .boxHeader .actions-menu {
  display: flex;
  width: 100%;
  justify-content: flex-end;
  align-items: center;
  margin-top: 5px;
}
#arqHeader .boxHeader .actions-menu .client-area {
  -webkit-transition: opacity 600ms;
  transition: opacity 600ms;
  width: 100%;
  overflow: hidden;
  text-align: end;
  opacity: 1;
  border-right: 0.5px solid #43cea2;
  padding-right: 10px;
}
#arqHeader .boxHeader .actions-menu .client-area h3 {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 12px;
  line-height: 16px;
  color: #ffffff;
  cursor: pointer;
  white-space: nowrap;
  text-transform: uppercase;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
}
#arqHeader .boxHeader .actions-menu .search-box {
  display: flex;
  align-items: center;
}
#arqHeader .boxHeader .actions-menu .search-box.search-box-open {
  width: 100%;
  margin: 0px 0px 0px 25px;
}
#arqHeader .boxHeader .actions-menu .search-box .btn-search-open {
  color: #fff;
}
#arqHeader .boxHeader .actions-menu .search-box .search-input {
  width: 100%;
  margin-right: 20px;
}
#arqHeader .boxHeader .actions-menu .search-area {
  width: 0;
  overflow: hidden;
  display: flex;
  margin-left: 100%;
  -webkit-transition: all 600ms linear;
  transition: all 600ms linear;
  align-items: center;
}
#arqHeader .boxHeader .actions-menu .search-area .v-input__slot {
  border-radius: 0;
  min-height: 36px;
  top: 7px;
  border: 0.5px solid #fff;
}
#arqHeader .boxHeader .actions-menu .btn-search-find {
  text-transform: initial;
  background: linear-gradient(180deg, #43cea2 0%, rgba(67, 206, 162, 0) 100%);
  border: 0.5px solid #43cea2;
  box-sizing: border-box;
  color: #fff;
  margin-left: 15px;
}
#arqHeader .boxHeader .actions-menu .search-open {
  width: 100%;
  margin-left: 0%;
  -webkit-transition: all 600ms linear;
  transition: all 600ms linear;
}

#arqHeader .hamburger {
  height: 20px;
  width: 40px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
#arqHeader .hamburger:hover {
  cursor: pointer;
}
#arqHeader .hamburger__item {
  height: 3px;
  width: 100%;
  background: #fff;
  transition: transform 300ms cubic-bezier(0.445, 0.05, 0.55, 0.95),
    opacity 300ms linear;
}
#arqHeader .hamburger--is-open .hamburger__item--first {
  transform: translate(0, 9px) rotate(45deg);
  width: 20px;
}
#arqHeader .hamburger--is-open .hamburger__item--middle {
  opacity: 0;
}
#arqHeader .hamburger--is-open .hamburger__item--last {
  transform: translate(0, -8px) rotate(-45deg);
  width: 20px;
}

#inspire .client-menu {
  min-width: auto !important;
  top: 50px !important;
  left: unset !important;
  right: 8.5% !important;
}
#inspire .client-menu .box-client {
  padding: 5px 15px 10px;
  background-color: #0b0a0a;
  text-align: center;
  height: 230px;
}
#inspire .client-menu .box-client-logado {
  padding: 5px 15px 10px;
  background-color: #0b0a0a;
  text-align: center;
  height: 150px;
}
#inspire .client-menu .box-client .v-text-field__details {
  display: none;
}
#inspire .client-menu .box-client .v-input__slot {
  background-color: transparent;
  border-radius: 0;
  border-bottom: 1px solid #fff;
  padding: 2px 5px;
}
#inspire .client-menu .box-client .v-text-field__slot label {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 13px;
  line-height: 20px;
  color: #7a6767;
}
#inspire .client-menu .box-client .btn-login,
#inspire .client-menu .box-client-logado .btn-login {
  border: 1px solid #43cea2;
  box-sizing: border-box;
  border-radius: 20px;
  background-color: transparent;
  padding: 8px 12px;
  height: auto;
  margin: 25px 0 0;
}
#inspire .client-menu .box-client .btn-login span,
#inspire .client-menu .box-client-logado .btn-login span {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 10px;
  line-height: 11px;
  color: #fffcfc;
  text-transform: capitalize;
}
#inspire .client-menu .box-client a,
#inspire .client-menu .box-client-logado a {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: normal;
  font-size: 13px;
  line-height: 11px;
  color: #fffcfc;
  border-bottom: 1px solid #185a9d;
  margin: 15px 20px 15px;
  display: block;
}
#inspire .client-menu .box-client p,
#inspire .client-menu .box-client-logado p {
  font-family: "Archivo", sans-serif;
  font-style: normal;
  font-weight: 400;
  font-size: 12px;
  line-height: 10px;
  color: #fffcfc;
  padding-bottom: 14px;
  margin: 0;
}

@media (max-width: 1270px) {
  #arqHeader .boxHeader ul {
    margin: 0;
  }
}
@media (max-width: 1020px) {
  #arqHeader .desktop-header {
    display: none;
  }
  #inspire .mobile-header {
    display: block;
  }
}
</style>

<script>
import Vue from "vue";
import { userKey, showError } from "@/global";

export default {
  name: "myHeader",
  data: () => ({
    loged_user: JSON.parse(localStorage.getItem(userKey)),
    hamburgerOpen: false,
    textMenu: false,
    buscaGeral: "",
    dataImoveis: [],
    listMenu: false,
    searchOpen: false,
    dialogMenu: false,
    headerMenu: [
      { name: "Home", link: "/" },
      { name: "Imóveis", link: "/lista-imoveis" },
      { name: "Quem somos", link: "/page-desenvolvimento" },
      { name: "Fale Conosco", link: "/page-desenvolvimento" },
      { name: "Corretores", link: "/page-desenvolvimento" },
    ],
    scrolled: false,
    clientMenu: false,
    loading: false,
    is_loged: false,
    userData: {
      email: "",
      password: "",
    },
    emailRules: [
      (v) => !!v || "O Email é obrigatório",
      (v) => /.+@.+\..+/.test(v) || "Email precisa ser válido",
    ],
  }),
  mounted() {
    this.handleScroll();
  },
  beforeMount() {
    if (this.loged_user) {
      this.is_loged = true;
    }
  },
  methods: {
    openMenu() {
      this.hamburgerOpen = !this.hamburgerOpen;
      this.textMenu = !this.textMenu;
      this.listMenu = !this.listMenu;
    },
    submitLogin(e) {
      if (e.keyCode === 13) {
        this.login();
      }
    },
    buscarIm() {
      if (this.buscaGeral == "") {
        Vue.toasted.global.defaultError({
          errors: "Digite algo para realizar a pesquisa!",
        });
      } else {
        this.$router.push("/pesquisa-imoveis?s=" + this.buscaGeral);
      }
    },
    submitBusca(e) {
      if (e.keyCode === 13) {
        this.buscarIm();
      }
    },
    openSearch() {
      this.searchOpen = !this.searchOpen;
    },
    handleScroll() {
      if (window.scrollY > 50) {
        this.scrolled = true;
      } else {
        this.scrolled = false;
      }
    },
    lowercase() {
      this.userData.email = this.userData.email.toLowerCase();
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
    logout() {
      this.loading = true;

      this.$http.post("/logout").then((res) => {
        localStorage.removeItem(userKey);
        localStorage.setItem(userKey, JSON.stringify(null));
        console.log(res.data);
        setTimeout(
          () => (
            (this.loading = false),
            (this.clientMenu = false),
            this.$router.go(this.$router.currentRoute)
          ),
          2000
        );
      });
    },
  },
  created() {
    window.addEventListener("scroll", this.handleScroll);
  },
  destroyed() {
    window.removeEventListener("scroll", this.handleScroll);
  },
};
</script>
