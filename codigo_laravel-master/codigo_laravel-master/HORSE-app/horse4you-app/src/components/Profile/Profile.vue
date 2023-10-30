<template>
  <section v-if="pageReady == true">
    <myHeader />
    <div id="secProfile">
      <offline ref="offline" />
      <v-container>
        <v-row>
          <v-col
            cols="12"
            class="profile"
          >
            <div class="formatTop dotsViewUser">
              <div class="logoutConfig">
                <a
                  @click="btnLogout"
                >Sair</a>
              </div>

              <div class="ImageUser">
                <v-avatar size="68">
                  <img :src="myInfos.avatar">
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
                <v-list
                  class="boxMenu"
                >
                  <v-list-item>
                    <v-list-item-title @click="goPageBlock()">
                      Usuários Bloqueados
                    </v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </div>
            <h2>{{ user.name }}</h2>
            <h3>Perfil {{ roleUser }}</h3>
            <h3>Site: {{ user.site }}</h3>
            <v-card-text>{{ user.descricao }}</v-card-text>
            <div class="followTags">
              <div
                v-for="(nameTag, i) in user.tags"
                :key="i"
              >
                <v-card-text>#{{ nameTag.tag }}</v-card-text>
              </div>
            </div>
            <div class="buttonForm">
              <v-btn
                class="buttonBlue"
                @click="editProfile"
              >
                Editar Perfil
              </v-btn>
            </div>

            <div class="postUser">
              <h2>
                Publicações de <strong> {{ user.name }}</strong>
              </h2>
              <p
                v-if="noPost"
                class="mb-2"
              >
                Você possui nenhuma publicação!
              </p>
            </div>
            
            <div v-scroll="handleScroll">
              <comments ref="comments" />
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
                              <v-list-item @click="deletePost(feed.id, i)">
                                <v-list-item-title>
                                  Deletar post
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
import { showError } from "@/global";
import VueObserveVisibility from "vue-observe-visibility";
import myHeader from "../Header/header.vue";
import myFooter from "../Footer/footer.vue";
import Offline from "../Modals/Offline.vue";
import LoadPage from "../Modals/LoadPage.vue";
import Comments from "../Modals/Comments.vue";

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
    Offline,
    LoadPage,
    Comments
  },
  data: () => {
    return {
      postView: [],
      myInfos: [],
      pageReady: false,
      postId: 0,
      roleUser: "",
      quant: 0,
      tam: true,
      tam2: true,
      tam3: true,
      vazio: false,
      display: "block",
      blocker: true,
      isVisible: true,
      noPost: false,
      firstReq: true,
      quantTexto: "",
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
    window.addEventListener("scroll", this.handleScroll);
  },
  destroyed() {
    window.removeEventListener("scroll", this.handleScroll);
  },
  mounted() {
    this.loadMyPosts();
    this.loadMyInfo();
  },
  updated(){
    this.postsAll();
  },
  methods: {
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
        this.loadMyPosts();
        this.tam = true;
      }
    },
    loadMyInfo() {
      var isOnline = navigator.onLine;
      if (!isOnline) {
        this.$refs.offline.loadPage();
      } else {
        this.$http
          .post("/auth/me?user=me")
          .then((res) => {
            this.myInfos = res.data;
            this.roleUser = this.myInfos.roles[0].name;
            setTimeout(() => {
              this.pageReady = true;
            }, 1000);
          })
          .catch(showError);
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
    deletePost(postID, index) {
      this.$http
        .delete("/posts/" + postID + "")
        .then(() => {
          this.postView.splice(index, 1);
          Vue.toasted.global.defaultSuccess({ msg: "Post deletado com sucesso!"});
        })
        .catch(showError);
    },
    editProfile: function () {
      this.$router.replace("/edit-profile");
    },
    loadMyPosts() {
      this.quant++;
      this.$http
        .get("/posts?page=" + this.quant + "&iduser=me")
        .then((res) => {
          if (res.data.data) {
            if (res.data.data.length > 0 && res.data.data.length < 15) {
              this.postView = this.postView.concat(res.data.data);
              this.vazio = true;
              this.display = "none";
              this.noPost = false;
            } else if (res.data.data.length == 0) {
              this.vazio = true;
              this.display = "none";
              this.noPost = false;
              this.firstReq = false;
              if (this.firstReq) {
                console.log("entrou aq");
                this.noPost = true;
                this.firstReq = false;
              }
            } else {
              this.postView = this.postView.concat(res.data.data);
              this.noPost = false;
            }
          } else if(res.data.data) {
            this.vazio = true;
            this.display = "none";
            this.blocker = true;
          }
        })
        .catch((err) => {
          this.blocker = false;
          showError(err);
        });
    },
    postsAll(){
      let posts = document.querySelectorAll("#secProfile .boxTimeline .lb-more");
      for (let i=0; i<posts.length;i++) {
        this.quantTexto = posts[i].innerHTML.split("+")[0];
        if(this.quantTexto != ""){
          posts[i].innerHTML = "+"+posts[i].innerHTML.split("+")[0];
          console.log(this.quantTexto);
        }
      }        
    },
    btnLogout() {
      this.$http
        .post("/auth/singout")
        .then((res) => {
          this.userData = res.data;
          localStorage.removeItem("app_horse4you");
          localStorage.removeItem("conected");
          setTimeout(() => this.$router.push({ path: "/login" }), 1000);
        })
        .catch(showError);
    },
    goPageBlock() {
      this.$router.push({ path: "/users-block"});
    }
  },
};
</script>