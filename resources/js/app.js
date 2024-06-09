require('./bootstrap');

import { createApp } from 'vue';

import ExampleComponent from './components/ExampleComponent.vue';
import DashboardComponent from './components/DashboardComponent.vue';
import LoginComponent from './components/LoginComponent.vue';
import RegisterComponent from './components/RegisterComponent.vue';

const app = createApp({
    components: {
        'example-component': ExampleComponent,
        'dashboard-component': DashboardComponent,
        'login-component': LoginComponent,
        'register-component': RegisterComponent,
    }
});

app.mount('#app');
