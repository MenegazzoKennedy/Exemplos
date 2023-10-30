import Vue from "vue";
import Toasted from "vue-toasted";

Vue.use(Toasted, {
  iconPack: "fontawesome",
  duration: 5000
});

Vue.toasted.register(
  "defaultSuccess",
  payload => !payload.msg ? "Operação realidada com sucesso!" : payload.msg,
  { type: "success", icon: "check" }
);

Vue.toasted.register(
  "defaultError",
  payload => !payload.errors ? "Oops.. Erro inesperado." : payload.errors,
  { type: "error", icon: "times" }
);