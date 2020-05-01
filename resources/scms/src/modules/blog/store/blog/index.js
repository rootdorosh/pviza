import { TableHelper } from '@/mixins/TableHelper';
import cloneObject from '@/core/cloneObject';
import tableConfig from '@/core/tableConfig';
import { states, mutations, actions } from '@/components/Store/Index/Index';

const columns = {
  id: {},
  category_title: {
    filterable: 'select',
    optionsKey: 'categories',
  },
  is_active: {
    renderable: 'checkbox',
    filterable: TableHelper.methods.tableOptionsNoYes(),
  },
  is_home: {
    renderable: 'checkbox',
    filterable: TableHelper.methods.tableOptionsNoYes(),
  },
  image: {
    renderable: 'image',
    filterable: false,
    sortable: false,
  },
  created_at: {
    renderable: 'datetime',
    filterable: false,
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
    name: 'Blogs',
    url: '/blog/blogs',
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