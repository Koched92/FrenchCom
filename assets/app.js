// main.js
import { createApp } from 'vue';
import ElementPlus from 'element-plus';
import 'element-plus/dist/index.css';
import '../assets/styles/app.css'
import Navbar from './components/Navbar.vue'; // Assurez-vous que le chemin est correct
import footer from './components/footer.vue';
import LightDarkMode from './components/LightDarkMode.vue';
const app = createApp({});

app.use(ElementPlus);

app.component('navbar-component', Navbar);
app.component('footer-component', footer);
app.component('lightDarkMode-component', LightDarkMode);

app.mount('#app');