import router from '@/Routes';
import axios from 'axios';
import config from "@/config";

const getDefaultState = () => {
  let itemModel = {
    page_id: null,
    name: '',
    is_active: 1,
    is_targer_blank: 0,
    class: '',
    style: '',
    priority: '',
    image: '',
    image_name: '',
  }

  for (let key in config.locales) {
    itemModel[config.locales[key]] = {
        title: '',
        link: '',
        description: '',
    }
  }
  itemModel.children = [];

  return {
      url: '/menu/menus',
      modal: {
        destroy: 'modal-destroy'
      },
      meta: {
        menu: {
          fields: {},
          description: {},
          success: {},
          title: {},
        },
        item: {
          fields: {},
          description: {},
          success: {},
          title: {},
        }
      },
      model: {
        id: '',
        title: '',
        is_active: 1,
        is_sitemap: 0,
        items: '',
      },
      itemModel,
      modalItemForm: {
        show: false,
      },
      isFetching: false,
      errorMessage: {},
      errorMessageItem: {},
      domainId: null,
      domain: {},
      tree: false,
      treeMenuItems: [],
    }
}

// initial state
const defaultState = getDefaultState()

export default {
  namespaced: true,
  state: defaultState,
  getters: {
    changefreqsList: state => {
      return state.meta.item.changefreqs
    },
    prioritiesList: state => {
      return state.meta.item.priorities
    },
  },
  mutations: {
    setDefaultState(state) {
      Object.assign(state, getDefaultState())
    },
    setErrorMessageItem(state, data) {
      state.errorMessageItem = data;
    },
    setModalItemForm(state, data) {
      state.modalItemForm = data;
    },
    updateTreeMenuItems: (state, payload) => {
      state.treeMenuItems = payload;
    },
    setMenuItemsAppend(state, data) {
      state.treeMenuItems.push(data);
    },
    setMeta(state, data) {
      state.meta = data;
    },
    setModel(state, data) {
      if (typeof data === 'object') {
        for (let key in data) {
          state.model[key] = data[key]
        }
      }
    },
    setItemModel(state, data) {
      if (typeof data === 'object') {
        for (let key in data) {
          state.itemModel[key] = data[key]
        }
      }
    },
    setIsFetching(state, data) {
      state.isFetching = data;
    },
    setFailure(state, data) {
      state.isFetching = false;
      state.errorMessage = data;
    },
    setSuccess(state, data = true) {
      state.isFetching = false;
      state.errorMessage = '';

      if (data) {
        for (let key in state.model) {
          state.model[key] = '';
        }
      }
    },
    setTreeMenuItems(state, data) {
      state.treeMenuItems = data
    },
    setDomainId(state, data) {
      state.domainId = data
    },
    setDomain(state, data) {
      state.domain = data
    },
    setTree(state, data) {
      state.tree = data
    },
  },
  actions: {
    updateTreeMenuItems: ({ commit }, payload) => {
      commit("updateTreeMenuItems", payload);
    },
    onMeta({ state, commit, dispatch }) {
      let axiosAll = [
        axios.get(state.url + '/meta')
      ];

      if (state.model.id) {
        axiosAll.push(axios.get(state.url + '/' + state.model.id));
      }

      axios
        .all(axiosAll)
        .then(axios.spread((responseMeta, responseForm) => {
          commit('setMeta', responseMeta.data.labels);

          if (state.model.id) {
            let model = responseForm.data.data;
            commit('setModel', model);
            commit('setDomainId', model.domain_id);
            commit('setTreeMenuItems', model.items);
            dispatch('onGetDomain');
          }
        }))
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
    onGetDomain({ state, commit, getters, dispatch }) {

      axios
        .get(`structure/domains/${state.domainId}`)
        .then(response => {
          commit('setDomain', response.data.data)
          dispatch('onGetTree')
        })
        .catch(obj => {
          console.log(obj)
        })
    },
    onGetTree({ state, commit, getters }) {
      axios
        .get(`structure/domains/${state.domainId}/pages`)
        .then(response => {
          commit('setTree', response.data)
        })
        .catch(obj => {
          console.log(obj)
        })
    },
    onSubmit({ state, dispatch }, options) {
      let method = state.model.id ? 'PUT' : 'POST';
      let url = state.model.id ? state.url + '/' + state.model.id : state.url;

      /*
      state.model.items = state.treeMenuItems.map(function(item) {
        return JSON.stringify(item);
      })
      */

      state.model.domain_id = state.domainId;
      state.model.items = state.treeMenuItems;

      let data = state.model;
      console.log(data);

      dispatch('onRequest');

      axios({ method, url, data})
      .then(response => {
        dispatch('onSuccess', options)
      })
      .catch(error => {
        if (error.response) {
          dispatch('onFailure', error.response.data.errors);
        }
      });
    },
    onFailure({ commit }, data) {
      commit('setFailure', data);
    },
    onSuccess({ state, commit, dispatch }, data) {
      if (state.model.id) {
        commit('setSuccess', false);

        commit('alert/setAlert', {
          text: state.meta.menu.success.updated,
          type: 'success',
          show: true,
          redirect: data == 'saveExit' ? true : false,
        }, { root: true });

        if (data == 'saveExit') {
          commit('setSuccess');
          router.push('/menu/menus');
        }
      } else {
        commit('setSuccess');

        commit('alert/setAlert', {
          text: state.meta.menu.success.created,
          type: 'success',
          show: true,
          redirect: true,
        }, { root: true });

        router.push('/menu/menus');
      }
    },
    onRequest({ commit }, data) {
      commit('setIsFetching', data);
    },
    onCancel({ commit }) {
      commit('setSuccess');
      router.push('/menu/menus');
    },
    onSaveExit({ dispatch }) {
      dispatch('onSubmit', 'saveExit');
    },
  },
};
