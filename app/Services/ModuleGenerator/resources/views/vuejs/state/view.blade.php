<?php 
$enter = "\n";
$tab2 = "  ";
$tab4 = "    ";
$tab6 = "      ";
$tab8 = "        ";

?>

import axios from 'axios'
import cloneObject from '@/core/cloneObject'
import { states, mutations, actions } from '@/components/Store/Form/Index'
import config from "@/config"

const state = cloneObject(states)

const getDefaultState = () => {

  let model = {@foreach ($model['vue']['model'] as $attr => $def)<?= $enter?><?= $tab4?>{{ $attr }}: {!! $def !!},@endforeach<?= $enter?><?= $tab2?>}


  return {
    ...state,
    url: '/{{ Str::kebab($moduleName) }}/{{ Str::kebab($model['routes']['path']) }}',
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
  },
}
