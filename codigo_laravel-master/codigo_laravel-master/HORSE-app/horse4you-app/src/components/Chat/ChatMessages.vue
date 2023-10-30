<template>
  <section id="chat">
    <offline ref="offline" />
    <a
      class="goBack"
      @click="goBack"
    >
      <v-icon>mdi-close</v-icon>                     
    </a>
    <myHeader />
    <div
      id="secChat"
      class="full-height"
    >
      <v-row>
        <v-col
          cols="12"
        >
          <div class="chat-header">
            <div class="avatar">
              <v-avatar>
                <img
                  :src="userViewData.avatar"
                >
              </v-avatar>
            </div>
            <div class="inf">
              <h3>{{ userViewData.name }}</h3>
              <p>Online</p>
              <span class="dot" />
            </div>
          </div>
          <div
            v-chat-scroll
            class="chat-history"
          >
            <div
              v-for="(item, index) in chat"
              :key="index"
              style="display: contents;"
            >
              <div
                v-if="item.to == idViewUser"
                class="message my-message"
              >
                {{ item.content }}
                <span class="hourText">{{ formatTime(item.created_at) }}</span>
              </div>
              <div
                v-else
                class="message other-message"
              >
                {{ item.content }}
                <span class="hourText">{{ formatTime(item.created_at) }}</span>
              </div>
            </div>
          </div>
          <div class="chat-message">
            <v-text-field
              v-model="msg"
              rounded
              shaped
              outlined
              placeholder="Comente aqui"
              @keyup.enter="send"
            />
            <div class="btnText">
              <v-btn
                v-if="sendIcon"
                icon
                :loading="loading"
                @click="send"
              >
                <v-icon>
                  mdi-send
                </v-icon>
              </v-btn>
              <v-btn
                v-else
                icon
                :loading="loading"
                @click="uploadFile"
              >
                <img
                  src="@/assets/upload.png"
                >
              </v-btn>
            </div>
          </div>
        </v-col>
      </v-row>
    </div>
    <myFooter />
  </section>
</template>

<script>
import { mapState } from "vuex";
import { showError } from "@/global";
import myHeader from "../Header/header.vue";
import myFooter from "../Footer/footer.vue";
import offline from "../Modals/Offline.vue";

export default {
  components: {
    myHeader,
    myFooter,
    offline,
  },
  data: () => {
    return {
      msg: "",
      id: null,
      idViewUser: localStorage.getItem("idUser"),
      userViewData: [],
      chat: [],
      meSend: false,
      sendIcon: false,
      loading: false,
      sendMessage: false,
    };
  },
  computed: {
    ...mapState(["user"]),
    currentPage() {
      return this.$route.path;
    },
  },
  watch: {
    msg() {
      if (this.msg == "") {
        this.sendIcon = false;
      } else{
        this.sendIcon = true;
      }
    },
    sendMessage() {
      if(this.sendMessage == true) {
        this.sendIcon = false;
        this.sendMessage = false;
      }
    },
  },
  mounted() {
    this.loadMessages();
    this.infUser();
    // this.reloadPage();
    window.Echo.channel(`user.${this.user.id}`)
      .listen("SendMessage", (e) => {
        this.chat = this.chat.concat(e.message);
      });
  },
  methods: {
    reloadPage() {
      setTimeout(() =>
        this.loadMessages(), 5000
      );
    },
    send: function() {
      this.sendMessage = true;
      this.loading = true;
      this.sendIcon = false;
      this.$http.post("/mensages/store", {
        to: parseInt(this.idViewUser),
        content: this.msg
      }).then((res) => {
        this.chat = this.chat.concat(res.data);
      });
      this.loadMessages();
      this.meSend = true;
      this.msg = null;
      this.loading = false;
      
    },
    uploadFile() {
      //
    },
    goBack() {
      this.$router.push({ path: "/inbox"});
    },
    infUser() {
      this.$http.post("/auth/me", {
        user: this.idViewUser
      }).then((res) => {
        this.userViewData = res.data;
      }).catch(showError);
    },
    loadMessages() {
      this.$http.get(`/mensages/${this.idViewUser}`).then((res) => {
        this.chat = res.data[0];
      });
    },
    formatTime(timer) {
      const tempo = timer.slice(11,16);
      return tempo;
    }
  },
};
</script>