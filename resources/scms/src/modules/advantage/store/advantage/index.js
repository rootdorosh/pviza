import { TableHelper } from '@/mixins/TableHelper';
import cloneObject from '@/core/cloneObject';
import tableConfig from '@/core/tableConfig';
import { states, mutations, actions } from '@/components/Store/Index/Index';

const columns = {
  id: {},
  category_title: {
    renderable: 'common',
    filterable: 'select',
    optionsKey: 'categories',
  },
  image: {
    renderable: 'image',
    filterable: false,
    sortable: false,
  },
  is_active: {
    renderable: 'checkbox',
    filterable: TableHelper.methods.tableOptionsNoYes(),
  },
  rank: {},
  title: {},
  description: {},
}
const state = cloneObject(states);
const table = tableConfig(columns);

export default {
  namespaced: true,
  state: {
    ...state,
    name: 'Advantages',
    url: '/advantage/advantages',
    columns: table.columns,
    options: {
      ...table.options,
    },
  },
  mutations: {
    ...mutations,
  },
  actions: {
    ...actions,
  },
};
