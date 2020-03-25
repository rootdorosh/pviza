import config from "@/config";
import router from "@/Routes";
import axios from 'axios';
import { bus } from '@/main';

let pageModel = {
  id: '',
  parent_id: '',
  alias: '',
  template_id: '',
  is_search: '',
  is_canonical: '',
  is_breadcrumbs: '',
  is_menu: '',
  body_class: '',
}

for (let key in config.locales) {
  pageModel[config.locales[key]] = {
      seo_title: '',
      seo_h1: '',
      seo_description: '',
      breacrumbs_title: '',
      head: ''
  }
}

export default {
  namespaced: true,
  state: {
    widgetModel: {},
    widgets: [],
    widgetErrors: {},
    pageBlocks: [],
    blockModel: {
      page_id: '',
      template_id: '',
      alias: ''
    },
    currentPage: {},
    errors: {},
    pageModel,
    domainId: '',
    baseUrl: '/structure/domains/pages',
    labels: {
      success: {
        deleted: '',
      },
      title: {
        index: '',
        updating: '',
        creating: ''
      },
      fields: {}
    },
    templates: [],
    tree: false,
    isFetching: false,
    modalForm: {
      show: false,
      title: '',
    },
    modalDelete: {
      show: false
    },
    modalBlockDestroy: {
      show: false
    },
    modalBlockWidgetInsert: {
      show: false
    },
    alert: {
      type: '',
      text: '',
      show: false,
      redirect: false,
    },
  },
  getters: {
      domainUrl: state => {
        return '/structure/domains/' + state.domainId + '/pages'
      },
      pageUrl: state => {
        return '/structure/domains/' + state.domainId + '/pages/' + state.pageModel.id
      },
      templatesList: state => {
        var items = [];
        state.templates.forEach(function(item, i) {
          items.push({
            text: item.title,
            value: item.id
          })
        });
        return items;
      },
      editorTemplateName: state => {
        var template = null;

        if (typeof state.blockModel.template_id !== 'undefined') {
          state.templates.forEach(function(item, i) {
            if (item.id === state.blockModel.template_id) {
              template = item.alias;
            }
          });
        }
        return template;
      }
  },
  mutations: {
    setCurrentPage(state, data) {
      state.currentPage = data;
    },
    setModalForm(state, data) {
      state.modalForm = data;
    },
    setModalDelete(state, data) {
      state.modalDelete = data;
    },
    setModalBlockDestroy(state, data) {
      state.modalBlockDestroy = data;
    },
    setModalBlockWidgetInsert(state, data) {
      state.modalBlockWidgetInsert = data;
    },
    setWidgetModel(state, data) {
      state.widgetModel = data;
      state.widgetModel.fields = {};

      if (typeof data.config !== 'undefined') {
        for (var index = 0; index < data.config.length; index++) {
            state.widgetModel.fields[data.config[index].name] = '';
        }
      }
    },
    setBlockModel(state, data) {

      if (data === null) {
        for (let key in state.blockModel) {
            state.blockModel[key] = '';
        }
      } else {
        for (let key in data) {
            state.blockModel[key] = data[key];
        }
      }
    },
    setCurrentPage(state, data) {
      state.currentPage = data;
    },
    setDomainId(state, data) {
      state.domainId = data;
    },
    setLabels(state, data) {
      state.labels = data
    },
    setTemplates(state, data) {
      state.templates = data
    },
    setPageBlocks(state, data) {
      state.pageBlocks = data
    },
    setWidgets(state, data) {
      state.widgets = data
    },
    setPageModel(state, data) {
      if (typeof data === 'object') {
        for (let key in data) {
          state.pageModel[key] = data[key]
        }
      }
    },
    resetPageModel(state, data) {
      for (let key in state.pageModel) {
        if (typeof state.pageModel[key] === 'object') {
          for (let subKey in state.pageModel[key]) {
              state.pageModel[key][subKey] = '';
          }
        } else {
          state.pageModel[key] = '';
        }
      }
      console.log(state.pageModel)
    },
    setTree(state, data) {
      state.tree = data
    },
    setReady(state) {
      state.isReady = true
    },
    setLoading(state, data) {
      state.isLoading = data
      state.isRefresh = false
    },
    setRefresh(state, data) {
      state.isRefresh = data
    },
    setAlert(state, data) {
      for (let key in data) {
        state.alert[key] = data[key];
      }
    },
    setFailure(state, data) {
      state.isFetching = false;
      state.errors = data;
    },
    setFailureWidget(state, data) {
      state.isFetching = false;
    },
    setWidgetErrors(state, data) {
      state.widgetErrors = data;
    },
    setRequest(state, data = true) {
      state.isFetching = data;
    },
    setSuccess(state, data = {}) {
      state.isFetching = false;
      state.errors = {};
      for (let key in state.pageModel) {
        if (typeof state.pageModel[key] === 'object') {
            for (let subKey in state.pageModel[key]) {
              state.pageModel[key][subKey] = '';
            }
        } else {
            state.pageModel[key] = '';
        }
      }
    },
  },
  actions: {
    getTree({ state, commit, getters }) {
      axios
        .get(getters.domainUrl)
        .then(response => {
          commit('setTree', response.data)
        })
        .catch(obj => {
          console.log(obj)
        })
    },
    getMeta({ state, commit, dispatch }) {
      axios
        .get('/structure/domains/pages/meta')
        .then(response => {
          commit('setLabels', response.data.labels);
          commit('setTemplates', response.data.templates);
          dispatch('getTree');
        })
        .catch(obj => {
          console.log(obj)
        })
    },
    getPage({ state, commit, getters }, id) {
      axios
        .get('/structure/domains/' + state.domainId + '/pages/' + id)
        .then(response => {
          commit('setSuccess');
          commit('setPageModel', response.data.data);
          state.modalForm = {
            show: true,
            title: state.labels.title.updating
          }
        })
        .catch(obj => {
          console.log(obj)
        })
    },
    submitPageForm({ state, commit, dispatch, getters }) {
      let method = state.pageModel.id ? 'PUT' : 'POST';
      let url = state.pageModel.id ? getters.pageUrl : getters.domainUrl;
      dispatch('onRequest');

      axios({
          method,
          url,
          data: state.pageModel
        })
        .then(response => {
          if (typeof state.pageModel.id === 'number') {
            bus.$emit('update-page-' + state.pageModel.id, state.pageModel);

            if (state.pageModel.id === state.blockModel.page_id) {
              state.blockModel.template_id = state.pageModel.template_id;
            }

          } else {
            bus.$emit('add-child-' + state.pageModel.parent_id, state.pageModel);
          }
          state.modalForm.show = false;

          /*
          commit('setSuccess');
          commit('setAlert', {
            text: state.meta.success.deleted,
            type: 'success',
            show: true,
            redirect: false,
          });
          */
        })
        .catch(error => {
          if (typeof error.response !== 'undefined' && error.response.status === 422) {
            commit('setFailure', error.response.data.errors);
          }
        })
    },
    onDestroyPage({ state, commit, dispatch, getters }) {
      var page = state.currentPage
      axios({
          method: 'DELETE',
          url: '/structure/domains/' + state.domainId + '/pages/' + page.id
        })
        .then(response => {
          state.modalDelete.show = false;
          bus.$emit('delete-page-' + page.id, page)

          if (page.id === state.blockModel.page_id) {
            commit('setBlockModel', null);
          }

        })
        .catch(error => {
          console.log(error.response);
        })
    },
    onGetPageBlocks({ state, commit, dispatch, getters }) {
      let method = 'GET';
      let url = getters.domainUrl + '/' + state.blockModel.page_id + '/blocks';

      axios({ method, url })
        .then(response => {
          commit('setPageBlocks', response.data);
        })
        .catch(error => {
          console.log(error.response);
        })
    },
    onGetBlock({ state, commit, dispatch, getters }) {
      let url = getters.domainUrl + '/' + state.blockModel.page_id + '/blocks/' + state.blockModel.alias;
      axios.get(url)
      .then(response => {
          // has data
          if (response.status === 200) {
            let widgetData = response.data.meta;
            commit('setWidgetModel', widgetData);

            for (let key in response.data) {
              if (typeof state.widgetModel.fields[key] !== 'undefined') {
                state.widgetModel.fields[key] =  response.data[key];
              }
            }

          } else {
            commit('setWidgetModel', {});
          }
          commit('setWidgetErrors', {});
          commit('setModalBlockWidgetInsert', {show: true});
      })
      .catch(error => {
          console.log(error.response);
        })
    },
    onDestroyBlock({ state, commit, dispatch, getters }) {
      let url = getters.domainUrl + '/' + state.blockModel.page_id + '/blocks/' + state.blockModel.alias;
      axios.delete(url)
      .then(response => {
          state.modalBlockDestroy.show = false;
          dispatch('onGetPageBlocks');
      })
      .catch(error => {
          console.log(error.response);
        })
    },
    onGetWidgetsMeta({ state, commit, dispatch, getters }) {
      axios({
          method: 'GET',
          url: '/structure/domains/blocks/meta'
        })
        .then(response => {
          commit('setWidgets', response.data.widgets);
        })
        .catch(error => {
          console.log(error.response);
        })
    },
    onSubmitWidgetForm({ state, commit, dispatch, getters }) {
      let method = 'POST';
      let url = getters.domainUrl + '/' + state.blockModel.page_id + '/blocks';
      let data = state.widgetModel.fields;
      data.alias = state.blockModel.alias;
      data.widget_id = state.widgetModel.id;
      dispatch('onRequest');

      axios({ method, url, data })
        .then(response => {
            state.widgetModel = {};
            state.widgetErrors = {};
            state.modalBlockWidgetInsert.show = false;
            dispatch('onGetPageBlocks');
        })
        .catch(error => {
          if (typeof error.response !== 'undefined' && error.response.status === 422) {
            commit('setWidgetErrors', error.response.data.errors);
          }
        })
    },
    onRequest({ commit }, data) {
      commit('setRequest', data);
    },
    onLoading({ commit }) {
      commit('setLoading', true)
    },
    onLoaded({ state, commit }) {
      if(!state.isReady) commit('setReady')

      commit('setLoading', false);
    },
    onAlert({ commit }, data) {
      commit('setAlert', data);
    },
  },
};
