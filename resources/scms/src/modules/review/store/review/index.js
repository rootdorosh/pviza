import { TableHelper } from '@/mixins/TableHelper';
import cloneObject from '@/core/cloneObject';
import tableConfig from '@/core/tableConfig';
import { states, mutations, actions } from '@/components/Store/Index/Index';

const columns = {
  id: {},
  is_active: {
    renderable: 'checkbox',
    filterable: TableHelper.methods.tableOptionsNoYes(),
  },
  is_home: {
    renderable: 'checkbox',
    filterable: TableHelper.methods.tableOptionsNoYes(),
  },
  created_at: {
    renderable: 'datetime',
    filterable: false,
  },
  name: {
    filterable: true,
  },
  email: {
    filterable: true,
  },
  comment: {
    filterable: true,
  },
}
const state = cloneObject(states);
const table = tableConfig(columns);

export default {
  namespaced: true,
  state: {
    ...state,
    name: 'Reviews',
    url: '/review/reviews',
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