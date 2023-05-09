import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';
import { compileScript } from '@vue/compiler-sfc'


const app = createApp({
  // options
});

app.component('example-component', ExampleComponent);

app.mount('#app');
