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
  rank: {
    filterable: true,
  },
  image: {
    renderable: 'image',
    filterable: false,
    sortable: false,
  },
  title: {
    filterable: true,
  },
  alias: {
    filterable: true,
  },
}
const state = cloneObject(states);
const table = tableConfig(columns);

export default {
  namespaced: true,
  state: {
    ...state,
    name: 'Locations',
    url: '/vacancy/locations',
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