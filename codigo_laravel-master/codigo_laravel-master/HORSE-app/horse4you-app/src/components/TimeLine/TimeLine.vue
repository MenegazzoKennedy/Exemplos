<template>
  <section>
    <myHeader />
    <complaints
      ref="complaints"
      @removePost="deletePostComplaint"
    />
    <comments
      ref="comments"
      @refreshComments="loadTimeline"
    />
    <offline ref="offline" />
    <div
      id="postTimeLine"
      v-scroll="handleScroll"
    >
      <v-container>
        <v-row>
          <v-alert
            v-model="copyLinkAlert"
            class="alertCopy"
            close-text="Close Alert"
            color="#252422"
            dark
          >
            Link copiado para área de transferência.
          </v-alert>

          <v-col
            cols="12"
            class="nopadding"
          >
            <template
              v-for="(feed, i) in timeline"
            >
              <div
                :key="i"
                class="boxTimeline"
              >
                <div
                  v-if="feed.isAnuncio == true"
                  class="followTags"
                >
                  <span class="font-weight-bold text-subtitle-2">ANÚNCIO</span>
                </div>
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
                  <router-link
                    v-if="feed.user_id != user.id"
                    :to="'/view-profile/' + feed.user.id"
                  >
                    <v-avatar size="40">
                      <img :src="feed.user.avatar">
                    </v-avatar>
                    <h2>{{ feed.user.name }}</h2>
                  </router-link>

                  <router-link
                    v-else
                    to="/profile"
                  >
                    <v-avatar size="40">
                      <img :src="feed.user.avatar">
                    </v-avatar>
                    <h2>{{ feed.user.name }}</h2>
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
                        v-if="feed.user_id == user.id"
                        @click="deletePost(feed.id, i)"
                      >
                        <v-list-item-title>Deletar post</v-list-item-title>
                      </v-list-item>

                      <v-list-item 
                        v-if="feed.user_id != user.id"
                        @click="denuncias(feed.id, 2, i)"
                      >
                        <v-list-item-title>Denunciar post</v-list-item-title>
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
                  <div
                    v-if="feed.tipo == 'imagem'"
                    class="form-group mt-30"
                  >
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
                        controls
                      />
                    </router-link>
                  </div>
                </div>

                <div class="actionsBox mt-3">
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
                    @click="loadComments(feed.id, i)"
                  >
                    <img
                      src="../../assets/comments.png"
                      style="width: 20px; height: 20px"
                    >
                    <p>{{ quantComments[i] }}</p>
                  </v-btn>

                  <span class="shareBtn">
                    <input
                      v-model="linkShare"
                      type="hidden"
                    >
                    <button
                      v-clipboard:copy="
                        linkShare + '/horse4you-app/view-post/' + feed.id
                      "
                      v-clipboard:success="onCopy"
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
                <div class="diviserBorder" />
              </div>
            </template>
          </v-col>
        </v-row>
        <div class="loaderPost">
          <v-progress-circular
            v-observe-visibility="visibilityChanged"
            indeterminate
            color="red"
            class="mx-auto"
            :style="`display: ${computedDisplay}`"
          />
        </div>
      </v-container>
    </div>
    <myFooter />
  </section>
</template>

<script>
import Vue from "vue";
import { mapState } from "vuex";
import { showError } from "@/global";
import myHeader from "../Header/header.vue";
import myFooter from "../Footer/footer.vue";
import Complaints from "../Modals/Complaints.vue";
import Comments from "../Modals/Comments.vue";
import offline from "../Modals/Offline.vue";
import VueObserveVisibility from "vue-observe-visibility";

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
  name: "Galeria",
  components: {
    myHeader,
    myFooter,
    Complaints,
    Comments,
    offline,
  },
  data: () => {
    return {
      timeline: [],
      postId: 0,
      copyLinkAlert: false,
      linkShare: window.location.origin,
      quant: 0,
      tam: true,
      tam2: true,
      display: "block",
      isVisible: true,
      index: null,
      entrarLoad: true,
      quantComments: [],
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
  mounted() {
    this.loadTimeline();
  },
  created() {
    window.addEventListener("scroll", this.handleScroll);
  },
  updated(){
    this.postsAll();
  },
  destroyed() {
    window.removeEventListener("scroll", this.handleScroll);
  },
  methods: {
    deletePostComplaint() {
      this.timeline.splice(this.index, 1);
    },
    visibilityChanged(isVisible) {
      this.isVisible = isVisible;
    },
    handleScroll() {
      if (this.isVisible) {
        if (this.tam) {
          if (this.tam2) {
            this.tam = false;
            this.tam2 = false;
            this.appendListaPosts();
          } else {
            this.tam2 = true;
          }
        }
      }
    },
    appendListaPosts() {
      if (!this.tam) {
        this.loadTimeline();
        this.tam = true;
      }
    },
    onCopy() {
      this.copyLinkAlert = true;
      setTimeout(() => (this.copyLinkAlert = false), 3000);
    },
    loadTimeline(newComments, index, deletedComments) {
      if (this.entrarLoad) {
        this.entrarLoad = false;
        var isOnline = navigator.onLine;
        if (!isOnline) {
          this.$refs.offline.loadPage();
        } else {
          this.quant++;
          this.$http
            .get("/posts?page=" + this.quant)
            .then((res) => {
              if (res.data.data.length == 0) {
                this.display = "none";
              }
              this.timeline = this.timeline.concat(res.data.data);
              for (let i=0; i<this.timeline.length;i++) {
                this.quantComments[i] = this.timeline[i].comments.length;
              }
              let soma = newComments - deletedComments;
              this.quantComments[index] = this.quantComments[index] + soma;
              this.entrarLoad = true;
            })
            .catch((err) => {
              showError(err);
            });
        }
      }
    },
    postsAll(){
      let posts = document.querySelectorAll("#postTimeLine .boxTimeline .lb-more");
      for (let i=0; i<posts.length;i++) {
        this.quantTexto = posts[i].innerHTML.split("+")[0];
        if(this.quantTexto != ""){
          posts[i].innerHTML = "+"+posts[i].innerHTML.split("+")[0];
          console.log(this.quantTexto);
        }
      }        
    },
    loadComments(postID, index) {
      localStorage.setItem("idPost", postID);
      localStorage.setItem("index", index);
      this.$refs.comments.loadComments();
    },
    like(postID) {
      let post = this.timeline.find((post) => post.id == postID);
      post.statelike = true;
      post.countlikes++;

      this.$http.post("/likes", {
        postid: postID,
        like: "like",
      });
    },
    unlike(postID) {
      let post = this.timeline.find((post) => post.id == postID);
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
          this.timeline.splice(index, 1);
        })
        .catch(showError);
    },
    denuncias(id, tipo, index) {
      if (tipo == 1) {
        localStorage.setItem("usuarioID", id);
        localStorage.setItem("tipoReq", tipo);
        this.index = index;
        this.$refs.complaints.openDialog();
      } else if (tipo == 2) {
        localStorage.setItem("postID", id);
        localStorage.setItem("tipoReq", tipo);
        this.index = index;
        this.$refs.complaints.openDialog();
      } else {
        localStorage.setItem("comentarioID", id);
        localStorage.setItem("tipoReq", tipo);
        this.index = index;
        this.$refs.complaints.openDialog();
      }
    },
  },
};
</script>