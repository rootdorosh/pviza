import config from '@/config';
import axios from 'axios';
import { i18n } from '@/lang';
import { TableHelper } from '@/mixins/TableHelper';

export default {
  namespaced: true,
  state: {
    tableId: 'tableMenus',
    url: '/menu/menus',
    modal: {
      destroy: 'modal-destroy'
    },
    meta: {
      success: {
        deleted: '',
      },
      title: {
        index: '',
      }
    },
    columns: ['marks', 'id', 'title', 'is_active', 'is_sitemap', 'actions'],
    options: {
      url: config.url,
      headings: {
        marks: '',
        id: '',
        title: '',
        is_active: '',
        is_sitemap: '',
        actions: '',
      },
      perPageValues: [],
      debounce: Infinity,
      filterByColumn: true,
      sortable: ['id', 'title', 'is_active', 'is_sitemap'],
      filterable: ['id', 'title', 'is_active', 'is_sitemap'],
      listColumns: {
        is_active: [{
          id: 0,
          text: i18n.t('no')
        }, {
          id: 1,
          text: i18n.t('yes'),
        }],
        is_sitemap: [{
          id: 0,
          text: i18n.t('no')
        }, {
          id: 1,
          text: i18n.t('yes'),
        }]
      },
      initFilters: {
        id: '',
        title: '',
        is_active: '',
        is_sitemap: '',
      },
      requestFunction(data) {
        return axios
          .get(this.url, {
            params: data
          })
          .catch(function(error) {
            let errors = error.response.data.errors;

            this.$store.commit('alert/setAlert', {
              text: errors[Object.keys(errors)[0]][0],
              type: 'danger',
              show: true,
              redirect: false,
            }, { root: true });

            this.$store.commit('menus/setLoading', false, { root: true });
          }.bind(this));
      },
      responseAdapter(response) {
        if (response) {
          return {
            data: response.data.data,
            count: response.data.meta.pagination.total,
          }
        }
      },
      requestAdapter(response) {
        let data = TableHelper.methods.tableParamsResolver(response, this);

        for (let key in response.query) {
          if (this.sortable.includes(key)) {
            data[key] = response.query[key];
          }
        }

        return data;
      },
    },
    isReady: false,
    isLoading: true,
    isRefresh: false,
    ids: [],
    marksAll: false,
    marksLength: null,
    clearIds: true,
  },
  mutations: {
    setState(state, options) {
      state[options.name] = options.data;
    },
    setStateByKey(state, options) {
      for (let key in options.data) {
        state[options.name][key] = options.data[key];
      }
    },
    setHeadings(state, data) {
      for (let key in data) {
        state.options.headings[key] = data[key];
      }
    },
    setInitFilters(state, data) {
      for (let key in data) {
        state.options.initFilters[key] = data[key];
      }
    },
    setLoading(state, data) {
      state.isLoading = data;
      state.isRefresh = false;
    },
  },
  actions: {
    onMeta({ state, commit }) {
      axios
        .get(state.url + '/meta')
        .then(response => {
          commit('setState', {
            name: 'meta',
            data: response.data.labels.menu
          });

          commit('setHeadings', response.data.labels.menu.fields);
        })
        .catch(error => {
          if (error.response) {
            let errors = error.response.data.errors;

            commit('alert/setAlert', {
              text: errors[Object.keys(errors)[0]][0],
              type: 'danger',
              show: true,
              redirect: false,
            }, { root: true });
          }
        });
    },
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
            name: 'isRefresh',
            data: true
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
              name: 'isRefresh',
              data: true
            });

            commit('alert/setAlert', {
              text: errors[Object.keys(errors)[0]][0],
              type: 'danger',
              show: true,
              redirect: false,
            }, { root: true });
          }
        });
    },
  },
};
