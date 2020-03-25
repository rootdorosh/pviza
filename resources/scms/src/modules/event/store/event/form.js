import axios from 'axios'
import cloneObject from '@/core/cloneObject'
import { states, mutations, actions } from '@/components/Store/Form/Index'
import config from "@/config"

const state = cloneObject(states)

const getDefaultState = () => {

  let model = {
    id: '',
    event_id: '',
    content_type: '',
    is_active: '',
    from_email: '',
    vars: '',
  }

  for (let key in config.locales) {
    model[config.locales[key]] = {
    subject: '',
    from_name: '',
    body: '',
    }
  }

  return {
    ...state,
    url: '/event/events',
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
      let responseMeta = response.meta.data
      state.meta = responseMeta.labels
      state.meta.options = responseMeta.options
      state.meta.default = responseMeta.default
      state.meta.isLoaded = true

      if (state.model.id) {
        for (let key in state.model) {
          let value = response.form.data.data[key]
          state.model[key] = typeof value !== 'undefined' ? value : ''
        }

      } else {
        for (let key in meta.default) {
          let value = meta.default[key]
          state.model[key] = typeof value !== 'undefined' ? value : ''
        }
      }

    },
    onSubmit({ state, dispatch }, options) {
      let method = state.model.id ? 'PUT' : 'POST'
      let url = state.model.id ? state.url + '/' + state.model.id : state.url
      let data = state.model

      dispatch('onSubmitRequest', {
        options,
        config: {
          method,
          url,
          data
        }
      })
    },
  },
}
