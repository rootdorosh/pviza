import axios from 'axios';
import { i18n } from '@/lang';
import cloneObject from '@/core/cloneObject';
import { states, mutations, actions } from '@/components/Store/Form/Index';

const state = cloneObject(states);

export default {
  namespaced: true,
  state: {
    ...state,
    url: '/user/roles',
    model: {
      id: '',
      name: '',
      slug: '',
      description: '',
      permissions: [],
    },
    nodes: {
      permissions: {
        dataSource: [],
        id: 'id',
        parentID: 'pid',
        text: 'name',
        hasChildren: 'hasChild'
      }
    },
  },
  mutations: {
    ...mutations,
    setNodes(state, data) {
      state.nodes[data.name][data.key] = data.options;
    },
  },
  actions: {
    ...actions,
    onMetaResponse({ state, commit, dispatch }, response) {
      commit('setState', {
        meta: response.meta.data.labels
      });

      if (state.model.id) {
        commit('setState', {
          model: response.form.data.data
        });
      }

      dispatch('onCreateNodesOptions', {
        name: 'permissions',
        options: response.meta.data.permissions
      });
    },
    onSubmit({ state, dispatch }, options) {
      let method = state.model.id ? 'PUT' : 'POST';
      let url = state.model.id ? state.url + '/' + state.model.id : state.url;
      let data = state.model;

      dispatch('onSubmitRequest', {
        options,
        config: {
          method,
          url,
          data
        }
      });
    },
    onCreateNodesOptions({ state, commit }, data) {
      let name = data.name;
      let options = [];
      let checked = [];

      options.push({
        id: 0,
        name: i18n.t('select.all'),
        hasChild: true,
        expanded: true,
        isChecked: false,
      });

      for(let key in data.options) {
        let option = {
          id: key,
          pid: 0,
          name: data.options[key],
          hasChild: false,
          expanded: true,
          isChecked: false,
        };

        options.push(option);

        state.model[name].forEach(function(e, i) {
          if (e == key) {
            checked.push(option);

            option.isChecked = true;
          }
        });
      }

      commit('setNodes', {
        name: name,
        key: 'dataSource',
        options: options
      });
    },
  },
};
