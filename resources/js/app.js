import './bootstrap';

import { createApp } from 'vue'
import Vue3EasyDataTable from 'vue3-easy-data-table'
import BootstrapVue3 from 'bootstrap-vue-3'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css'
import '@vuepic/vue-datepicker/dist/main.css'
import 'vue3-easy-data-table/dist/style.css'
import 'vue-multiselect/dist/vue-multiselect.css'

import App from '../components/App.vue'

createApp(App)
  .use(BootstrapVue3)
  .component('EasyDataTable', Vue3EasyDataTable)
  .mount('#app')