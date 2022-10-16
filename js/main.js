const store = new Vuex.Store({
    state: {
      titulo: ''
    },
    mutations: {

    }
})


const Inicio = { template: '<web-inicio></web-inicio>' }
const Inicio_estatus = { template: '<inicio-estatus></inicio-estatus>' }
const Inicio_rescontra = { template: '<inicio-rescontra></inicio-rescontra>' }
const Inicio_registro = { template: '<inicio-registro></inicio-registro>' }

const routes = [
  { path: '/', component: Inicio },
  { path: '/inicio-estatus', component: Inicio_estatus },
  { path: '/inicio-rescontra', component: Inicio_rescontra },
  { path: '/inicio-registro', component: Inicio_registro }
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHashHistory(),
    routes,
})
  
const app = Vue.createApp({
    data() {
        return {
            
        }
    }
})