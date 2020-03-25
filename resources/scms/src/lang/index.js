import Vue from 'vue';
import VueI18n from 'vue-i18n';

import ua from './ua/main.json';

Vue.use(VueI18n);

const messages = {
  ua
};

export let i18n = new VueI18n({
  locale: 'ua',
  fallbackLocale: 'ua',
  messages
});
