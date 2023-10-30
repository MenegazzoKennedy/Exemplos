<template>
  <section v-if="loadPage == true">
    <offline ref="offline" />
    <myHeader />
    <div id="secMessage">
      <v-row>
        <v-col
          cols="12"
          class="pt-0 colunaCerta"
        >
          <div class="title bg-white">
            <a class="leftBtn">Voltar</a>
            <h2>Caixa de Mensagem</h2>
          </div>
          <div
            v-for="(user, i) in users"
            :key="i"
            class="searchConfig"
          >
            <div
              class="newsearch"
            >
              <div
                class="formatSearch"
                @click="goChat(user.user.id)"
              >
                <v-avatar
                  size="60"
                  color="#EE6C4D"
                >
                  <img
                    :src="user.user.avatar"
                    :alt="user.user.name"
                  >
                </v-avatar>
                <div class="textUserSearch">
                  <h3>
                    {{ user.user.name }}
                    <span
                      v-if="!newMessage"
                      class="caption rounded-circle white--text"
                    >2</span>
                  </h3>
                  <p>{{ user.content }}</p>
                </div>
              </div>
              <span class="dot" />
            </div>
          </div>
        </v-col>
      </v-row>
    </div>
    <myFooter />
  </section>
  <section v-else>
    <loadPage />
  </section>
</template>

<script>
import { mapState } from "vuex";
import myHeader from "../Header/header.vue";
import myFooter from "../Footer/footer.vue";
import Offline from "../Modals/Offline.vue";
import LoadPage from "../Modals/LoadPage.vue";
export default {
  components: {
    myHeader,
    myFooter,
    Offline,
    LoadPage
  },
  data: () => {
    return {
      newMessage: true,
      users: [],
      loadPage: false,
    };
  },
  computed: {
    ...mapState(["user"]),
    currentPage() {
      return this.$route.path;
    },
  },
  mounted() {
    this.loadMessages();
  },
  methods: {
    goBack() {
      this.$router.push({ path: "/profile" });
    },
    goChat(id){
      localStorage.setItem("idUser", id);
      this.$router.push({path: "/chat"});
    },
    loadMessages() {
      this.$http.post("/mensages/ultimas")
        .then(res => {
          this.users = res.data;
          setTimeout(this.loadPage = true, 1000);
        });
    }
  },
};
</script>