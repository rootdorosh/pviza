import router from '@/Routes';
import axios from 'axios';

export default {
  namespaced: true,
  state: {
    url: '/auth',
    isFetching: false,
    errorMessage: '',
    isEmailForm: true,
    isSuccessForm: false,
    redirectTimer: null
  },
  mutations: {
    remindFailure(state, payload) {
      state.isFetching = false;
      state.errorMessage = payload;
    },
    remindSuccess(state) {
      state.isFetching = false;
      state.errorMessage = '';
    },
    remindRequest(state) {
      state.isFetching = true;
    },
    remindReset(state) {
      state.isEmailForm = true;
      state.isSuccessForm = false;

      clearTimeout(state.redirectTimer);
    }
  },
  actions: {
    remindSend({ state, dispatch }, creds) {
      dispatch('requestRemind');

      let url = state.isEmailForm ? '/email' : '/input';

      axios
        .post(state.url + '/remind-password' + url, creds)
        .then(response => {
          if (state.isEmailForm) {
            dispatch('receiveRemind');
          } else {

          }
        })
        .catch(error => {
          if (error.response) {
            dispatch('remindError', error.response.data.errors);
          }
        });
    },
    remindError({ commit }, payload) {
      commit('remindFailure', payload);
    },
    receiveRemind({ commit, state }) {
      if (state.isEmailForm) {
        state.isEmailForm = false;

        commit('remindSuccess');
      } else {
        clearTimeout(state.redirectTimer);

        state.redirectTimer = setTimeout(function() {
          state.isEmailForm = true;

          commit('remindSuccess');
          router.push('/auth/login');
        }, 5000);
      }
    },
    requestRemind({ commit }) {
      commit('remindRequest');
    }
  }
};
