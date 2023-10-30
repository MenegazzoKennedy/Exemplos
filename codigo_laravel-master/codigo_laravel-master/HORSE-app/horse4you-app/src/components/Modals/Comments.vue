<template>
  <div>
    <complaints ref="complaints" />
    <offline ref="offline" />
    <v-dialog
      v-model="value"
      style="z-index: 265"
      origin="bottom"
      transition="dialog-bottom-transition"
      content-class="commentsDialog"
      scrollable
      persistent
      fullscreen
      :retain-focus="false"
    >
      <v-container>
        <v-row>
          <v-col
            cols="12"
            class="commentsHeader"
          >
            <v-btn
              icon
              @click="fechaDialog"
            >
              <v-icon>mdi-close</v-icon>
            </v-btn>
            <h4>Comentários</h4>
          </v-col>
        </v-row>
        <v-row
          class="arqMargin"
        >
          <v-progress-circular
            :size="70"
            :width="7"
            color="black"
            class="mx-auto"
            style="display: block"
            :class="{ none: !carregouDados }"
            indeterminate
          />
          <v-col
            v-for="(comments, i) in commentsData"
            :key="i"
            cols="12"
            class="boxComments"
          >
            <div
              v-for="(usuario, j) in comments.user"
              :key="j"
              class="titleComments"
            >
              <router-link :to="'/view-profile/' + comments.user_id">
                <v-avatar size="35">
                  <img :src="usuario.avatar">
                </v-avatar>
                <h2>{{ usuario.name }}</h2>
              </router-link>
            </div>
            <div class="areaComments">
              <v-divider vertical />

              <div>
                <p>{{ comments.texto }}</p>

                <div class="actionsBox">
                  <v-btn
                    v-if="comments.statelikecomment == false"
                    icon
                    class="commentsBtn"
                    @click="likeComment(comments.id, comments.post_id, 0, 1)"
                  >
                    <v-icon>mdi-heart-outline</v-icon>
                    <p>Curtir</p>
                  </v-btn>
                  <v-btn
                    v-else
                    icon
                    class="commentsBtn"
                    @click="unlikeComment(comments.id, comments.post_id, 0, 1)"
                  >
                    <v-icon>mdi-heart</v-icon>
                    <p>Descurtir</p>
                  </v-btn>

                  <v-btn
                    icon
                    class="commentsBtn"
                    @click="showTextField(i)"
                  >
                    <img src="../../assets/sharemdi.png">
                    <p>Responder</p>
                  </v-btn>

                  <v-menu :offset-y="true">
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn
                        class="commentsBtn dotsBtn"
                        v-bind="attrs"
                        icon
                        v-on="on"
                      >
                        <v-icon>mdi-dots-horizontal</v-icon>
                      </v-btn>
                    </template>
                    <v-list class="boxMenu">
                      <v-list-item
                        @click="deleteComments(comments.id)"
                      >
                        <v-list-item-title>Deletar</v-list-item-title>
                      </v-list-item>

                      <v-list-item
                        @click="denuncias(comments.id, 3)"
                      >
                        <v-list-item-title>Denunciar</v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                  <p
                    v-if="
                      numeroRespostas[i] > 0 && showCommentReply[i] === false
                    "
                    @click="showReply(i)"
                  >
                    Ver {{ numeroRespostas[i] }} respostas do comentário.
                  </p>
                  <p
                    v-if="
                      numeroRespostas[i] > 0 && showCommentReply[i] === true
                    "
                    @click="hideReply(i)"
                  >
                    Ocultar {{ numeroRespostas[i] }} respostas do comentário.
                  </p>
                </div>
                <div
                  v-for="(reply, k) in comments.reply"
                  v-show="showCommentReply[i] == true"
                  :key="k"
                  class="boxComments replyComments"
                >
                  <div class="titleComments">
                    <v-avatar size="30">
                      <img :src="reply.user[0].avatar">
                    </v-avatar>
                    <h2>{{ reply.user[0].name }}</h2>
                  </div>
                  <div class="areaComments">
                    <div>
                      <p>
                        {{ reply.texto }}
                      </p>

                      <div class="actionsBox">
                        <v-btn
                          v-if="reply.statelikecomment == false"
                          icon
                          class="commentsBtn"
                          @click="likeComment(reply.id, reply.post_id, i, 0)"
                        >
                          <v-icon>mdi-heart-outline</v-icon>
                          <p>Curtir</p>
                        </v-btn>
                        <v-btn
                          v-else
                          icon
                          class="commentsBtn"
                          @click="unlikeComment(reply.id, reply.post_id, i, 0)"
                        >
                          <v-icon>mdi-heart</v-icon>
                          <p>Descurtir</p>
                        </v-btn>

                        <v-menu :offset-y="true">
                          <template v-slot:activator="{ on, attrs }">
                            <v-btn
                              class="commentsBtn dotsBtn"
                              v-bind="attrs"
                              icon
                              v-on="on"
                            >
                              <v-icon>mdi-dots-horizontal</v-icon>
                            </v-btn>
                          </template>
                          <v-list class="boxMenu">
                            <v-list-item @click="deleteComments(reply.id)">
                              <v-list-item-title>Deletar</v-list-item-title>
                            </v-list-item>

                            <v-list-item @click="denuncias(reply.id, 3)">
                              <v-list-item-title>Denunciar</v-list-item-title>
                            </v-list-item>
                          </v-list>
                        </v-menu>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-if="replyTextField[i] == true">
                  <div class="d-inline-block">
                    <v-text-field
                      v-model="replyValue[i]"
                      rounded
                      shaped
                      outlined
                      placeholder="Comente aqui"
                      @keyup.enter="postReply(comments.id, i)"
                    />
                  </div>
                  <div class="d-inline-block my-auto">
                    <v-btn
                      icon
                      :loading="loadingReply[i]"
                      @click="postReply(comments.id, i)"
                    >
                      <v-icon>mdi-send</v-icon>
                    </v-btn>
                  </div>
                </div>
              </div>
            </div>
          </v-col>
        </v-row>

        <v-row>
          <v-col
            cols="12"
            class="commentsInput"
          >
            <v-text-field
              v-model="commentValue"
              rounded
              shaped
              outlined
              placeholder="Comente aqui"
              @keyup.enter="postComments"
            />
            <v-btn
              icon
              :loading="loading"
              @click="postComments"
            >
              <v-icon>mdi-send</v-icon>
            </v-btn>
          </v-col>
        </v-row>
      </v-container>
    </v-dialog>
  </div>
</template>

<script>
import Vue from "vue";
import { mapState } from "vuex";
import { showError } from "@/global";
import Complaints from "./Complaints.vue";
import offline from "./Offline.vue";
export default {
  name: "Comments",
  components: { Complaints, offline },
  data() {
    return {
      value: false,
      carregouDados: true,
      commentsData: [],
      commentValue: "",
      numeroRespostas: [],
      showCommentReply: [],
      replyTextField: [],
      replyValue: [],
      postId: null,
      loading: false,
      loadingReply: false,
      newComments: 0,
      deletedComments: 0,
      index: null
    };
  },
  computed: {
    ...mapState(["user"]),
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
    fechaDialog() {
      this.value = false;
      this.commentsData = [];
      this.commentsPost = [];
      this.commentValue = "";
      this.carregouDados = true;
      this.postId = 0;
      this.$emit("refreshComments", this.newComments, this.index, this.deletedComments);
    },
    loadComments() {
      this.value = true;
      this.postId = parseInt(localStorage.getItem("idPost"));
      this.index = parseInt(localStorage.getItem("index"));
      this.$http.get("/comments/" + this.postId + "").then((res) => {
        this.commentValue = "";
        for (let i = 0; i < res.data.length; i++) {
          this.replyValue[i] = "";
          this.numeroRespostas[i] = res.data[i].reply.length;
          this.showCommentReply[i] = false;
          this.replyTextField[i] = false;
        }
        this.commentsData = res.data;
        this.carregouDados = false;
      });
    },
    postComments() {
      this.loading = true;
      this.disabled = true;
      if (this.commentValue != "") {
        this.$http
          .post("/comments", {
            texto: this.commentValue,
            idpost: this.postId,
          })
          .then((res) => {
            this.commentsPost = res.data;
            this.loadComments(this.postId);
            this.newComments++;
            this.commentValue = "";
            this.loading = false;
          })
          .catch(showError);
      } else {
        Vue.toasted.global.defaultError({
          errors: "Digite algo para fazer o comentário",
        });
        this.loading = false;
      }
    },
    showReply(index) {
      this.showCommentReply[index] = true;
      var componente = this.commentsData;
      this.commentsData = [];
      this.commentsData = componente;
    },
    hideReply(index) {
      this.showCommentReply[index] = false;
      var componente = this.commentsData;
      this.commentsData = [];
      this.commentsData = componente;
    },
    showTextField(index) {
      this.replyTextField[index] = true;
      var componente = this.commentsData;
      this.commentsData = [];
      this.commentsData = componente;
    },
    postReply(postReply, index) {
      this.loadingReply = true;
      if (this.replyValue[index]) {
        this.$http
          .post("/comments", {
            texto: this.replyValue[index],
            idpost: this.postId,
            post_reply: postReply,
          })
          .then(() => {
            this.loadComments(this.postId);
            this.newComments++;
            this.replyValue[index] = "";
            this.loadingReply = false;
          })
          .catch(showError);
      } else {
        Vue.toasted.global.defaultError({
          errors: "Digite algo para fazer o comentário",
        });
        this.loadingReply = false;
      }
    },
    deleteComments(commentsID) {
      this.$http
        .delete("/comments/" + commentsID + "")
        .then(() => {
          this.loadComments(this.postId);
          this.deletedComments++;
        })
        .catch(showError);
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
    likeComment(commentID, postID, index, verify) {
      if (verify == 1) {
        let comment = this.commentsData.find(
          (comment) => comment.id == commentID
        );
        comment.statelikecomment = true;
        comment.countlikescomment++;
      } else {
        let reply = this.commentsData[index].reply.find(
          (reply) => reply.id == commentID
        );
        reply.statelikecomment = true;
        reply.countlikescomment++;
      }
      this.$http.post("/comments/likes", {
        postid: postID,
        commentid: commentID,
        like: "like",
      });
    },
    unlikeComment(commentID, postID, index, verify) {
      if (verify == 1) {
        let comment = this.commentsData.find(
          (comment) => comment.id == commentID
        );
        comment.statelikecomment = false;
        comment.countlikescomment--;
      } else {
        let reply = this.commentsData[index].reply.find(
          (reply) => reply.id == commentID
        );
        reply.statelikecomment = false;
        reply.countlikescomment--;
      }

      this.$http.post("/comments/likes", {
        postid: postID,
        commentid: commentID,
        like: "unlike",
      });
    },
  },
};
</script>