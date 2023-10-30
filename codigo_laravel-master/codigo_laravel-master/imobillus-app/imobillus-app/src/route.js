import Vue from 'vue'
import Router from 'vue-router'
import { userKey } from '@/global'

//Account
const Main = () => import('./components/Main')

const Header = () => import('./components/Header/header')
const Footer = () => import('./components/Footer/footer')

//Cliente
const Cadastro = () => import('./components/Cliente/cadastro')
const RecuperarSenha = () => import('./components/Cliente/recuperar-senha')
const MeuPerfil = () => import('./components/Cliente/meu-perfil')

//Imoveis 
const ImoveisList = () => import('./components/Imovel/imoveis-list')
const SingleImovel = () => import('./components/Imovel/single-imovel')
const PesquisaImoveis = () => import('./components/Imovel/pesquisa-imovel')

//Financiamentos
const SimularFinanciamento = () => import('./components/Financiamento/simular-financiamento')
const SimularValores = () => import('./components/Financiamento/simular-valores')
const SelecionarBanco = () => import('./components/Financiamento/select-bank')

//Negociação
const IniciarNegociacao = () => import('./components/Negociacao/iniciar-negociacao')

//Termos
const Privacidade = () => import('./components/Termos/privacidade')
const TermosUso = () => import('./components/Termos/termos-de-uso')

//Agendar Visitas
const AgendarVisita = () => import('./components/Visita/agendar-visita')

//Page Dev
const Construcao = () => import('./components/Footer/dev-page')

Vue.use(Router)

const router = new Router({
    mode: "history",
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/',
            component: Main,
            meta: { requiresLogin: false }
        },
        {
            path: '/header',
            component: Header,
            meta: { requiresLogin: false }
        },
        {
            path: '/footer',
            component: Footer,
            meta: { requiresLogin: false }
        },
        {
            path: '/cadastro',
            component: Cadastro,
            meta: { requiresLogin: false }
        },
        {
            path: '/recuperar-senha',
            component: RecuperarSenha,
            meta: { requiresLogin: false }
        },
        {
            path: '/meu-perfil',
            component: MeuPerfil,
            meta: { requiresLogin: true }
        },
        {
            path: '/lista-imoveis',
            component: ImoveisList,
            meta: { requiresLogin: false }
        },
        {
            path: '/imovel/:slug',
            component: SingleImovel,
            meta: { requiresLogin: false }
        },
        {
            path: '/pesquisa-imoveis',
            component: PesquisaImoveis,
            meta: { requiresLogin: false }
        },
        {
            path: '/simular-financiamento/:slug',
            component: SimularFinanciamento,
            meta: { requiresLogin: false }
        },
        {
            path: '/simular-valor/:slug',
            component: SimularValores,
            meta: { requiresLogin: false }
        },
        {
            path: '/selecionar-banco/:id',
            component: SelecionarBanco,
            meta: { requiresLogin: false }
        },
        {
            path: '/iniciar-negociacao/:slug',
            component: IniciarNegociacao,
            meta: { requiresLogin: false }
        },
        {
            path: '/politica-de-privacidade',
            component: Privacidade,
            meta: { requiresLogin: false }
        },
        {
            path: '/termos-de-uso',
            component: TermosUso,
            meta: { requiresLogin: false }
        },
        {
            path: '/agendar-visita/:slug',
            component: AgendarVisita,
            meta: { requiresLogin: false }
        },


        {
            path: '/page-desenvolvimento',
            component: Construcao,
            meta: { requiresLogin: false }
        },
    ],
    scrollBehavior() {
        window.scrollTo(0, 0);
    }
})

router.beforeEach((to, from, next) => {
    const json = localStorage.getItem(userKey)

    if (to.matched.some(record => record.meta.requiresLogin)) {
        const user = JSON.parse(json)
        user && user.token ? next() : next({ path: '/' })
    } else {
        next()
    }
})

export default router