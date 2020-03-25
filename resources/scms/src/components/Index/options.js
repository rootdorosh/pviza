import { TableHelper } from '@/mixins/TableHelper';
import { i18n } from '@/lang';

export default {
  perPageValues: [],
  debounce: Infinity,
  filterByColumn: true,
  columnsClasses: {
    id: 'column-id'
  },
  requestKeys: {
    query: 'query',
    limit: 'limit',
    orderBy: 'sort_attr',
    ascending: 'sort_dir',
    page: 'page',
    byColumn: 'byColumn'
  },
  requestFunction(data) {
    return axios
      .get(this.url, {
        params: data
      })
      .catch(function(error) {
        let errors = error.response.data.errors;

        this.$store.commit('alert/setAlert', {
          text: errors[Object.keys(errors)[0]][0],
          type: 'danger',
          show: true,
          redirect: false,
        }, { root: true });

        this.$store.commit('index/setLoading', false, { root: true });
      }.bind(this));
  },
  responseAdapter(response) {
    return {
      data: response.data.data,
      count: response.data.meta.pagination.total,
    }
  },
  requestAdapter(response) {
    let data = TableHelper.methods.tableParamsResolver(response, this);

    for (let key in response.query) {
      if (this.sortable.includes(key)) {
        data[key] = response.query[key];
      }
    }

    return data;
  },
  texts: {
    count: i18n.t('tables2.count'),
    first: i18n.t('tables2.first'),
    last: i18n.t('tables2.last'),
    filter: i18n.t('tables2.filter'),
    filterPlaceholder: i18n.t('tables2.filter.placeholder'),
    limit: i18n.t('tables2.limit'),
    page: i18n.t('tables2.page'),
    noResults: i18n.t('tables2.no.results'),
    filterBy: '',
    loading: i18n.t('tables2.loading'),
    defaultOption: '-',
    columns: i18n.t('tables2.columns')
  },
}
