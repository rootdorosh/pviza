import router from '@/Routes';
import axios from 'axios';
import cloneObject from '@/core/cloneObject';
import { states, mutations, actions } from '@/components/Store/Form/Index';

const state = cloneObject(states);

export default {
  namespaced: true,
  state: {
    ...state,
    url: '/user/users',
    model: {
      id: '',
      name: '',
      email: '',
      is_active: '',
      password: '',
      image_file: '',
      is_delete_image_file: '',
      position: '',
      roles: '',
      events: '',
    },
    select: {
      roles: {
        options: [],
        selected: [],
      },
      events: {
        options: [],
        selected: [],
      },
    },
    image: {
      user: ''
    },
  },
  mutations: {
    ...mutations,
    setSelect(state, data) {
      state.select[data.name][data.key] = data.options;
    },
  },
  actions: {
    ...actions,
    onMetaResponse({ state, commit, dispatch }, response) {
      commit('setState', {
        meta: response.meta.data.labels
      });

      if (state.model.id) {
        let image = response.form.data.data.image;

        for (let key in state.model) {
          let model = {};
          let value = response.form.data.data[key];

          model[key] = value != undefined ? value : '';

          commit('setState', {
            model
          });
        }

        if (image != 'null') {
          commit('setState', {
            image: {
              user: image
            }
          });
        }
      }

      dispatch('onCreateSelectOptions', {
        name: 'roles',
        options: response.meta.data.roles
      });
      dispatch('onCreateSelectOptions', {
        name: 'events',
        options: response.meta.data.events
      });
    },
    onSubmit({ state, dispatch }, options) {
      let method = 'POST';
      let url = state.model.id ? state.url + '/' + state.model.id : state.url;
      let data = new FormData();
      let headers = { 'Content-Type': 'multipart/form-data' };

      for (let key in state.model) {
        let val = state.model[key];

        if (val.constructor == Array) {
          for (let i in val) {
            data.append(key + '[]', val[i]);
          }
        } else {
          data.append(key, state.model[key]);
        }
      }

      dispatch('onSubmitRequest', {
        options,
        config: {
          method,
          url,
          data,
          headers
        }
      });
    },
    onCreateSelectOptions({ state, commit }, data) {
      let name = data.name;
      let options = [];
      let selected = [];

      for (let val in data.options) {
        let option = {
          val: val,
          label: data.options[val],
        };

        options.push(option);

        state.model[name].forEach(function(e, i) {
          if (e == val) selected.push(option);
        });
      }

      commit('setSelect', {
        name: name,
        options: options,
        key: 'options'
      });

      commit('setSelect', {
        name: name,
        options: selected,
        key: 'selected'
      });
    },
  },
};
