// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import VueTouch from 'vue-touch';
import axios from 'axios';
import store from './store';
import router from './Routes';
import App from './App';
//import layoutMixin from './mixins/layout';
//import { AuthMixin } from './mixins/auth';
//import { canAction } from './mixins/canAction';
import { ImgHelper } from './mixins/ImgHelper';
import { ArrayHelper } from './mixins/ArrayHelper';
import { AuthHelper } from './mixins/AuthHelper';
import { UserHelper } from './mixins/UserHelper';
import { FormHelper } from './mixins/FormHelper';
import { ModalHelper } from './mixins/ModalHelper';
import { FormOptionsHelper } from './mixins/FormOptionsHelper';
import { FormElementsHelper } from './mixins/FormElementsHelper';
import { TableHelper } from './mixins/TableHelper';
import config from './config';
import MainContent from './components/MainContent/MainContent';
import { i18n } from './lang';
import { ServerTable } from 'vue-tables-2';
import TableIndexOptions from './components/Index/options';
import RenderableCheckbox from './components/Index/Renderable/Checkbox';
import RenderableImage from './components/Index/Renderable/Image';
import RenderableArraySecondary from './components/Index/Renderable/ArraySecondary';
import RenderableCommon from './components/Index/Renderable/Common';
import RenderableColor from './components/Index/Renderable/Color';
import vSelect from 'vue-select';
import Toasted from 'vue-toasted';
import { TreeViewPlugin } from "@syncfusion/ej2-vue-navigations";
import MavonEditor from 'mavon-editor';
import Editor from '@/components/Editor/Editor';
import { Datetime } from 'vue-datetime'
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'

// не видаляти, або поясни чому видалив?
export const bus = new Vue();

Vue.config.productionTip = false;
Vue.prototype.$user = {};

//Vue.use(Datetime)
Vue.component('MainContent', MainContent);
Vue.component('RenderableCheckbox', RenderableCheckbox);
Vue.component('RenderableImage', RenderableImage);
Vue.component('RenderableArraySecondary', RenderableArraySecondary);
Vue.component('RenderableCommon', RenderableCommon);
Vue.component('RenderableColor', RenderableColor);
Vue.component('Editor', Editor);
Vue.component('Datetime', Datetime);

Vue.mixin(ImgHelper);
Vue.mixin(ArrayHelper);
Vue.mixin(AuthHelper);
Vue.mixin(UserHelper);
Vue.mixin(FormHelper);
Vue.mixin(ModalHelper);
Vue.mixin(TableHelper);
Vue.mixin(FormElementsHelper);
Vue.mixin(FormOptionsHelper);

Vue.use(BootstrapVue);
Vue.use(VueTouch);
Vue.use(Toasted);
Vue.use(TreeViewPlugin);
Vue.use(ServerTable, TableIndexOptions);
Vue.use(MavonEditor);

MavonEditor.mavonEditor.props.language.default = 'en';
MavonEditor.mavonEditor.props.boxShadow.default = false;
MavonEditor.mavonEditor.props.autofocus.default = false;

window.axios = require('axios');
axios.defaults.baseURL = config.urlApi;
axios.defaults.headers.common['Content-Type'] = "application/json";
axios.defaults.timeout = 5000;

const token = localStorage.getItem('token');
if (token) axios.defaults.headers.common['Authorization'] = "Bearer " + token;

const user = localStorage.getItem('user');
if (user) Vue.prototype.$user = JSON.parse(user);

new Vue({
  el: '#app',
  store,
  router,
  i18n,
  render: h => h(App),
});

window.addEventListener("load", function(event) {
  // TOTD update menu, permissions
});
