import axios from 'axios';
import cloneObject from '@/core/cloneObject';
import { states, mutations, actions } from '@/components/Store/Form/Index';
import config from "@/config";

const state = cloneObject(states);

const getDefaultState = () => {
  let model = {
    id: '',
    alias: '',
    is_active: '1',
    site_lang: '',
    site_langs: '',
    logo: '',
    logo_name: '',
  }

  for (let key in config.locales) {
    model[config.locales[key]] = {
        copyright: '',
    }
  }

  return {
    ...state,
    url: '/structure/domains',
    model,
  }
}

// initial state
const defaultState = getDefaultState()

export default {
  namespaced: true,
  state: defaultState,
  mutations: {
    ...mutations,
    setDefaultState(state) {
      Object.assign(state, getDefaultState())
    }
  },
  actions: {
    ...actions,
    onMetaResponse({ state, commit, dispatch }, response) {

      let meta = response.meta.data.labels;
      meta.options = response.meta.data.options;

      commit('setState', {
        meta: meta
      });

      if (state.model.id) {

        for (let key in state.model) {
          let model = {};
          let value = response.form.data.data[key];

          model[key] = value != undefined ? value : '';

          commit('setState', {
            model
          });
        }
      }
    },
    onSubmit({ state, dispatch }, options) {
      let method = state.model.id ? 'PUT' : 'POST';
      let url = state.model.id ? state.url + '/' + state.model.id : state.url;
      let data = state.model;

      if ((data.logo.match(/base64/g) || []).length) {
        data.logo_base64 = data.logo;
      }
      data.logo = '';

      dispatch('onSubmitRequest', {
        options,
        config: {
          method,
          url,
          data
        }
      });
    },
  },
};
