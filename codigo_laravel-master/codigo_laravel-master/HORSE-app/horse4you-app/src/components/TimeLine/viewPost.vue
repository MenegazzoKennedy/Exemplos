<template>
  <section id="viewPost">
    <myHeader />
    <complaints ref="complaints" />
    <comments ref="comments" />
    <offline ref="offline" />
    <div>
      <v-container>
        <v-row>
          <a
            class="goBack"
            @click="goBack"
          >
            <v-icon>mdi-window-close</v-icon>
          </a>
          <v-col
            cols="12"
            class="nopadding"
          >
            <div
              v-for="(post, i) in postView"
              :key="i"
              class="boxTimeline"
            >
              <div
                v-if="post.tipo == 'imagem'"
                class="slideImg"
              >
                <slide
                  :data="post.post_imagens"
                  :time="10000000"
                />
              </div>
              <div v-else>
                <video
                  :src="post.post_videos"
                  type="video/mp4"
                  width="350"
                  height="250"
                  controls
                />
              </div>

              <div class="boxHeader">
                <router-link :to="'/view-profile/' + post.user.id">
                  <v-avatar size="40">
                    <img :src="post.user.avatar">
                  </v-avatar>
                  <h2>{{ post.user.name }}</h2>
                </router-link>

                <v-menu :offset-y="true">
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      class="rightIcon"
                      v-bind="attrs"
                      icon
                      v-on="on"
                    >
                      <v-icon>mdi-dots-horizontal</v-icon>
                    </v-btn>
                  </template>
                  <v-list class="boxMenu">
                    <v-list-item
                      v-if="post.user_id == user.id"
                      @click="deletePost(post.id)"
                    >
                      <v-list-item-title>Deletar post</v-list-item-title>
                    </v-list-item>

                    <v-list-item
                      v-if="post.user_id != user.id"
                      @click="denuncias(post.id, 2)"
                    >
                      <v-list-item-title>Denunciar post</v-list-item-title>
                    </v-list-item>
                  </v-list>
                </v-menu>
              </div>
              <p class="ml-7">
                {{ post.texto }}
              </p>

              <div class="actionsBox ml-5">
                <v-btn
                  v-if="post.statelike == false"
                  icon
                  class="leftBtn"
                  @click="like(post.id)"
                >
                  <v-icon>mdi-heart-outline</v-icon>
                  <p>{{ post.countlikes }}</p>
                </v-btn>
                <v-btn
                  v-else
                  icon
                  class="leftBtn"
                  @click="unlike(post.id)"
                >
                  <v-icon>mdi-heart</v-icon>
                  <p>{{ post.countlikes }}</p>
                </v-btn>

                <v-btn
                  icon
                  class="leftBtn"
                  @click="loadComments(post.id)"
                >
                  <img
                    src="../../assets/comments.png"
                    style="width: 20px; height: 20px"
                  >
                  <p>{{ post.comments.length }}</p>
                </v-btn>

                <span class="shareBtn mr-4">
                  <input
                    v-model="linkShare"
                    type="hidden"
                  >
                  <button
                    v-clipboard:copy="linkShare"
                    v-clipboard:success="onCopy"
                    v-clipboard:error="onError"
                    icon
                    type="button"
                  >
                    <img
                      class="imgIcon"
                      src="../../assets/share.png"
                    >
                  </button>
                </span>
              </div>
            </div>

            <v-alert
              v-model="copyLinkAlert"
              close-text="Close Alert"
              color="#252422"
              dark
            >
              Link copiado para área de transferência.
            </v-alert>
            <v-alert
              v-model="errorCopy"
              close-text="Close Alert"
              color="#252422"
              dark
            >
              Erro ao copiar para área de transferência.
            </v-alert>
          </v-col>
        </v-row>
      </v-container>
    </div>
    <myFooter />
  </section>
</template>

<script>
import { mapState } from "vuex";
import myHeader from "../Header/header.vue";
import myFooter from "../Footer/footer.vue";
import slide from "@wyhaya/vue-slide";
import { showError } from "@/global";
import Complaints from "../Modals/Complaints.vue";
import offline from "../Modals/Offline.vue";
import Comments from "../Modals/Comments.vue";

export default {
  name: "Viewpost",
  components: {
    myHeader,
    myFooter,
    slide,
    Complaints,
    Comments,
    offline,
  },
  data: () => {
    return {
      dialogComments: false,
      postId: 0,
      postView: [],
      carregouDados: true,
      commentsPost: [],
      commentsData: [],
      replyValue: [],
      numeroRespostas: [],
      showCommentReply: [],
      replyTextField: [],
      commentValue: "",
      copyLinkAlert: false,
      errorCopy: false,
      linkShare: window.location.href,
      quant: 0,
    };
  },
  computed: {
    ...mapState(["user"]),
    currentPage() {
      return this.$route.path;
    },
  },
  created() {
    this.postID = this.$route.params.id;
  },
  mounted() {
    this.loadTimeline();
  },
  methods: {
    onCopy() {
      this.copyLinkAlert = true;
      setTimeout(() => (this.copyLinkAlert = false), 3000);
    },
    onError() {
      this.errorCopy = true;
      setTimeout(() => (this.errorCopy = false), 3000);
    },
    goBack() {
      this.$router.push({ path: "/timeline" });
    },
    loadTimeline() {
      var isOnline = navigator.onLine;
      if (!isOnline) {
        this.$refs.offline.loadPage();
      } else {
        this.$http
          .get("/posts/" + this.postID)
          .then((res) => {
            this.postView = res.data;
          })
          .catch((err) => {
            showError(err);
          });
      }
    },
    slideDots() {
      if (this.postView[0].imagens.length == 1) {
        const element = document.getElementsByClassName("spot");
        element[0].classList.add("arq-none");
      }
    },
    loadComments(postID) {
      localStorage.setItem("idPost", postID);
      this.$refs.comments.loadComments();
    },
    deletePost() {
      this.$http
        .delete("/posts/" + this.postId + "")
        .then(() => {
          this.$router.push({ path: "/timeline/" });
        })
        .catch(showError);
    },
    like(postID) {
      let post = this.postView.find((post) => post.id == postID);
      post.statelike = true;
      post.countlikes++;

      this.$http
        .post("/likes", {
          postid: postID,
          like: "like",
        });
    },
    unlike(postID) {
      let post = this.postView.find((post) => post.id == postID);
      post.statelike = false;
      post.countlikes--;

      this.$http.post("/likes", {
        postid: postID,
        like: "unlike",
      });
    },
    denuncias(id, tipo) {
      if (tipo == 1) {
        localStorage.setItem("usuarioID", id);
        localStorage.setItem("tipoReq", tipo);
        this.$refs.complaints.openDialog();
      } else if (tipo == 2) {
        localStorage.setItem("postID", id);
        localStorage.setItem("tipoReq", tipo);
        this.$refs.complaints.openDialog();
      } else {
        localStorage.setItem("comentarioID", id);
        localStorage.setItem("tipoReq", tipo);
        this.$refs.complaints.openDialog();
      }
    },
  },
};
</script>