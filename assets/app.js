// main.js
import { createApp } from 'vue';
import ElementPlus from 'element-plus';
import 'element-plus/dist/index.css';
import Navbar from './components/Navbar.vue'; // Assurez-vous que le chemin est correct
import footer from './components/footer.vue';
const app = createApp({});

app.use(ElementPlus);

app.component('navbar-component', Navbar);
app.component('footer-component', footer);

app.mount('#app');