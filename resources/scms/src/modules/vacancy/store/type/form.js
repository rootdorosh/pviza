import axios from 'axios'
import cloneObject from '@/core/cloneObject'
import { states, mutations, actions } from '@/components/Store/Form/Index'
import config from "@/config"

const state = cloneObject(states)

const getDefaultState = () => {

  let model = {
    id: '',
    is_active: '',
    rank: '',
    image: '',
    image_name: '',
  }

  for (let key in config.locales) {
    model[config.locales[key]] = {
    title: '',
    alias: '',
    description: '',
    seo_h1: '',
    seo_title: '',
    seo_description: '',      
    }
  }

  return {
    ...state,
    url: '/vacancy/types',
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
      let meta = responseMeta.labels
      for (let key in responseMeta) {
        if (key !== 'labels') {
            if (typeof responseMeta[key] === 'object') {
              meta[key] = {}
              for (let subKey in responseMeta[key]) {
                  meta[key][subKey] = responseMeta[key][subKey]
              }
            } else {
              meta[key] = responseMeta[key]
            }
        }
      }
      meta.isLoaded = true

      commit('setState', {
        meta: meta
      })

      let model = {}

      if (state.model.id) {
        for (let key in state.model) {
          let value = response.form.data.data[key]
          model[key] = typeof value !== 'undefined' ? value : ''
        }

      } else {
        for (let key in meta.default) {
          let value = meta.default[key]
          model[key] = typeof value !== 'undefined' ? value : ''
        }
      }

      commit('setState', {
        model
      })
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