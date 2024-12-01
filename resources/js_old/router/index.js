import {createRouter,createWebHistory} from "vue-router"
import productsIndex from "../components/products/index.vue"
import notFound from "../components/products/notfound.vue"


const routes=[
    {
        path:'/',
        name:'products.index',
        component:productsIndex
    },
    {
        path:'/:pathMatch(.*)*',
        name:'notfound',
        component:notFound
    }
]


const router=createRouter({
    history:createWebHistory(),
    routes  
})



export default router