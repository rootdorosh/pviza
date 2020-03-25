import setState from '@/components/Store/Base/Mutations/SetState';

export default {
  namespaced: true,
  state: {
    url: '',
    isReady: false,
    isLoading: true,
    isRefresh: false,
    ids: [],
    marksAll: false,
    marksLength: null,
    clearIds: true,
  },
  mutations: {
    setState,
    setLoading(state, data) {
      state.isLoading = data;
      state.isRefresh = false;
    },
  },
  actions: {
    onDestroy({ state, commit, dispatch }) {
      commit('setLoading', true);

      axios
        .delete(state.url + '/bulk-destroy', {
          data: {
            ids: state.ids
          }
        })
        .then(response => {
          commit('setState', {
            isRefresh: true
          });

          commit('alert/setAlert', {
            text: state.meta.success.deleted,
            type: 'success',
            show: true,
            redirect: false,
          }, { root: true });
        })
        .catch(error => {
          if (error.response) {
            let errors = error.response.data.errors;

            commit('setState', {
              isRefresh: true
            });

            commit('alert/setAlert', {
              text: errors[Object.keys(errors)[0]][0],
              type: 'danger',
              show: true,
              redirect: false,
            }, { root: true });
          }
        });
    }
  },
};
