<template>
  <section
    v-if="pageReady == true"
  >
    <div id="secViewProfile">
      <myHeader />
      <complaints ref="complaints" />
      <comments ref="comments" />
      <offline ref="offline" />
      <v-container>
        <v-row>
          <v-col
            cols="12"
            class="profile"
          >
            <div class="formatTop dotsViewUser">
              <a @click="goBack">Voltar</a>

              <div class="ImageUser">
                <v-avatar size="68">
                  <img :src="viewData.avatar">
                </v-avatar>
              </div>

              <v-menu :offset-y="true">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    class="rightIcon dotsViewUser"
                    v-bind="attrs"
                    icon
                    v-on="on"
                  >
                    <v-icon>mdi-dots-horizontal</v-icon>
                  </v-btn>
                </template>
                <v-list class="boxMenu">
                  <v-list-item
                    v-if="!blocked"
                    @click="blockUser(viewData.id, 1)"
                  >
                    <v-list-item-title>Bloquear</v-list-item-title>
                  </v-list-item>
                  <v-list-item
                    v-if="blocked"
                    @click="blockUser(viewData.id)"
                  >
                    <v-list-item-title>Desbloquear</v-list-item-title>
                  </v-list-item>
                  <v-list-item
                    v-if="!blocked"
                    @click="denuncias(viewData.id, 1)"
                  >
                    <v-list-item-title>Denunciar</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </div>

            <h2>{{ viewData.name }}</h2>
            <h3>Perfil {{ viewData.roles[0].name }}</h3>
            <v-card-text>{{ viewData.descricao }}</v-card-text>
            <div class="followTags">
              <div
                v-for="(nameTag, i) in viewData.tags"
                :key="i"
              >
                <v-card-text>#{{ nameTag.tag }}</v-card-text>
              </div>
            </div>

            <v-row>
              <v-col cols="10">
                <v-btn
                  v-if="!viewData.follower && !blocked"
                  block
                  @click="follow"
                >
                  Seguir
                </v-btn>
                <v-btn
                  v-else-if="viewData.follower && !blocked"
                  block
                  @click="unfollow"
                >
                  Parar de Seguir
                </v-btn>
                <v-btn
                  v-else-if="viewData.bloqueado || blocked"
                  block
                  @click="blockUser(viewData.id)"
                >
                  Desbloquear
                </v-btn>
              </v-col>
              <v-col
                cols="2"
                class="dotsViewUser"
              >
                <div @click="goChat(viewData.id)">
                  <img
                    class="imgIcon"
                    src="../../assets/mailBlue.png"
                  >
                </div>
              </v-col>
            </v-row>
            <div v-if="noPost && !blocked">
              <p>Este usuário não possui nenhuma publicação</p>
            </div>
            <div
              v-if="!blocked"
              v-scroll="handleScroll"
            >
              <v-container>
                <v-row>
                  <v-col
                    cols="12"
                    class="nopadding"
                  >
                    <template v-for="(feed, i) in postView">
                      <div
                        :key="i"
                        class="boxTimeline"
                      >
                        <div
                          v-if="feed.tags.length > 0"
                          class="followTags"
                        >
                          <span class="subtitle-2">Postado em <span
                            v-for="(tagPost,index) in feed.tags"
                            :key="index"
                            class="font-weight-bold text-subtitle-2"
                          > {{ tagPost.tag }}<span v-if="index != feed.tags.length - 1">,</span>
                            <span v-else>.</span> </span>
                          </span>
                        </div>
                        <div class="boxHeader">
                          <v-avatar size="40">
                            <img :src="feed.user.avatar">
                          </v-avatar>
                          <h2>{{ feed.user.name }}</h2>

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
                              <v-list-item @click="denuncias(feed.id, 2)">
                                <v-list-item-title>
                                  Denunciar post
                                </v-list-item-title>
                              </v-list-item>
                            </v-list>
                          </v-menu>
                        </div>
                        <router-link
                          class="postSingle"
                          :to="'/view-post/' + feed.id"
                        >
                          <p>{{ feed.texto }}</p>
                        </router-link>
                        <div v-if="feed.post_imagens || feed.post_videos">
                          <div v-if="feed.tipo == 'imagem'">
                            <lightbox
                              v-if="feed.post_imagens.length > 1"
                              :items="feed.post_imagens"
                              :cells="3"
                            />
                            <router-link
                              v-else
                              class="postSingle"
                              :to="'/view-post/' + feed.id"
                            >
                              <img
                                class="imgPost"
                                :src="feed.post_imagens[0]"
                                width="300"
                                height="300"
                              >
                            </router-link>
                          </div>
                          <div v-else>
                            <router-link
                              class="postSingle"
                              :to="'/view-post/' + feed.id"
                            >
                              <video
                                class="imgPost"
                                :src="feed.post_videos[0]"
                                type="video/mp4"
                                width="300"
                                height="300"
                                controls
                              />
                            </router-link>
                          </div>
                        </div>

                        <div class="actionsBox">
                          <v-btn
                            v-if="feed.statelike == false"
                            icon
                            class="leftBtn"
                            @click="like(feed.id)"
                          >
                            <v-icon>mdi-heart-outline</v-icon>
                            <p>{{ feed.countlikes }}</p>
                          </v-btn>
                          <v-btn
                            v-else
                            icon
                            class="leftBtn"
                            @click="unlike(feed.id)"
                          >
                            <v-icon>mdi-heart</v-icon>
                            <p>{{ feed.countlikes }}</p>
                          </v-btn>

                          <v-btn
                            icon
                            class="leftBtn"
                            @click="loadComments(feed.id)"
                          >
                            <img
                              src="../../assets/comments.png"
                              style="width: 20px; height: 20px"
                            >
                            <p>{{ feed.comments.length }}</p>
                          </v-btn>

                          <v-btn
                            icon
                            class="shareBtn"
                          >
                            <img
                              class="imgIcon"
                              src="../../assets/share.png"
                            >
                          </v-btn>
                        </div>
                        <div class="diviserBorder" />
                      </div>
                    </template>
                  </v-col>
                </v-row>
                <div class="loaderPost">
                  <v-progress-circular
                    v-observe-visibility="visibilityChanged"
                    indeterminate
                    class="mx-auto"
                    color="red"
                    :style="`display: ${computedDisplay}`"
                  />
                </div>
              </v-container>
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
import { mapState } from "vuex";
import myHeader from "../Header/header.vue";
import myFooter from "../Footer/footer.vue";
import { showError } from "@/global";
import VueObserveVisibility from "vue-observe-visibility";
import Complaints from "../Modals/Complaints.vue";
import Comments from "../Modals/Comments.vue";
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
    Complaints,
    Comments,
    offline,
    LoadPage
  },
  data: () => {
    return {
      postView: [],
      viewData: [],
      display: "block",
      postId: null,
      quant: null,
      viewUserID: null,
      pageReady: false,
      tam: true,
      tam2: true,
      tam3: true,
      vazio: false,
      blocker: true,
      isVisible: true,
      blocked: false,
      noPost: false,
      firstReq: true,
    };
  },
  computed: {
    ...mapState(["user"]),
    currentPage() {
      return this.$route.path;
    },
    computedDisplay: function () {
      return this.display;
    },
  },
  created() {
    this.viewUserID = this.$route.params.id;
    window.addEventListener("scroll", this.handleScroll);
  },
  destroyed() {
    window.removeEventListener("scroll", this.handleScroll);
  },
  mounted() {
    this.loadViewPosts();
    this.loadViewUser();
  },
  methods: {
    goChat(id){
      localStorage.setItem("idUser", id);
      this.$router.push({path: "/chat"});
    },
    visibilityChanged(isVisible) {
      this.isVisible = isVisible;
    },
    handleScroll() {
      if (this.isVisible) {
        if (this.tam) {
          if (this.tam2) {
            if (this.tam3) {
              this.tam = false;
              this.tam2 = false;
              this.tam3 = false;
              this.appendListaPosts();
            } else {
              this.tam3 = true;
            }
          } else {
            this.tam2 = true;
          }
        }
      }
    },
    appendListaPosts() {
      if (!this.tam) {
        this.loadViewPosts();
        this.tam = true;
      }
    },
    loadComments(postID) {
      localStorage.setItem("idPost", postID);
      this.$refs.comments.loadComments();
    },
    like(postID) {
      let post = this.postView.find((post) => post.id == postID);
      post.statelike = true;
      post.countlikes++;

      this.$http.post("/likes", {
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
    loadViewUser() {
      this.$http
        .post("/auth/me", {
          user: this.viewUserID,
        })
        .then((res) => {
          this.viewData = res.data;
          if (this.viewData.bloqueado) {
            this.blocked = true;
          } else {
            this.blocked = false;
          }
          setTimeout(() => {
            this.pageReady = true;
          }, 1000);
        })
        .catch(showError);
    },
    follow() {
      this.$http
        .post("/followers", {
          userid: this.viewUserID,
          follower: "follower",
        })
        .then(() => {
          this.loadViewUser();
        })
        .catch(showError);
    },
    unfollow() {
      this.$http
        .post("/followers", {
          userid: this.viewUserID,
          follower: "unfollower",
        })
        .then(() => {
          this.loadViewUser();
        })
        .catch(showError);
    },
    loadViewPosts() {
      var isOnline = navigator.onLine;
      if (!isOnline) {
        this.$refs.offline.loadPage();
      } else {
        if (this.blocker) {
          this.blocker = false;
          this.quant++;
          this.$http
            .get("/posts?page=" + this.quant + "&iduser=" + this.viewUserID)
            .then((res) => {
              if (this.firstReq) {
                if (res.data.data.length == 0) {
                  this.noPost = true;
                }

                this.firstReq = false;
              }
              if (res.data.data) {
                if (res.data.data.length > 0 && res.data.data.length < 15) {
                  this.postView = this.postView.concat(res.data.data);
                  this.vazio = true;
                  this.display = "none";
                  this.blocker = true;
                  this.noPost = false;
                } else if (res.data.data.length == 0) {
                  this.vazio = true;
                  this.display = "none";
                  this.blocker = true;
                  this.noPost = false;
                } else {
                  this.postView = this.postView.concat(res.data.data);
                  this.noPost = false;
                }
              } else {
                this.vazio = true;
                this.display = "none";
                this.blocker = true;
              }
            })
            .catch((err) => {
              this.blocker = false;
              showError(err);
            });
        }
      }
    },
    goBack() {
      this.$router.go(-1);
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
    blockUser(idUser, tipo) {
      if (tipo == 1) {
        this.$http
          .post("/usuario/bloqueio/" + idUser, {
            acao: 1,
          })
          .then(() => {
            this.blocked = true;
          });
      } else {
        this.$http
          .post("/usuario/bloqueio/" + idUser, {
            acao: 0,
          }).then(() => {
            this.blocked = false;
          });
      }
    },
  },
};
</script>