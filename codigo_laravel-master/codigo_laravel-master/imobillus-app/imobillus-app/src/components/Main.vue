<template>
    <section id="arqHome">

        <myHeader />

        <div class="banner-home">
            <v-container>
                <v-row>
                    <v-col cols="12">
                        <div class="banner-title">
                            <h1>UMA NOVA MANEIRA DE <br> ENCONTRAR SEU IMÓVEL</h1>
                            <h3>MODERNO, INTUITIVO E SIMPLES</h3>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </div>

        <div class="second-banner">
            <v-container>
                <v-row>
                    <v-col md="7">
                        <div class="second-title">
                            <h4>SE REINVENTAR NA ESCOLHA DO IMÓVEL</h4>
                            <h2>NUNCA FOI TÃO FÁCIL</h2>

                            <p>Contamos com filtro inteligente para te auxiliar na escolha do imóvel, catálogos personalizados e atendimento digital.</p>
                            <p>Tudo que precisa na palma da sua mão.</p>
                            <v-btn @click="findImovel" class="btn-padrao">Encontre seu imóvel</v-btn>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </div>

        <div class="professionals-banner">
            <v-container>
                <v-row>
                    <v-col offset-md="5" md="7">
                        <div class="professionals-title">
                            <h2>PROFISSIONAIS</h2>
                            <p>Capacitados e treinados para atender você!<br>
                            Atendimentos personalizado: presenciais ou virtuais, GARANTINDO A MELHOR EXPERIÊNCIA.</p>

                            <v-btn class="btn-padrao" @click="routeCadastro">Junte-se a nossa plataforma</v-btn>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </div>

        <div class="common-questions">
            <v-container>
                <v-row>
                    <v-col offset-md="1" md="10">
                        <div class="questions-title">
                            <h2>PERGUNTAS FREQUENTES</h2>

                            <v-expansion-panels class="panel-questions">

                                <v-expansion-panel class="box-questions">
                                    <v-expansion-panel-header>
                                        Lorem ipsum dolor sit amet?
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit
                                        ipsum dolor sit amet, consectetur adipiscing elit,
                                        ipsum dolor sit amet, consectetur adipiscing elit
                                    </v-expansion-panel-content>
                                </v-expansion-panel>

                                <v-expansion-panel class="box-questions">
                                    <v-expansion-panel-header>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit?
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit
                                        ipsum dolor sit amet, consectetur adipiscing elit,
                                        ipsum dolor sit amet, consectetur adipiscing elit
                                    </v-expansion-panel-content>
                                </v-expansion-panel>

                                <v-expansion-panel class="box-questions">
                                    <v-expansion-panel-header>
                                        Lorem ipsum dolor sit amet?
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit
                                        ipsum dolor sit amet, consectetur adipiscing elit,
                                        ipsum dolor sit amet, consectetur adipiscing elit
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                                
                                <v-expansion-panel class="box-questions">
                                    <v-expansion-panel-header>
                                        Lorem ipsum dolor sit amet?
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit
                                        ipsum dolor sit amet, consectetur adipiscing elit,
                                        ipsum dolor sit amet, consectetur adipiscing elit
                                    </v-expansion-panel-content>
                                </v-expansion-panel>

                            </v-expansion-panels>

                            <v-btn @click="goQuestions" class="btn-padrao" v-show="false">Ver todas as perguntas</v-btn>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </div>

        <myFooter />

    </section> 
</template>

<style>
    #arqHome .banner-home {
        background-image: url('../assets/banner-home.png');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
        height: 90vh;
        padding: 100px 0px;
        z-index: 1;
        display: flex;
        align-items: center;
    }
    #arqHome .banner-home:before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        z-index: -1;
        background-image: url('../assets/banner-filter.png');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    #arqHome .banner-home .banner-title {
        text-align: center;
    }
    #arqHome .banner-home .banner-title h1 {
        font-family: 'Archivo', sans-serif;
        font-style: normal;
        font-weight: bold;
        font-size: 55px;
        line-height: 75px;
        text-align: center;
        text-transform: uppercase;
        color: #FFFFFF;
        padding-bottom: 25px;
    }
    #arqHome .banner-home .banner-title h3 {
        font-family: 'Nunito Sans', sans-serif;
        font-style: normal;
        font-weight: normal;
        font-size: 30px;
        line-height: 41px;
        text-align: center;
        text-transform: uppercase;
        color: #FFFFFF;
    }

    #arqHome .btn-padrao {
        background-color: #185A9D;
        border: none;
        box-sizing: border-box;
        border-radius: 8px;
        padding: 22px 25px;
        margin-top: 35px;   
    }
    #arqHome .btn-padrao span {
        font-family: 'Archivo', sans-serif;
        font-style: normal;
        font-weight: normal;
        font-size: 20px;
        line-height: 22px;
        color: #FFFFFF;
        text-transform: initial;
    }

    #arqHome .second-banner {
        background-image: url('../assets/home-img1.png');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
        padding: 100px 0px;
        z-index: 1;
        display: flex;
        align-items: center;
    }
    #arqHome .second-banner:before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        z-index: -1;
        background-image: url('../assets/filter-img.png');
        background-position: center;
        background-repeat: no-repeat;
        background-size: 100% 100%;
    }
    #arqHome .second-banner .second-title {
        text-align: left;
    }
    #arqHome .second-banner .second-title h2 {
        font-family: 'Archivo', sans-serif;
        font-style: normal;
        font-weight: bold;
        font-size: 50px;
        line-height: 54px;
        text-transform: uppercase;
        color: #FFFFFF;
        padding-bottom: 20px;
    }
    #arqHome .second-banner .second-title h4 {
        font-family: 'Archivo', sans-serif;
        font-style: normal;
        font-weight: normal;
        font-size: 24px;
        line-height: 26px;
        text-transform: uppercase;
        color: #FFFFFF;
        padding-bottom: 15px;
    }
    #arqHome .second-banner .second-title p {
        font-family: 'Archivo', sans-serif;
        font-style: normal;
        font-weight: normal;
        font-size: 24px;
        line-height: 30px;
        padding-bottom: 20px;
    }

    #arqHome .professionals-banner {
        background-image: url('../assets/home-img2.png');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
        padding: 100px 0px;
        z-index: 1;
        display: flex;
        align-items: center;
    }
    #arqHome .professionals-banner:before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        z-index: -1;
        background-image: url('../assets/filter-img.png');
        background-position: center;
        background-repeat: no-repeat;
        background-size: 100% 100%;
        transform: rotate(180deg);
    }
    #arqHome .professionals-banner .professionals-title {
        text-align: right;
    }
    #arqHome .professionals-banner .professionals-title h2 {
        font-family: 'Archivo', sans-serif;
        font-style: normal;
        font-weight: bold;
        font-size: 50px;
        line-height: 54px;
        text-transform: uppercase;
        color: #FFFFFF;
        padding-bottom: 20px;
    }
    #arqHome .professionals-banner .professionals-title p {
        font-family: 'Archivo', sans-serif;
        font-style: normal;
        font-weight: normal;
        font-size: 24px;
        line-height: 30px;
        padding-bottom: 20px;
    }

    #arqHome .common-questions {
        background-color: #1A1919;
        padding: 100px 0px;
        position: relative;
        display: flex;
        align-items: center;
    }
    #arqHome .common-questions .questions-title {
        text-align: center;
    }
    #arqHome .common-questions .questions-title h2 {
        font-family: 'Archivo', sans-serif;
        font-style: normal;
        font-weight: 500;
        font-size: 40px;
        line-height: 44px;
        text-transform: uppercase;
        color: #FFFFFF;
        padding-bottom: 20px;
    }
    #arqHome .common-questions .panel-questions .box-questions {
        margin: 10px 0px;
        border-radius: 0;
        background-color: #4F4F4F;
    }
    #arqHome .common-questions .panel-questions .box-questions .v-icon {
        color: #fff;
    }
    #arqHome .common-questions .panel-questions .box-questions .v-expansion-panel-header {
        color: #fff;
        font-size: 18px;
        font-family: 'Archivo', sans-serif;
        font-style: normal;
        font-weight: normal;
        line-height: 30px;
        text-transform: uppercase;
    }
    #arqHome .common-questions .panel-questions .box-questions .v-expansion-panel-content__wrap {
        text-align: left;
        font-family: 'Archivo', sans-serif;
        font-style: normal;
        font-weight: 300;
        font-size: 16px;
        line-height: 20px;
        color: #FFFFFF;
    }
    #arqHome .common-questions .panel-questions .v-expansion-panel--active > .v-expansion-panel-header {
        min-height: 48px;
    }


    @media (max-width: 1024px) {
        #arqHome .banner-home {
            height: 65vh;
        }
        #arqHome .banner-home .banner-title h1 {
            font-size: 36px;
            line-height: 42px;
        }     
        #arqHome .banner-home .banner-title h3 {
            font-size: 25px;
            line-height: 27px;
        } 
    }

    @media (max-width: 768px) {
        #arqHome .banner-home .banner-title h1 {
            font-size: 28px;
            line-height: 31px;
        }
        #arqHome .banner-home .banner-title h3 {
            font-size: 20px;
            line-height: 22px;
        }
        #arqHome .second-banner .second-title,
        #arqHome .professionals-banner .professionals-title {
            text-align: center;
        }
        #arqHome .professionals-banner .professionals-title h2 {
            font-size: 28px;
            line-height: 30px;
        }
        #arqHome .professionals-banner .professionals-title p {
            font-size: 17px;
            line-height: 20px;
        }
        #arqHome .common-questions .questions-title h2 {
            font-size: 28px;
            line-height: 30px;
        }
        #arqHome .common-questions .panel-questions .box-questions .v-expansion-panel-header {
            font-size: 14px;
            line-height: 16px;
        }
    }
    @media (max-width: 500px) {
        #arqHome .second-banner .second-title h2 {
            font-size: 36px;
            line-height: 39px;
        }
        #arqHome .second-banner .second-title p {
            font-size: 20px;
            line-height: 23px;
        }
        #arqHome .btn-padrao {
            width: 100%;
        }
        #arqHome .btn-padrao span {
            font-size: 15px;
            line-height: 18px;
        }
    }
</style>

<script>
import { mapState } from 'vuex';
import myHeader from './Header/header.vue';
import myFooter from './Footer/footer.vue';

export default {
    name: 'home',
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
        routeCadastro() {
            this.$router.push({ path: '/cadastro', query: {corretor: 'true'}})
        },

        findImovel() {
            this.$router.push({ path: '/lista-imoveis'})
        },

        goQuestions() {
            this.$router.push({ path: '/page-desenvolvimento'})
        }
    }
}
</script>
