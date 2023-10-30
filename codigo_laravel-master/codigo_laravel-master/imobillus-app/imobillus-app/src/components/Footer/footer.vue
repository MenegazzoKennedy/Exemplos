<template>
  <div id="arqFooter">
    <v-container>
      <v-row>
        <v-col sm="4" md="4" cols="12" class="arqIndex">
          <router-link to="/">
            <img src="../../assets/logo-footer.png" />
            <h2>IMOBILIÁRIA DIGITAL</h2>
          </router-link>

          <div class="social-media">
            <h3>INSTITUCIONAL</h3>
            <ul>
              <li>
                <a target="_blank" href="https://www.facebook.com/Imobillus/">
                  <v-icon>fab fa-facebook-square</v-icon>
                </a>
              </li>
              <li>
                <a target="_blank" href="https://www.instagram.com/imobillus_/">
                  <v-icon>fab fa-instagram-square</v-icon>
                </a>
              </li>
              <li>
                <a
                  target="_blank"
                  href="https://www.linkedin.com/company/imobillus?originalSubdomain=br"
                >
                  <v-icon>fab fa-linkedin</v-icon>
                </a>
              </li>
              <li>
                <a target="_blank" href="https://wa.me/2137261301">
                  <v-icon>fab fa-whatsapp-square</v-icon>
                </a>
              </li>
              <li>
                <a
                  target="_blank"
                  href="https://www.youtube.com/channel/UCBxhLXC2ioY97ZjAmlpPJbA"
                >
                  <v-icon>fab fa-youtube-square</v-icon>
                </a>
              </li>
            </ul>
          </div>
        </v-col>
        <v-col sm="4" md="4" cols="12" class="arqIndex">
          <div class="box-menu-footer">
            <h3>INSTITUCIONAL</h3>
            <ul class="footer-menu">
              <li>
                <router-link to="/page-desenvolvimento">Quem somos</router-link>
              </li>
              <li>
                <router-link to="/page-desenvolvimento">Corretores</router-link>
              </li>
              <li>
                <router-link to="/page-desenvolvimento">Contato</router-link>
              </li>
              <li>
                <router-link to="/page-desenvolvimento">Parceiros</router-link>
              </li>
              <li>
                <router-link to="/politica-de-privacidade"
                  >Política de privacidade</router-link
                >
              </li>
            </ul>
          </div>
        </v-col>
        <v-col sm="4" md="4" cols="12" class="arqIndex">
          <div class="box-menu-footer">
            <h3>SERVIÇOS</h3>
            <ul class="footer-menu">
              <li>
                <router-link to="/page-desenvolvimento"
                  >Atendimento online</router-link
                >
              </li>
              <li>
                <router-link to="/page-desenvolvimento"
                  >Financiamento online</router-link
                >
              </li>
              <li>
                <router-link to="/page-desenvolvimento"
                  >Receba conteúdos</router-link
                >
              </li>
              <li>
                <router-link to="/page-desenvolvimento"
                  >Expert Imobillus</router-link
                >
              </li>
              <li>
                <router-link to="/page-desenvolvimento"
                  >Trabalhe conosco</router-link
                >
              </li>
            </ul>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<style>
#arqFooter {
  background-color: #000;
  position: relative;
  padding: 90px 0px;
  z-index: 0;
}
#arqFooter:before {
  content: "";
  position: absolute;
  display: block;
  background-image: url("../../assets/fundo-footer.png");
  width: 100%;
  height: 100%;
  background-repeat: no-repeat;
  background-size: contain;
  background-position: right bottom;
  top: 0;
  bottom: 0;
}
#arqFooter .arqIndex {
  z-index: 5;
}
#arqFooter h2 {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 200;
  font-size: 18px;
  line-height: 20px;
  text-transform: uppercase;
  color: #ffffff;
  letter-spacing: 5px;
  padding: 0 3px;
}
#arqFooter img {
  width: 100%;
  height: 45px;
  object-fit: contain;
  object-position: left;
}
#arqFooter h3 {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 800;
  font-size: 18px;
  line-height: 25px;
  color: #ffffff;
  position: relative;
  width: fit-content;
  width: -moz-fit-content;
  margin-bottom: 10px;
}
#arqFooter h3:after {
  content: "";
  position: absolute;
  height: 0.5px;
  display: block;
  border-bottom: 0.5px solid #43cea2;
  width: 65%;
}
#arqFooter .footer-menu {
  list-style: none;
  padding: 0;
  margin: 0;
  z-index: 5;
}
#arqFooter .footer-menu li {
  padding: 5px 0px;
}
#arqFooter .footer-menu li a {
  font-family: "Nunito Sans", sans-serif;
  font-style: normal;
  font-weight: 400;
  font-size: 18px;
  line-height: 25px;
  color: #ffffff;
}
#arqFooter .box-menu-footer {
  align-self: center;
  display: grid;
  justify-content: center;
}
#arqFooter .social-media {
  padding-top: 50px;
}
#arqFooter .social-media ul {
  display: flex;
  list-style: none;
  padding: 0;
  margin: 0;
}
#arqFooter .social-media ul li .v-icon {
  color: #fff;
  font-size: 37px;
  padding: 15px 20px 0 0;
}
@media (max-width: 767px) {
  #arqFooter .box-menu-footer {
    display: block;
  }
}
</style>

<script>
export default {
  name: "myFooter",
  data: () => ({}),
  methods: {},
};
</script>
