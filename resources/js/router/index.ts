import { createRouter, createWebHistory } from "vue-router";
import Cart from "../components/Cart.vue";

const routes = [
    {
        path: '/sepet',
        name: 'Shopping Cart',
        component: Cart
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;