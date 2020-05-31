import { isAuthenticated } from './mixins/AuthHelper'
import clearCookie from '@/core/clearCookie'
import Vue from 'vue'
import Router from 'vue-router';
import axios from 'axios';
import Layout from '@/components/Layout/Layout';
import Error from '@/modules/error/routes';
import AuthModule from '@/modules/auth/routes';

import AdvantageModule from '@/modules/advantage/routes';
import BlogModule from '@/modules/blog/routes';
import ContentBlockModule from '@/modules/contentBlock/routes';
import EventModule from '@/modules/event/routes';
import MenuModule from '@/modules/menu/routes';
import ResumeModule from '@/modules/resume/routes';
import SettingsModule from '@/modules/settings/routes';
import StructureModule from '@/modules/structure/routes';
import TranslationModule from '@/modules/translation/routes';
import UserModule from '@/modules/user/routes';
import VacancyModule from '@/modules/vacancy/routes';

Vue.use(Router);

const baseRoutes = [
  {
    path: '/scms',
    redirect: '/dashboard'
  },
  {
    path: '*',
    redirect: '/404'
  },
  {
    path: '/',
    name: 'Layout',
    component: Layout,
    beforeEnter: (to, from, next) => {
      let token = localStorage.getItem('token');

      isAuthenticated(token) ? next() : next({ path: '/auth/login' });
    },
    children: [].concat(
      AdvantageModule,
      BlogModule,
      ContentBlockModule,
      EventModule,
      MenuModule,
      ResumeModule,
      SettingsModule,
      StructureModule,
      TranslationModule,
      UserModule,
      VacancyModule      
    )
  },
];

const routes = baseRoutes.concat(
  AuthModule,
  Error
);

const router = new Router({
  mode: 'history',
  base: '/scms',
  routes
});

axios.interceptors.response.use(function(response) {
  return response;
}, function(error) {
  if (error.response.status === 401) {
    clearCookie();
    router.push('/auth/login');
  }

  return Promise.reject(error);
});

export default router;
