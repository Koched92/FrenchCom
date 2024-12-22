import 'materialize-css/dist/css/materialize.min.css';
import 'materialize-css/dist/js/materialize.min.js';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';


const appInstance = createApp(App);

appInstance.use(router);

appInstance.mount("#app");