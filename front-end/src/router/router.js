import PostPage from "../pages/PostPage.vue";
import {createRouter, createWebHistory} from "vue-router";
import About from "../pages/About.vue";
import PostIdPage from "../pages/PostIdPage.vue";

const routes = [
    {
        path: '/',
        component: PostPage
    },
    {
        path: '/posts/:id',
        component: PostIdPage
    },
    {
        path: '/about',
        component: About
    },
];

const router = createRouter({
    routes,
    history: createWebHistory()
});

export default router;