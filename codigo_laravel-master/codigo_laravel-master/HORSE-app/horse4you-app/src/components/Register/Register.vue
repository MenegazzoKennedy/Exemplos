<template>
  <section
    id="secRegister"
    class="pattern_dark"
  >
    <offline ref="offline" />
    <v-container>
      <v-row>
        <v-col
          cols="12"
          style="padding-bottom: 6px"
        >
          <img
            class="brand"
            src="../../assets/LogoHorse.png"
            alt=""
          >
        </v-col>
        <v-col cols="12">
          <h1>{{ title }}</h1>
          <h5>{{ subTitle }}</h5>
        </v-col>
        <v-col cols="12 inputConfig">
          <label>Seu nome</label>
          <v-text-field
            v-model="user.name"
            :rules="nameRules"
            placeholder="Insira seu nome completo"
            class="placeHolder"
            outlined
            dense
          />
          <label>Email</label>
          <v-text-field
            v-model="user.email"
            placeholder="Insira seu Email"
            :rules="emailRules"
            class="placeHolder"
            outlined
            dense
          />
          <label>Senha</label>
          <v-text-field
            v-model="user.password"
            placeholder="Digite uma senha"
            name="password"
            class="placeHolder"
            :rules="passRules"
            outlined
            dense
            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
            :type="show1 ? 'text' : 'password'"
            @click:append="show1 = !show1"
          />
          <label class="confirmPass">Confirmar senha</label>
          <v-text-field
            v-model="user.password_confirmation"
            placeholder="Digite sua senha novamente"
            name="confPassword"
            :rules="confPassRules.concat(passConfRule)"
            class="placeHolder"
            outlined
            dense
            :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
            :type="show2 ? 'text' : 'password'"
            @click:append="show2 = !show2"
          />

          <label>Seu Perfil</label>
          <v-select
            v-model="user.role"
            :items="profileStatusValue"
            item-text="status"
            item-value="statusValue"
            dense
            label="Selecione um Perfil"
            outlined
          />

          <template v-if="menorIdade == 'true'">
            <label>Email do Responsavel</label>
            <v-text-field
              v-model="user.responsible_email"
              placeholder="Digite o e-mail de seu responsavel"
              class="placeHolder"
              :rules="emailRules"
              outlined
              dense
            />
          </template>

          <div class="buttonForm">
            <v-btn
              class="buttonBlue"
              dark
              btn-horse
              @click="btnNext"
            >
              {{ BtnTextNext }}
            </v-btn>
            <v-btn
              class="buttonGray"
              dark
              btn-horse
              @click="btnBack"
            >
              {{ BtnTextBack }}
            </v-btn>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </section>
</template>

<script>
import Vue from "vue";
import offline from "../Modals/Offline.vue";
export default {
  components: { offline },
  data() {
    return {
      user: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        aniversario: localStorage.getItem("dataNasc"),
        responsible_email: "",
        role: "",
      },
      show1: false,
      show2: false,
      menorIdade: localStorage.getItem("menorIdade"),
      title: "Seja bem vindo!",
      subTitle: "Queremos saber quem é você",
      BtnTextNext: "Continuar",
      BtnTextBack: "Voltar",
      confPass: "",
      passRules: [
        (v) => !!v || "A senha é obrigatória",
        (v) =>
          (v && v.length > 5) || "A senha deve conter no minímo 6 caracteres",
      ],
      confPassRules: [(v) => !!v || "A senha é obrigatória"],
      email: "",
      emailRules: [
        (v) => !!v || "O E-mail é obrigatório",
        (v) => /.+@.+\..+/.test(v) || "E-mail precisa ser válido",
      ],
      nameRules: [(v) => !!v || "O Nome é obrigatório"],
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
          status: "Perfil Empresarial",
          statusValue: 5,
        },
      ],
      profileStatus: {
        status: "",
        statusValue: 0,
      },
    };
  },
  computed: {
    passConfRule() {
      return (
        this.user.password === this.user.password_confirmation ||
        "As senhas não são iguais"
      );
    },
  },
  mounted() {
    this.isOnline();
  },
  methods: {
    isOnline() {
      var isOnline = navigator.onLine;
      if (!isOnline) {
        this.$refs.offline.loadPage();
      }
    },
    btnBack: function () {
      this.$router.replace("/login");
    },
    btnNext: function () {
      if (this.user.name == "") {
        return Vue.toasted.global.defaultError({
          errors: "Campo nome é obrigatório",
        });
      } else if (this.user.email == "") {
        return Vue.toasted.global.defaultError({
          errors: "Campo email é obrigatório",
        });
      } else if (this.user.password == "") {
        return Vue.toasted.global.defaultError({
          errors: "Campo senha é obrigatório",
        });
      } else if (this.user.role == "") {
        return Vue.toasted.global.defaultError({
          errors: "Campo perfil é obrigatório",
        });
      }
      localStorage.setItem("userInf", JSON.stringify(this.user));
      this.$router.replace("/category");
    },
  },
};
</script>