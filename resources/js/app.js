import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';
import Flash from './components/Flash.vue';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const app = createApp()
    .component('flash', Flash)
    .mount('#app');
