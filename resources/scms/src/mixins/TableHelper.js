import { i18n } from '@/lang';

export const TableHelper = {
  methods: {

    tableInit() {
      const url = window.location.href;
      const urlSplit = url.split('?');
      const urlBase = urlSplit[0];
      const urlKeys = urlSplit[1];
      const filterable = this.options.filterable;
      let data = {};

      if (urlKeys) {
        let urlParams = new URLSearchParams(urlKeys);

        for (let param of urlParams) {
          if (filterable.includes(param[0])) {
            data[param[0]] = param[1];
          }
        }
      } else {
        for (let key of filterable) {
          data[key] = '';
        }
      }

      this.setState({
        options: {
          initFilters: data
        }
      });
    },

    tableAddUrlParams(params) {
      const url = window.location.href;
      const urlSplit = url.split('?');
      const query = params.query;
      const queryKeys = Object.keys(query);
      let urlBase = urlSplit[0];

      if (queryKeys.length) {
        urlBase += '?';

        for(let key in query) {
          const split = queryKeys.indexOf(key) ? '&' : '';

          urlBase += split + key + '=' + query[key];
        }
      }

      window.history.pushState(null, null, urlBase);
    },

    tableLoading(params) {
      this.tableAddUrlParams(params);

      this.$store.commit('index/setLoading', false, { root: true });

      this.$store.commit('index/setState', {
        ids: [],
        marksAll: false,
        marksLength: null,
        clearIds: true
      }, { root: true });
    },

    tableLoaded(response) {
      let marks = response.data.data.filter(e => e.id != this.adminId);
      let marksLength = marks.length;

      if(!this.isReady) {
        this.$store.commit('index/setState', {
          isReady: true
        }, { root: true });
      }

      this.$store.commit('index/setState', {
        marksLength
      }, { root: true });

      this.$store.commit('index/setLoading', false, { root: true });
    },

    tableModalWarning(modalId, data, isOne = true) {
      this.modalShow(modalId);

      if (data) {
        let ids = [];

        if (isOne) {
          ids.push(data);
        } else {
          ids = data;
        }

        this.$store.commit('index/setState', {
          ids
        }, { root: true });
      }
    },

    tableModalDestroy(modalId) {
      this.$store.commit('index/setState', {
        clearIds: false
      }, { root: true });

      this.$store.dispatch('index/onDestroy', null, { root: true });

      this.modalHide(modalId);
    },

    tableModalWatch() {
      this.$root.$on('bv::modal::hidden', () => {
        this.tableClearMarks();
      });
    },

    tableDestroyMarkAll(event, table) {
      let data = this.$refs[table].data;
      let checked = event.target.checked;
      let ids = [];

      if (checked) {
        for (let key in data) {
          if (data[key].id != this.adminId) {
            ids.push(data[key].id);
          }
        }
      }

      this.$store.commit('index/setState', {
        ids,
        marksAll: checked
      }, { root: true });
    },

    tableRefresh(table) {
      this.$refs[table].refresh();
    },

    tableIdsRefresh() {
      let data = this.ids.length === this.marksLength ? true : false;

      this.$store.commit('index/setState', {
        marksAll: data
      }, { root: true });
    },

    tableClearMarks() {
      if (this.$store.state.index.clearIds) {
        this.$store.commit('index/setState', {
          ids: [],
          marksAll: false
        }, { root: true });
      }
    },

    tableParamsResolver(response, options) {
      let data = {};

      for (let key in response) {
        if (key == options.requestKeys.ascending) {
          data[key] = response[key] ? 'asc' : 'desc';
        } else {
          data[key] = response[key];
        }
      }

      return data;
    },

    tableOptionsNoYes() {
      return [{
        id: 0,
        text: i18n.t('no'),
      }, {
        id: 1,
        text: i18n.t('yes'),
      }];
    },

  }
};
