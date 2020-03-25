import router from '@/Routes';
import Vue from 'vue';
import axios from 'axios';
import clearCookie from '@/core/clearCookie';

export default {
  namespaced: true,
  state: {
    url: '/auth',
    isFetching: false,
    errorMessage: '',
  },
  mutations: {
    loginFailure(state, payload) {
      state.isFetching = false;
      state.errorMessage = payload;
    },
    loginSuccess(state) {
      state.isFetching = false;
      state.errorMessage = '';
    },
    loginRequest(state) {
      state.isFetching = true;
    },
  },
  actions: {
    loginUser({ state, dispatch, commit }, creds) {
      dispatch('requestLogin');

      axios
        .post(state.url + '/login', creds)
        .then(response => {
          const data = response.data;

          dispatch('receiveToken', data);
        })
        .catch(error => {
          if (error.response) {
            dispatch('loginError', error.response.data.errors);
          }
        });
    },
    receiveToken({dispatch}, data) {
      const token = data.token;

      const user = {
        data: data.data,
        menu: {
          left: data.menu.filter(item => item.left),
          header: data.menu.filter(item => item.right)
        },
        permissions: data.permissions
      };

      localStorage.setItem('token', token);
      localStorage.setItem('user', JSON.stringify(user));

      axios.defaults.headers.common['Authorization'] = "Bearer " + token;
      Vue.prototype.$user = user;

      dispatch('receiveLogin');
    },
    logoutUser() {
      clearCookie();
      router.push('/auth/login');
    },
    loginError({commit}, payload) {
      commit('loginFailure', payload);
    },
    receiveLogin({commit}) {
      commit('loginSuccess');
      router.push('/content-block/content-blocks');
    },
    requestLogin({commit}) {
      commit('loginRequest');
    }
  }
};
