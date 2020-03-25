import axios from 'axios'
import cloneObject from '@/core/cloneObject'
import { states, mutations, actions } from '@/components/Store/Form/Index'
import config from "@/config"

const state = cloneObject(states)

export default {
  namespaced: true,
  state: {
    ...state,
    url: '/settings/settings',
    model: {},
    tabs: {},
  },
  mutations: {
    ...mutations,
    setSuccess (state) {
    }
  },
  actions: {
    ...actions,
    onMetaResponse({ state, commit, dispatch }, response) {
      let responseMeta = response.meta.data

      state.meta = responseMeta.labels;
      state.tabs = responseMeta.tabs;

      let model = {}
      for (let tabKey in state.tabs) {
        for (let fieldKey in state.tabs[tabKey]['fields']) {
          model[fieldKey] = state.tabs[tabKey]['fields'][fieldKey].value
        }
      }
      state.model = model;
    },
    onSubmit({ state, dispatch }, options) {
      let method = 'POST'
      let url = state.url
      let data = state.model

      dispatch('onSubmitRequest', {
        options,
        config: {
          method,
          url,
          data
        }
      })
      state.model = data;
    },
  },
}
