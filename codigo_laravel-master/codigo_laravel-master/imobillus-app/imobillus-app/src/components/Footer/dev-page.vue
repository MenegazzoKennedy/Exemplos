<template>
    <section id="arqCadastro">

        <myHeader />

        <div class="banner-cadastro">
            <v-container>
                <v-row>
                    <v-col offset-md="2" md="8" cols="12">
                        <div class="dev-title">
                            <h1>PÁGINA EM DESENVOLVIMENTO</h1>
                            
                            <img src="../../assets/dev-page-img.png">

                            <div class="arq-center">
                                <router-link class="btn-back" to="/">HOME</router-link>
                            </div>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </div>

        <myFooter />

    </section> 
</template>

<script>
import { mapState } from 'vuex';
import myHeader from '../Header/header.vue';
import myFooter from '../Footer/footer.vue';

export default {
    name: 'cadastro',
    data () {
        return {
 
        }
    },
    components: {
        myHeader,
        myFooter
    },
    computed: {
        ...mapState(['user']),
            currentPage() {
            return this.$route.path;
        },
    },
    methods: {
  
    },
}
</script>

<style>
    #arqCadastro .banner-cadastro {
        background-image: url('../../assets/banner-cadastro.png');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
        padding: 100px 0px;
        z-index: 1;
        display: flex;
    }
    #arqCadastro .banner-cadastro:before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        z-index: -1;
        background-image: url('../../assets/filter-cadastro.png');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    #arqCadastro .dev-title {
        background-color: rgba(0, 0, 0, 0.8);
        padding: 65px 145px;
        margin: 50px 0px;
    }
    #arqCadastro .dev-title h1 {
        font-family: 'Nunito Sans', sans-serif;
        font-style: normal;
        font-weight: bold;
        font-size: 30px;
        line-height: 32px;
        text-align: center;
        color: #FFFFFF;
        position: relative;
        width: fit-content;
        margin: auto;
    }
    #arqCadastro .dev-title h1:after {
        content: '';
        border-bottom: 0.5px solid #43CEA2;
        width: 75%;
        height: 0.5px;
        position: absolute;
        margin: auto;
        display: block;
        right: 0;
        left: 0;
    }
    #arqCadastro .dev-title img {
        width: 100%;
        object-fit: contain;
        object-position: center;
        height: 315px;
    }
    #arqCadastro .dev-title .btn-back {
        background-color: #185A9D;
        border: none;
        box-sizing: border-box;
        border-radius: 8px;
        padding: 10px 20px;
        margin-top: 35px;
        font-family: 'Archivo', sans-serif;
        font-style: normal;
        font-weight: normal;
        font-size: 20px;
        line-height: 22px;
        color: #FFFFFF;
        text-transform: initial;
        display: block;
        width: 40%;
        margin: 10px auto 0px;
    }

    @media (max-width: 500px) {
        #arqCadastro .dev-title h1 {
            font-size: 15px;
            line-height: 27px;
        }
        #arqCadastro .dev-title {
            padding: 15px;
        }
    }
</style>