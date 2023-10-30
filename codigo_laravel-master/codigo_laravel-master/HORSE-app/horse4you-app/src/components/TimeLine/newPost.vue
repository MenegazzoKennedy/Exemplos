<template>
  <section
    v-if="pageReady == true"
    id="newpost"
  >
    <myHeader />
    <v-container>
      <offline ref="offline" />
      <v-row>
        <v-col
          cols="12"
          class="coluna"
        >
          <div class="title">
            <a
              class="leftBtn"
              @click="goBack"
            > Voltar </a>
            <h2>NOVO POST</h2>
          </div>

          <div class="menuPost">
            <input
              id="postImage"
              type="file"
              accept="image/png, image/jpg, image/jpeg"
              name="uploads[]"
              multiple="multiple"
              :disabled="selectImage"
              @change="handleSelects"
            >
            <input
              id="postVideo"
              type="file"
              accept="video/mp4"
              name="uploads[]"
              :disabled="selectVideo"
              @change="handleSelectsVideo"
            >

            <h4>Importar mídia</h4>
            <label
              for="postImage"
              class="newPhoto"
            >
              <img src="../../assets/galeria.png">
              GALERIA
            </label>
            <label
              for="postVideo"
              class="newPhoto"
            >
              <img src="../../assets/video.png">
              VÍDEO
            </label>

            <h4>Descrição:</h4>
            <v-textarea
              v-model="descriptionPost"
              outlined
              class="contentPost"
              rows="4"
              maxlength="480"
              placeholder="Digite aqui sobre o assunto escolhido..."
              :disabled="textField"
            />
            <p class="limiter">
              {{ descriptionPost.length }} de 480 caracteres
            </p>

            <div class="selectCategories">
              <h4>Categoria:</h4>
              <v-combobox
                v-model="nameTags"
                class="tagsSelect"
                placeholder="Categorias relacionadas ao post"
                :items="getTags"
                chips
                multiple
                deletable-chips
                single-line
                @keyup.enter="inputTags"
              />
            </div>

            <template v-if="images != ''">
              <h4 class="mt-3">
                Mídias importadas:
              </h4>
              <div class="myPostList">
                <div class="myImage">
                  <div
                    v-for="(img, i) in images"
                    :key="i"
                  >
                    <div @click="removeImg(i)">
                      <img :src="img">
                    </div>
                  </div>
                  <label
                    for="postImage"
                    class="mt-5"
                  >
                    <img
                      src="../../assets/addMore.png"
                      class="bg-white"
                    >
                  </label>
                </div>
              </div>
            </template>
            <template v-if="videos != ''">
              <h4>Mídias importadas:</h4>
              <div class="myPostList">
                <div class="myVideo">
                  <div
                    v-for="(video, i) in videos"
                    :key="i"
                  >
                    <div @click="removeVideo(i)">
                      <video :src="video" />
                    </div>
                  </div>
                </div>
              </div>
            </template>
          </div>

          <div>
            <v-btn
              :disabled="!descriptionPost"
              :loading="loading"
              class="btnPost mb-3"
              block
              @click="createPost"
            >
              Postar
            </v-btn>
          </div>
        </v-col>
      </v-row>
    </v-container>

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
import { showError } from "@/global";
import Vue from "vue";
import Offline from "../Modals/Offline.vue";
import LoadPage from "../Modals/LoadPage.vue";

export default {
  name: "Newpost",
  components: {
    myHeader,
    myFooter,
    Offline,
    LoadPage
  },
  data: () => {
    return {
      imageFile: [],
      videoFile: [],
      images: [],
      videos: [],
      postData: [],
      nameTags: [],
      getTags: [],
      pageReady: false,
      descriptionPost: "",
      loading: false,
      selectVideo: false,
      selectImage: false,
      textField: false,
      index: null
    };
  },
  computed: {
    ...mapState(["user"]),
    currentPage() {
      return this.$route.path;
    },
  },
  mounted() {
    this.carregaTags();
  },
  methods: {
    inputTags() {
      if (this.nameTags.length > 10) {
        Vue.toasted.global.defaultError({ errors: "Limite de tags atingido!" });
        this.nameTags.length = 9;
      }
    },
    carregaTags() {
      var isOnline = navigator.onLine;
      if (!isOnline) {
        this.$refs.offline.loadPage();
      } else {
        this.$http.get("/tags").then((res) => {
          for (let i = 0; i < res.data.length; i++) {
            this.getTags[i] = res.data[i].tag;
          }
          setTimeout(() => (this.pageReady = true), 1000);
        });
      }
    },
    goBack() {
      this.$router.go(-1);
    },
    handleSelects(e) {
      this.selectVideo = true;
      let fileList = Array.prototype.slice.call(e.target.files);
      let i = this.imageFile.length;
      let y = e.target.files;
      for (let j = 0; j < y.length; j++) {
        this.imageFile[i + j] = y[j];
        this.index = i+j;
      }
      if (this.imageFile[this.index].type == "image/jpeg" || this.imageFile[this.index].type == "image/jpg" || this.imageFile[this.index].type == "image/png") {
        
        Array.from(fileList).forEach((f) => {
          const reader = new FileReader();
          reader.onload = () => {
            this.images.push(reader.result);
          };
          reader.readAsDataURL(f);
        });
      } else {
        Vue.toasted.global.defaultError({errors:"Válido somente arquivos jpeg, jpg e png!"});
        this.selectVideo = false;
      }
      
    },
    handleSelectsVideo(e) {
      this.selectImage = true;
      this.selectVideo = true;
      let fileList = Array.prototype.slice.call(e.target.files);
      let i = this.videoFile.length;
      let y = e.target.files;
      for (let j = 0; j < y.length; j++) {
        this.videoFile[i + j] = y[j];
        this.index = i+j;
      }
      
      if (this.videoFile[this.index].type == "video/mp4" && this.videoFile[this.index].size < 67108864){
        Array.from(fileList).forEach((f) => {
          const reader = new FileReader();
          reader.onload = () => {
            this.videos.push(reader.result);
          };
          reader.readAsDataURL(f);
        });
      } else {
        if (this.videoFile[this.index].type != "video/mp4") {
          Vue.toasted.global.defaultError({errors:"Válido somente arquivos mp4!"});
          this.selectImage = false;
          this.selectVideo = false;
        }
        if (this.videoFile[this.index].size > 67108864) {
          Vue.toasted.global.defaultError({errors:"Válido somente arquivos menores que 64Mb!"});
          this.selectImage = false;
          this.selectVideo = false;
        }
      }
    },
    removeImg(img) {
      this.selectVideo = false;
      this.selectImage = false;
      if (!this.selectImage) {
        this.images = this.images
          .slice(0, img)
          .concat(this.images.slice(img + 1, this.images.length));
        this.imageFile.splice(img, 1);
      }
    },
    removeVideo(video) {
      this.selectVideo = false;
      this.selectImage = false;
      if (!this.selectVideo) {
        this.videos = this.videos
          .slice(0, video)
          .concat(this.videos.slice(video + 1, this.videos.length));
        this.videoFile.splice(video, 1);
      }
    },
    createPost() {
      this.loading = true;
      this.selectVideo = true;
      this.selectImage = true;
      this.textField = true;
      if (this.imageFile == "" && this.videoFile == "") {
        Vue.toasted.global.defaultError({
          errors: "Imagem ou Vídeo Obrigatório!",
        });
        this.selectVideo = false;
        this.selectImage = false;
        this.textField = false;
      }
      if (this.descriptionPost != "" && this.imageFile != "") {
        this.$http
          .post("/posts", {
            texto: this.descriptionPost,
            tags: this.nameTags,
          })
          .then((res) => {
            this.postData = res.data;
            this.uploadImg();
          })
          .catch(() => {
            Vue.toasted.global.defaultError({ errors:"Erro ao enviar post, realize o reenvio" });
            this.loading = false;
            this.selectVideo = false;
            this.selectImage = false;
            this.textField = false;
          });
      } else if (this.descriptionPost != "" && this.videoFile != "") {
        this.$http
          .post("/posts", {
            texto: this.descriptionPost,
            tags: this.nameTags,
          })
          .then((res) => {
            this.postData = res.data;
            this.uploadVideo();
          })
          .catch(() => {
            Vue.toasted.global.defaultError({ errors:"Erro ao enviar post, realize o reenvio" });
            this.loading = false;
            this.selectVideo = false;
            this.selectImage = false;
            this.textField = false;
          });
      } else {
        this.loading = false;
      }
    },
    uploadImg() {
      if (this.imageFile != "") {
        for (let i = 0; i < this.imageFile.length; i++) {
          var postData = new FormData();
          postData.append("post_id", this.postData.id);
          postData.append("arquivo", this.imageFile[i]);
          postData.append("tipo", "imagem");

          this.$http
            .post("/posts/upload/file", postData)
            .then((res) => {
              (this.imgData = res.data),
              (this.loading = false),
              this.$router.push({ path: "/timeline/" });
            })
            .catch(showError);
        }
      } else {
        (this.loading = false), this.$router.push({ path: "/timeline/" });
      }
    },
    uploadVideo() {
      if (this.videoFile != "") {
        for (let i = 0; i < this.videoFile.length; i++) {
          var postData = new FormData();
          postData.append("post_id", this.postData.id);
          postData.append("arquivo", this.videoFile[i]);
          postData.append("tipo", "video");

          this.$http
            .post("/posts/upload/file", postData)
            .then((res) => {
              (this.videoData = res.data),
              (this.loading = false),
              this.$router.push({ path: "/timeline/" });
            })
            .catch(showError);

          // if(i + 1 == this.imageFile.length){
          //     setTimeout(() => (
          //         this.loading = false,
          //         this.$router.push({ path: '/timeline/'})
          //     ), 1500)
          // }
        }
      } else {
        (this.loading = false), this.$router.push({ path: "/timeline/" });
      }
    },
  },
};
</script>