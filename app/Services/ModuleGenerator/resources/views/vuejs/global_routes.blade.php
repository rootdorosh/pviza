<?php 
use Illuminate\Support\Str;
?>
import { isAuthenticated } from './mixins/AuthHelper'
import clearCookie from '@/core/clearCookie'
import Vue from 'vue'
import Router from 'vue-router';
import axios from 'axios';
import Layout from '@/components/Layout/Layout';
import Error from '@/modules/error/routes';
import AuthModule from '@/modules/auth/routes';

@foreach ($modules as $module)
import {{ $module }}Module from '@/modules/{{ Str::camel($module) }}/routes';
@endforeach

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
      <?= implode(",\n      ", $modulesModule)?>      
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
