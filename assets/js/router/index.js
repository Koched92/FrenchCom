import { createRouter, createWebHistory } from 'vue-router';
import Body from '../components/Body.vue';
import Dashboard from '../components/Dashboard.vue';

const routes = [
  {
    path: '/',
    name: 'Body',
    component: Body
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;