// main.js
import { createApp } from 'vue';
import ElementPlus from 'element-plus';
import 'element-plus/dist/index.css';
import * as ElIcons from '@element-plus/icons-vue';
import Navbar from './components/Navbar.vue'; // Assurez-vous que le chemin est correct

const app = createApp({});

app.use(ElementPlus);

// Enregistrez globalement les icônes
for (const [key, component] of Object.entries(ElIcons)) {
  app.component(key, component);
}

app.component('navbar-component', Navbar);

app.mount('#app');