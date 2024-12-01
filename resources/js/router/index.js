import { createRouter, createWebHashHistory } from "vue-router";
import studentindex from "../components/Students/index.vue";
import studentinsert from "../components/Students/insert.vue";
import courseindex from "../components/Course/index.vue";
import studentedit from "../components/Students/edit.vue";
import studentadd from "../components/Students/add.vue"
import courseinsert from "../components/Course/insert.vue";
import courseedit from "../components/Course/edit.vue";
import notFound from "../components/Students/notfound.vue";

const routes = [
    {
        path: '/',
        component: studentindex

    },

    {
        path: '/student/insert',
        component: studentinsert
    },
    {
        path: '/courses/index',
        component: courseindex
    },

    {
        path: '/courses/insert',
        component: courseinsert
    },

    {
        path: '/course/edit/:id',
        component: courseedit
    },
    {
        path: '/student/edit/:id',
        component: studentedit
    },

    {
        path: '/student/add',
        component: studentadd
    },

    {
        path: '/:pathMatch(.*)*',
        name: 'notfound',
        component: notFound
    }
];

const router = createRouter({
    history: createWebHashHistory(),
    routes
});

export default router;
