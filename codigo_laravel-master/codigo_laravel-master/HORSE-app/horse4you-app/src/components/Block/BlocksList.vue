<template>
  <section
    v-if="loadPage == true"
    id="blockList"
  >
    <offline ref="offline" />
    <a
      class="goBack"
      @click="goBackProfile"
    >
      <v-icon>mdi-close</v-icon>                     
    </a>
    <myHeader />
    <headerBlock />
    <usersBlock
      :users="users"
      @unblock="unblock"
      @goBack="goBackProfile"
    />
    <myFooter />
  </section>
  <section v-else>
    <loadPage />
  </section>
</template>

<script>
import myHeader from "../Header/header.vue";
import myFooter from "../Footer/footer.vue";
import UsersBlock from "./UsersBlock.vue";
import HeaderBlock from "./HeaderBlock.vue";
import LoadPage from "../Modals/LoadPage.vue";
import Offline from "../Modals/Offline.vue";
export default {
  components: {myHeader, HeaderBlock, UsersBlock, myFooter, LoadPage, Offline},
  data(){
    return {
      users: [],
      loadPage: false
    };
  },
  mounted() {
    this.loadUsersBlock();
  },
  methods: {
    loadUsersBlock() {
      this.$http.post("/usuario/listar/bloqueio")
        .then(res => {
          this.users = res.data[0].bloquear;
          setTimeout(() => (this.loadPage = true), 1000);
        });
    },
    unblock() {
      let id = localStorage.getItem("idBlock");
      this.$http.post("/usuario/bloqueio/" + id, {
        acao: 0,
      }).then(() => {
        this.loadUsersBlock();
      });
    },
    goBackProfile() {
      this.$router.push({path: "/profile"});
    }
  }

};
</script>